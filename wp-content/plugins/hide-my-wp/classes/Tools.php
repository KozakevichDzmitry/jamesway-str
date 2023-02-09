<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

/**
 * Handles the parameters and url
 *
 */
class HMWP_Classes_Tools {

    /** @var array Saved options in database */
    public static $init = array(), $default = array(), $lite = array(), $ninja = array();
    public static $options = array();
    public static $debug = array();
    public static $is_multisite;
    public static $active_plugins;

    /** @var integer Count the errors in site */
    static $errors_count = 0;

    static $current_user_role = 'default';

    /**
     * HMWP_Classes_Tools constructor.
     */
    public function __construct() {
        //Check the max memory usage
        $maxmemory = self::getMaxMemory();
        if ( $maxmemory && $maxmemory < 60 ) {
            if ( defined( 'WP_MAX_MEMORY_LIMIT' ) && (int)WP_MAX_MEMORY_LIMIT > 60 ) {
                @ini_set( 'memory_limit', apply_filters( 'admin_memory_limit', WP_MAX_MEMORY_LIMIT ) );
            } else {
                define( 'HMWP_DISABLE', true );
                HMWP_Classes_Error::setError( sprintf( __( 'Your memory limit is %sM. You need at least %sM to prevent loading errors in frontend. See: %sIncreasing memory allocated to PHP%s', _HMWP_PLUGIN_NAME_ ), $maxmemory, 64, '<a href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">', '</a>' ) );
            }
        }

        //Get the plugin options from database
        self::$options = self::getOptions();

        //Load multilanguage
        add_filter( "init", array($this, 'loadMultilanguage') );

        //add setting link in plugin
        add_filter( 'plugin_action_links_' . HMWP_BASENAME, array( $this, 'hookActionlink' ) );
        add_filter( 'network_admin_plugin_action_links_'. HMWP_BASENAME, array($this, 'hookActionlink'));

        //check plugin token
        add_action( 'in_plugin_update_message-' . _HMWP_PLUGIN_NAME_ . '/index.php', array(
            $this,
            'hmwp_plugin_update_message'
        ), 10, 2 );

    }

    /**
     * @param $plugin_data
     * @param $response
     */
    function hmwp_plugin_update_message( $plugin_data, $response ) {

        // check the token
        if ( self::getOption( 'hmwp_token' ) ) {
            return;
        }

        // show the error message if no token
        echo '<br />' . sprintf( __( 'To enable updates and settings, please <a href="%s">activate the plugin</a> first. If you don\'t have a licence key, please see <a href="%s">details & pricing</a>.', 'acf' ), self::getSettingsUrl(), _HMWP_SUPPORT_SITE_ );

    }

    /**
     * Check the memory and make sure it's enough
     * @return bool|string
     */
    public static function getMaxMemory() {
        try {
            $memory_limit = @ini_get( 'memory_limit' );
            if ( (int)$memory_limit > 0 ) {
                if ( preg_match( '/^(\d+)(.)$/', $memory_limit, $matches ) ) {
                    if ( $matches[2] == 'G' ) {
                        $memory_limit = $matches[1] * 1024 * 1024 * 1024; // nnnM -> nnn MB
                    } elseif ( $matches[2] == 'M' ) {
                        $memory_limit = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
                    } else if ( $matches[2] == 'K' ) {
                        $memory_limit = $matches[1] * 1024; // nnnK -> nnn KB
                    }
                }
                if ( (int)$memory_limit > 0 ) {
                    return number_format( (int)$memory_limit / 1024 / 1024, 0, '', '' );
                }
            }
        } catch ( Exception $e ) {
        }

        return false;

    }

