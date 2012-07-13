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
define('DB_NAME', 'dal2012');

/** MySQL database username */
define('DB_USER', 'dal2012');

/** MySQL database password */
define('DB_PASSWORD', 'dal2012');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '@Lv[gSwWCGI0l!|)P/3a|dnx&jg<|Qra7|_=`d(a9Gc4<c[Yv,%?M4- q3#O7+k%');
define('SECURE_AUTH_KEY',  '4e+=:.mqT[$`m~T:LC+j?mLv<QRzqTN9,OXC7q2A,COU%q@8%ON3SA |Bm+?&^5b');
define('LOGGED_IN_KEY',    'f`9b,Gr!=RHtMGue3^_p Bm)_,.Wvl90OMTX;gj12D7qhxD9aWKwe7AIC>+C(wJ%');
define('NONCE_KEY',        'sa;-$c@`cCuL.|%YR%K||U|8!>!x2*3Udqs#spaLL TfI*2;^m$bozWz@pa03-KK');
define('AUTH_SALT',        'C{*8c+-*mhqV)2)n3#%4<LB#B=XN@@=VZ;57b2ZO<C:O#Q9xRPC+9_PY#+9`s6j^');
define('SECURE_AUTH_SALT', 'fhzat#+59+d` 7k|USZ Pi5eSnYxpjL^amt~^ka-,yzfvfh}v.Onfi2K7S`F#Dcp');
define('LOGGED_IN_SALT',   ':DIg;UT?wH!dCvnGIT+K<iP<1$Af71D|b8(>y+a-Y];h,VC{+K}+.50FhN^HZ]-O');
define('NONCE_SALT',       'cMkOMGH;hE{aEsO?``hPYp]`ntQqi*Ska_~[ew1?;F=OQi+G5-A;.fF?HD1+z7x5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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

define('WP_ALLOW_MULTISITE', true);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
$base = '/';
define('DOMAIN_CURRENT_SITE', 'desarrollandoamerica.org');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
