<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class HMWP_Models_Compatibility {

    public function __construct() {
        if ( is_admin() ) {
            add_filter( 'rocket_cache_reject_uri', array($this, 'rocket_reject_url'), PHP_INT_MAX );

            //Check compatibility with Really Simple SSL
            if ( HMWP_Classes_Tools::isPluginActive( 'really-simple-ssl/rlrsssl-really-simple-ssl.php' ) ) {
                add_action( 'hmwp_flushed_rewrites', array($this, 'checkSimpleSSLRewrites') );
            }

        } else {
            defined( 'WPFC_REMOVE_FOOTER_COMMENT' ) || define( 'WPFC_REMOVE_FOOTER_COMMENT', true );
            defined( 'WP_ROCKET_WHITE_LABEL_FOOTPRINT' ) || define( 'WP_ROCKET_WHITE_LABEL_FOOTPRINT', true );

            //Conpatibility with Confirm Email from AppThemes
            if ( HMWP_Classes_Tools::isPluginActive( 'confirm-email/confirm-email.php' ) ) {
                add_action( 'init', array($this, 'checkAppThemesConfirmEmail') );
            }
        }

        //Check boot compatibility for some plugins and functionalities
        $this->checkCompatibilityOnLoad();
    }


    /**
     * Set the compatibility needed on plugin activation
     * Called on plugin activation
     */
    public function install() {
        if ( HMWP_Classes_Tools::isPluginActive( 'worker/init.php' ) ) {
            $this->addMUPlugin();
        }
    }

    /**
     * Delete the compatibility with other plugins
     * Called on plugin deactivation
     */
    public function uninstall() {
        $this->deleteMUPlugin();
    }

    /**
     * Check and prevend multiple caching
     * @return bool
     */
    public function alreadyCached() {
        if ( did_action( 'wpsupercache_buffer' ) || did_action( 'autoptimize_html_after_minify' ) || did_action( 'rocket_buffer' ) || did_action( 'hmwp_buffer' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Check some compatibility on page load
     *
     */
    public function checkCompatibilityOnLoad() {

        //Compatibility with WPML plugin
        if ( HMWP_Classes_Tools::isPluginActive( 'sitepress-multilingual-cms/sitepress.php' ) ) {
            //WPML checks the HTTP_REFERER based on wp-admin and not the custom admin path
            if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
                $_SERVER['HTTP_REFERER'] = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Files' )->getOriginalUrl( $_SERVER['HTTP_REFERER'] );
            }
        }

        //Compatibility with iThemes security plugin
        if ( HMWP_Classes_Tools::isPluginActive( 'ithemes-security-pro/ithemes-security-pro.php' ) ||
            HMWP_Classes_Tools::isPluginActive( 'better-wp-security/better-wp-security.php' ) ) {
            $settings = get_option( 'itsec-storage' );
            if ( isset( $settings['hide-backend']['enabled'] ) && $settings['hide-backend']['enabled'] ) {
                if ( isset( $settings['hide-backend']['slug'] ) && $settings['hide-backend']['slug'] <> '' ) {
                    defined( 'HMWP_DEFAULT_LOGIN' ) || define( 'HMWP_DEFAULT_LOGIN', $settings['hide-backend']['slug'] );
                    HMWP_Classes_Tools::$options['hmwp_login_url'] = HMWP_Classes_Tools::$default['hmwp_login_url'];
                }
            }
        }

        //Add Compatibility with PPress plugin
        if ( HMWP_Classes_Tools::isPluginActive( 'ppress/profilepress.php' ) ) {

            if ( 'logout' <> HMWP_Classes_Tools::getValue( 'action' ) ) {
                add_action( 'hmwp_login_init', array($this, 'ppressLoginPage') );
            }

        }

        //Add compatibility with WP Defender plugin
        if ( HMWP_Classes_Tools::isPluginActive( 'wp-defender/wp-defender.php' ) ) {
            add_action( 'login_form_defender-verify-otp', array($this, 'wpDefenderLogin'), 9 );
        }


        if ( !is_admin() ) {

            try {
                //Robots.txt compatibility with other plugins
                if ( HMWP_Classes_Tools::getOption( 'hmwp_robots' ) ) {
                    if ( HMWP_Classes_ObjController::getClass( 'HMWP_Models_Files' )->isFile( $_SERVER['REQUEST_URI'] ) ) {
                        //Compatibility with Squirrly SEOx-cf-powered-by
                        if ( HMWP_Classes_Tools::isPluginActive( 'squirrly-seo/squirrly.php' ) ) {
                            add_filter( 'sq_robots', array(
                                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ),
                                'replace_robots'
                            ), 11 );
                        } else {
                            if ( strpos( $_SERVER['REQUEST_URI'], 'robots.txt' ) ) {
                                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->replace_robots( false );
                            }
                        }
                    }
                }


                //Compatibility with W3 Total cache
                if ( HMWP_Classes_Tools::isPluginActive( 'w3-total-cache/w3-total-cache.php' ) ) {

                    if ( apply_filters( 'w3tc_lazyload_is_embed_script', true ) ) {
                        add_filter( 'w3tc_lazyload_is_embed_script', array('HMWP_Classes_Tools', 'returnFalse'), PHP_INT_MAX );
                        add_filter( 'w3tc_lazyload_embed_script', array($this, 'embedW3TotalCacheLazyLoadscript'), PHP_INT_MAX );
                    }
                }

            } catch ( Exception $e ) {
            }
        }

    }

    /**
     * Check other plugins and set compatibility settings
     *
     * @throws Exception
     */
    public function checkCompatibility() {
        //don't let to rename and hide the current paths if logout is required
        if ( HMWP_Classes_Tools::getOption( 'error' ) || HMWP_Classes_Tools::getOption( 'logout' ) ) {
            return;
        }

        //Check the compatibility with builders
        //Don't load when on builder editor
        //Compatibility with Oxygen Plugin, Elementor, Thrive and more
        if ( function_exists( 'is_user_logged_in' ) && is_user_logged_in() ) {
            $builder_paramas = array(
                'fl_builder',
                'vcv-action',
                'et_fb',
                'ct_builder',
                'tve',
                'preview',
                'elementor-preview',
                'uxb_iframe',
            );

            foreach ( $builder_paramas as $param ) {
                if ( HMWP_Classes_Tools::getValue( $param, false ) ) {
                    add_filter( 'hmwp_laterload', array('HMWP_Classes_Tools', 'returnFalse') );
                    add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnFalse') );
                    return;
                }
            }
        }


        if ( !is_admin() ) {

            //Compatibility with Oxygen
            if ( HMWP_Classes_Tools::isPluginActive( 'oxygen/functions.php' ) ) {
                add_filter( 'option_hmwp_hide_styleids', array('HMWP_Classes_Tools', 'returnFalse') );
            }

            //Chech if the users set to change for logged users users
            //don't let cache plugins to change the paths is not needed
            if ( !HMWP_Classes_Tools::doChangesAdmin() ) {
                add_filter( 'hmwp_laterload', array('HMWP_Classes_Tools', 'returnFalse') );
                add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnFalse') );

                return;
            }

            //Change the template directory URL in themes
            if ( (HMWP_Classes_Tools::isThemeActive( 'Avada' ) || HMWP_Classes_Tools::isThemeActive( 'WpRentals' )) && !HMWP_Classes_Tools::getOption( 'hmwp_mapping_file' ) ) {
                add_filter( 'template_directory_uri', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'find_replace_url'), PHP_INT_MAX );
            }

            //Compatibility with Squirrly SEOx-cf-powered-by
            if ( HMWP_Classes_Tools::isPluginActive( 'squirrly-seo/squirrly.php' ) ) {
                add_filter( 'sq_buffer', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'find_replace'), PHP_INT_MAX );

                add_filter( 'sq_robots', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'find_replace_robots'), PHP_INT_MAX );
            }

            //compatibility with Wp Maintenance plugin
            if ( HMWP_Classes_Tools::isPluginActive( 'wp-maintenance-mode/wp-maintenance-mode.php' ) ) {
                add_filter( 'wpmm_footer', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'getTempBuffer') );
            }

            //compatibility with All In One WP Security
            if ( HMWP_Classes_Tools::isPluginActive( 'all-in-one-wp-security-and-firewall/wp-security.php' ) ) {
                add_filter( 'aiowps_site_lockout_output', array($this, 'aioSecurityMaintenance'), PHP_INT_MAX, 1 );
            }

            //compatibility with wp-defender on custom login
            if ( HMWP_Classes_Tools::isPluginActive( 'wp-defender/wp-defender.php' ) ) {
                add_filter( 'wd_mask_login_enable', array('HMWP_Classes_Tools', 'returnFalse'), PHP_INT_MAX, 1 );
            }

            //Compatibility with WP-rocket plugin
            if ( HMWP_Classes_Tools::isPluginActive( 'wp-rocket/wp-rocket.php' ) ) {
                add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnFalse') );

                add_filter( 'rocket_buffer', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'find_replace'), PHP_INT_MAX );

                add_filter( 'rocket_cache_busting_filename', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'find_replace_url'), PHP_INT_MAX );
                add_filter( 'rocket_iframe_lazyload_placeholder', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'find_replace_url'), PHP_INT_MAX );

                //When WP-Rocket doesn't cache URLs, let Hide My WP do the rewrites
                return;
            }

            //Compatibility with CDN Enabler
            if ( HMWP_Classes_Tools::isPluginActive( 'hummingbird-performance/wp-hummingbird.php' ) ) {
                add_filter( 'hmwp_laterload', array('HMWP_Classes_Tools', 'returnTrue') );
                add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnTrue') );

                return;
            }

            //Compatibility with Wp Super Cache Plugin
            if ( HMWP_Classes_Tools::isPluginActive( 'wp-super-cache/wp-cache.php' ) ) {
                add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnTrue') );

                add_filter( 'wpsupercache_buffer', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'find_replace'), PHP_INT_MAX );

                return;
            }

            //Compatibility with CDN Enabler
            if ( HMWP_Classes_Tools::isPluginActive( 'cdn-enabler/cdn-enabler.php' ) ) {
                add_filter( 'hmwp_laterload', array('HMWP_Classes_Tools', 'returnTrue') );
                add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnTrue') );

                return;
            }

            //Compatibility with Autoptimize plugin
            if ( HMWP_Classes_Tools::isPluginActive( 'autoptimize/autoptimize.php' ) ) {
                add_filter( 'hmwp_laterload', array('HMWP_Classes_Tools', 'returnFalse') );
                add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnTrue') );

                if ( HMWP_Classes_Tools::isPluginActive( 'wp-smush-pro/wp-smush.php' ) ) {
                    if ( $smush = get_option( 'wp-smush-cdn_status' ) ) {
                        if ( isset( $smush->cdn_enabled ) && $smush->cdn_enabled ) {
                            return;
                        }
                    }
                }

                add_filter( 'autoptimize_html_after_minify', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'find_replace'), PHP_INT_MAX );

                return;
            }

            if ( HMWP_Classes_Tools::isPluginActive( 'wp-asset-clean-up/wpacu.php' ) || HMWP_Classes_Tools::isPluginActive( 'wp-asset-clean-up-pro/wpacu.php' ) ) {
                add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnFalse') );
                add_filter( 'hmwp_laterload', array('HMWP_Classes_Tools', 'returnFalse') );

                add_filter( 'wpacu_html_source', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'find_replace'), PHP_INT_MAX );
                return;
            }


            //Patch for WOT Cache plugin
            if ( defined( 'WOT_VERSION' ) ) {
                add_filter( 'hmwp_laterload', array('HMWP_Classes_Tools', 'returnTrue') );
                add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnTrue') );

                add_filter( 'wot_cache', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'find_replace'), PHP_INT_MAX );

                return;
            }

            //For woo-global-cart plugin
            if ( defined( 'WOOGC_VERSION' ) ) {
                remove_all_actions( 'shutdown', 1 );
                add_filter( 'hmwp_buffer', array($this, 'fix_woogc_shutdown') );

                return;
            }


            if ( HMWP_Classes_Tools::isPluginActive( 'cache-enabler/cache-enabler.php' ) ) {
                add_filter( 'hmwp_laterload', array('HMWP_Classes_Tools', 'returnFalse') );
                add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnTrue') );

                return;
            }


            //Compatibility with Wp Fastest Cache
            if ( HMWP_Classes_Tools::isPluginActive( 'wp-fastest-cache/wpFastestCache.php' ) ) {

                add_filter( 'wpfc_buffer_callback_filter', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'find_replace'), PHP_INT_MAX );

                add_filter( 'hmwp_laterload', array('HMWP_Classes_Tools', 'returnTrue') );
                add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnTrue') );

                return;
            }

            //Compatibility with Powered Cache
            if ( HMWP_Classes_Tools::isPluginActive( 'powered-cache/powered-cache.php' ) ) {
                global $powered_cache_options;

                if ( apply_filters( 'powered_cache_lazy_load_enabled', true ) ) {
                    add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnTrue') );
                }

                add_filter( 'powered_cache_page_caching_buffer', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'find_replace'), PHP_INT_MAX );

                if ( isset( $powered_cache_options ) ) {
                    $powered_cache_options['show_cache_message'] = false;
                }

                return;
            }

            //Compatibility with W3 Total cache
            if ( HMWP_Classes_Tools::isPluginActive( 'w3-total-cache/w3-total-cache.php' ) ) {
                add_filter( 'hmwp_process_buffer', array('HMWP_Classes_Tools', 'returnTrue') );

                //Don't show comments
                add_filter( 'w3tc_can_print_comment', array('HMWP_Classes_Tools', 'returnFalse'), PHP_INT_MAX );

                return;
            }

        }
    }

    /**
     * Compatibility with All In On Security plugin
     *
     * @param $content
     *
     * @throws Exception
     */
    public function aioSecurityMaintenance( $content ) {
        if ( defined( 'AIO_WP_SECURITY_PATH' ) ) {
            if ( empty( $content ) ) {
                nocache_headers();
                header( "HTTP/1.0 503 Service Unavailable" );
                remove_action( 'wp_head', 'head_addons', 7 );

                ob_start();
                $template = apply_filters( 'aiowps_site_lockout_template_include', AIO_WP_SECURITY_PATH . '/other-includes/wp-security-visitor-lockout-page.php' );
                include_once($template);
                $output = ob_get_clean();

                echo HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->find_replace( $output );
            } else {
                echo $content;
            }

            exit();
        }
    }

    /**
     * Check if the cache plugins are loaded and have cached files
     * @throws Exception
     */
    public function checkCacheFiles() {
        $changed = false;

        //Change the paths in the cached css
        if ( HMWP_Classes_Tools::isPluginActive( 'elementor/elementor.php' ) ) {
            //Set the cache directory for this plugin
            $path = WP_CONTENT_DIR . '/' . HMWP_Classes_Tools::$default['hmwp_upload_url'] . '/elementor/css/';
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //change the paths in css
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //change the paths in js
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();

            //mark as cache changed
            $changed = true;
        }

        //Change the paths in the cached css
        if ( HMWP_Classes_Tools::isPluginActive( 'fusion-builder/fusion-builder.php' ) ) {
            //Set the cache directory for this plugin
            $path = WP_CONTENT_DIR . '/' . HMWP_Classes_Tools::$default['hmwp_upload_url'] . '/fusion-styles/';
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //change the paths in css
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //mark as cache changed
            $changed = true;
        }

        //Change the paths in the cached css
        if ( HMWP_Classes_Tools::isPluginActive( 'beaver-builder-lite-version/fl-builder.php' ) ||
            HMWP_Classes_Tools::isPluginActive( 'beaver-builder/fl-builder.php' ) ) {
            //Set the cache directory for this plugin
            $path = WP_CONTENT_DIR . '/' . HMWP_Classes_Tools::$default['hmwp_upload_url'] . '/bb-plugin/cache/';

            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //change the paths in css
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //change the paths in js
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();

            //mark as cache changed
            $changed = true;
        }

        //Change the paths in the cached css
        if ( HMWP_Classes_Tools::isPluginActive( 'wp-super-cache/wp-cache.php' ) ) {
            $wp_cache_config_file = WP_CONTENT_DIR . '/wp-cache-config.php';

            if ( file_exists( $wp_cache_config_file ) ) {
                include($wp_cache_config_file);
            }

            //Set the cache directory for this plugin
            if ( isset( $cache_path ) ) {
                $path = $cache_path;
            } else {
                $path = WP_CONTENT_DIR . '/cache';
            }

            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //change the paths in css
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //change the paths in js
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();

            //mark as cache changed
            $changed = true;
        }

        //Change the paths in the cached css
        if ( HMWP_Classes_Tools::isPluginActive( 'litespeed-cache/litespeed-cache.php' ) ) {
            //Set the cache directory for this plugin
            $path = WP_CONTENT_DIR . '/litespeed/';
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //change the paths in css
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //change the paths in js
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();

            //mark as cache changed
            $changed = true;
        }

        //Change the paths in the cached css
        if ( HMWP_Classes_Tools::isPluginActive( 'comet-cache/comet-cache.php' ) ) {

            //Set the cache directory for this plugin
            $path = false;
            if ( $options = get_option( 'comet_cache_options' ) ) {
                if ( isset( $options['base_dir'] ) ) {
                    $path = WP_CONTENT_DIR . '/' . rtrim( $options['base_dir'], '/' ) . '/';
                }
            }

            if ( !$path ) {
                $path = WP_CONTENT_DIR . '/cache/';
            }

            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //change the paths in css
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //change the paths in js
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();

            //mark as cache changed
            $changed = true;
        }

        if ( HMWP_Classes_Tools::isPluginActive( 'hummingbird-performance/wp-hummingbird.php' ) ) {
            //Set the cache directory for this plugin
            $path = WP_CONTENT_DIR . '/wphb-cache/';

            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //change the paths in css
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //change the paths in js
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();

            //mark as cache changed
            $changed = true;
        }

        if ( HMWP_Classes_Tools::isPluginActive( 'hyper-cache/plugin.php' ) ) {
            //Set the cache directory for this plugin
            if ( defined( 'HYPER_CACHE_FOLDER' ) ) {
                $path = HYPER_CACHE_FOLDER;
            } else {
                $path = WP_CONTENT_DIR . '/cache/';
            }

            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //change the paths in css
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //change the paths in js
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();
            //change the paths in html
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInHTML();

            //mark as cache changed
            $changed = true;
        }

        //For WP-Rocket
        if ( HMWP_Classes_Tools::isPluginActive( 'wp-rocket/wp-rocket.php' ) ) {
            if ( function_exists( 'get_rocket_option' ) ) {
                $concatenate = get_rocket_option( 'minify_concatenate_css', false ) ? true : false;

                if ( $concatenate ) {
                    //Set the cache directory for this plugin
                    $path = WP_CONTENT_DIR . '/cache/min/';
                    if ( function_exists( 'get_current_blog_id' ) ) {
                        $path .= get_current_blog_id() . '/';
                    }
                    HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
                    //change the paths in css
                    HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
                    //change the paths in js
                    HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();
                }
            }

            //mark as cache changed
            $changed = true;
        }

        //For Autoptimizer
        if ( HMWP_Classes_Tools::isPluginActive( 'autoptimize/autoptimize.php' ) ) {
            //Set the cache directory for this plugin
            $path = WP_CONTENT_DIR . '/cache/autoptimize/';
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //change the paths in css
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //change the paths in js
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();
            //mark as cache changed
            $changed = true;
        }

        //For bb-plugin
        if ( HMWP_Classes_Tools::isPluginActive( 'beaver-builder-lite-version/fl-builder.php' ) ) {
            //Set the cache directory for this plugin
            $path = WP_CONTENT_DIR . '/uploads/bb-plugin/cache/';
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //change the paths in css
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //change the paths in js
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();
            //mark as cache changed
            $changed = true;
        }

        //For WP Fastest Cache
        if ( HMWP_Classes_Tools::isPluginActive( 'wp-fastest-cache/wpFastestCache.php' ) ) {
            //Set the cache directory for this plugin
            $path = WP_CONTENT_DIR . '/cache/wpfc-minified/';
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //Change the paths in cache
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //change the paths in js
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();
            //Change the paths in html
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInHTML();

            $path = WP_CONTENT_DIR . '/cache/all/';
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //Change the paths in cache
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInHTML();

            //mark as cache changed
            $changed = true;
        }

        //For Siteground Cache
        if ( HMWP_Classes_Tools::isPluginActive( 'sg-cachepress/sg-cachepress.php' ) ) {
            //Set the cache directory for this plugin
            $path = WP_CONTENT_DIR . '/' . HMWP_Classes_Tools::$default['hmwp_upload_url'] . '/siteground-optimizer-assets/';
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //Change the paths in cache
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //change the paths in js
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();

            //mark as cache changed
            $changed = true;
        }

        //IF none of these plugins are installed. Search whole directory.
        if ( !$changed && defined( 'WP_CACHE' ) && WP_CACHE ) {
            //Set the cache directory for this plugin
            $path = WP_CONTENT_DIR . '/cache/';

            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
            //if other cache plugins are installed
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();
            //change the paths in js
            HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInJs();

            //mark as cache changed
            $changed = true;
        }

        if ( $changed && HMWP_Classes_Tools::getOption( 'hmwp_debug' ) ) {
            @file_put_contents( _HMWP_CACHE_DIR_ . 'checkCacheFiles.log', date( 'Y-m-d H:i:s' ) . PHP_EOL . $path );
        }

    }

    /**
     * Get all alert messages
     * @throws Exception
     */
    public static function getAlerts() {
        //is CDN plugin installed
        if ( is_admin() || is_network_admin() ) {
            if ( HMWP_Classes_Tools::isPluginActive( 'cdn-enabler/cdn-enabler.php' ) ) {
                if ( HMWP_Classes_Tools::getOption( 'hmwp_mode' ) <> 'default' ) {
                    if ( $cdn_enabler = get_option( 'cdn_enabler' ) ) {
                        if ( isset( $cdn_enabler['dirs'] ) ) {
                            $dirs = explode( ',', $cdn_enabler['dirs'] );
                            if ( !empty( $dirs ) &&
                                !in_array( HMWP_Classes_Tools::getOption( 'hmwp_wp-content_url' ), $dirs ) &&
                                !in_array( HMWP_Classes_Tools::getOption( 'hmwp_wp-includes_url' ), $dirs )
                            ) {
                                HMWP_Classes_Error::setError( sprintf( __( 'CDN Enabled detected. Please include %s and %s paths in CDN Enabler Settings', _HMWP_PLUGIN_NAME_ ), '<strong>' . HMWP_Classes_Tools::getOption( 'hmwp_wp-content_url' ) . '</strong>', '<strong>' . HMWP_Classes_Tools::getOption( 'hmwp_wp-includes_url' ) . '</strong>' ), 'default' );
                            }
                        }
                    }
                }

                if ( admin_url( 'options-general.php?page=cdn_enabler', 'relative' ) == $_SERVER['REQUEST_URI'] ) {
                    HMWP_Classes_Error::setError( sprintf( __( "CDN Enabler detected! Learn how to configure it with Hide My WP PRO %sClick here%s", _HMWP_PLUGIN_NAME_ ), '<a href="https://hidemywpghost.com/hide-my-wp-and-cdn-enabler/" target="_blank">', '</a>' ), 'error' );
                }
            }

            if ( HMWP_Classes_Tools::isPluginActive( 'wp-super-cache/wp-cache.php' ) ) {
                if ( get_option( 'ossdl_off_cdn_url' ) <> '' && get_option( 'ossdl_off_cdn_url' ) <> home_url() ) {
                    $dirs = explode( ',', get_option( 'ossdl_off_include_dirs' ) );
                    if ( !empty( $dirs ) &&
                        !in_array( HMWP_Classes_Tools::getOption( 'hmwp_wp-content_url' ), $dirs ) &&
                        !in_array( HMWP_Classes_Tools::getOption( 'hmwp_wp-includes_url' ), $dirs )
                    ) {
                        HMWP_Classes_Error::setError( sprintf( __( 'WP Super Cache CDN detected. Please include %s and %s paths in WP Super Cache > CDN > Include directories', _HMWP_PLUGIN_NAME_ ), '<strong>' . HMWP_Classes_Tools::getOption( 'hmwp_wp-content_url' ) . '</strong>', '<strong>' . HMWP_Classes_Tools::getOption( 'hmwp_wp-includes_url' ) . '</strong>' ), 'default' );
                    }
                }
            }

            //Mor Rewrite is not installed
            if ( HMWP_Classes_Tools::isApache() && !HMWP_Classes_Tools::isModeRewrite() ) {
                HMWP_Classes_Error::setError( sprintf( __( 'Hide My WP does not work without mode_rewrite. Please activate the rewrite module in Apache. %sMore details%s', _HMWP_PLUGIN_NAME_ ), '<a href="https://tecadmin.net/enable-apache-mod-rewrite-module-in-ubuntu-linuxmint/" target="_blank">', '</a>' ) );
            }

            //No permalink structure
            if ( !HMWP_Classes_Tools::isPermalinkStructure() ) {
                HMWP_Classes_Error::setError( sprintf( __( 'Hide My WP does not work with %s Permalinks. Change it to %s or other type in Settings > Permalinks in order to hide it', _HMWP_PLUGIN_NAME_ ), __( 'Plain' ), __( 'Post Name' ) ) );
                defined( 'HMWP_DISABLE' ) || define( 'HMWP_DISABLE', true );
            } else {
                //IIS server and no Rewrite Permalinks installed
                if ( HMWP_Classes_Tools::isIIS() && HMWP_Classes_Tools::isPHPPermalink() ) {
                    HMWP_Classes_Error::setError( sprintf( __( 'You need to activate the URL Rewrite for IIS to be able to change the permalink structure to friendly URL (without index.php). %sMore details%s', _HMWP_PLUGIN_NAME_ ), '<a href="https://www.iis.net/downloads/microsoft/url-rewrite" target="_blank">', '</a>' ) );
                } elseif ( HMWP_Classes_Tools::isPHPPermalink() ) {
                    HMWP_Classes_Error::setError( __( 'You need to set the permalink structure to friendly URL (without index.php).', _HMWP_PLUGIN_NAME_ ) );
                }
            }


            if ( HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->isConfigAdminCookie() ) {
                HMWP_Classes_Error::setError( __( 'The constant ADMIN_COOKIE_PATH is defined in wp-config.php by another plugin. Hide My WP Ghost will not work unless you remove the line define(\'ADMIN_COOKIE_PATH\', ...);', _HMWP_PLUGIN_NAME_ ) );
                //defined('HMWP_DISABLE') || define('HMWP_DISABLE', true);
            }

            //Inmotion server detected
            if ( HMWP_Classes_Tools::isInmotion() ) {
                HMWP_Classes_Error::setError( sprintf( __( 'Inmotion detected. %sPlease read how to make the plugin compatible with Inmotion Nginx Cache%s', _HMWP_PLUGIN_NAME_ ), '<a href="https://hidemywpghost.com/hide-my-wp-pro-compatible-with-inmotion-wordpress-hosting/" target="_blank">', '</a>' ) );
            }

            //The login path is changed by other plugins and may affect the functionality
            if ( HMWP_Classes_Tools::$default['hmwp_login_url'] == HMWP_Classes_Tools::getOption( 'hmwp_login_url' ) ) {
                if ( strpos( site_url( 'wp-login.php' ), HMWP_Classes_Tools::$default['hmwp_login_url'] ) === false ) {
                    defined( 'HMWP_DEFAULT_LOGIN' ) || define( 'HMWP_DEFAULT_LOGIN', site_url( 'wp-login.php' ) );
                }
            }

            if ( HMWP_Classes_Tools::isThemeActive( 'Avada' ) ) {
                if ( defined( 'FUSION_LIBRARY_URL' ) && strpos( FUSION_LIBRARY_URL, 'wp-content' ) !== false ) {
                    HMWP_Classes_Error::setError( sprintf( __( 'To hide the Avada library, please add the Avada FUSION_LIBRARY_URL in wp-config.php file after $table_prefix line: %s', _HMWP_PLUGIN_NAME_ ), '<br /><strong>define(\'FUSION_LIBRARY_URL\',\'' . site_url( HMWP_Classes_Tools::getOption( 'hmwp_themes_url' ) ) . '/9792e4242d/includes/lib\');</strong>' ) );

                }
            }

            //The admin URL is already changed by other plugins and may affect the functionality
            if ( !HMW_RULES_IN_CONFIG ) {
                HMWP_Classes_Error::setError( __( 'Hide My WP rules are not saved in the config file and this may affect the website loading speed.', _HMWP_PLUGIN_NAME_ ) );
                defined( 'HMWP_DEFAULT_ADMIN' ) || define( 'HMWP_DEFAULT_ADMIN', HMWP_Classes_Tools::$default['hmwp_admin_url'] );
            } elseif ( HMWP_Classes_Tools::$default['hmwp_admin_url'] == HMWP_Classes_Tools::getOption( 'hmwp_admin_url' ) ) {
                if ( strpos( admin_url(), HMWP_Classes_Tools::$default['hmwp_admin_url'] ) === false ) {
                    defined( 'HMWP_DEFAULT_ADMIN' ) || define( 'HMWP_DEFAULT_ADMIN', admin_url() );
                }
            }

            if ( HMWP_Classes_Tools::isPluginActive( 'wp-fastest-cache/wpFastestCache.php' ) ) {
                global $wp_fastest_cache_options;
                $wp_fastest_cache_options = json_decode( get_option( "WpFastestCache" ) );
                if ( isset( $wp_fastest_cache_options->wpFastestCacheStatus ) && $wp_fastest_cache_options->wpFastestCacheStatus ) {
                    if ( !HMWP_Classes_Tools::getOption( 'hmwp_change_in_cache' ) ) {
                        HMWP_Classes_Error::setError( sprintf( __( "To change the paths in WP Fastest Cache plugin you need to switch on %sHide My WP > Tweaks > Change Paths in Cache Files%s", _HMWP_PLUGIN_NAME_ ), '<strong>', '</strong>' ) );
                    }
                }
            }

            if ( HMWP_Classes_Tools::isGodaddy() ) {
                HMWP_Classes_Error::setError( sprintf( __( "Godaddy detected! To avoid CSS errors, make sure you switch off the CDN from %s", _HMWP_PLUGIN_NAME_ ), '<strong>' . '<a href="https://hidemywpghost.com/how-to-use-hide-my-wp-with-godaddy/" target="_blank"> Godaddy > Managed WordPress > Overview</a>' . '</strong>' ) );
            }

            if ( HMWP_Classes_Tools::isPluginActive( 'bulletproof-security/bulletproof-security.php' ) ) {
                HMWP_Classes_Error::setError( __( "BulletProof plugin! Make sure you save the settings in Hide My WP Ghost after activating Root Folder BulletProof Mode in BulletProof plugin.", _HMWP_PLUGIN_NAME_ ) );
            }

            //Check if the rules are working as expected
            if ( HMWP_Classes_Tools::getOption( 'rewrites' ) ) {
                HMWP_Classes_Error::setError( sprintf( __( 'Attention! Please check the rewrite rules in the config file. Some URLs passed through the config file rules and are loaded through WordPress which may slow down your website. Please follow this tutorial: %s', _HMWP_PLUGIN_NAME_ ), '<a href="https://hidemywpghost.com/kb/when-the-website-loads-slower-with-hide-my-wp-ghost/" target="_blank" class="text-warning">https://hidemywpghost.com/kb/when-the-website-loads-slower-with-hide-my-wp-ghost/</a>' ), 'text-white bg-danger' );
            }

        }

    }

    /**
     * Fix WP Rocket reject URL
     *
     * @param $uri
     *
     * @return array
     */
    public function rocket_reject_url( $uri ) {
        if ( HMWP_Classes_Tools::$default['hmwp_login_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_login_url' ) ) {
            $path = parse_url( home_url(), PHP_URL_PATH );
            $uri[] = ($path <> '/' ? $path . '/' : $path) . HMWP_Classes_Tools::getOption( 'hmwp_login_url' );
        }

        return $uri;
    }

    /**
     * Create the WP-Rocket Burst Mapping
     * @throws Exception
     */
    public function rocket_burst_mapping() {
        //Add the URL mapping for wp-rocket plugin
        if ( HMWP_Classes_Tools::isPluginActive( 'wp-rocket/wp-rocket.php' ) ) {
            if ( HMWP_Classes_Tools::$default['hmwp_wp-content_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_wp-content_url' ) ||
                HMWP_Classes_Tools::$default['hmwp_wp-includes_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_wp-includes_url' ) ) {
                if ( defined( 'WP_ROCKET_CACHE_BUSTING_URL' ) ) {
                    $hmwp_url_mapping = json_decode( HMWP_Classes_Tools::getOption( 'hmwp_url_mapping' ), true );

                    //if no mapping is set allready
                    if ( !isset( $hmwp_url_mapping['from'] ) ) {
                        $blog_ids = array();
                        if ( HMWP_Classes_Tools::isMultisites() ) {
                            global $wpdb;
                            $blogs = $wpdb->get_results( "SELECT blog_id FROM " . $wpdb->blogs );
                            foreach ( $blogs as $blog ) {
                                $blog_ids[] = $blog->blog_id;
                            }
                        } else {
                            $blog_ids[] = get_current_blog_id();
                        }

                        $home_root = parse_url( home_url() );
                        if ( isset( $home_root['path'] ) ) {
                            $home_root = trailingslashit( $home_root['path'] );
                        } else {
                            $home_root = '/';
                        }

                        $busting_url = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->find_replace_url( WP_ROCKET_CACHE_BUSTING_URL );
                        if ( $busting_url = HMWP_Classes_Tools::getRelativePath( $busting_url ) ) {
                            foreach ( $blog_ids as $blog_id ) {
                                //mapp the wp-rocket busting wp-content
                                if ( HMWP_Classes_Tools::$default['hmwp_wp-content_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_wp-content_url' ) ) {
                                    $hmwp_url_mapping['from'][] = '/' . $busting_url . '/' . $blog_id . $home_root . HMWP_Classes_Tools::$default['hmwp_wp-content_url'] . '/';
                                    $hmwp_url_mapping['to'][] = '/' . $busting_url . '/' . $blog_id . '/' . HMWP_Classes_Tools::getOption( 'hmwp_wp-content_url' ) . '/';
                                }

                                //mapp the wp-rocket busting wp-includes
                                if ( HMWP_Classes_Tools::$default['hmwp_wp-includes_url'] <> HMWP_Classes_Tools::getOption( 'hmwp_wp-includes_url' ) ) {
                                    $hmwp_url_mapping['from'][] = '/' . $busting_url . '/' . $blog_id . $home_root . HMWP_Classes_Tools::$default['hmwp_wp-includes_url'] . '/';
                                    $hmwp_url_mapping['to'][] = '/' . $busting_url . '/' . $blog_id . '/' . HMWP_Classes_Tools::getOption( 'hmwp_wp-includes_url' ) . '/';
                                }
                            }
                        }

                        HMWP_Classes_Tools::saveOptions( 'hmwp_url_mapping', json_encode( $hmwp_url_mapping ) );
                    }
                }
            }
        }
    }

    /**
     * Include CDNs if found
     * @return array|false
     */
    public function findCDNServers() {
        $domains = array();

        if ( HMWP_Classes_Tools::isPluginActive( 'wp-rocket/wp-rocket.php' ) && function_exists( 'get_rocket_option' ) ) {
            $cnames = get_rocket_option( 'cdn_cnames', array() );
            foreach ( $cnames as $k => $_urls ) {

                $_urls = explode( ',', $_urls );
                $_urls = array_map( 'trim', $_urls );

                foreach ( $_urls as $url ) {
                    $domains[] = $url;
                }
            }
        }

        if ( HMWP_Classes_Tools::isPluginActive( 'cdn-enabler/cdn-enabler.php' ) ) {
            if ( $cdn_enabler = get_option( 'cdn_enabler' ) ) {
                if ( isset( $cdn_enabler['url'] ) ) {
                    $domains[] = $cdn_enabler['url'];
                }
            }
        }

        if ( HMWP_Classes_Tools::isPluginActive( 'powered-cache/powered-cache.php' ) ) {
            global $powered_cache_options;
            if ( isset( $powered_cache_options['cdn_hostname'] ) ) {
                $hostnames = $powered_cache_options['cdn_hostname'];
                if ( !empty( $hostnames ) ) {
                    foreach ( $hostnames as $host ) {
                        if ( !empty( $host ) ) {
                            $domains[] = $host;
                        }
                    }
                }
            }
        }

        if ( HMWP_Classes_Tools::isPluginActive( 'wp-super-cache/wp-cache.php' ) ) {
            if ( get_option( 'ossdl_off_cdn_url' ) <> '' && get_option( 'ossdl_off_cdn_url' ) <> home_url() ) {
                $domains[] = get_option( 'ossdl_off_cdn_url' );
            }
        }

        $hmwp_cdn_urls = json_decode( HMWP_Classes_Tools::getOption( 'hmwp_cdn_urls' ), true );
        if ( !empty( $hmwp_cdn_urls ) ) {
            foreach ( $hmwp_cdn_urls as $url ) {
                $domains[] = $url;
            }
        }

        if ( HMWP_Classes_Tools::isPluginActive( 'wp-smush-pro/wp-smush.php' ) ) {
            if ( $smush = get_option( 'wp-smush-cdn_status' ) ) {
                if ( isset( $smush->cdn_enabled ) && $smush->cdn_enabled ) {
                    if ( isset( $smush->endpoint_url ) && isset( $smush->site_id ) ) {
                        $domains[] = 'https://' . $smush->endpoint_url . '/' . $smush->site_id;
                    }
                }
            }
        }

        if ( !empty( $domains ) ) {
            return $domains;
        }

        return false;
    }

    /**
     * Fix compatibility with WooGC plugin
     *
     * @param $buffer
     *
     * @return mixed
     */
    public function fix_woogc_shutdown( $buffer ) {
        global $blog_id, $woocommerce, $WooGC;;

        if ( !class_exists( 'WooGC' ) ) {
            return $buffer;
        }

        if ( !is_object( $woocommerce->cart ) ) {
            return $buffer;
        }


        if ( class_exists( 'WooGC' ) ) {
            if ( $WooGC && !$WooGC instanceof WooGC ) {
                return $buffer;
            }
        }

        $options = $WooGC->functions->get_options();
        $blog_details = get_blog_details( $blog_id );

        //replace any checkout links
        if ( !empty( $options['cart_checkout_location'] ) && $options['cart_checkout_location'] != $blog_id ) {
            $checkout_url = $woocommerce->cart->get_checkout_url();
            $checkout_url = str_replace( array('http:', 'https:'), "", $checkout_url );
            $checkout_url = trailingslashit( $checkout_url );

            $buffer = str_replace( $blog_details->domain . "/checkout/", $checkout_url, $buffer );

        }

        return $buffer;
    }

    /**
     * Add rules to be compatible with Simple SSL plugins
     */
    public function checkSimpleSSLRewrites() {

        $wp_filesystem = HMWP_Classes_Tools::initFilesystem();

        try {
            $options = get_option( 'rlrsssl_options' );

            if ( isset( $options['htaccess_redirect'] ) && $options['htaccess_redirect'] ) {
                if ( method_exists( $wp_filesystem, 'get_contents' ) && method_exists( $wp_filesystem, 'put_contents' ) ) {

                    $config_file = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->getConfFile();
                    $htaccess = $wp_filesystem->get_contents( $config_file );
                    preg_match( "/#\s?BEGIN\s?rlrssslReallySimpleSSL.*?#\s?END\s?rlrssslReallySimpleSSL/s", $htaccess, $match );

                    if ( isset( $match[0] ) && !empty( $match[0] ) ) {
                        $htaccess = preg_replace( "/#\s?BEGIN\s?rlrssslReallySimpleSSL.*?#\s?END\s?rlrssslReallySimpleSSL/s", "", $htaccess );
                        $htaccess = $match[0] . PHP_EOL . $htaccess;
                        $htaccess = preg_replace( "/\n+/", "\n", $htaccess );
                        $wp_filesystem->put_contents( $config_file, $htaccess );
                    }

                }
            }
        } catch ( Exception $e ) {
        }
    }
    /************************************************************ Must Use Plugin (needed for Manage WP and other cache plugins) */

    /**
     * Add the Must Use plugin to make sure is loading for the custom wp-admin path every time
     *
     */
    public function addMUPlugin() {
        try {
            $this->registerMUPlugin( '0-hidemywp.php', $this->buildLoaderContent( 'hide-my-wp/index.php' ) );
        } catch ( Exception $e ) {
        }
    }

    /**
     * Remove the Must Use plugin on deactivation
     */
    public function deleteMUPlugin() {
        try {
            $this->deregisterMUPlugin( '0-hidemywp.php' );
        } catch ( Exception $e ) {
        }
    }

    /**
     * The MU plugin content
     * @param $pluginBasename
     * @return string
     */
    public function buildLoaderContent( $pluginBasename ) {
        return "<?php
        /*
        Plugin Name: HideMyWP - Ghost Loader
        Description: This is automatically generated by the hideMyWP plugin to increase performance and reliability. It is automatically disabled when disabling the main plugin.
        */
        
        if (function_exists('untrailingslashit') && defined('WP_PLUGIN_DIR') && file_exists(untrailingslashit(WP_PLUGIN_DIR).'/$pluginBasename')) {
            if (in_array('$pluginBasename', (array) get_option('active_plugins')) ) {
                include_once untrailingslashit(WP_PLUGIN_DIR).'/$pluginBasename';
            }
        }";

    }

    /**
     * Add the MU file
     * @param $loaderName
     * @param $loaderContent
     */
    public function registerMUPlugin( $loaderName, $loaderContent ) {

        $wp_filesystem = HMWP_Classes_Tools::initFilesystem();

        $mustUsePluginDir = rtrim( WPMU_PLUGIN_DIR, '/' );
        $loaderPath = $mustUsePluginDir . '/' . $loaderName;

        if ( file_exists( $loaderPath ) && md5( $loaderContent ) === md5_file( $loaderPath ) ) {
            return;
        }

        if ( !is_dir( $mustUsePluginDir ) ) {
            @mkdir( $mustUsePluginDir );
        }

        if ( is_writable( $mustUsePluginDir ) ) {
            $wp_filesystem->put_contents( $loaderPath, $loaderContent );
        }

    }

    /**
     * Delete the MU file
     * @param $loaderName
     */
    public function deregisterMUPlugin( $loaderName ) {
        $mustUsePluginDir = rtrim( WPMU_PLUGIN_DIR, '/' );
        $loaderPath = $mustUsePluginDir . '/' . $loaderName;

        if ( !file_exists( $loaderPath ) ) {
            return;
        }

        @unlink( $loaderPath );
    }

    /**
     * Add Compatibility with PPress plugin
     * Load the post from Ppress for the login page
     */
    public function ppressLoginPage() {

        //Add compatibility with PPress plugin
        $data = get_option( 'pp_settings_data' );
        if ( class_exists( 'WP_Query' ) && isset( $data['set_login_url'] ) && (int)$data['set_login_url'] > 0 ) {
            $query = new WP_Query( array('p' => $data['set_login_url'], 'post_type' => 'any') );
            if ( $query->have_posts() ) {
                $query->the_post();
                get_header();
                the_content();
                get_footer();
            }
            exit();
        }

    }

    /**
     * Conpatibility with Confirm Email from AppThemes
     *
     * call the appthemes_confirm_email_template_redirect
     * for custom login paths
     */
    public function checkAppThemesConfirmEmail() {

        if ( HMWP_Classes_Tools::getIsset( 'action' ) ) {
            if ( function_exists( 'appthemes_confirm_email_template_redirect' ) ) {
                appthemes_confirm_email_template_redirect();
            }
        }

    }

    public function embedW3TotalCacheLazyLoadscript( $buffer ) {
        $js_url = plugins_url( 'pub/js/lazyload.min.js', W3TC_FILE );
        $js_url = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->find_replace_url( $js_url );

        $fireEvent = 'function(t){var e;try{e=new CustomEvent("w3tc_lazyload_loaded",{detail:{e:t}})}catch(a){(e=document.createEvent("CustomEvent")).initCustomEvent("w3tc_lazyload_loaded",!1,!1,{e:t})}window.dispatchEvent(e)}';
        $config = '{elements_selector:".lazy",callback_loaded:' . $fireEvent . '}';

        $on_initialized_javascript = apply_filters( 'w3tc_lazyload_on_initialized_javascript', '' );

        $on_initialized_javascript_wrapped = '';
        if ( !empty( $on_initialized_javascript ) ) {
            // LazyLoad::Initialized fired just before making LazyLoad global
            // so next execution cycle have it
            $on_initialized_javascript_wrapped =
                'window.addEventListener("LazyLoad::Initialized", function(){' .
                'setTimeout(function() {' .
                $on_initialized_javascript .
                '}, 1);' .
                '});';
        }

        $embed_script =
            '<style>img.lazy{min-height:1px}</style>' .
            '<link rel="preload" href="' . esc_url( $js_url ) . '" as="script">';

        $buffer = preg_replace( '~<head(\s+[^>]*)*>~Ui',
            '\\0' . $embed_script, $buffer, 1 );

        // load lazyload in footer to make sure DOM is ready at the moment of initialization
        $footer_script =
            '<script>' .
            $on_initialized_javascript_wrapped .
            'window.w3tc_lazyload=1,' .
            'window.lazyLoadOptions=' . $config .
            '</script>' .
            '<script async src="' . esc_url( $js_url ) . '"></script>';
        $buffer = preg_replace( '~</body(\s+[^>]*)*>~Ui',
            $footer_script . '\\0', $buffer, 1 );

        return $buffer;
    }

    /**
     * Compatibility with wp-defender login
     */
    public function wpDefenderLogin() {
        if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
            return;
        }

        $_POST['_wpnonce'] = wp_create_nonce( 'verify_otp' );
    }

}