    /**
     * Load the Options from user option table in DB
     *
     * @param bool|false $safe
     *
     * @return array|mixed|object
     */
    public static function getOptions( $safe = false ) {
        $keymeta = HMWP_OPTION;
        $homepath = ltrim( parse_url( site_url(), PHP_URL_PATH ), '/' );
        $pluginurl = ltrim( parse_url( plugins_url(), PHP_URL_PATH ), '/' );
        $contenturl = ltrim( parse_url( content_url(), PHP_URL_PATH ), '/' );

        if ( $safe ) {
            $keymeta = HMWP_OPTION_SAFE;
        }

        self::$init = array(
            'hmwp_ver' => 0,
            'api_token' => false,
            'hmwp_token' => 0,
            'hmwp_debug' => 0,
            'hmwp_valid' => 1,
            'hmwp_expires' => 0,
            'hmwp_disable' => mt_rand( 111111, 999999 ),
            'hmwp_disable_name' => 'hmwp_disable',
            'logout' => false,
            'error' => false,
            'rewrites' => 0,
            'test_frontend' => false,
            'changes' => false,
            'admin_notice' => array(),
            //--
            'hmwp_firstload' => 0, //load Hide My WP on construct
            'hmwp_laterload' => 0, //load Hide My WP on template redirect
            'hmwp_shutdownload' => 0, //check Hide My WP on shutdown
            //--
            'hmwp_fix_relative' => 1,
            'hmwp_remove_third_hooks' => 0,
            'hmwp_send_email' => 1,
            'hmwp_activity_log' => 1,
            'hmwp_activity_log_roles' => array(),
            'hmwp_email_address' => '',

            //-- Brute Force
            'hmwp_bruteforce' => 0,
            'hmwp_bruteforce_log' => 1,
            'hmwp_brute_message' => __( 'Your IP has been flagged for potential security violations. Please try again in a little while...', _HMWP_PLUGIN_NAME_ ),
            'whitelist_ip' => array(),
            'banlist_ip' => array(),
            'hmwp_hide_classes' => json_encode( array() ),
            'trusted_ip_header' => '',
            //
            'brute_use_math' => 0,
            'brute_max_attempts' => 5,
            'brute_max_timeout' => 3600,
            //captcha
            'brute_use_captcha' => 1,
            'brute_captcha_site_key' => '',
            'brute_captcha_secret_key' => '',
            'brute_captcha_theme' => 'light',
            'brute_captcha_language' => '',
            //
            'hmw_new_plugins' => array(),
            'hmw_new_themes' => array(),
            //tweaks
            'hmwp_in_dashboard' => 0,
            'hmwp_hideajax_paths' => 1,
            'hmwp_change_in_cache' => ((defined( 'WP_CACHE' ) && WP_CACHE) ? 1 : 0),
            'hmwp_hide_loggedusers' => 1,
            'hmwp_hide_admin_loggedusers' => 0,
            'hmwp_hide_version' => 1,
            'hmwp_hide_header' => 1,
            'hmwp_hide_comments' => 1,
            'hmwp_disable_emojicons' => 0,
            'hmwp_disable_xmlrpc' => 0,
            'hmwp_disable_manifest' => 1,
            'hmwp_disable_embeds' => 0,
            'hmwp_disable_debug' => 1,
            'hmwp_file_cache' => 0,
            'hmwp_url_mapping' => json_encode( array() ),
            'hmwp_mapping_classes' => 1,
            'hmwp_mapping_file' => 0,
            'hmwp_text_mapping' => json_encode(
                array(
                    'from' => array('wp-caption', 'wp-custom'),
                    'to' => array('caption', 'custom'),
                )
            ),
            'hmwp_cdn_urls' => json_encode( array() ),
            'hmwp_security_alert' => 1,
            //--
            'hmwp_userroles' => 0,
            //--
            'hmwp_robots' => 0,

            //redirects
            'hmwp_url_redirect' => '.',
            'hmwp_url_redirects' => array('default' => array('login' => '', 'logout' => '')),
            'hmwp_signup_template' => false,
            'hmwp_login_template' => false,
        );
        self::$default = array(
            'hmwp_mode' => 'default',
            'hmwp_admin_url' => 'wp-admin',
            'hmwp_login_url' => 'wp-login.php',
            'hmwp_activate_url' => 'wp-activate.php',
            'hmwp_lostpassword_url' => '',
            'hmwp_register_url' => '',
            'hmwp_logout_url' => '',

            'hmwp_plugin_url' => trim( preg_replace( '/' . str_replace( '/', '\/', $homepath ) . '/', '', $pluginurl, 1 ), '/' ),
            'hmwp_plugins' => array(),
            'hmwp_themes_url' => 'themes',
            'hmwp_themes' => array(),
            'hmwp_upload_url' => 'uploads',
            'hmwp_admin-ajax_url' => 'admin-ajax.php',
            'hmwp_hideajax_admin' => 0,
            'hmwp_tags_url' => 'tag',
            'hmwp_wp-content_url' => trim( preg_replace( '/' . str_replace( '/', '\/', $homepath ) . '/', '', $contenturl, 1 ), '/' ),
            'hmwp_wp-includes_url' => 'wp-includes',
            'hmwp_author_url' => 'author',
            'hmwp_hide_authors' => 0,
            'hmwp_wp-comments-post' => 'wp-comments-post.php',
            'hmwp_themes_style' => 'style.css',
            'hmwp_hide_img_classes' => 0,
            'hmwp_hide_styleids' => 0,
            'hmwp_noncekey' => '_wpnonce',
            'hmwp_wp-json' => 'wp-json',
            'hmwp_disable_rest_api' => 0,
            'hmwp_hide_admin' => 0,
            'hmwp_hide_newadmin' => 0,
            'hmwp_hide_login' => 0,
            'hmwp_hide_wplogin' => 0,
            'hmwp_hide_plugins' => 0,
            'hmwp_hide_all_plugins' => 0,
            'hmwp_hide_themes' => 0,
            'hmwp_emulate_cms' => '',
            //
            'hmwp_sqlinjection' => 0,
            'hmwp_security_header' => 0,
            'hmwp_hide_commonfiles' => 0,
            'hmwp_hide_oldpaths' => 0,
            'hmwp_disable_browsing' => 0,
            'hmwp_hide_oldpaths_types' => array(),
            //
            'hmwp_category_base' => '',
            'hmwp_tag_base' => '',
            //
        );
        self::$lite = array(
            'hmwp_mode' => 'lite',
            'hmwp_login_url' => 'newlogin',
            'hmwp_activate_url' => 'activate',
            'hmwp_lostpassword_url' => 'lostpass',
            'hmwp_register_url' => 'register',
            'hmwp_logout_url' => '',
            'hmwp_admin-ajax_url' => 'admin-ajax.php',
            'hmwp_hideajax_admin' => 0,
            'hmwp_plugin_url' => 'core/modules',
            'hmwp_themes_url' => 'core/views',
            'hmwp_upload_url' => 'storage',
            'hmwp_wp-content_url' => 'core',
            'hmwp_wp-includes_url' => 'lib',
            'hmwp_author_url' => 'writer',
            'hmwp_hide_authors' => 1,
            'hmwp_wp-comments-post' => 'comments',
            'hmwp_themes_style' => 'design.css',
            'hmwp_wp-json' => 'api',
            'hmwp_hide_admin' => 1,
            'hmwp_hide_newadmin' => 0,
            'hmwp_hide_login' => 1,
            'hmwp_hide_wplogin' => 1,
            'hmwp_hide_plugins' => 1,
            'hmwp_hide_all_plugins' => 0,
            'hmwp_hide_themes' => 1,
            'hmwp_emulate_cms' => 'drupal',
            //
            'hmwp_hide_img_classes' => 1,
            'hmwp_disable_rest_api' => 0,
            'hmwp_hide_styleids' => 0,
            'hmwp_hide_oldpaths_types' => array('js', 'txt', 'html'),
            //
            'hmwp_sqlinjection' => 1,
            'hmwp_security_header' => 1,
            'hmwp_hide_commonfiles' => 1,
            'hmwp_hide_oldpaths' => 0,
            'hmwp_disable_browsing' => 0,
            //

        );
        self::$ninja = array(
            'hmwp_mode' => 'ninja',
            'hmwp_admin_url' => 'ghost-admin',
            'hmwp_login_url' => 'ghost-login',
            'hmwp_activate_url' => 'activate',
            'hmwp_lostpassword_url' => 'lostpass',
            'hmwp_register_url' => 'register',
            'hmwp_logout_url' => 'disconnect',
            'hmwp_admin-ajax_url' => 'ajax-call',
            'hmwp_hideajax_admin' => 1,
            'hmwp_plugin_url' => 'core/modules',
            'hmwp_themes_url' => 'core/assets',
            'hmwp_upload_url' => 'storage',
            'hmwp_wp-content_url' => 'core',
            'hmwp_wp-includes_url' => 'lib',
            'hmwp_author_url' => 'writer',
            'hmwp_hide_authors' => 1,
            'hmwp_wp-comments-post' => 'comments',
            'hmwp_themes_style' => 'design.css',
            'hmwp_wp-json' => 'api',
            'hmwp_hide_admin' => 1,
            'hmwp_hide_newadmin' => 1,
            'hmwp_hide_login' => 1,
            'hmwp_hide_wplogin' => 1,
            'hmwp_hide_plugins' => 1,
            'hmwp_hide_all_plugins' => 0,
            'hmwp_hide_themes' => 1,
            'hmwp_hide_img_classes' => 1,
            'hmwp_disable_rest_api' => 1,
            'hmwp_hide_styleids' => 0,
            'hmwp_emulate_cms' => 'drupal',
            //
            'hmwp_sqlinjection' => 1,
            'hmwp_security_header' => 1,
            'hmwp_hide_commonfiles' => 1,
            'hmwp_hide_oldpaths' => 1,
            'hmwp_disable_browsing' => 0,
            'hmwp_hide_oldpaths_types' => array('css', 'js', 'php', 'txt', 'html'),
            //
            'hmwp_shutdownload' => 1, //fix sitemap.xml on shutdown
            'hmwp_robots' => 1,
            'hmwp_disable_embeds' => 1,
            'hmwp_disable_manifest' => 1,
            'hmwp_disable_emojicons' => 1,

        );


        if ( is_multisite() && defined( 'BLOG_ID_CURRENT_SITE' ) ) {
            $options = json_decode( get_blog_option( BLOG_ID_CURRENT_SITE, $keymeta ), true );
        } else {
            $options = json_decode( get_option( $keymeta ), true );
        }

        //make sure it works with WP Client plugin by default
        if ( self::isPluginActive( 'wp-client/wp-client.php' ) ) {
            self::$lite['hmwp_wp-content_url'] = 'include';
            self::$ninja['hmwp_wp-content_url'] = 'include';
        }

        //Set default hmwp_hide_wplogin
        if ( !isset( $options['hmwp_hide_wplogin'] ) && isset( $options['hmwp_hide_login'] ) && $options['hmwp_hide_login'] ) {
            $options['hmwp_hide_wplogin'] = $options['hmwp_hide_login'];
        }

        //upgrade the redirects to the new redirects
        if ( isset( $options['hmwp_logout_redirect'] ) && $options['hmwp_logout_redirect'] ) {
            $options['hmwp_url_redirects']['default']['logout'] = $options['hmwp_logout_redirect'];
            unset( $options['hmwp_logout_redirect'] );
        }

        if ( is_array( $options ) ) {
            $options = @array_merge( self::$init, self::$default, $options );
        } else {
            $options = @array_merge( self::$init, self::$default );
        }


        //Set the categories and tags paths
        $category_base = get_option( 'category_base' );
        $tag_base = get_option( 'tag_base' );

        if ( is_multisite() && !is_subdomain_install() && is_main_site() && 0 === strpos( get_option( 'permalink_structure' ), '/blog/' ) ) {
            $category_base = preg_replace( '|^/?blog|', '', $category_base );
            $tag_base = preg_replace( '|^/?blog|', '', $tag_base );
        }

        $options['hmwp_category_base'] = $category_base;
        $options['hmwp_tag_base'] = $tag_base;


        return $options;
    }

