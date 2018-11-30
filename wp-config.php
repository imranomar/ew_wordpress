<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'eazywash');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'O}`JM}:D*9C;+%tj ~Jj6F0KF)}jHa6Q;$651P`D-O?9l=m9nU!Z?;_76V|[{gVw');
define('SECURE_AUTH_KEY',  'qd}~B1&4~e6;Y4|bL21RhWj(ZE[cWlBctJ1Lil,sRgrH?.[!RexCK06PztXHfPeD');
define('LOGGED_IN_KEY',    '!@Zxe~l*=+u%$bN#S:>dP*lDj&<0M!}yO>Fe9:ef!GJ)I@vf HNb382WK%9TKITi');
define('NONCE_KEY',        'r,m`>wT[7EifF.#TKUAW{?h%-fHOiBi=^NPX+]B8 c`HqP2n-DFYM+P2*n#uMX$m');
define('AUTH_SALT',        'lwi7tb41bEQ[v1l2[uY^3XK<gVD^1]JUQNf`4t,j=w>Q2F;8u~MOeD+vr38UF{`c');
define('SECURE_AUTH_SALT', '&%r;&Y46:}xdkr#Si!qi!n4`J+g<TFoKpkmg}#fJyHkU<n(Kgs#pz1vQ.L4$fj8t');
define('LOGGED_IN_SALT',   '6l6qFsvb1-%S-iJ>%,$Qyn:R&8oQ;bG+z~h_Y3*hd/%8?qJC]?Ke>a[,OZrsZ-GT');
define('NONCE_SALT',       'CRI0~Q,Ds9,S2OKn@8G<K+ v7I/#6Zy_`8lLR-yaG+8sXE0urU!|_^F^02@lgyTW');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

//ini_set(‘display_errors’,’Off’);
//ini_set(‘error_reporting’, E_ALL );
//ini_set(‘error_reporting’, 0 );
//define(‘WP_DEBUG’, false);
//define(‘WP_DEBUG_DISPLAY’, false);
//define(‘WP_DEBUG’, true);
//define(‘WP_DEBUG_DISPLAY’, true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
