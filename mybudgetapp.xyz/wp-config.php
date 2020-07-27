<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'mybudgetapp_xyz');

/** MySQL database username */
define('DB_USER', 'mybudgetappxyz1');

/** MySQL database password */
define('DB_PASSWORD', 'YauT2?-m');

/** MySQL hostname */
define('DB_HOST', 'mysql.mybudgetapp.xyz');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'HNLIEg+L9WVeQNCsG63yWB0sZK@t2Nyy?62MVJ~u1rixhh8p&M7`TZY/r9"^`VsA');
define('SECURE_AUTH_KEY',  'CBT:y&wutV*1_OwT)Gb05+g:@ptS(lBpB*frP4VOV0p)Mh0b3^n~v&)IJH8XAc1e');
define('LOGGED_IN_KEY',    'i8VT#/aCT(niGVhr(+QZq+9p242yr&JVHu%NV1cBk(2Z8RjHZoCUTR3|YeS4:Gu#');
define('NONCE_KEY',        '!$;z@|FX`&e@sp)1?e4QIITO;6c@)2r`(vtk^4Bs^wFYM?tL&+%iVWg*gJFgSXxo');
define('AUTH_SALT',        '/dm*aX(Zg"JVIe%V1mqge92`eL$LW~F_!8faf?ZRUca6myLA%W@JYC7qJI7r:rV%');
define('SECURE_AUTH_SALT', 'ZsB7#wL@^x$3GWb/Seho;crXx#SwS~6x`VOFVPEMo:MFJNaid^n0U1!H:8O&%B!C');
define('LOGGED_IN_SALT',   '^gB_|xtdk3aV*!IlGt7pAK()ULJjHF+Mj$xe@DvQ:1a?LyJn463_$DBozW*V2K`&');
define('NONCE_SALT',       '&d1cG9I`ui`lYv9;S&2Xp37^A$CoyqXCY4r:$H)Voi+MX9hBWulNkf:b4^QcZr&%');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_bkgkzf_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/**
 * Removing this could cause issues with your experience in the DreamHost panel
 */

if (preg_match("/^(.*)\.dream\.website$/", $_SERVER['HTTP_HOST'])) {
        $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        define('WP_SITEURL', $proto . '://' . $_SERVER['HTTP_HOST']);
        define('WP_HOME',    $proto . '://' . $_SERVER['HTTP_HOST']);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