    /**
     * Get the option from database
     *
     * @param $key
     *
     * @return mixed
     */
    public static function getOption( $key ) {
        if ( !isset( self::$options[$key] ) ) {
            self::$options = self::getOptions();

            if ( !isset( self::$options[$key] ) ) {
                self::$options[$key] = 0;
            }
        }

        return apply_filters( 'option_' . $key, self::$options[$key] );
    }

    /**
     * Save the Options in user option table in DB
     *
     * @param string $key
     * @param string $value
     * @param bool|false $safe
     *
     */
    public static function saveOptions( $key = null, $value = '', $safe = false ) {
        $keymeta = HMWP_OPTION;

        if ( $safe ) {
            $keymeta = HMWP_OPTION_SAFE;
        }

        if ( isset( $key ) ) {
            self::$options[$key] = $value;
        }

        if ( is_multisite() && defined( 'BLOG_ID_CURRENT_SITE' ) ) {
            update_blog_option( BLOG_ID_CURRENT_SITE, $keymeta, json_encode( self::$options ) );
        } else {
            update_option( $keymeta, json_encode( self::$options ) );
        }
    }

    /**
     * Save the options into backup
     */
    public static function saveOptionsBackup() {
        //Save the working options into backup
        foreach ( self::$options as $key => $value ) {
            HMWP_Classes_Tools::saveOptions( $key, $value, true );
        }
    }

    /**
     * Add a link to settings in the plugin list
     *
     * @param array $links
     * @param string $file
     *
     * @return array
     */
    public function hookActionlink( $links ) {
        $links[] = '<a href="' . self::getSettingsUrl() . '">' . __( 'Settings', _HMWP_PLUGIN_NAME_ ) . '</a>';
        $links = array_reverse($links);
        return $links;
    }

    /**
     * Load the multilanguage support from .mo
     */
    public static function loadMultilanguage() {
        if ( !defined( 'WP_PLUGIN_DIR' ) ) {
            load_plugin_textdomain( _HMWP_PLUGIN_NAME_, _HMWP_PLUGIN_NAME_ . '/languages/' );
        } else {
            load_plugin_textdomain( _HMWP_PLUGIN_NAME_, null, _HMWP_PLUGIN_NAME_ . '/languages/' );
        }
    }

    /**
     * Check if it's Ajax call
     * @return bool
     */
    public static function isAjax() {
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            return true;
        }

