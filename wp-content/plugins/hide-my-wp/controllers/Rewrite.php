<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class HMWP_Controllers_Rewrite extends HMWP_Classes_FrontController {
    /**
     * HMWP_Controllers_Rewrite constructor.
     * @throws Exception
     */
    public function __construct() {
        parent::__construct();

        if ( defined( 'HMWP_DISABLE' ) && HMWP_DISABLE ) {
            return;
        }

        //Start the buffer only if priority is set
        if ( HMW_PRIORITY || HMW_ALWAYS_CHANGE_PATHS ) {
            $this->model->startBuffer();
        }

        //Init the main hooks
        $this->initHooks();
    }

    /**
     * Init the hooks for hide my wp
     * @throws Exception
     */
    public function initHooks() {

        if ( HMWP_Classes_Tools::isPermalinkStructure() ) {
            if ( HMWP_Classes_Tools::isApache() && !HMWP_Classes_Tools::isModeRewrite() ) {
                return;
            }

            if ( !HMWP_Classes_Tools::getOption( 'error' ) && !HMWP_Classes_Tools::getOption( 'logout' ) ) {
                //rename the author if set so
                add_filter( 'author_rewrite_rules', array($this->model, 'author_url'), PHP_INT_MAX, 1 );
            }
            //filters
            add_filter( 'query_vars', array($this->model, 'addParams'), 1, 1 );
            add_filter( 'login_redirect', array($this->model, 'sanitize_login_redirect'), 9, 3 );
            add_filter( 'wp_redirect', array($this->model, 'sanitize_redirect'), PHP_INT_MAX, 2 );

            //hmwp redirect based on current user role
            add_action( 'set_current_user', array('HMWP_Classes_Tools', 'setCurrentUserRole'), PHP_INT_MAX );
            add_filter( 'hmwp_url_login_redirect', array('HMWP_Classes_Tools', 'getCustomLoginURL'), 10, 1 );
            add_filter( 'hmwp_url_logout_redirect', array('HMWP_Classes_Tools', 'getCustomLogoutURL'), 10, 1 );

            //custom hook for WPEngine
            if ( HMWP_Classes_Tools::isWpengine() && PHP_VERSION_ID >= 70400 ) {
                add_filter( 'wp_redirect', array($this->model, 'loopCheck'), PHP_INT_MAX, 1 );
            }

            //actions
            add_action( 'login_init', array($this->model, 'login_init'), PHP_INT_MAX );
            add_action( 'login_head', array($this->model, 'login_head'), PHP_INT_MAX );
            add_action( 'wp_logout', array($this->model, 'wp_logout'), PHP_INT_MAX );

            //change the admin urlhmwp_login_init
            add_filter( 'lostpassword_url', array($this->model, 'lostpassword_url'), PHP_INT_MAX, 1 );
            add_filter( 'register', array($this->model, 'register_url'), PHP_INT_MAX, 1 );
            add_filter( 'login_url', array($this->model, 'login_url'), PHP_INT_MAX, 1 );
            add_filter( 'logout_url', array($this->model, 'logout_url'), PHP_INT_MAX, 2 );
            add_filter( 'admin_url', array($this->model, 'admin_url'), PHP_INT_MAX, 3 );
            add_filter( 'network_admin_url', array($this->model, 'network_admin_url'), PHP_INT_MAX, 3 );
            add_filter( 'site_url', array($this->model, 'site_url'), PHP_INT_MAX, 2 );
            add_filter( 'network_site_url', array($this->model, 'site_url'), PHP_INT_MAX, 3 );
            add_filter( 'plugins_url', array($this->model, 'plugin_url'), PHP_INT_MAX, 3 );

            add_filter( 'wp_php_error_message', array($this->model, 'replace_error_message'), PHP_INT_MAX, 2 );
            //Change the rest api if needed
            add_filter( 'rest_url_prefix', array($this->model, 'replace_rest_api'), 1 );

            //check and set the cookied for the modified urls
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cookies' );
            //load the compatibility class when the plugin loads
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Compatibility' );
        }

        //Load the PluginLoaded Hook
        add_action( 'plugins_loaded', array($this, 'hookPreload'), 1 );
        //just to make sure it called in case plugins_loaded is not triggered
        add_action( 'template_redirect', array($this, 'hookPreload'), 1 );

        //in case of broken URL, try to load it
        add_action( 'template_redirect', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Files' ), 'checkBrokenFile'), 10 );

    }

    /**
     * Call it on plugins_loaded and template_redirect
     * @throws Exception
     */
    public function hookPreload() {

        //if plugin_loaded then remove template_redirect
        if ( !did_action( 'template_redirect' ) ) {
            remove_action( 'template_redirect', array($this, 'hookPreload'), 1 );
        }

        include_once(ABSPATH . 'wp-admin/includes/plugin.php');

        //Make sure is permalink set up
        if ( HMWP_Classes_Tools::isPermalinkStructure() ) {

            if ( HMWP_Classes_Tools::isApache() && !HMWP_Classes_Tools::isModeRewrite() ) {
                return;
            }

            //Don't go further if the safe parameter is set
            if ( HMWP_Classes_Tools::getIsset( HMWP_Classes_Tools::getOption( 'hmwp_disable_name' ) ) ) {
                if ( HMWP_Classes_Tools::getValue( HMWP_Classes_Tools::getOption( 'hmwp_disable_name' ) ) == HMWP_Classes_Tools::getOption( 'hmwp_disable' ) ) {
                    return;
                }
            }

            //Build the find_replace list
            $this->model->buildRedirect();

            //don't let to rename and hide the current paths if logout is required
            if ( HMWP_Classes_Tools::getOption( 'error' ) || HMWP_Classes_Tools::getOption( 'logout' ) ) {
                return;
            }

            //stop here is the option is default.
            //the prvious code is needed for settings change and validation
            if ( HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'default' ) {
                return;
            }


            //If is ajax call... start the buffer right away
            if ( HMWP_Classes_Tools::isAjax() ) {
                $this->model->startBuffer();

                //hide the ajax in required
                add_action( 'init', array($this->model, 'hideUrls'), 99 );

                return;
            }

            //Check Compatibilities with ther plugins
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Compatibility' )->checkCompatibility();

            //Start the Buffer if not late loading
            $hmwp_laterload = HMWP_Classes_Tools::getOption( 'hmwp_laterload' );

            //Check lateload
            if ( $hmwp_laterload && !did_action( 'template_redirect' ) ) {
                //start the buffer on template_redirect
                add_action( 'template_redirect', array($this->model, 'startBuffer'), PHP_INT_MAX );
                add_action( 'login_init', array($this->model, 'startBuffer') );

            } else {
                //start the buffer now
                $this->model->startBuffer();
            }

            //Check the buffer on shutdown
            if ( HMWP_Classes_Tools::getOption( 'hmwp_shutdownload' ) ) {
                add_action( 'shutdown', array($this->model, 'shutDownBuffer'), 0 );
            }

            //hide the URLs from admin and login
            add_action( 'init', array($this->model, 'hideUrls'), 99 );

            //Show the templates if selected in Hide My WP
            //add_action( 'init', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Templates' ), 'getURLTemplate') );

            //hide headers added by plugins and add the security header if needed
            add_action( 'template_redirect', array($this->model, 'hideHeaders'), PHP_INT_MAX );
            add_action( 'template_redirect', array($this->model, 'addSecurityHeader'), PHP_INT_MAX );

            //Don't load while in admin dashboard
            if ( !is_admin() ) {
                if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_version' ) ) {
                    add_filter( 'the_generator', array('HMWP_Classes_Tools', 'returnFalse'), PHP_INT_MAX, 1 );
                    remove_action( 'wp_head', 'wp_generator' );
                    remove_action( 'wp_head', 'wp_resource_hints', 2 );
                }

                if ( HMWP_Classes_Tools::getOption( 'hmwp_disable_emojicons' ) ) {
                    //disable the emoji icons
                    $this->disable_emojicons();
                }

                if ( HMWP_Classes_Tools::getOption( 'hmwp_disable_rest_api' ) ) {
                    //disable the rest_api
                    if ( !HMWP_Classes_Tools::isPluginActive( 'contact-form-7/wp-contact-form-7.php' ) ) {
                        if ( function_exists( 'is_user_logged_in' ) && !is_user_logged_in() ) {
                            $this->disable_rest_api();
                        }
                    }
                }

                //disable xml-rpc ony if not Apache server
                //for apache server add the .htaccess rules
                if ( HMWP_Classes_Tools::getOption( 'hmwp_disable_xmlrpc' ) && !HMWP_Classes_Tools::isApache() ) {
                    add_filter( 'xmlrpc_enabled', array('HMWP_Classes_Tools', 'returnFalse') );
                }

                if ( HMWP_Classes_Tools::getOption( 'hmwp_disable_embeds' ) ) {
                    //disable the embeds
                    $this->disable_embeds();
                }

                //Windows Live Write
                if ( HMWP_Classes_Tools::getOption( 'hmwp_disable_manifest' ) ) {
                    //disable the embeds
                    $this->disable_manifest();
                }

                //Really Simple Discovery
                if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_header' ) ) {
                    $this->disable_rds();
                }

                if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_comments' ) ) {
                    $this->disable_comments();
                }

                //Disable the admin bar whe users are hidden in admin
                if ( HMWP_Classes_Tools::getOption( 'hmwp_in_dashboard' ) ) {
                    add_filter( 'show_admin_bar', array('HMWP_Classes_Tools', 'returnFalse') );
                }

                //Disable Database Debug
                if ( HMWP_Classes_Tools::getOption( 'hmwp_disable_debug' ) ) {
                    global $wpdb;
                    $wpdb->hide_errors();
                }
            }
        }


    }


    /**
     *  On admin init
     *  Load the Menu
     *  If the user changes the Permalink to default ... prevent errors
     * @throws Exception
     */
    public function hookInit() {

        if ( HMWP_Classes_Tools::getIsset( HMWP_Classes_Tools::getOption( 'hmwp_disable_name' ) ) ) {
            if ( HMWP_Classes_Tools::getValue( HMWP_Classes_Tools::getOption( 'hmwp_disable_name' ) ) == HMWP_Classes_Tools::getOption( 'hmwp_disable' ) ) {
                return;
            }
        }

        //If the user changes the Permalink to default ... prevent errors
        if ( !HMWP_Classes_Tools::isPermalinkStructure() ) {
            if ( HMWP_Classes_Tools::userCan( 'hmwp_manage_settings' ) ) {
                if ( HMWP_Classes_Tools::$default['hmwp_admin_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_admin_url' ) ) {
                    $this->model->flushChanges();
                }
            }
        }

        //Show the menu for admins only
        if ( HMWP_Classes_Tools::userCan( 'hmwp_manage_settings' ) ) {
            HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Menu' )->hookInit();
        }

    }


    /**
     * Disable the emoji icons
     */
    public function disable_emojicons() {

        // all actions related to emojis
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        add_filter( 'emoji_svg_url', array('HMWP_Classes_Tools', 'returnFalse') );

        // filter to remove TinyMCE emojis
        add_filter( 'tiny_mce_plugins', array($this, 'disable_emojicons_tinymce') );
    }

    function disable_emojicons_tinymce( $plugins ) {
        if ( is_array( $plugins ) ) {
            return array_diff( $plugins, array('wpemoji') );
        } else {
            return array();
        }
    }

    /**
     * Disable the Rest Api access
     */
    public function disable_rest_api() {
        remove_action( 'init', 'rest_api_init' );
        remove_action( 'rest_api_init', 'rest_api_default_filters', 10 );
        remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
        remove_action( 'parse_request', 'rest_api_loaded' );
    }

    /**
     * Disable the embeds
     */
    public function disable_embeds() {
        // Remove the REST API endpoint.
        remove_action( 'rest_api_init', 'wp_oembed_register_route' );

        // Turn off oEmbed auto discovery.
        // Don't filter oEmbed results.
        remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

        // Remove oEmbed discovery links.
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

        // Remove oEmbed-specific JavaScript from the front-end and back-end.
        remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    }

    /**
     * Disable Windows Live Write
     */
    public function disable_manifest() {
        remove_action( 'wp_head', 'wlwmanifest_link' );
    }

    /**
     * Disable Really Simple Discovery
     */
    public function disable_rds() {
        remove_action( 'wp_head', 'rsd_link' );
    }

    /**
     * Disable the commend from W3 Total Cache
     */
    public function disable_comments() {
        global $wp_super_cache_comments;
        remove_all_filters( 'w3tc_footer_comment' );
        $wp_super_cache_comments = false;
    }

}
