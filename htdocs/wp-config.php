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
define('DB_NAME', 'krishna');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'lX9vJOMw~>?]{3&y;,w/l&7bwJ`# iArZ>_|+w@]n-djVvbFdX%QxfWKqOl@4ev:');
define('SECURE_AUTH_KEY',  ')IaA^mw1J>XR|&*wnsw-h^?5bMT?9<@S#Y>#!Uo l+FI+;-(:Ux5B*F: _+7PES3');
define('LOGGED_IN_KEY',    '<NiDt.u%+t*m}E;7sj^9)V?~sUIHmRW/_*-pE7[l#pnw.9iD|Q|rv>]w8+iAl$|v');
define('NONCE_KEY',        'k-+0KWi$NJfucyFJ# 5V}||c |*ZblU@qFQw{<5$a_v?o+ek6HG^E-Fd|9iA?|r!');
define('AUTH_SALT',        'Bu#~J8r2z{hU5czk[B~+eSp1?^AEH!XX6MJb7xGK-~HKb{AWST??B1w5lgCM.%m4');
define('SECURE_AUTH_SALT', ',Vne}k+ecu85s<4gL_g9[`?Z:nmMHh}7?{<I^2=ZA5:%~H#d<l9J{|e&_m)ST?|+');
define('LOGGED_IN_SALT',   'oUQ<Ibv@.$izV4:<-,jp#<$z>-jV_+~K9^)XE0?+jsY L|KyxJt*BO= -<UUa:AO');
define('NONCE_SALT',       'i/@w]z29GvC|qY*@4UspFn^$oQiR]S]_Rz>vP|;)6$GEh(X+Y{/o5dUcHYO>kW,!');

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
