<?php
define( 'WP_CACHE', true );
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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u199319889_qLjMI' );

/** Database username */
define( 'DB_USER', 'u199319889_CahMa' );

/** Database password */
define( 'DB_PASSWORD', 'tYcIKiKYEN' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'qZ${x11m/I74)0vu3%z$!U*;9p!)7qqH?4AfAtorYrOrI$Y{|thgSA^zeCcJ$*T9' );
define( 'SECURE_AUTH_KEY',   ';cTE&&d%DH WcIHn!s_rvj2UPqi>?`Z%Hh}h4iN,<%_mzpD17^&@sN_(nw)Wg<vh' );
define( 'LOGGED_IN_KEY',     '}88UjaIX)~c92_~eE#*Y$dW;}TYwVVGmTJrT s>)1@r,&/oLO*soiuzbe}4_~(ev' );
define( 'NONCE_KEY',         'EQWc?5l% [lqJ0faNawg) R@d`-4;Z d!H Xt_%7k03Yju|h?aA.~Y*m_7Huov!P' );
define( 'AUTH_SALT',         'V!B>4MB[*FnA8<[C(}M*w%|8g5k(]Xj4VeMS2fGqGGVI7jRhii?py0WBRHjp?An}' );
define( 'SECURE_AUTH_SALT',  '@)vC<)o4A_{:k]&/lIvkttpsV*9wEM~Ntl!zmFzG,+Z%gu$P2,OvGz=b3T5G`8HP' );
define( 'LOGGED_IN_SALT',    'A>Y4@-O46IFFEU.q]6P4hi)Jrf{9!7+U_Du,*|1aUC1O,&gFX7`/1CXz8f!#E6g@' );
define( 'NONCE_SALT',        'Zm-`XYV3?I_^_>Z}Kw4e_5^mY{UCMGe1S,)>Q~pb[@d4&Es-Xsqu3rj>D*a1Q$^M' );
define( 'WP_CACHE_KEY_SALT', '{QoT_9 C[gnvDPKStKU&JZ|Jl_R|heYg7.Jh>6i?gM_j5v5Ny,H hKcfB,8&gsdH' );


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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';