<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * The configuration file
 */
!defined( 'HMWP_REQUEST_TIME' ) && define( 'HMWP_REQUEST_TIME', microtime( true ) );

if(defined( 'NONCE_KEY' )){
    defined( '_HMWP_NONCE_ID_' ) || define( '_HMWP_NONCE_ID_', NONCE_KEY );
}else{
    defined( '_HMWP_NONCE_ID_' ) || define( '_HMWP_NONCE_ID_', md5(date('Y-m-d')) );
}

//Force Hide My WP buffer to load right after initialization
defined( 'HMW_PRIORITY' ) || define( 'HMW_PRIORITY', false );
//Force not to write the rules in config file
defined( 'HMW_RULES_IN_CONFIG' ) || define( 'HMW_RULES_IN_CONFIG', true );
//add HMW Rules in WordPress rewrite definition in htaccess
defined( 'HMW_RULES_IN_WP_RULES' ) || define( 'HMW_RULES_IN_WP_RULES', true );
//Force all CSS and JS to load dynamically
defined( 'HMW_DYNAMIC_FILES' ) || define( 'HMW_DYNAMIC_FILES', false );
//Force Hide My WP to rename the paths even in admin mode
defined( 'HMW_ALWAYS_CHANGE_PATHS' ) || define( 'HMW_ALWAYS_CHANGE_PATHS', false );
//Set a custom cookie while user logged in for path disable feature
defined( 'HMWP_LOGGED_IN_COOKIE' ) || define( 'HMWP_LOGGED_IN_COOKIE', 'hmwp_logged_in_' );


//Set the PHP version ID for later use
defined( 'PHP_VERSION_ID' ) || define( 'PHP_VERSION_ID', (int)str_replace( '.', '', PHP_VERSION ) );
//Set the HMWP id for later verification
defined( 'HMWP_VERSION_ID' ) || define( 'HMWP_VERSION_ID', (int)str_replace( '.', '', HMWP_VERSION ) );

/* No path file? error ... */
require_once(dirname( __FILE__ ) . '/paths.php');

/* Define the record name in the Option and UserMeta tables */
define( 'HMWP_OPTION', 'hmwp_options' );
define( 'HMWP_OPTION_SAFE', 'hmwp_options_safe' );