        return false;
    }

    /**
     * Change the paths in admin and for logged users
     * @return bool
     */
    public static function doChangesAdmin() {
        if ( HMW_ALWAYS_CHANGE_PATHS ) {
            return true;
        } elseif ( function_exists( 'is_user_logged_in' ) && function_exists( 'current_user_can' ) ) {
            if ( !is_admin() && !is_network_admin() ) {
                if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_loggedusers' ) || !is_user_logged_in() ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get the plugin settings URL
     *
     * @param string $page
     * @param string $relative
     *
     * @return string
     */
    public static function getSettingsUrl( $page = 'hmwp_settings', $relative = false ) {
        if ( $relative ) {
            return 'admin.php?page=' . $page;
        } else {
            if ( !is_multisite() ) {
                return admin_url( 'admin.php?page=' . $page );
            } else {
                return network_admin_url( 'admin.php?page=' . $page );
            }
        }
    }

    /**
     * Get the config file for WordPress
     * @return string
     */
    public static function getConfigFile() {
        if ( file_exists( self::getRootPath() . 'wp-config.php' ) ) {
            return self::getRootPath() . 'wp-config.php';
        }

        if ( file_exists( dirname( ABSPATH ) . '/wp-config.php' ) ) {
            return dirname( ABSPATH ) . '/wp-config.php';
        }

        return false;
    }

    /**
     * Set the header type
     *
     * @param string $type
     */
    public static function setHeader( $type ) {
        switch ( $type ) {
            case 'json':
                header( 'Content-Type: application/json' );
                break;
            case 'html':
                header( "Content-type: text/html" );
                break;
            case 'text':
                header( "Content-type: text/plain" );
                break;
        }
    }

    /**
     * Get a value from $_POST / $_GET
     * if unavailable, take a default value
     *
     * @param string $key Value key
     * @param boolean $keep_newlines Keep the new lines in variable in case of texareas
     * @param mixed $defaultValue (optional)
     *
     * @return mixed Value
     */
    public static function getValue( $key = null, $defaultValue = false, $keep_newlines = false ) {
        if ( !isset( $key ) || $key == '' ) {
            return false;
        }

        $ret = (isset( $_POST[$key] ) ? $_POST[$key] : (isset( $_GET[$key] ) ? $_GET[$key] : $defaultValue));

        if ( is_string( $ret ) === true ) {
            if ( $keep_newlines === false ) {
                if ( in_array( $key, array('hmwp_email_address', 'hmwp_email') ) ) { //validate email address
                    $ret = preg_replace( '/[^A-Za-z0-9-_\.\#\/\*\@]/', '', $ret );
                } elseif ( in_array( $key, array('hmwp_disable_name') ) ) { //validate url parameter
                    $ret = preg_replace( '/[^A-Za-z0-9-_]/', '', $ret );
                } else {
                    $ret = preg_replace( '/[^A-Za-z0-9-_\/\.]/', '', $ret ); //validate fields
                }
                $ret = sanitize_text_field( $ret );
            } else {
                $ret = preg_replace( '/[^A-Za-z0-9-_.\#\n\r\s\/\*]\@/', '', $ret );
                if ( function_exists( 'sanitize_textarea_field' ) ) {
                    $ret = sanitize_textarea_field( $ret );
                }
            }
        }

        return wp_unslash( $ret );
    }

    /**
     * Check if the parameter is set
     *
     * @param string $key
     *
     * @return boolean
     */
    public static function getIsset( $key = null ) {
        if ( !isset( $key ) || $key == '' ) {
            return false;
        }

        return isset( $_POST[$key] ) ? true : (isset( $_GET[$key] ) ? true : false);
    }

    /**
     * Show the notices to WP
     *
     * @param $message
     * @param string $type
     *
     * @return string
     */
    public static function showNotices( $message, $type = '' ) {

        if ( file_exists( _HMWP_THEME_DIR_ . 'Notices.php' ) ) {
            ob_start();
            include(_HMWP_THEME_DIR_ . 'Notices.php');
            $message = ob_get_contents();
            ob_end_clean();
        }

        return $message;
    }

    /**
     * Connect remote with wp_remote_get
     *
     * @param $url
     * @param array $params
     * @param array $options
     *
     * @return bool|string
     */
    public static function hmwp_remote_get( $url, $params = array(), $options = array() ) {
        $options['method'] = 'GET';

        $parameters = '';
        if ( !empty( $params ) ) {
            foreach ( $params as $key => $value ) {
                if ( $key <> '' ) {
                    $parameters .= ($parameters == "" ? "" : "&") . $key . "=" . $value;
                }
            }

            if ( $parameters <> '' ) {
                $url .= ((strpos( $url, "?" ) === false) ? "?" : "&") . $parameters;
            }
        }

        if ( !$response = self::hmwp_wpcall( $url, $params, $options ) ) {
            return false;
        }

        return $response;
    }

    /**
     * Connect remote with wp_remote_get
     *
     * @param $url
     * @param array $params
     * @param array $options
     *
     * @return bool|string
     */
    public static function hmwp_remote_post( $url, $params = array(), $options = array() ) {
        $options['method'] = 'POST';
        if ( !$response = self::hmwp_wpcall( $url, $params, $options ) ) {
            return false;
        }

        return $response;
    }

    /**
     * Use the WP remote call
     *
     * @param string $url
     * @param array $params
     * @param array $options
     *
     * @return string
     */
    private static function hmwp_wpcall( $url, $params, $options ) {
        $options['timeout'] = (isset( $options['timeout'] )) ? $options['timeout'] : 30;
        $options['sslverify'] = false;
        $options['httpversion'] = '1.0';

        if ( $options['method'] == 'POST' ) {
            $options['body'] = $params;
            unset( $options['method'] );
            $response = wp_remote_post( $url, $options );
        } else {
            unset( $options['method'] );
            $response = wp_remote_get( $url, $options );
        }
        if ( is_wp_error( $response ) ) {

            if ( HMWP_Classes_Tools::getOption( 'hmwp_debug' ) ) {
                @file_put_contents( _HMWP_CACHE_DIR_ . 'hmwp_wpcall.log', date( 'Y-m-d H:i:s' ) . PHP_EOL . $url . "\n" . print_R( $response, true ) );
            }

            return false;
        }

        $response = self::cleanResponce( wp_remote_retrieve_body( $response ) ); //clear and get the body
        HMWP_Debug::dump( 'hmwp_wpcall', $url, $options, $response ); //output debug

        return $response;
    }

    /**
     * Get the Json from responce if any
     *
     * @param string $response
     *
     * @return string
     */
    private static function cleanResponce( $response ) {
        $response = trim( $response, '()' );

        return $response;
    }

    /**
     * Returns true if permalink structure
     *
     * @return boolean
     */
    public static function isPermalinkStructure() {
        return true;
    }


    /**
     * Check if HTML Headers to prevent chenging the code for other file extension
     *
     * @param array $types
     *
     * @return bool
     * @throws Exception
     */
    public static function isContentHeader( $types = array('text/html', 'text/xml') ) {
        $headers = headers_list();

        foreach ( $headers as $index => $value ) {
            if ( strpos( $value, ':' ) !== false ) {
                $exploded = @explode( ': ', $value );
                if ( count( $exploded ) > 1 ) {
                    $headers[$exploded[0]] = $exploded[1];
                }
            }
        }

        if ( isset( $headers['Content-Type'] ) ) {
            foreach ( $types as $type ) {
                if ( strpos( $headers['Content-Type'], $type ) !== false ) {
                    return true;
                }
            }

        } else {
            return false;
        }

        return false;
    }


    /**
     * Returns true if server is Apache
     *
     * @return boolean
     */
    public static function isApache() {
        global $is_apache;

        //If custom defined
        if ( defined( 'HMWP_SERVER_TYPE' ) && strtolower( HMWP_SERVER_TYPE ) == 'apache' ) {
            return true;
        }

        if ( self::isFlywheel() ) { //force Nginx on Flywheel server
            return false;
        }

        return $is_apache;
    }

    /**
     * Check if mode rewrite is on
     * @return bool
     */
    public static function isModeRewrite() {
        if ( function_exists( 'apache_get_modules' ) ) {
            $modules = apache_get_modules();
            if ( !empty( $modules ) ) {
                return in_array( 'mod_rewrite', $modules );
            }
        }

        return true;
    }

    /**
     * Check whether server is LiteSpeed
     *
     * @return bool
     */
    public static function isLitespeed() {
        $litespeed = false;

        //If custom defined
        if ( defined( 'HMWP_SERVER_TYPE' ) && strtolower( HMWP_SERVER_TYPE ) == 'litespeed' ) {
            return true;
        }

        if ( isset( $_SERVER['SERVER_SOFTWARE'] ) && stristr( $_SERVER['SERVER_SOFTWARE'], 'LiteSpeed' ) !== false ) {
            $litespeed = true;
        } elseif ( isset( $_SERVER['SERVER_NAME'] ) && stristr( $_SERVER['SERVER_NAME'], 'LiteSpeed' ) !== false ) {
            $litespeed = true;
        } elseif ( isset( $_SERVER['X-Litespeed-Cache-Control'] ) ) {
            $litespeed = true;
        }

        if ( self::isFlywheel() ) {
            return false;
        }

        return $litespeed;
    }

    /**
     * Check whether server is Lighthttp
     *
     * @return bool
     */
    public static function isLighthttp() {
        return (isset( $_SERVER['SERVER_SOFTWARE'] ) && stristr( $_SERVER['SERVER_SOFTWARE'], 'lighttpd' ) !== false);
    }

    /**
     * Check if multisites with path
     *
     * @return bool
     */
    public static function isMultisites() {
        if ( !isset( self::$is_multisite ) ) {
            self::$is_multisite = (is_multisite() && ((defined( 'SUBDOMAIN_INSTALL' ) && !SUBDOMAIN_INSTALL) || (defined( 'VHOST' ) && VHOST == 'no')));
        }

        return self::$is_multisite;
    }

    /**
     * Returns true if server is nginx
     *
     * @return boolean
     */
    public static function isNginx() {
        global $is_nginx;

        //If custom defined
        if ( defined( 'HMWP_SERVER_TYPE' ) && strtolower( HMWP_SERVER_TYPE ) == 'nginx' ) {
            return true;
        }

        if ( self::isFlywheel() ) {
            return true;
        }

        return ($is_nginx || (isset( $_SERVER['SERVER_SOFTWARE'] ) && stristr( $_SERVER['SERVER_SOFTWARE'], 'nginx' ) !== false));
    }

    /**
     * Returns true if server is Wpengine
     *
     * @return boolean
     */
    public static function isWpengine() {

        //If custom defined
        if ( defined( 'HMWP_SERVER_TYPE' ) && strtolower( HMWP_SERVER_TYPE ) == 'wpengine' ) {
            return true;
        }

        return (isset( $_SERVER['WPENGINE_PHPSESSIONS'] ));
    }


    /**
     * Returns true if server is Wpengine
     *
     * @return boolean
     */
    public static function isFlywheel() {

        //If custom defined
        if ( defined( 'HMWP_SERVER_TYPE' ) && strtolower( HMWP_SERVER_TYPE ) == 'flywheel' ) {
            return true;
        }

        return (isset( $_SERVER['SERVER_SOFTWARE'] ) && stristr( $_SERVER['SERVER_SOFTWARE'], 'Flywheel' ) !== false);
    }

    /**
     * Returns true if server is Inmotion
     *
     * @return boolean
     */
    public static function isInmotion() {

        //If custom defined
        if ( defined( 'HMWP_SERVER_TYPE' ) && strtolower( HMWP_SERVER_TYPE ) == 'inmotion' ) {
            return true;
        }

        return (isset( $_SERVER['SERVER_ADDR'] ) && strpos( @gethostbyaddr( $_SERVER['SERVER_ADDR'] ), 'inmotionhosting.com' ) !== false);
    }

    /**
     * Returns true if server is Godaddy
     *
     * @return boolean
     */
    public static function isGodaddy() {

        //If custom defined
        if ( defined( 'HMWP_SERVER_TYPE' ) && strtolower( HMWP_SERVER_TYPE ) == 'godaddy' ) {
            return true;
        }

        return (file_exists( ABSPATH . 'gd-config.php' ));
    }

    /**
     * Returns true if server is IIS
     *
     * @return boolean
     */
    public static function isIIS() {
        global $is_IIS, $is_iis7;

        //If custom defined
        if ( defined( 'HMWP_SERVER_TYPE' ) && strtolower( HMWP_SERVER_TYPE ) == 'iis' ) {
            return true;
        }

        return ($is_iis7 || $is_IIS || (isset( $_SERVER['SERVER_SOFTWARE'] ) && stristr( $_SERVER['SERVER_SOFTWARE'], 'microsoft-iis' ) !== false));
    }

    /**
     * Returns true if windows
     * @return bool
     */
    public static function isWindows() {
        return (strtoupper( substr( PHP_OS, 0, 3 ) ) === 'WIN');
    }

    /**
     * Check if IIS has rewrite 2 structure enabled
     * @return bool
     */
    public static function isPHPPermalink() {
        if ( get_option( 'permalink_structure' ) ) {
            if ( strpos( get_option( 'permalink_structure' ), 'index.php' ) !== false || strpos( get_option( 'permalink_structure' ), 'index.html' ) !== false || strpos( get_option( 'permalink_structure' ), 'index.htm' ) !== false ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check whether the plugin is active by checking the active_plugins list.
     *
     * @source wp-admin/includes/plugin.php
     *
     * @param string $plugin Plugin folder/main file.
     *
     * @return boolean
     */
    public static function isPluginActive( $plugin ) {
        if ( empty( self::$active_plugins ) ) {
            self::$active_plugins = (array)get_option( 'active_plugins', array() );

            if ( is_multisite() ) {
                self::$active_plugins = array_merge( array_values( self::$active_plugins ), array_keys( get_site_option( 'active_sitewide_plugins' ) ) );
            }

        }

        return in_array( $plugin, self::$active_plugins, true );
    }

    /**
     * Check whether the theme is active.
     *
     * @param string $theme Theme folder/main file.
     *
     * @return boolean
     */
    public static function isThemeActive( $theme ) {
        if ( function_exists( 'wp_get_theme' ) ) {
            $themes = wp_get_theme();

            if ( isset( $themes->name ) && (strtolower( $themes->name ) == strtolower( $theme ) || strtolower( $themes->name ) == strtolower( $theme ) . ' child' || strtolower( $themes->name ) == strtolower( $theme ) . ' child theme') ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all the plugin names
     *
     * @return array
     */
    public static function getAllPlugins() {
        if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_all_plugins' ) ) {
            $all_plugins = (array)array_keys( get_plugins() );
        } else {
            $all_plugins = (array)get_option( 'active_plugins', array() );
        }
        if ( is_multisite() ) {
            $all_plugins = array_merge( array_values( $all_plugins ), array_keys( get_site_option( 'active_sitewide_plugins' ) ) );
        }

        return $all_plugins;
    }

    /**
     * Get all the themes names
     *
     * @return array
     */
    public static function getAllThemes() {
        return search_theme_directories();
    }

    /**
     * Get the absolute filesystem path to the root of the WordPress installation
     *
     * @return string Full filesystem path to the root of the WordPress installation
     */
    public static function getRootPath() {
        if ( defined( '_HMWP_CONFIGPATH' ) ) {
            return _HMWP_CONFIGPATH;
        } elseif ( self::isFlywheel() && defined( 'WP_CONTENT_DIR' ) && dirname( WP_CONTENT_DIR ) ) {
            return str_replace( '\\', '/', dirname( WP_CONTENT_DIR ) ) . '/';
        } else {
            return ABSPATH;
        }
    }

    /**
     * Get Relative path for the current blog in case of WP Multisite
     *
     * @param $url
     *
     * @return mixed|string
     */
    public static function getRelativePath( $url ) {
        $url = wp_make_link_relative( $url );

        if ( $url <> '' ) {
            $url = str_replace( wp_make_link_relative( get_bloginfo( 'url' ) ), '', $url );

            if ( self::isMultisites() && defined( 'PATH_CURRENT_SITE' ) ) {
                $url = str_replace( rtrim( PATH_CURRENT_SITE, '/' ), '', $url );
                $url = trim( $url, '/' );
                $url = $url . '/';
            } else {
                $url = trim( $url, '/' );
            }
        }

        return $url;
    }

    /**
     * Empty the cache from other cache plugins when save the settings
     */
    public static function emptyCache() {

        try {
            //Empty WordPress rewrites count for 404 error.
            //This happens when the rules are not saved through config file
            HMWP_Classes_Tools::saveOptions( 'rewrites', 0 );

            //empty rewrites log
            if ( HMWP_Classes_Tools::getOption( 'hmwp_debug' ) ) {
                @file_put_contents( _HMWP_CACHE_DIR_ . 'rewrite.log', '' );
            }

            //////////////////////////////////////////////////////////////////////////////
            if ( function_exists( 'w3tc_pgcache_flush' ) ) {
                w3tc_pgcache_flush();
            }

            if ( function_exists( 'w3tc_minify_flush' ) ) {
                w3tc_minify_flush();
            }
            if ( function_exists( 'w3tc_dbcache_flush' ) ) {
                w3tc_dbcache_flush();
            }
            if ( function_exists( 'w3tc_objectcache_flush' ) ) {
                w3tc_objectcache_flush();
            }
            //////////////////////////////////////////////////////////////////////////////

            if ( function_exists( 'wp_cache_clear_cache' ) ) {
                wp_cache_clear_cache();
            }

            if ( function_exists( 'rocket_clean_domain' ) && function_exists( 'rocket_clean_minify' ) && function_exists( 'rocket_clean_cache_busting' ) ) {
                // Remove all cache files
                rocket_clean_domain();
                rocket_clean_minify();
                rocket_clean_cache_busting();
            }
            //////////////////////////////////////////////////////////////////////////////

            if ( function_exists( 'apc_clear_cache' ) ) {
                // Remove all apc if enabled
                apc_clear_cache();
            }
            //////////////////////////////////////////////////////////////////////////////

            if ( class_exists( 'Cache_Enabler_Disk' ) && method_exists( 'Cache_Enabler_Disk', 'clear_cache' ) ) {
                // clear disk cache
                Cache_Enabler_Disk::clear_cache();
            }
            //////////////////////////////////////////////////////////////////////////////

            if ( class_exists( 'LiteSpeed_Cache' ) ) {
                LiteSpeed_Cache::get_instance()->purge_all();
            }
            //////////////////////////////////////////////////////////////////////////////

            if ( self::isPluginActive( 'hummingbird-performance/wp-hummingbird.php' ) ) {
                do_action( 'wphb_clear_page_cache' );
            }
            //////////////////////////////////////////////////////////////////////////////

            if ( class_exists( 'WpeCommon' ) ) {
                if ( method_exists( 'WpeCommon', 'purge_memcached' ) ) {
                    WpeCommon::purge_memcached();
                }
                if ( method_exists( 'WpeCommon', 'clear_maxcdn_cache' ) ) {
                    WpeCommon::clear_maxcdn_cache();
                }
                if ( method_exists( 'WpeCommon', 'purge_varnish_cache' ) ) {
                    WpeCommon::purge_varnish_cache();
                }
            }
            //////////////////////////////////////////////////////////////////////////////

            if ( self::isPluginActive( 'sg-cachepress/sg-cachepress.php' ) && class_exists( 'Supercacher' ) ) {
                if ( method_exists( 'Supercacher', 'purge_cache' ) && method_exists( 'Supercacher', 'delete_assets' ) ) {
                    Supercacher::purge_cache();
                    Supercacher::delete_assets();
                }
            }

            //Clear the fastest cache
            global $wp_fastest_cache;
            if ( isset( $wp_fastest_cache ) && method_exists( $wp_fastest_cache, 'deleteCache' ) ) {
                $wp_fastest_cache->deleteCache();
            }
            //////////////////////////////////////////////////////////////////////////////
        } catch ( Exception $e ) {

        }

    }

    /**
     * Flush the WordPress rewrites
     */
    public static function flushWPRewrites() {
        if ( HMWP_Classes_Tools::isPluginActive( 'woocommerce/woocommerce.php' ) ) {
            update_option( 'woocommerce_queue_flush_rewrite_rules', 'yes' );
        }

        flush_rewrite_rules();
    }

    /**
     * Called on plugin activation
     * @throws Exception
     */
    public function hmwp_activate() {
        set_transient( 'hmwp_activate', true );

        //set restore settings option on plugin activate
        $lastsafeoptions = self::getOptions( true );
        if ( isset( $lastsafeoptions['hmwp_mode'] ) && ($lastsafeoptions['hmwp_mode'] == 'ninja' || $lastsafeoptions['hmwp_mode'] == 'lite') ) {
            set_transient( 'hmwp_restore', true );
        }

        if ( !HMWP_Classes_Tools::getOption( 'hmwp_userroles' ) ) {
            //remove Hide My WP Roles
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_RoleManager' )->removeHMWPCaps();
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_RoleManager' )->removeHMWPRoles();
        }

        //set default options on plugin activate
        self::$options = @array_merge( self::$init, self::$default );
        self::$options['hmwp_ver'] = HMWP_VERSION_ID;
        self::saveOptions();

        //Initialize the compatibility with other plugins
        HMWP_Classes_ObjController::getClass( 'HMWP_Models_Compatibility' )->install();
    }

    /**
     * Called on plugin deactivation
     * @throws Exception
     */
    public function hmwp_deactivate() {
        $options = self::$default;
        //Prevent duplicates
        foreach ( $options as $key => $value ) {
            //set the default params from tools
            self::saveOptions( $key, $value );
        }

        //remove Hide My WP Roles
        HMWP_Classes_ObjController::getClass( 'HMWP_Models_RoleManager' )->removeHMWPCaps();
        HMWP_Classes_ObjController::getClass( 'HMWP_Models_RoleManager' )->removeHMWPRoles();

        //remove the custom rules
        HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->writeToFile( '', 'HMWP_VULNERABILITY' );
        HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->writeToFile( '', 'HMWP_RULES' );

        //clear the locked ips
        HMWP_Classes_ObjController::getClass( 'HMWP_Controllers_Brute' )->clearBlockedIPs();

        //Delete the compatibility with other plugins
        HMWP_Classes_ObjController::getClass( 'HMWP_Models_Compatibility' )->uninstall();
    }

    /**
     * Call this function on rewrite update from other plugins
     *
     * @param $wp_rules
     *
     * @return mixed
     * @throws Exception
     */
    public function checkRewriteUpdate( $wp_rules ) {
        try {
            if ( !HMWP_Classes_Tools::getOption( 'error' ) && !HMWP_Classes_Tools::getOption( 'logout' ) ) {

                //Build the redirect table
                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->clearRedirect()->buildRedirect()->setRewriteRules()->flushRewrites();

                //INSERT SEURITY RULES
                if ( !HMWP_Classes_Tools::isIIS() ) {
                    //For Nginx and Apache the rules can be inserted separately
                    $rules = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->getInjectionRewrite();

                    if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_oldpaths' ) ) {
                        $rules .= HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->getHideOldPathRewrite();
                    }

                    HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->writeToFile( $rules, 'HMWP_VULNERABILITY' );

                }
            }

        } catch ( Exception $e ) {

        }

        return $wp_rules;
    }

    /**
     * Check for upgrade from free version
     * Called on activation
     */
    public static function checkUpgrade() {
        //Upgrade from Hide My WP Lite
        if ( get_option( 'hmw_options_safe' ) ) {
            $options = json_decode( get_option( 'hmw_options_safe' ), true );
            if ( !empty( $options ) ) {
                foreach ( $options as $key => $value ) {
                    self::$options[str_replace( 'hmw_', 'hmwp_', $key )] = $options[$key];
                }
            }


            self::$options['hmwp_ver'] = HMWP_VERSION_ID;
            self::saveOptions();

            delete_option( 'hmw_options_safe' );
        }

    }

    /**
     * Check if new themes or plugins are added or removed
     */
    public function checkWpUpdates() {

        if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_plugins' ) ) {
            $all_plugins = self::getAllPlugins();
            $dbplugins = self::getOption( 'hmwp_plugins' );
            foreach ( $all_plugins as $plugin ) {
                if ( is_plugin_active( $plugin ) && isset( $dbplugins['from'] ) && !empty( $dbplugins['from'] ) ) {
                    if ( !in_array( plugin_dir_path( $plugin ), $dbplugins['from'] ) ) {
                        self::saveOptions( 'changes', true );
                    }
                }
            }
        }

        if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_themes' ) ) {
            $all_themes = self::getAllThemes();
            $dbthemes = self::getOption( 'hmwp_themes' );
            foreach ( $all_themes as $theme => $value ) {
                if ( is_dir( $value['theme_root'] ) && isset( $dbthemes['from'] ) && !empty( $dbthemes['from'] ) ) {
                    if ( !in_array( $theme . '/', $dbthemes['from'] ) ) {
                        self::saveOptions( 'changes', true );
                    }
                }
            }
        }

        if ( self::getOption( 'changes' ) ) {
            //Initialize the compatibility with other plugins
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Compatibility' )->install();
        }

    }

    /**
     * Call API Server
     *
     * @param null $token
     * @param string $redirect_to
     *
     * @return array|bool|mixed|object
     */
    public static function checkApi( $token = null, $redirect_to = '' ) {

        $check = array('show_token' => true);
        $domain = (is_multisite() && defined( 'BLOG_ID_CURRENT_SITE' )) ? get_home_url( BLOG_ID_CURRENT_SITE ) : home_url();
        if ( isset( $token ) ) {
            $args = array('token' => $token, 'activation' => true, 'url' => $domain);
            $response = self::hmwp_remote_get( _HMWP_API_SITE_ . '/api/token', $args, array('timeout' => 10) );
        } elseif ( self::getOption( 'hmwp_token' ) ) {
            $args = array('token' => self::getOption( 'hmwp_token' ), 'url' => $domain);
            $response = self::hmwp_remote_get( _HMWP_API_SITE_ . '/api/token', $args, array('timeout' => 10) );
        } else {
            return $check;
        }

        if ( $response && json_decode( $response ) ) {
            $check = json_decode( $response, true );

            self::saveOptions( 'hmwp_token', (isset( $check['token'] ) ? $check['token'] : 0) );
            self::saveOptions( 'api_token', (isset( $check['api_token'] ) ? $check['api_token'] : false) );
            if ( isset( $check['error'] ) ) {
                self::saveOptions( 'error', true );
            }

            if ( !isset( $check['error'] ) ) {
                if ( $redirect_to <> '' ) {
                    wp_redirect( $redirect_to );
                    exit();
                }
            } elseif ( isset( $check['message'] ) ) {
                HMWP_Classes_Error::setError( $check['message'] );
            }
        } else {
            HMWP_Classes_Error::setError( sprintf( __( 'CONNECTION ERROR! Make sure your website can access: %s', _HMWP_PLUGIN_NAME_ ), '<a href="' . _HMWP_SUPPORT_SITE_ . '" target="_blank">' . _HMWP_SUPPORT_SITE_ . '</a>' ) . " <br /> " );
        }

        return $check;
    }

    /**
     * Send the email is case there are major changes
     * @return bool
     */
    public static function sendEmail() {
        $email = self::getOption( 'hmwp_email_address' );
        if ( $email == '' ) {
            global $current_user;
            $email = $current_user->user_email;
        }

        $line = "\n" . "________________________________________" . "\n";
        $to = $email;
        $from = 'support@wpplugins.tips';
        $subject = __( 'Hide My WP Ghost - New Login Data', _HMWP_PLUGIN_NAME_ );
        $message = "Thank you for using Hide My WordPress!" . "\n";
        $message .= $line;
        $message .= "Your new site URLs are:" . "\n";
        $message .= "Admin URL: " . admin_url() . "\n";
        $message .= "Login URL: " . site_url( self::$options['hmwp_login_url'] ) . "\n";
        $message .= $line;
        $message .= "Note: If you can't login to your site, just access this URL: \n";
        $message .= site_url() . "/wp-login.php?" . self::getOption( 'hmwp_disable_name' ) . "=" . self::$options['hmwp_disable'] . "\n\n";
        $message .= $line;
        $message .= "Best regards," . "\n";
        $message .= "WPPlugins Team" . "\n";

        $headers = array();
        $headers[] = 'From: Hide My WP Ghost <' . $from . '>';
        $headers[] = 'Content-type: text/plain';

        add_filter( 'wp_mail_content_type', array('HMWP_Classes_Tools', 'setContentType') );

        if ( @wp_mail( $to, $subject, $message, $headers ) ) {
            return true;
        }

        return false;
    }

    /**
     * Set the content type to text/plain
     * @return string
     */
    public static function setContentType() {
        return "text/plain";
    }

    /**
     * Set the current user role for later use
     * @param $user
     *
     * @return string
     */
    public static function setCurrentUserRole( $user = null ) {
        $roles = array();

        if ( !$user && function_exists( 'wp_get_current_user' ) ) {
            $user = wp_get_current_user();
        }

        if ( isset( $user->roles ) ) {
            $roles = ( array )$user->roles;
        }

        if ( !empty( $roles ) ) {
            self::$current_user_role = current( $roles );
        }

        return self::$current_user_role;
    }

    /**
     * Get the user main Role or default
     * @return mixed|string
     */
    public static function getUserRole() {
        return self::$current_user_role;
    }

    /**
     * Check the user capability for the roles attached
     *
     * @param $cap
     * @return bool
     */
    public static function userCan( $cap ) {

        if ( function_exists( 'current_user_can' ) ) {

            if ( current_user_can( $cap ) ) {
                return true;
            }

            $user = wp_get_current_user();
            if ( count( (array)$user->roles ) > 1 ) {
                foreach ( $user->roles as $role ) {
                    $role_object = get_role( $role );

                    if ( $role_object->has_cap( $cap ) ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }


    /**
     * Customize the redirect for the logout process
     * @param $redirect
     * @return mixed
     */
    public static function getCustomLogoutURL( $redirect ) {
        //Get Logout based on user Role
        $role = HMWP_Classes_Tools::getUserRole();
        $urlRedirects = HMWP_Classes_Tools::getOption( 'hmwp_url_redirects' );
        if ( isset( $urlRedirects[$role]['logout'] ) && $urlRedirects[$role]['logout'] <> '' ) {
            $redirect = $urlRedirects[$role]['logout'];
        } elseif ( isset( $urlRedirects['default']['logout'] ) && $urlRedirects['default']['logout'] <> '' ) {
            $redirect = $urlRedirects['default']['logout'];
        }

        return $redirect;
    }

    /**
     * Customize the redirect for the login process
     * @param $redirect
     * @param $user
     * @return mixed
     */
    public static function getCustomLoginURL( $redirect ) {

        //Get Logout based on user Role
        $role = HMWP_Classes_Tools::getUserRole();
        $urlRedirects = HMWP_Classes_Tools::getOption( 'hmwp_url_redirects' );
        if ( isset( $urlRedirects[$role]['login'] ) && $urlRedirects[$role]['login'] <> '' ) {
            $redirect = $urlRedirects[$role]['login'];
        } elseif ( isset( $urlRedirects['default']['login'] ) && $urlRedirects['default']['login'] <> '' ) {
            $redirect = $urlRedirects['default']['login'];
        }

        return $redirect;
    }

    /**
     * Generate a string
     * @param int $length
     * @return bool|string
     */
    public static function generateRandomString( $length = 10 ) {
        return substr( str_shuffle( str_repeat( $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil( $length / strlen( $x ) ) ) ), 1, $length );
    }

    /**
     * Return false on hooks
     *
     * @param string $param
     *
     * @return bool
     */
    public static function returnFalse( $param = null ) {
        return false;
    }

    /**
     * Return true function
     *
     * @param null $param
     *
     * @return bool
     */
    public static function returnTrue( $param = null ) {
        return true;
    }

    /**
     * make hidemywp the first plugin that loads
     */
    public static function movePluginFirst() {
        //Make sure the plugin is loaded first
        $plugin = _HMWP_PLUGIN_NAME_ . '/index.php';
        $active_plugins = get_option( 'active_plugins' );

        if ( !empty( $active_plugins ) ) {

            $this_plugin_key = array_search( $plugin, $active_plugins );

            if ( $this_plugin_key > 0 ) {
                array_splice( $active_plugins, $this_plugin_key, 1 );
                array_unshift( $active_plugins, $plugin );
                update_option( 'active_plugins', $active_plugins );


            }

        }
    }

    /**
     * Instantiates the WordPress filesystem for use with Hide My WP.
     *
     * @static
     * @access public
     * @return object
     */
    public static function initFilesystem() {
        // The WordPress filesystem.
        global $wp_filesystem;

        require_once wp_normalize_path( ABSPATH . '/wp-admin/includes/file.php' );
        WP_Filesystem();

        return $wp_filesystem;
    }


}