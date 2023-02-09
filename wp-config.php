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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'jamesway-str' );

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
define( 'AUTH_KEY',         'q,f WrIgguP5qURms&(p7Xd/764<.gd/ X`V^|9L1xT[^(~u~8Qc-CT]mQ!H/9Lj' );
define( 'SECURE_AUTH_KEY',  'EjI2(p<%bV.b6:,^sQLWR_vU-a)ZVY7W3x&3)T2wgv-Nfx7Lxjr@q/6)N]+0TJgg' );
define( 'LOGGED_IN_KEY',    '5pX=[1[R3YJvr|1$e7Tm40_b{|Sgg*MNzv@_zzYNL6qm&=f^bfM2agzs85a/tfkT' );
define( 'NONCE_KEY',        '6@R`sR$PDL?<Au+[GY*uRX~160EGZ-G<nR[QU4}(&.UZEP,Cse+|e`qx;ODJa6*,' );
define( 'AUTH_SALT',        '[1J?unB+!uOZSY1b(SXrc;[@)0n@</A/dNPd;vLJ3i;2L#Hi:Wyg/@_FW0aS1;km' );
define( 'SECURE_AUTH_SALT', 'vt~XxgnDy{Tji7gQLgvt;c:U1mQ(7Dy`g(uVi_t.&S-r-rXF@~m5OCt(EqN|3$N;' );
define( 'LOGGED_IN_SALT',   '=~)B!?#%t&=)IAt^|#u,StC6`Jm(ijufqPg: X _U`(F;TRwBFV@*QEnPGRs%H_&' );
define( 'NONCE_SALT',       'K*Wl4l735l<:Z{nqr<@U`oKtvZT{Mfh{9L%pSv/ZYPX+qwYgqlNse<PL13H9H3&j' );

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
