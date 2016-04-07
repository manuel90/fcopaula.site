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
define('DB_NAME', 'dbfcopaula');

/** MySQL database username */
define('DB_USER', 'fcopaula');

/** MySQL database password */
define('DB_PASSWORD', 'z4LKaFhQqwLztPHd');

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
define('AUTH_KEY',         'Yt?+1O-Vsc705AHu}c-]BT8}Z@g|-:YY}BWTB|{8@j&4!xF9$Fxm:W665<<LZn(%');
define('SECURE_AUTH_KEY',  '0,B##ympm@|,By2-?Y0CML>8al#7EL|jNKZboXlHU.mO*v_G$&zmf*|6-|X)[UIr');
define('LOGGED_IN_KEY',    ')F@a+6Ku=C/~j|eiao!kj[j:C}i6K, -%hb+?0)@1TMQIP$|xmJLzBF7w)9B%Af?');
define('NONCE_KEY',        'Y##N+Ojx-I9n=GT~~SUGz-`w}|Hy/Ol(j/&jQpj|SH_bn?>O`nr_co0GDY{?Low)');
define('AUTH_SALT',        'b0vkE+AW>m]3}3Fb23hq}3rqJ%Fy6q)lch7&pU>e_y#+{>ew]K4&,V-*/|U&K-v ');
define('SECURE_AUTH_SALT', '7_).:%,Mm~of^>dS??pBHGhVm5X_CY`P!Bq<MSpg=E>u1vQ|TwCGWHxjDR-i3uGF');
define('LOGGED_IN_SALT',   'zB49L2&%0-)H]=qXfV(v8j5]yjwurS|[Rzp0G6au?ae0R3#sQwb>-t}AU[<3Fy)}');
define('NONCE_SALT',       '1A7#+5/A-}qGGJZPKntczungLeq9;4TxRd-|I><=h`K4`{sege6YvQ]25o3qpxRu');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'fcopaula_';

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
