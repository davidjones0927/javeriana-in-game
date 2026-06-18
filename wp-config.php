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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u878289058_Qli2z' );

/** Database username */
define( 'DB_USER', 'u878289058_jn8qs' );

/** Database password */
define( 'DB_PASSWORD', 'P&Fr}5~>M]' );

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
define( 'AUTH_KEY',          '-m>p}M>GI}Zc0EBQW9:{Kr>~x20]U1;y||-.Z,w G0nn^8UY9ji~=RcE |WIE(}8' );
define( 'SECURE_AUTH_KEY',   'mXpyDnv{Ela Ki$Ycv_5N^.;wq/ F:*{AQ%8Q*c@ssf#J(YX]o;/[R#dJ(B![/$f' );
define( 'LOGGED_IN_KEY',     '5!VJ~hrvsxhrp) I%k{^ZwZ8TR&3M0aipH|ib{JqewTUuOcvF$;K>amfjd#c!iOI' );
define( 'NONCE_KEY',         'p!$][:OP0/zAHz]-rsXAHYrh ^#k32{LEc8E.Q:08GZN}kUp?Wlj^aChumD<h4Pb' );
define( 'AUTH_SALT',         'x|<VBYr4Ldf:-U7a$d;bxJUq{Z#OnI@R</U+^y:B]Jb#wwG|63Oqub41St6H[c)F' );
define( 'SECURE_AUTH_SALT',  'GVFL6Oy<x*lpsj/syP&~i-mr2n#~!qcjnYNAeBjE5j96t%H14{{^EgWa:]CmyN!F' );
define( 'LOGGED_IN_SALT',    'LXN.Y#GS7Uu8A#e|RsEv~)Wjdb3MS`8]6y,+3`qgUTfTZ5eGQH>9kWt .3eN+ 2e' );
define( 'NONCE_SALT',        '_4x>6Ah(q;T<q|V_(sl6`ED0$D &>9%NAy+;3#Aisr<0_kq+R;&JPF*]#M@8-h0h' );
define( 'WP_CACHE_KEY_SALT', ' x4 .<$iR[~==[M}dRyN5XX]Wd7u(#kez1~,:Tw4^f`,>XmX(rL.khbVPPP.$+}1' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'd8178d45eb98c17d5d095a392b059dba' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
