#!/usr/bin/env python3
"""
Create Vultr Instance with SSH access and WordPress
"""

import requests
import json
import time
import sys
import os
import base64
from pathlib import Path

# Load .env
try:
    from dotenv import load_dotenv
    load_dotenv()
except ImportError:
    pass

def get_ssh_key_id():
    """Get the SSH key ID from file or API"""
    if os.path.exists('.ssh_key_id_vultr'):
        with open('.ssh_key_id_vultr', 'r') as f:
            return f.read().strip()
    return None

def create_wordpress_instance():
    api_token = os.getenv('VULTR_API_KEY')
    if not api_token:
        print("❌ VULTR_API_KEY not found in .env")
        print("Get your API key from: https://my.vultr.com/settings/#settingsapi")
        sys.exit(1)
    
    headers = {
        'Authorization': f'Bearer {api_token}',
        'Content-Type': 'application/json'
    }
    
    # Get SSH key ID
    ssh_key_id = get_ssh_key_id()
    if not ssh_key_id:
        print("❌ No SSH key found. Run: ./setup_ssh_vultr.sh first")
        sys.exit(1)
    
    # Generate passwords
    import secrets
    import string
    chars = string.ascii_letters + string.digits
    mysql_root_pass = ''.join(secrets.choice(chars) for _ in range(16))
    wp_db_pass = ''.join(secrets.choice(chars) for _ in range(16))
    
    # Instance configuration
    region = os.getenv('VULTR_REGION', 'ewr')  # New Jersey
    plan = os.getenv('VULTR_PLAN', 'vc2-1c-1gb')  # $6/month, 1GB RAM
    
    # User data script to install WordPress
    user_data = f"""#!/bin/bash
# Install WordPress on Ubuntu 22.04
export DEBIAN_FRONTEND=noninteractive

# Update system
apt-get update && apt-get upgrade -y

# Install Apache, PHP 8.3, MySQL
apt-get install -y software-properties-common
add-apt-repository -y ppa:ondrej/php
apt-get update

# Install packages
apt-get install -y apache2 mysql-server \\
    php8.3 php8.3-cli php8.3-common php8.3-mysql \\
    php8.3-xml php8.3-xmlrpc php8.3-curl php8.3-gd \\
    php8.3-imagick php8.3-mbstring php8.3-zip \\
    php8.3-intl php8.3-bz2 php8.3-bcmath php8.3-soap \\
    libapache2-mod-php8.3

# Configure MySQL
mysql <<EOF
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '{mysql_root_pass}';
CREATE DATABASE wordpress;
CREATE USER 'wordpress'@'localhost' IDENTIFIED BY '{wp_db_pass}';
GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';
FLUSH PRIVILEGES;
EOF

# Download WordPress
cd /tmp
wget https://wordpress.org/wordpress-6.8.1.tar.gz
tar xzvf wordpress-6.8.1.tar.gz
cp -R wordpress/* /var/www/html/
rm -f /var/www/html/index.html

# Configure WordPress
cp /var/www/html/wp-config-sample.php /var/www/html/wp-config.php
sed -i "s/database_name_here/wordpress/" /var/www/html/wp-config.php
sed -i "s/username_here/wordpress/" /var/www/html/wp-config.php
sed -i "s/password_here/{wp_db_pass}/" /var/www/html/wp-config.php

# Set salts
curl -s https://api.wordpress.org/secret-key/1.1/salt/ >> /tmp/salts
sed -i "/AUTH_KEY/d; /SECURE_AUTH_KEY/d; /LOGGED_IN_KEY/d; /NONCE_KEY/d" /var/www/html/wp-config.php
sed -i "/AUTH_SALT/d; /SECURE_AUTH_SALT/d; /LOGGED_IN_SALT/d; /NONCE_SALT/d" /var/www/html/wp-config.php
sed -i "/define( 'DB_COLLATE'/r /tmp/salts" /var/www/html/wp-config.php

# Set permissions
chown -R www-data:www-data /var/www/html
find /var/www/html -type d -exec chmod 755 {{}} \\;
find /var/www/html -type f -exec chmod 644 {{}} \\;

# Enable Apache modules
a2enmod rewrite

# Configure Apache virtual host
cat > /etc/apache2/sites-available/wordpress.conf <<'APACHECONF'
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html
    
    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${{APACHE_LOG_DIR}}/error.log
    CustomLog ${{APACHE_LOG_DIR}}/access.log combined
</VirtualHost>
APACHECONF

# Enable the new site
a2dissite 000-default.conf
a2ensite wordpress.conf

# Create .htaccess
cat > /var/www/html/.htaccess <<'HTACCESS'
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\\.php$ - [L]
RewriteCond %{{REQUEST_FILENAME}} !-f
RewriteCond %{{REQUEST_FILENAME}} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
HTACCESS

chown www-data:www-data /var/www/html/.htaccess
chmod 644 /var/www/html/.htaccess

# Install WP-CLI
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp

# Restart Apache
systemctl restart apache2

# Mark as ready
touch /root/.wordpress_ready
echo "MySQL Root: {mysql_root_pass}" > /root/credentials.txt
echo "WP DB Pass: {wp_db_pass}" >> /root/credentials.txt
"""
    
    # Create instance
    instance_data = {
        'region': region,
        'plan': plan,
        'os_id': 1743,  # Ubuntu 22.04 LTS x64
        'sshkey_id': [ssh_key_id],
        'label': f'wordpress-timer-{int(time.time())}',
        'hostname': 'blog-timer',
        'enable_ipv6': True,
        'backups': 'disabled',
        'ddos_protection': False,
        'user_data': base64.b64encode(user_data.encode()).decode()
    }
    
    print(f"Creating Vultr instance...")
    print(f"Region: {region}, Plan: {plan}")
    print(f"Using SSH key ID: {ssh_key_id}")
    
    response = requests.post('https://api.vultr.com/v2/instances', 
                            headers=headers, json=instance_data)
    
    if response.status_code not in [200, 201, 202]:
        print(f"❌ Failed to create instance: {response.text}")
        sys.exit(1)
    
    instance = response.json()['instance']
    instance_id = instance['id']
    
    print(f"✅ Instance created with ID: {instance_id}")
    print("Waiting for instance to become active...")
    
    # Wait for instance to be active
    for i in range(60):
        time.sleep(5)
        response = requests.get(f'https://api.vultr.com/v2/instances/{instance_id}', 
                              headers=headers)
        if response.status_code == 200:
            instance = response.json()['instance']
            if instance['status'] == 'active' and instance.get('main_ip'):
                break
        print(f"  Waiting... ({i*5}s)")
    
    # Get IP address
    ip_address = instance.get('main_ip')
    
    # Save instance info
    instance_info = {
        'instance_id': instance_id,
        'instance_label': instance['label'],
        'ip_address': ip_address,
        'mysql_root_pass': mysql_root_pass,
        'wp_db_pass': wp_db_pass,
        'region': region,
        'plan': plan,
        'ssh_access': True
    }
    
    with open('.vultr_instance_info', 'w') as f:
        json.dump(instance_info, f, indent=2)
    
    print("\n================================================")
    print("✅ WordPress Instance Created on Vultr!")
    print("================================================")
    print(f"IP Address: {ip_address}")
    print(f"SSH Access: ssh -i ~/.ssh/wordpress_vultr root@{ip_address}")
    print(f"\nMySQL Root Pass: {mysql_root_pass}")
    print(f"WordPress DB Pass: {wp_db_pass}")
    print("\nWordPress will be ready in 2-3 minutes")
    print("\nNext: Run ./migrate_to_vultr.sh to migrate your local WordPress")

if __name__ == '__main__':
    create_wordpress_instance()
