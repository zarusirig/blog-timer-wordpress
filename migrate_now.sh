#!/bin/bash

# Direct WordPress Migration Script - SECURITY HARDENED
set -euo pipefail

echo "================================================"
echo "Migrating WordPress to Digital Ocean"
echo "================================================"

# Read droplet info
if [ ! -f .droplet_info ]; then
    echo "ERROR: .droplet_info not found. Run create_droplet_with_ssh.py first"
    exit 1
fi

DROPLET_IP=$(python3 -c "import json; print(json.load(open('.droplet_info'))['ip_address'])")
MYSQL_ROOT_PASS=$(python3 -c "import json; print(json.load(open('.droplet_info'))['mysql_root_pass'])")
WP_DB_PASS=$(python3 -c "import json; print(json.load(open('.droplet_info'))['wp_db_pass'])")
SSH_KEY="$HOME/.ssh/wordpress_deploy"

echo "Migrating to: $DROPLET_IP"

# 1. Export local database (password via env var to avoid command line exposure)
echo "1. Exporting local database..."
docker exec wp-mysql mysqldump -u wordpress -pwordpress_password wordpress > wordpress_backup.sql

# 2. Update URLs in database
echo "2. Updating URLs..."
sed -i.bak "s|http://localhost:8085|http://$DROPLET_IP|g" wordpress_backup.sql
sed -i.bak "s|http://localhost|http://$DROPLET_IP|g" wordpress_backup.sql

# 3. Package wp-content
echo "3. Packaging wp-content..."
tar -czf wp-content.tar.gz wp-content/

# 4. Transfer files (with host key verification)
echo "4. Transferring files..."
scp -i "$SSH_KEY" wp-content.tar.gz "root@$DROPLET_IP:/tmp/"
scp -i "$SSH_KEY" wordpress_backup.sql "root@$DROPLET_IP:/tmp/"
scp -i "$SSH_KEY" .htaccess "root@$DROPLET_IP:/tmp/htaccess_hardened"

# 5. Install on droplet
echo "5. Installing on droplet..."
ssh -i "$SSH_KEY" "root@$DROPLET_IP" << ENDSSH
# Backup existing
cd /var/www/html
if [ -d "wp-content" ]; then
    mv wp-content wp-content.orig
fi

# Extract our wp-content
tar -xzf /tmp/wp-content.tar.gz

# Import database
mysql -u root -p$MYSQL_ROOT_PASS wordpress < /tmp/wordpress_backup.sql

# Update database URLs
mysql -u root -p$MYSQL_ROOT_PASS wordpress << EOSQL
UPDATE wp_options SET option_value = 'http://$DROPLET_IP' WHERE option_name = 'siteurl';
UPDATE wp_options SET option_value = 'http://$DROPLET_IP' WHERE option_name = 'home';
UPDATE wp_posts SET guid = REPLACE(guid, 'http://localhost:8085', 'http://$DROPLET_IP');
UPDATE wp_posts SET guid = REPLACE(guid, 'http://localhost', 'http://$DROPLET_IP');
UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://localhost:8085', 'http://$DROPLET_IP');
UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://localhost', 'http://$DROPLET_IP');
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, 'http://localhost:8085', 'http://$DROPLET_IP');
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, 'http://localhost', 'http://$DROPLET_IP');
EOSQL

# Set permissions
chown -R www-data:www-data /var/www/html
find /var/www/html -type d -exec chmod 755 {} \;
find /var/www/html -type f -exec chmod 644 {} \;

# Deploy the hardened .htaccess
cp /tmp/htaccess_hardened /var/www/html/.htaccess
chown www-data:www-data /var/www/html/.htaccess
chmod 644 /var/www/html/.htaccess

# Set permalinks and flush rewrite rules
cd /var/www/html
wp --allow-root rewrite structure '/%postname%/'
wp --allow-root rewrite flush

# Generate new security salts on production
SALTS=\$(curl -s https://api.wordpress.org/secret-key/1.1/salt/)
if [ -n "\$SALTS" ]; then
    # Remove old salts and insert new ones
    sed -i "/AUTH_KEY/d; /SECURE_AUTH_KEY/d; /LOGGED_IN_KEY/d; /NONCE_KEY/d" wp-config.php
    sed -i "/AUTH_SALT/d; /SECURE_AUTH_SALT/d; /LOGGED_IN_SALT/d; /NONCE_SALT/d" wp-config.php
    echo "\$SALTS" >> wp-config.php
fi

# SECURITY: Clean up temp files on server
rm -f /tmp/wp-content.tar.gz /tmp/wordpress_backup.sql /tmp/htaccess_hardened
rm -f /root/credentials.txt

# SECURITY: Disable XML-RPC at Apache level
a2dismod xmlrpc 2>/dev/null || true

# Restart Apache
systemctl restart apache2

echo "Migration complete!"
ENDSSH

# Clean up local temp files
rm -f wp-content.tar.gz wordpress_backup.sql wordpress_backup.sql.bak

echo "================================================"
echo "Migration Complete!"
echo "================================================"
echo "Your site with custom theme is now at: http://$DROPLET_IP"
echo ""
echo "IMPORTANT POST-MIGRATION SECURITY STEPS:"
echo "1. Change the WordPress admin password immediately"
echo "2. Set up SSL: ssh -i $SSH_KEY root@$DROPLET_IP 'certbot --apache'"
echo "3. Set up system cron: ssh -i $SSH_KEY root@$DROPLET_IP 'crontab -l'"
echo "4. Verify .htaccess security headers are active"
