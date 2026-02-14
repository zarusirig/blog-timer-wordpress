#!/bin/bash

# WordPress Migration Script for Vultr - SECURITY HARDENED
set -euo pipefail

echo "================================================"
echo "Migrating WordPress to Vultr"
echo "================================================"

# Read instance info
if [ ! -f .vultr_instance_info ]; then
    echo "ERROR: .vultr_instance_info not found. Run create_vultr_instance.py first"
    exit 1
fi

INSTANCE_IP=$(python3 -c "import json; print(json.load(open('.vultr_instance_info'))['ip_address'])")
MYSQL_ROOT_PASS=$(python3 -c "import json; print(json.load(open('.vultr_instance_info'))['mysql_root_pass'])")
WP_DB_PASS=$(python3 -c "import json; print(json.load(open('.vultr_instance_info'))['wp_db_pass'])")
SSH_KEY="$HOME/.ssh/wordpress_vultr"

echo "Migrating to: $INSTANCE_IP"

# 1. Export local database
echo "1. Exporting local database..."
docker exec wp-mysql mysqldump -u wordpress -pwordpress_password wordpress > wordpress_backup.sql

# 2. Update URLs in database
echo "2. Updating URLs..."
sed -i.bak "s|http://localhost:8085|http://$INSTANCE_IP|g" wordpress_backup.sql
sed -i.bak "s|http://localhost|http://$INSTANCE_IP|g" wordpress_backup.sql

# 3. Package wp-content
echo "3. Packaging wp-content..."
tar -czf wp-content.tar.gz wp-content/

# 4. Transfer files (with host key verification)
echo "4. Transferring files..."
scp -i "$SSH_KEY" wp-content.tar.gz "root@$INSTANCE_IP:/tmp/"
scp -i "$SSH_KEY" wordpress_backup.sql "root@$INSTANCE_IP:/tmp/"
scp -i "$SSH_KEY" .htaccess "root@$INSTANCE_IP:/tmp/htaccess_hardened"

# 5. Install on instance
echo "5. Installing on instance..."
ssh -i "$SSH_KEY" "root@$INSTANCE_IP" <<ENDSSH
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
mysql -u root -p$MYSQL_ROOT_PASS wordpress <<EOSQL
UPDATE wp_options SET option_value = 'http://$INSTANCE_IP' WHERE option_name = 'siteurl';
UPDATE wp_options SET option_value = 'http://$INSTANCE_IP' WHERE option_name = 'home';
UPDATE wp_posts SET guid = REPLACE(guid, 'http://localhost:8085', 'http://$INSTANCE_IP');
UPDATE wp_posts SET guid = REPLACE(guid, 'http://localhost', 'http://$INSTANCE_IP');
UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://localhost:8085', 'http://$INSTANCE_IP');
UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://localhost', 'http://$INSTANCE_IP');
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, 'http://localhost:8085', 'http://$INSTANCE_IP');
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, 'http://localhost', 'http://$INSTANCE_IP');
EOSQL

# Set permissions
chown -R www-data:www-data /var/www/html
find /var/www/html -type d -exec chmod 755 {} \;
find /var/www/html -type f -exec chmod 644 {} \;

# Deploy the hardened .htaccess
cp /tmp/htaccess_hardened /var/www/html/.htaccess
chown www-data:www-data /var/www/html/.htaccess
chmod 644 /var/www/html/.htaccess

# Activate theme and plugin using WP-CLI
cd /var/www/html
wp --allow-root theme activate my-custom-theme
wp --allow-root plugin activate timer-engine

# Set permalinks and flush rewrite rules
wp --allow-root rewrite structure '/%postname%/'
wp --allow-root rewrite flush

# Generate new security salts on production
SALTS=\$(curl -s https://api.wordpress.org/secret-key/1.1/salt/)
if [ -n "\$SALTS" ]; then
    sed -i "/AUTH_KEY/d; /SECURE_AUTH_KEY/d; /LOGGED_IN_KEY/d; /NONCE_KEY/d" wp-config.php
    sed -i "/AUTH_SALT/d; /SECURE_AUTH_SALT/d; /LOGGED_IN_SALT/d; /NONCE_SALT/d" wp-config.php
    echo "\$SALTS" >> wp-config.php
fi

# SECURITY: Clean up temp files on server
rm -f /tmp/wp-content.tar.gz /tmp/wordpress_backup.sql /tmp/htaccess_hardened
rm -f /root/credentials.txt

# Restart Apache
systemctl restart apache2

echo "Migration complete!"
ENDSSH

# Clean up local temp files
rm -f wp-content.tar.gz wordpress_backup.sql wordpress_backup.sql.bak

echo "================================================"
echo "Migration Complete!"
echo "================================================"
echo "Your WordPress Blog Timer is now live at: http://$INSTANCE_IP"
echo ""
echo "IMPORTANT POST-MIGRATION SECURITY STEPS:"
echo "1. Change the WordPress admin password immediately"
echo "2. Set up SSL: ssh -i $SSH_KEY root@$INSTANCE_IP 'certbot --apache'"
echo "3. Set up system cron for wp-cron"
echo "4. Verify .htaccess security headers are active"
echo ""
echo "To generate timer posts on the server:"
echo "  ssh -i $SSH_KEY root@$INSTANCE_IP"
echo "  cd /var/www/html"
echo "  wp timer-generator generate-all-timers --allow-root"
echo "  wp timer-generator generate-guides --allow-root"
