<?php
    require_once('configs/creds.php');
     $dev = $users['dev'];
    // $dev = $users['stage'];
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', $dev['dbname'] );

/** MySQL database username */
define( 'DB_USER', $dev['dbuser']  );

/** MySQL database password */
define( 'DB_PASSWORD', $dev['dbpass'] );

/** MySQL hostname */
define( 'DB_HOST', $dev['dbhost']  );
//define( 'DB_HOST', 'ec2-54-177-231-14.us-west-1.compute.amazonaws.com:3306' );

define('WP_SITEURL', 'http://' . $dev['dbsite']);
define('WP_HOME', 'http://' . $dev['dbsite']);


/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '$B(xW)|l1ZxKs-a&_$&h-Ct5F[=^`]FLba&|grYs7WF7?y5m.QA-!q]YBIt@,6Di' );
define( 'SECURE_AUTH_KEY',  '&Dvtueh{P=8k<Ws:3dwKr0cjGEhd7P-nD^I$kp`||/%_!DVpT,~4zD0VKN8Sb@Jg' );
define( 'LOGGED_IN_KEY',    '(o$/}oj91v$j7H|_{Qb):IKpeS9DFe1/mEUuKNtL.tOP4C=H,/UNq1FWTb~,z;-j' );
define( 'NONCE_KEY',        '>*ZtGsy|}{rXvHxI!.4t2<N](~7aA-)M:)jHO$X3&i#{?n7~h=8mZ$7SoCh,%bhy' );
define( 'AUTH_SALT',        'YDt`StrbI`M)ljMS2/A6u)4O/%fw*n-`ub<6zO$=QF v9t$;O?0B5el1OspJ~.uS' );
define( 'SECURE_AUTH_SALT', 'XZRJO5=A[j?tH$@`{33AB<#5{X7*,9+QwDyaow}5|Vqfom,!l,YFs4%kSP#AgnZJ' );
define( 'LOGGED_IN_SALT',   '<Wix$ohq_>7n45@W,M|IEY[qKryi+nLiqvh7fv0r)Hz?E:Z;-=LD&9{%75;I#5,=' );
define( 'NONCE_SALT',       'F;xII(-n&9MJi2i=oQzep)NN~pGk9&wN1#Xxop,sF$SYFR}u{P&5dN4^!vH< 3o|' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define('WP_DEBUG_DISPLAY', false);


//increases upload size
@ini_set( 'upload_max_size' , '20M' );
@ini_set( 'post_max_size', '13M');
@ini_set( 'memory_limit', '15M' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
