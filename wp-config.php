<?php
//define( 'WPCACHEHOME', '/home/genderhub/public_html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('CONCATENATE_SCRIPTS', false);

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
 

//* define('ALTERNATE_WP_CRON', true);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'genderhub_wp' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Serendipity99*%' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define('AUTH_KEY',         'sh#(!>^>2-L-eVaPdjk+[FF^?3 -O8X|(gx~2$$+-^QJ#VMDM<2alB`mF*!.MFd&');
define('SECURE_AUTH_KEY',  'Es!$}u<Rie-Ps4q{ H/TmZZn*TnuA&5Xkp:9sD1y+iZn.0chd#XnawF>XS.*Wzm!');
define('LOGGED_IN_KEY',    'GoBim^@{l^AmnGG/d( P=xL[,#liTv+~0rc!qZ9U7wTcZ*[|~7vKm.k~S-ON`;Sd');
define('NONCE_KEY',        'TE77#vp,S?w@[Q:M|g|?-SwA9*4@ajeDwdak}Y@!n iw<1RL[C8Ko$jt;pd%JRMX');
define('AUTH_SALT',        ';J?/dRdx7cWr;kVLz2Ax9e_:3rP=-H/hTwEN`k+kl=KZETOa^IM]Pa{e-Q&dbt2a');
define('SECURE_AUTH_SALT', 'xaAWc}V&R|P.u0@A8m:u+m:YqR-:; -/> cpYxuCq1N?+veuxXyv?!eeq+k9`Frr');
define('LOGGED_IN_SALT',   'f[5}<8jD(Mlo~vxYj;$RMJoS*@cZiRgY|2,q--=)1~OJpWw1UO[`T-AB`pDw;8l1');
define('NONCE_SALT',       'zu,4#|F#:qCz>dU8msk P4;!#Nv_{tpn#Kn_j)% FGH/f0c8y/:l!n-_`=-8}U@=');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpgh_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'en_GB');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
// Turns WordPress debugging on
define('WP_DEBUG', true);

// Tells WordPress to log everything to the /wp-content/debug.log file
define('WP_DEBUG_LOG', false);

// Doesn't force the PHP 'display_errors' variable to be on
define('WP_DEBUG_DISPLAY', false);

// Hides errors from being displayed on-screen
@ini_set('display_errors', 0);


/* set post revisions 
define ('WP_POST_REVISIONS', 2); */

/* change auto save from default 60 seconds */
define ('AUTOSAVE_INTERVAL', 180);

/* change saved in trash from default 30 days */
define ('EMPTY_TRASH_DAYS', 1);

/* STOP ABILITY TO EDIT PLUGINS IN ADMIN */
define('DISALLOW_FILE_EDIT', false);

/* STOP ABILITY TO DELETE / ADD PLUGINS
*/
define('DISALLOW_FILE_MODS', false);

/* enable WP caching */
//define('WP_CACHE', true); //Added by WP-Cache Manager

/* hard code site urls and lock them */
define('WP_HOME','http://genderhub:8888');
define('WP_SITEURL','http://genderhub:8888');


/* enable cookie domain 
//define ('COOKIE_DOMAIN','www.genderhub.org'); 
*/










/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
