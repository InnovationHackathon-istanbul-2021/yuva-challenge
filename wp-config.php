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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'yuvaassociation' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'UUUNKPu70IRH%5N!h& DWCd$C_=RqF&/Rh(zq@Kuai0Q/V(KiS .?ixAgJMJ}J5(' );
define( 'SECURE_AUTH_KEY',  '{ru-jQyE@p=7QrxO}GjxDW|(T5};oLA5GK^|%eB*Cs63!zs6p6b~ZySEtv@:l9c6' );
define( 'LOGGED_IN_KEY',    'D>Jsu#@sAeStlx)_PuMgAk=8Y@KTFlp5shUSm8j$QpUF.OHK@EN~SDPF9p-qbqwT' );
define( 'NONCE_KEY',        'kIjQq%w-6<mc`;x- U`$nL#o]s-DH5&^S<gsd]FpB-%4wI,8!A.*exn.m>3:jlG6' );
define( 'AUTH_SALT',        '{ZXIh16d(2hK/.Gg)|:@91`&6z9L6${0QT?TZRzhRh,+Lb91f8hx7pmu7${l$[xO' );
define( 'SECURE_AUTH_SALT', 'U6@!=iFRvgI)!7Hj+z[wUAE(e&*5X-m9n/EF!L$bZ_@lQVofuWdB,F^DF.CAQjnC' );
define( 'LOGGED_IN_SALT',   'J%AWNg~&`w*^n,vMXc~L;LrkkNS%_cb]1RjXd`C_-gezL1XyA(~&=GaH!o7[n2yp' );
define( 'NONCE_SALT',       ';3%pDqtb`7R3ZN$|fDfa10OcR-<$iA[c5I[~rj~d?iL;jBE]2W,{`jg>`!>d78u7' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
