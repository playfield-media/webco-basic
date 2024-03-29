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
define('DB_NAME', 'basic-webco');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'i-4R^BUtu@-Fp/-oA$<5p(+ZfjArWZR@^-|Q|ZDd%!wX!AVGd/9:}%*%ERx&<!+2');
define('SECURE_AUTH_KEY',  '[@YTV WqX7BG2N3S5cu8/>MoqyQ-iWFaptB:M=1j/U--A[I>_`fUApg?GNeqhx>e');
define('LOGGED_IN_KEY',    '+2tJX?v4hTpxb~=O@<VH1sf-N<y#(hk36-2,v|D2pb#---:_r6_Aw6V1Cc=^Dm#Y');
define('NONCE_KEY',        '1f>&!E|+`-hV-Mp1S1Tr;+`m7)S,)}E/I1cbI5#|y;pJ%(02+K;wPYpG^`*PB)v-');
define('AUTH_SALT',        '%;bf6l`^LX`qQD-~X<).KW;OoT|wZVBbYi3=`j-o3&SlX}r|61*jdiaJl;knh]*&');
define('SECURE_AUTH_SALT', 'l0&3m,3cN|kBa +!l_HnPY+l;-(m-WGPdbWvQuCpG#&s3zgb91lK .?8+b{6a/Y/');
define('LOGGED_IN_SALT',   '>7R6=l<iypcWRjT2UQEH:IWN_n;m54+-8A&gJF.9}u+QTe6tx>t]F5:o|O(i<+Y9');
define('NONCE_SALT',       '<<Pue:uA/-`>~Dht;;W-S%?U6wT2$3#$k3Q<D!O!>9E#^e,S&o@5=}n=D;es|1j.');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wi_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'nl_NL');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
