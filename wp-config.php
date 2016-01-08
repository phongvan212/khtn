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
define('DB_NAME', 'dbKHTN');

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
define('AUTH_KEY',         'uRs)I;_<TVuNy{z?a%$:}yp[W2$OWPf`zsMuF*.I^7>+4n(|J]kp+oiX;W XD!%;');
define('SECURE_AUTH_KEY',  '#LSy6l/*9Hw&(B(^1+Op%|(O|7Y)RkyTKqd^o+YJEtc9)By-fz,2Nx/B=[^jvp.+');
define('LOGGED_IN_KEY',    '<@UIbk;_a4zbdY q0&_zz`xpqG(i1u+33uega`#4hYM! 7|T23h+b^5`2Oh|=3bJ');
define('NONCE_KEY',        '{.sM$q$efNDK:w[aWFGbUWUz!KfQ-S9:6c/@wPW Iw8[mnq:2r>@h:J_l!|*{f!+');
define('AUTH_SALT',        'oLUBql0p[UE/y;.;h:%`-lCkRdk5619:/G&g;1<vT2dR=#w8m#$lIIeG$D{E@;*9');
define('SECURE_AUTH_SALT', '$Bu(DCO1zbbI@a1sF&^l3!Xj8/qVrfx|<mx^VU2,|^N@?`B;W/,4vx5PO4-7V7R2');
define('LOGGED_IN_SALT',   'p!%`[e>xye6q|K{jGnwRt]GoK<0aC GSsj/*4C8rjP7-#0 |G@?&/{kv~k}5@o4T');
define('NONCE_SALT',       '>-j--q5p4= 4qtC%:I1A>k WiGS W^6&QbSK8#]H4Hd0]FFReIid}3*(m$ g/5a+');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
