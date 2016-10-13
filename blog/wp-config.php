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
define('DB_NAME', '3038_twizla');

/** MySQL database username */
define('DB_USER', '3038_twizla_u');

/** MySQL database password */
define('DB_PASSWORD', 'YrGkdP37Hd9356H');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1:3320');

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
define('AUTH_KEY',        '4((IjG0u~Ir1+?y]ZnANcuC*W.)CfC1._3mB#6Yk)?CLKqbS/.oG|,H7*mZhw#b<');
define('SECURE_AUTH_KEY', '@^rvGnYE~`]wIoQ0~ptYFse3qgN-%o+|uTpGxzaxU7)I!gBnVfseO^}OqHuy*Y%d');
define('LOGGED_IN_KEY',   'f:%Qa6<c,.6Qm>9(Jn1O+ngJ.&w@g}gP8Pg{Pj0Wb`#EL[|^8s0QF3IBQ+7*NOYJ');
define('NONCE_KEY',       'mkv,B1Ow[G qeU:[/mR T7F{i+ZlkC[3~s4&IDRxpjuGkaPwt]]5rF|HW9r J$(^');
define('AUTH_SALT',        'hgdien');
define('SECURE_AUTH_SALT', 'hgdien');
define('LOGGED_IN_SALT',   'hgdien');
define('NONCE_SALT',       'hgdien');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpBlog_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);


define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/blog');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
