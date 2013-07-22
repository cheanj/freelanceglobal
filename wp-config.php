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
define('DB_NAME', 'freelance');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'kmo%wPUd*|p(V#hJ)jwLdl]a#TxVp=C/z/kbdRQE$+kd?G/@>B~>rdfL`|`ZTlJ%');
define('SECURE_AUTH_KEY',  '@8+(@<5WhAh9G_#W8% NTO(D1hG6V#)2<l LE!u&=>hvL6f{bV&@ZO3^Jl6:M)Cq');
define('LOGGED_IN_KEY',    'NWp`/:z.;V8wDPqe2>V.>n{M|+~5PH~o!<8@>3Z69Ak,o(Kg JdIUAOSm}C,,6FJ');
define('NONCE_KEY',        'hr{ep]7_Z[RJWP~6n1u$QZbISZJiEdEP2#9C17TPhq]wp)GG`Xm/N?IBvlt063uw');
define('AUTH_SALT',        'e5.qt|+(,?jehKC.^R)$6UOAY!Y=JVWb8XKU8JcBXQQ>|VaWOC`O]aoGlfgX=|}t');
define('SECURE_AUTH_SALT', ';=0ag7Hi7mhuY!{+v.F~<9fUo*jIYJ3[>TF3RU*LIVHE?>LO}dZ_#~20.%s?&U#T');
define('LOGGED_IN_SALT',   'sngE-;2I=*.>FDl-so1[rji;3n$]RJy/omLICSfg+4a5(^[;JI=fxzUeT9?`. =<');
define('NONCE_SALT',       'gS]Y7J}HFJ2N_qo@IG183JL8_UJGT XxR=j$Ez-spwkI%!3C>h>rZG/9LKnBv<4F');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
