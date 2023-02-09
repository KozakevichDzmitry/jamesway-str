<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

$currentDir = dirname( __FILE__ );

define( '_HMWP_NAMESPACE_', 'HMWP' );
define( '_HMWP_VER_NAME_', 'Ghost' );
define( '_HMWP_PLUGIN_NAME_', 'hide-my-wp' );
define( '_HMWP_THEME_NAME_', 'default' );
define( '_HMWP_SUPPORT_SITE_', 'https://wpplugins.tips' );
define( '_HMWP_ACCOUNT_SITE_', 'https://account.wpplugins.tips' );
defined( '_HMWP_API_SITE_' ) || define( '_HMWP_API_SITE_', _HMWP_ACCOUNT_SITE_ );
define( '_HMWP_SUPPORT_EMAIL_', 'contact@wpplugins.tips' );

/* Directories */
define( '_HMWP_ROOT_DIR_', realpath( $currentDir . '/..' ) );
define( '_HMWP_CLASSES_DIR_', _HMWP_ROOT_DIR_ . '/classes/' );
define( '_HMWP_CONTROLLER_DIR_', _HMWP_ROOT_DIR_ . '/controllers/' );
define( '_HMWP_MODEL_DIR_', _HMWP_ROOT_DIR_ . '/models/' );
define( '_HMWP_TRANSLATIONS_DIR_', _HMWP_ROOT_DIR_ . '/languages/' );
define( '_HMWP_THEME_DIR_', _HMWP_ROOT_DIR_ . '/view/' );
define( '_HMWP_TEMPLATES_DIR_', _HMWP_ROOT_DIR_ . '/view/templates/' );

if ( defined( 'WP_CONTENT_DIR' ) ) {
    if ( !is_dir( WP_CONTENT_DIR . '/cache' ) ) {
        @mkdir( WP_CONTENT_DIR . '/cache' );
        @mkdir( WP_CONTENT_DIR . '/cache/hmwp' );
    }

    define( '_HMWP_CACHE_DIR_', WP_CONTENT_DIR . '/cache/hmwp/' );
} else {
    define( '_HMWP_CACHE_DIR_', _HMWP_ROOT_DIR_ . '/cache/' );
}

/* URLS */
define( '_HMWP_URL_', plugins_url() . '/' . _HMWP_PLUGIN_NAME_ );
define( '_HMWP_THEME_URL_', _HMWP_URL_ . '/view/' );