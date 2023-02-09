<?php
/*
  Copyright (c) 2020, WPPlugins.
  Plugin Name: Hide My WP Ghost
  Plugin URI:
  Author: WPPlugins
  Description: Complex Security through Obscurity, Logs and Alerts for every WordPress website.
  Version: 5.0.21
  Author URI: http://wpplugins.tips
  Network: true
 */

if ( defined( 'ABSPATH' ) && !defined( 'HMW_VERSION' ) ) {

    define( 'HMWP_VERSION', '5.0.21' );
    define( 'HMWP_STABLE_VERSION', '5.0.20' );
    define( 'HMWP_BASENAME',  plugin_basename(__FILE__) );

    /* Call config files */
    require(dirname( __FILE__ ) . '/config/config.php');

    /* important to check the PHP version */
    try {
        /* inport main classes */
        require_once(_HMWP_CLASSES_DIR_ . 'ObjController.php');
        HMWP_Classes_ObjController::getClass( 'HMWP_Classes_FrontController' );

        //Load the debug
        require(dirname( __FILE__ ) . '/debug/index.php');

        if ( defined( 'HMWP_DISABLE' ) && HMWP_DISABLE ) {
            return;
        }

        //don't run cron hooks and update if there are installs
        if ( !is_multisite() && defined( 'WP_INSTALLING' ) && WP_INSTALLING ) {
            return;
        } elseif ( is_multisite() && defined( 'WP_INSTALLING_NETWORK' ) && WP_INSTALLING_NETWORK ) {
            return;
        }


        //If Brute Force is activated
        if ( HMWP_Classes_Tools::getOption( 'hmwp_bruteforce' ) ) {
            HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Brute' );
        }
        if ( HMWP_Classes_Tools::getOption( 'hmwp_activity_log' ) ) {
            HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Log' );
        }

        //Make sure to write the rewrites with other plugins
        add_action( 'rewrite_rules_array', array(HMWP_Classes_ObjController::getClass( 'HMWP_Classes_Tools' ), 'checkRewriteUpdate') );
        //verify if there are updated and all plugins and themes are in the right list
        add_action( 'upgrader_process_complete', array(HMWP_Classes_ObjController::getClass( 'HMWP_Classes_Tools' ), 'checkWpUpdates') );

        if ( is_admin() || is_network_admin() ) {
            //Check the user roles
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_RoleManager' );

            //hook activation and deactivation
            register_activation_hook( __FILE__, array(HMWP_Classes_ObjController::getClass( 'HMWP_Classes_Tools' ), 'hmwp_activate') );
            register_deactivation_hook( __FILE__, array(HMWP_Classes_ObjController::getClass( 'HMWP_Classes_Tools' ), 'hmwp_deactivate') );

            //verify if there are updated and all plugins and themes are in the right list
            add_action( 'activated_plugin', array(HMWP_Classes_ObjController::getClass( 'HMWP_Classes_Tools' ), 'checkWpUpdates') );
            //When a theme is changed
            add_action( 'after_switch_theme', array(HMWP_Classes_ObjController::getClass( 'HMWP_Classes_Tools' ), 'checkWpUpdates') );

            if ( HMWP_Classes_Tools::getOption( 'hmwp_token' ) ) {
                //Request the plugin update when a new version is released
                require _HMWP_ROOT_DIR_ . '/update/plugin-update-checker.php';
                Puc_v4_Factory::buildUpdateChecker(
                    _HMWP_API_SITE_ . sprintf( '/api/update/?token=%s&url=%s', HMWP_Classes_Tools::getOption( 'hmwp_token' ), home_url() ),
                    __FILE__,
                    _HMWP_PLUGIN_NAME_
                );
            }

        }

        //Check if the cron is loaded in advanced settings
        if ( HMWP_Classes_Tools::getOption( 'hmwp_change_in_cache' ) || HMWP_Classes_Tools::getOption( 'hmwp_mapping_file' ) ) {
            //Run the HMWP crons
            HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Cron' );
            add_action( 'hmwp_cron_process', array(HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Cron' ), 'processCron') );
        }



    } catch ( Exception $e ) {
    }

}