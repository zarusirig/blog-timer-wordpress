<?php
/**
 * WordPress Configuration - Works for both local Docker and Digital Ocean
 * SECURITY HARDENED - Feb 2026
 */

// Environment detection
$http_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
$is_local = (strpos($http_host, 'localhost') !== false || strpos($http_host, '127.0.0.1') !== false || getenv('WORDPRESS_DB_HOST'));

// Database settings - dynamically set based on environment
if ($is_local) {
    // Docker/Local environment - credentials from env vars only
    define('DB_NAME', getenv('WORDPRESS_DB_NAME') ?: 'wordpress');
    define('DB_USER', getenv('WORDPRESS_DB_USER') ?: 'wordpress');
    define('DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: 'wordpress_password');
    define('DB_HOST', getenv('WORDPRESS_DB_HOST') ?: 'mysql:3306');
} else {
    // Production - these MUST be set during deployment via sed
    define('DB_NAME', 'wordpress');
    define('DB_USER', 'wordpress');
    define('DB_PASSWORD', 'CHANGE_ON_DEPLOYMENT');
    define('DB_HOST', 'localhost');
}

define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// Authentication keys and salts - UNIQUE CRYPTOGRAPHIC KEYS
define('AUTH_KEY',         'k9#Xm4$vLpQ7!rN2wTe5^jHgBz&Yf8AcUdWo0iSsD3lR6KxCbMa1JnFyP@qVuG');
define('SECURE_AUTH_KEY',  'Wq3$Lm7!Hk9@Bn5^Rf2&Yd8*Tc1Xp4Uj6Gs0NeZo#Ia%Ev+Fw-Cx.Dz:Ky;Jl');
define('LOGGED_IN_KEY',    'Pv8@Jn2#Wg6^Tz0&Xk4!Qs9*Lf3Yd7$Uc1Rm5%Bh+Ei-Oa.Nw:Cs;Dp,Kx>Mj');
define('NONCE_KEY',        'Hx5!Qd9@Nk3#Yf7^Wp1&Tc4*Rl8$Uj2Bg6%Le0Sm+Ia-Ov.Cz:Kw;Fn,Gm>Xb');
define('AUTH_SALT',        'Mz7@Uf1#Kd5^Tq9&Ys3!Lx6*Wn0$Hg4Pc8%Ej2Rv+Bi-Oa.Cm:Nw;Fs,Dk>Jl');
define('SECURE_AUTH_SALT', 'Bd4!Hn8@Xk2#Wg6^Tf0&Qs3*Yc7$Lm1Uj5%Rv9Pi+Ea-Os.Nz:Kw;Cm,Fx>Dl');
define('LOGGED_IN_SALT',   'Vc9@Rm3#Jf7^Yd1&Tk5!Bg8*Xn2$Qs6Wl0%Uo4Hi+Ea-Pz.Kw:Cs;Nm,Dx>Fg');
define('NONCE_SALT',       'Nl6!Tk0@Wg4#Xd8^Yf2&Qs5*Hm9$Uj3Rv7%Lc1Bi+Ea-Oz.Pw:Ks;Cn,Fm>Dx');

// WordPress Database Table prefix
$table_prefix = 'wp_';

// ==========================================
// SECURITY HARDENING
// ==========================================

// Disable file editing from WordPress admin (prevents code injection via dashboard)
define('DISALLOW_FILE_EDIT', true);

// Disable plugin/theme installation from admin (prevents uploading backdoors)
if (!$is_local) {
    define('DISALLOW_FILE_MODS', true);
}

// Limit post revisions to prevent database bloat (used in spam injection)
define('WP_POST_REVISIONS', 5);

// Force SSL on admin in production
if (!$is_local) {
    define('FORCE_SSL_ADMIN', true);
}

// Block external HTTP requests except to whitelisted hosts
// This prevents phone-home backdoors from communicating with C2 servers
if (!$is_local) {
    define('WP_HTTP_BLOCK_EXTERNAL', true);
    define('WP_ACCESSIBLE_HOSTS', 'api.wordpress.org,downloads.wordpress.org,*.github.com');
}

// Disable WordPress cron (use system cron instead to prevent wp-cron.php abuse)
if (!$is_local) {
    define('DISABLE_WP_CRON', true);
}

// Development/Debug settings
if ($is_local) {
    define('WP_DEBUG', true);
    define('WP_DEBUG_LOG', true);
    define('WP_DEBUG_DISPLAY', true);
    define('SCRIPT_DEBUG', true);
} else {
    define('WP_DEBUG', false);
    define('WP_DEBUG_LOG', false);
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
