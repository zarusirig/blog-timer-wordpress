<?php
/**
 * WordPress Configuration - Works for both local Docker and Digital Ocean
 */

// Environment detection
$http_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$is_local = (strpos($http_host, 'localhost') !== false || strpos($http_host, '127.0.0.1') !== false || getenv('WORDPRESS_DB_HOST'));

// Database settings - dynamically set based on environment
if ($is_local) {
    // Docker/Local environment
    define('DB_NAME', getenv('WORDPRESS_DB_NAME') ?: 'wordpress');
    define('DB_USER', getenv('WORDPRESS_DB_USER') ?: 'wordpress');
    define('DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: 'wordpress_password');
    define('DB_HOST', getenv('WORDPRESS_DB_HOST') ?: 'mysql:3306');
} else {
    // Digital Ocean production - these will be set during deployment
    define('DB_NAME', 'wordpress');
    define('DB_USER', 'wordpress');
    define('DB_PASSWORD', 'CHANGE_ON_DEPLOYMENT'); // Will be updated by deploy script
    define('DB_HOST', 'localhost');
}

define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// Authentication keys and salts
define('AUTH_KEY', 'put your unique phrase here');
define('SECURE_AUTH_KEY', 'put your unique phrase here');
define('LOGGED_IN_KEY', 'put your unique phrase here');
define('NONCE_KEY', 'put your unique phrase here');
define('AUTH_SALT', 'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT', 'put your unique phrase here');
define('NONCE_SALT', 'put your unique phrase here');

// WordPress Database Table prefix
$table_prefix = 'wp_';

// Development/Debug settings
if ($is_local) {
    define('WP_DEBUG', true);
    define('WP_DEBUG_LOG', true);
    define('WP_DEBUG_DISPLAY', true);
    define('SCRIPT_DEBUG', true);
} else {
    define('WP_DEBUG', false);
    define('WP_DEBUG_DISPLAY', false);
}

// URL settings for development
if ($is_local) {
    $local_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
    define('WP_HOME', 'http://' . $local_host);
    define('WP_SITEURL', 'http://' . $local_host);
}

// File permissions
define('FS_METHOD', 'direct');
define('FS_CHMOD_DIR', (0755 & ~umask()));
define('FS_CHMOD_FILE', (0644 & ~umask()));

// Increase memory limit
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// Disable automatic updates in development
if ($is_local) {
    define('AUTOMATIC_UPDATER_DISABLED', true);
    define('WP_AUTO_UPDATE_CORE', false);
}

// SSL settings for production
if (!$is_local && isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

// Absolute path to the WordPress directory
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

// Sets up WordPress vars and included files
require_once(ABSPATH . 'wp-settings.php');