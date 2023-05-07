<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '?~gVeXD?HE}^$)[Hu5cSIHG!vOt,3HL M[,md5eIFo>O)/8q`4^MRE^g0nc)M3Ts' );
define( 'SECURE_AUTH_KEY',  'WqT#__#EkV%@&0@&DLAit+T6KfA$F#4Oe-frz;/H$o/w|c)/XM=8qMcv^*wmSg a' );
define( 'LOGGED_IN_KEY',    '{D>I??}(HxJ:nJwUeM@>ZoJL+j}L8{1,QL+)kT=2Nfm^2I`vN gkk[En!ipx?=;2' );
define( 'NONCE_KEY',        't>[G<SyC(%5xgpl0]36b8hx]K*#5+2K)Q4,judnj4!l4JVSMSFbLDG8}9f$FH0=U' );
define( 'AUTH_SALT',        '~%>V&qRF|Dd=y~B,pHR_~Z335o&;M[^-?DS/PGfMqi(V#DQAK,i1Td5hPh]10j%m' );
define( 'SECURE_AUTH_SALT', '^N; z/G*=v3 Nqo2U;J[LY0Wk_Yat5}/.wPP)Q#`M9Hd;J>pp+>JJhG+.y0vWDZt' );
define( 'LOGGED_IN_SALT',   '5a)*`:O7F0{f8&Nv2$>.:g>80>HT{zrE80xyNH9s7Pg;Uqwh>l0Or~ii<p)4tjTd' );
define( 'NONCE_SALT',       'A}W($b}>E=P*y4*%:bUrePKzN&49$_!~hoKk5]-s*B/N5rQc?@v>cFl+,T<4F:;9' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
