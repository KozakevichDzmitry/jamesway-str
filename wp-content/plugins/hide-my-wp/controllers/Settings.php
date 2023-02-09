<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class HMWP_Controllers_Settings extends HMWP_Classes_FrontController {

    public $tabs;
    public $logout = false;
    public $show_token = false;
    public $plugins;

    public function __construct() {
        parent::__construct();

        //If save settings is required, show the alert
        if ( HMWP_Classes_Tools::getOption( 'changes' ) ) {
            add_action( 'admin_notices', array($this, 'showSaveRequires') );
        }

        if ( !HMWP_Classes_Tools::getOption( 'hmwp_valid' ) ) {
            add_action( 'admin_notices', array($this, 'showPurchaseRequires') );
        }


        //Add the Settings class only for Hide My WP plugin
        add_filter( 'admin_body_class', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Menu' ), 'addSettingsClass') );

    }

    /**
     * Called on Menu hook
     * Init the Settings page
     *
     * @return HMWP_Classes_FrontController|void
     * @throws Exception
     */
    public function init() {

        /////////////////////////////////////////////////
        //Get the current Page
        $page = HMWP_Classes_Tools::getValue( 'page' );

        //If the page is not for Hide My WP Settings, return
        if ( $page <> 'hmwp_settings' ) {
            if ( strpos( $page, '-' ) !== false ) {
                if ( substr( $page, 0, strpos( $page, '-' ) ) <> 'hmwp_settings' ) {
                    return;
                }
            }
        }

        if ( strpos( $page, '-' ) !== false ) {
            $_GET['tab'] = substr( $page, (strpos( $page, '-' ) + 1) );
        }
        /////////////////////////////////////////////////

        //We need that function so make sure is loaded
        if ( !function_exists( 'is_plugin_active_for_network' ) ) {
            require_once(ABSPATH . '/wp-admin/includes/plugin.php');
        }

        //Add the Plugin Paths in variable
        $this->plugins = $this->model->getPlugins();

        if ( HMWP_Classes_Tools::isNginx() && HMWP_Classes_Tools::getOption( 'test_frontend' ) && HMWP_Classes_Tools::getOption( 'hmwp_mode' ) <> 'default' ) {
            $config_file = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->getConfFile();
            HMWP_Classes_Error::setError( sprintf( __( "NGINX detected. In case you didn't add the code in the NGINX config already, please add the following line. %s", _HMWP_PLUGIN_NAME_ ), '<br /><br /><code><strong>include ' . $config_file . ';</strong></code> <br /><br /><h5>' . __( "Don't forget to reload the Nginx service.", _HMWP_PLUGIN_NAME_ ) . ' ' . '</h5><strong><br /><a href="https://hidemywpghost.com/how-to-setup-hide-my-wp-on-nginx-server/" target="_blank" style="color: red">' . __( "Learn how to setup on Nginx server", _HMWP_PLUGIN_NAME_ ) . '</a></strong>' ) );
        }


        //Settings Alerts based on Logout and Error statements
        if ( get_transient( 'hmwp_restore' ) == 1 ) {
            $restoreForm = '
                        <form method="POST">
                            ' . wp_nonce_field( 'hmwp_abort', 'hmwp_nonce', true, false ) . '
                            <input type="hidden" name="action" value="hmwp_abort" />
                            <input type="submit" class="hmwp_btn hmwp_btn-warning" value="' . __( "Restore Settings", _HMWP_PLUGIN_NAME_ ) . '" />
                        </form>
                        ';
            HMWP_Classes_Error::setError( __( 'You want to restore the last saved settings?', _HMWP_PLUGIN_NAME_ ) . '<div class="hmwp_abort" style="display: inline-block;">' . $restoreForm . '</div>' );
            // Delete the redirect transient
            delete_transient( 'hmwp_restore' );

        }

        //Show the config rules to make sure they are okay
        if ( HMWP_Classes_Tools::getValue( 'hmwp_config' ) ) {
            $config_file = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->getConfFile();
            if ( $config_file <> '' && file_exists( $config_file ) ) {
                $rules = @file_get_contents( HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->getConfFile() );
                HMWP_Classes_Error::setError( '<pre>' . $rules . '</pre>' );
            }
        }


        //Check compatibilities with other plugins
        HMWP_Classes_ObjController::getClass( 'HMWP_Classes_DisplayController' )->loadMedia( 'alert' );
        HMWP_Classes_ObjController::getClass( 'HMWP_Models_Compatibility' )->getAlerts();

        //Load the css for Settings
        if ( is_rtl() ) {
            HMWP_Classes_ObjController::getClass( 'HMWP_Classes_DisplayController' )->loadMedia( 'popper' );
            HMWP_Classes_ObjController::getClass( 'HMWP_Classes_DisplayController' )->loadMedia( 'bootstrap.rtl' );
            HMWP_Classes_ObjController::getClass( 'HMWP_Classes_DisplayController' )->loadMedia( 'rtl' );
        } else {
            HMWP_Classes_ObjController::getClass( 'HMWP_Classes_DisplayController' )->loadMedia( 'popper' );
            HMWP_Classes_ObjController::getClass( 'HMWP_Classes_DisplayController' )->loadMedia( 'bootstrap' );
        }

        HMWP_Classes_ObjController::getClass( 'HMWP_Classes_DisplayController' )->loadMedia( 'font-awesome' );
        HMWP_Classes_ObjController::getClass( 'HMWP_Classes_DisplayController' )->loadMedia( 'switchery' );
        HMWP_Classes_ObjController::getClass( 'HMWP_Classes_DisplayController' )->loadMedia( 'settings' );


        //Show errors on top
        HMWP_Classes_ObjController::getClass( 'HMWP_Classes_Error' )->hookNotices();

        //Check connection with the cloud
        HMWP_Classes_Tools::checkApi();

        //Show connect for activation
        if ( !HMWP_Classes_Tools::getOption( 'hmwp_token' ) ) {
            echo $this->getView( 'Connect' );

            return;
        }


        //Add the Menu Tabs in variable
        $this->tabs = $this->model->getTabs();

        //Show the Tab Content
        foreach ( $this->tabs as $slug => $value ) {
            if ( HMWP_Classes_Tools::getValue( 'tab', 'hmwp_permalinks' ) == $slug ) {
                if ( isset( $value['class'] ) && $value['class'] <> '' ) {
                    echo HMWP_Classes_ObjController::getClass( $value['class'] )->init()->getView();
                } else {
                    echo $this->getView( ucfirst( str_replace( 'hmwp_', '', $slug ) ) );
                }
            }
        }


    }

    /**
     * Load media header
     */
    public function hookHead() { }

    /**
     * Show this message to notify the user when to update th esettings
     */
    public function showSaveRequires() {
        if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_plugins' ) || HMWP_Classes_Tools::getOption( 'hmwp_hide_themes' ) ) {
            global $pagenow;
            if ( $pagenow == 'plugins.php' || HMWP_Classes_Tools::getValue( 'page' ) == 'hmwp_settings' ) {

                HMWP_Classes_ObjController::getClass( 'HMWP_Classes_DisplayController' )->loadMedia( 'alert' );

                ?>
                <div class="hmwp_notice error notice" style="margin-left: 0;">
                    <div style="display: inline-block;">
                        <form action="<?php echo HMWP_Classes_Tools::getSettingsUrl() ?>" method="POST">
                            <?php wp_nonce_field( 'hmwp_newpluginschange', 'hmwp_nonce' ) ?>
                            <input type="hidden" name="action" value="hmwp_newpluginschange"/>
                            <p>
                                <?php echo sprintf( __( "New Plugin/Theme detected! You need to save the Hide My WP Setting again to include them all! %sClick here%s", _HMWP_PLUGIN_NAME_ ), '<button type="submit" style="color: blue; text-decoration: underline; cursor: pointer; background: none; border: none;">', '</button>' ); ?>
                            </p>
                        </form>

                    </div>
                </div>
                <?php
            }
        }
    }


    public function showPurchaseRequires() {
        global $pagenow;
        if ( $pagenow == 'plugins.php' || $pagenow == 'index.php' ) {
            $expires = (int)HMWP_Classes_Tools::getOption( 'hmwp_expires' );
            if ( $expires > 0 ) {
                ?>
                <div class="col-sm-12 mx-0 hmwp_notice error notice">
                    <div style="display: inline-block;">
                        <p>
                            <?php echo sprintf( __( "Your %sHide My WP Ghost license expired on %s%s. To keep your website security up to date please make sure you have a valid subscription on %saccount.wpplugins.tips%s", _HMWP_PLUGIN_NAME_ ), '<strong>', date( 'd M Y', $expires ), '</strong>', '<a href="' . _HMWP_ACCOUNT_SITE_ . '/api/auth/' . HMWP_Classes_Tools::getOption( 'api_token' ) . '" class="btn btn-warning btn-lg rounded-0 text-white" target="_blank">', '</a>' ); ?>
                        </p>
                    </div>
                </div>
                <?php
            }
        }
    }


    /**
     * Get the Admin Toolbar
     *
     * @param null $current
     *
     * @return string
     */
    public function getAdminTabs( $current = null ) {
        //Add the Menu Tabs in variable if not set before
        if ( !isset( $this->tabs ) ) {
            $this->tabs = $this->model->getTabs();
        }

        $content = '';
        $content .= '<div class="hmwp_nav d-flex flex-column bd-highlight mb-3">';
        $content .= '<div  class="m-0 p-4 font-dark text-logo"><a href="https://hidemywpghost.com/" target="_blank"><img src="' . _HMWP_THEME_URL_ . 'img/logo.png" class="ml-0 mr-2" style="width:30px;"></a>' . __( 'Hide My WP', _HMWP_PLUGIN_NAME_ ) . ' <span style="color: #d6cdd1">' . _HMWP_VER_NAME_ . '</span></div>';
        foreach ( $this->tabs as $location => $tab ) {
            if ( $current == $location ) {
                $class = 'active';
            } else {
                $class = '';
            }
            if ( $location == 'hmwp_securitycheck' ) {
                $content .= '<a class="m-0 p-4 font-dark hmwp_nav_item ' . $class . ' fa fa-' . $tab['icon'] . '" href="' . HMWP_Classes_Tools::getSettingsUrl( $location, true ) . '">';
            } else {
                $content .= '<a class="m-0 p-4 font-dark hmwp_nav_item ' . $class . ' fa fa-' . $tab['icon'] . '" href="' . HMWP_Classes_Tools::getSettingsUrl( 'hmwp_settings', true ) . ($location <> 'hmwp_permalinks' ? '-' . $location : '') . '">';
            }
            $content .= '<span>' . $tab['title'] . '</span>';
            $content .= '<span class="hmwp_nav_item_description">' . $tab['description'] . '</span>';
            $content .= '</a>';
        }
        if ( HMWP_Classes_Tools::getOption( 'api_token' ) <> '' && apply_filters( 'hmwp_showaccount', true ) ) {
            $content .= '<div  class="m-2 p-4 hmwp_nav_button"><a href="' . _HMWP_ACCOUNT_SITE_ . '/api/auth/' . HMWP_Classes_Tools::getOption( 'api_token' ) . '" class="btn btn-warning btn-lg rounded-0 text-white" target="_blank">' . __( 'My Account', _HMWP_PLUGIN_NAME_ ) . '</a></div>';
        }
        $content .= '</div>';

        return $content;
    }

    /**
     * Called when an action is triggered
     * @throws Exception
     */
    public function action() {
        parent::action();

        if ( !HMWP_Classes_Tools::userCan( 'hmwp_manage_settings' ) ) {
            return;
        }

        switch ( HMWP_Classes_Tools::getValue( 'action' ) ) {
            case 'hmwp_settings':
                //Save the settings
                if ( !empty( $_POST ) ) {
                    $this->model->savePermalinks( $_POST );
                }

                //Create the Wp-Rocket Burts Mapping for all blogs if not exists
                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Compatibility' )->rocket_burst_mapping();


                //If no errors and no reconnect required
                if ( !HMWP_Classes_Tools::getOption( 'error' ) ) {

                    //Force the recheck security notification
                    delete_option( 'hmwp_securitycheck_time' );
                    //Clear the cache if there are no errors
                    HMWP_Classes_Tools::emptyCache();
                    //Flush the WordPress rewrites
                    HMWP_Classes_Tools::flushWPRewrites();

                    //Flush the changes
                    HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->flushChanges();

                    //If there are no errors
                    if ( !HMWP_Classes_Error::isError() ) {

                        if ( !HMWP_Classes_Tools::getOption( 'logout' ) || HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'default' ) {
                            //Save the working options into backup
                            HMWP_Classes_Tools::saveOptionsBackup();
                        }

                        //Send email notification about the path changed
                        HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->sendEmail();

                        HMWP_Classes_Error::setError( __( 'Saved' ), 'success' );

                        //Show the Nginx message to setup the config file
                        if ( HMWP_Classes_Tools::isNginx() && !HMWP_Classes_Tools::getOption( 'test_frontend' ) && HMWP_Classes_Tools::getOption( 'hmwp_mode' ) <> 'default' ) {
                            $config_file = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->getConfFile();
                            HMWP_Classes_Error::setError( sprintf( __( "NGINX detected. In case you didn't add the code in the NGINX config already, please add the following line. %s", _HMWP_PLUGIN_NAME_ ), '<br /><br /><code><strong>include ' . $config_file . ';</strong></code> <br /><br /><h5>' . __( "Don't forget to reload the Nginx service.", _HMWP_PLUGIN_NAME_ ) . ' ' . '</h5><strong><br /><a href="https://hidemywpghost.com/how-to-setup-hide-my-wp-on-nginx-server/" target="_blank" style="color: red">' . __( "Learn how to setup on Nginx server", _HMWP_PLUGIN_NAME_ ) . '</a></strong>' ) );
                        }

                        //Redirect to the new admin URL
                        if ( HMWP_Classes_Tools::getOption( 'logout' ) ) {

                            //Set the cookies for the current path
                            $cookies = HMWP_Classes_ObjController::newInstance( 'HMWP_Models_Cookies' );

                            if ( HMWP_Classes_Tools::isNginx() || $cookies->setCookiesCurrentPath() ) {
                                //set logout to false
                                HMWP_Classes_Tools::saveOptions( 'logout', false );
                                //activate frontend test
                                HMWP_Classes_Tools::saveOptions( 'test_frontend', true );

                                remove_all_filters( 'wp_redirect' );
                                remove_all_filters( 'admin_url' );
                                wp_safe_redirect( HMWP_Classes_Tools::getSettingsUrl() );
                                exit();
                            }
                        }
                    }
                }


                break;
            case 'hmwp_tweakssettings':
                //Save the settings
                if ( !empty( $_POST ) ) {
                    $this->model->saveValues( $_POST );
                }

                //Flush the changes for XML-RPC option
                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->flushChanges();

                if ( !HMWP_Classes_Tools::getOption( 'error' ) ) {

                    if ( !HMWP_Classes_Tools::getOption( 'logout' ) ) {
                        HMWP_Classes_Tools::saveOptionsBackup();
                    }

                    HMWP_Classes_Error::setError( __( 'Saved' ), 'success' );
                }

                //Set the cache directory for this plugin
                $path = WP_CONTENT_DIR . '/cache/';
                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->setCachePath( $path );
                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Cache' )->changePathsInCss();

                break;
            case 'hmwp_mappsettings':
                //Save Mapping for classes and ids
                HMWP_Classes_Tools::saveOptions( 'hmwp_mapping_classes', HMWP_Classes_Tools::getValue( 'hmwp_mapping_classes' ) );
                HMWP_Classes_Tools::saveOptions( 'hmwp_mapping_file', HMWP_Classes_Tools::getValue( 'hmwp_mapping_file' ) );

                //Save the patterns as array
                //Save CDN URLs
                if ( $urls = HMWP_Classes_Tools::getValue( 'hmwp_cdn_urls', false ) ) {
                    $hmwp_cdn_urls = array();
                    foreach ( $urls as $index => $row ) {
                        if ( $row <> '' ) {
                            $row = preg_replace( '/[^A-Za-z0-9-_\/\.:]/', '', $row );
                            if ( $row <> '' ) {
                                $hmwp_cdn_urls[] = $row;
                            }
                        }
                    }
                    HMWP_Classes_Tools::saveOptions( 'hmwp_cdn_urls', json_encode( $hmwp_cdn_urls ) );
                }

                //Save Text Mapping
                if ( $hmwp_text_mapping_from = HMWP_Classes_Tools::getValue( 'hmwp_text_mapping_from', false ) ) {
                    if ( $hmwp_text_mapping_to = HMWP_Classes_Tools::getValue( 'hmwp_text_mapping_to', false ) ) {
                        $hmwp_text_mapping = array();

                        //If there is an upgrade form Hide My WP 3
                        if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_classes' ) ) {
                            $custom_classes = json_decode( HMWP_Classes_Tools::getOption( 'hmwp_hide_classes' ), true );
                            if ( !empty( $custom_classes ) ) {
                                foreach ( $custom_classes as $custom_classe ) {
                                    if ( !in_array( $custom_classe, array('wp-image', 'wp-post', 'wp-caption') ) ) {
                                        $hmwp_text_mapping['from'][] = $custom_classe;
                                        $hmwp_text_mapping['to'][] = '';
                                    }
                                }
                                HMWP_Classes_Tools::saveOptions( 'hmwp_hide_classes', json_encode( array() ) );
                            }
                        }

                        foreach ( $hmwp_text_mapping_from as $index => $from ) {
                            if ( $hmwp_text_mapping_from[$index] <> '' && $hmwp_text_mapping_to[$index] <> '' ) {
                                $hmwp_text_mapping_from[$index] = preg_replace( '/[^A-Za-z0-9-_\/\.\{\}]/', '', $hmwp_text_mapping_from[$index] );
                                $hmwp_text_mapping_to[$index] = preg_replace( '/[^A-Za-z0-9-_\/\.\{\}]/', '', $hmwp_text_mapping_to[$index] );

                                if ( !isset( $hmwp_text_mapping['from'] ) || !in_array( $hmwp_text_mapping_from[$index], (array)$hmwp_text_mapping['from'] ) ) {
                                    //Don't save the wp-posts for Woodmart theme
                                    if ( HMWP_Classes_Tools::isPluginActive( 'woocommerce/woocommerce.php' ) ) {
                                        if ( $hmwp_text_mapping_from[$index] == 'wp-post-image' ) {
                                            continue;
                                        }
                                    }

                                    if ( $hmwp_text_mapping_from[$index] <> $hmwp_text_mapping_to[$index] ) {
                                        $hmwp_text_mapping['from'][] = $hmwp_text_mapping_from[$index];
                                        $hmwp_text_mapping['to'][] = $hmwp_text_mapping_to[$index];
                                    }
                                } else {
                                    HMWP_Classes_Error::setError( __( 'Error: You entered the same text twice in the Text Mapping. We removed the duplicates to prevent any redirect errors.' ) );
                                }
                            }
                        }
                        HMWP_Classes_Tools::saveOptions( 'hmwp_text_mapping', json_encode( $hmwp_text_mapping ) );

                    }
                }

                //Save URL mapping
                if ( $hmwp_url_mapping_from = HMWP_Classes_Tools::getValue( 'hmwp_url_mapping_from', false ) ) {
                    if ( $hmwp_url_mapping_to = HMWP_Classes_Tools::getValue( 'hmwp_url_mapping_to', false ) ) {
                        $hmwp_url_mapping = array();
                        foreach ( $hmwp_url_mapping_from as $index => $from ) {
                            if ( $hmwp_url_mapping_from[$index] <> '' && $hmwp_url_mapping_to[$index] <> '' ) {
                                $hmwp_url_mapping_from[$index] = preg_replace( '/[^A-Za-z0-9-_;:=%\.\#\/\?]/', '', $hmwp_url_mapping_from[$index] );
                                $hmwp_url_mapping_to[$index] = preg_replace( '/[^A-Za-z0-9-_;:%=\.\#\/\?]/', '', $hmwp_url_mapping_to[$index] );

                                //if (substr_count($hmwp_url_mapping_from[$index], home_url()) == 1 && substr_count($hmwp_url_mapping_to[$index], home_url()) == 1) {
                                if ( !isset( $hmwp_url_mapping['from'] ) || (
                                        !in_array( $hmwp_url_mapping_from[$index], (array)$hmwp_url_mapping['from'] ) &&
                                        !in_array( $hmwp_url_mapping_to[$index], (array)$hmwp_url_mapping['to'] )
                                    ) ) {
                                    if ( $hmwp_url_mapping_from[$index] <> $hmwp_url_mapping_to[$index] ) {
                                        $hmwp_url_mapping['from'][] = $hmwp_url_mapping_from[$index];
                                        $hmwp_url_mapping['to'][] = $hmwp_url_mapping_to[$index];
                                    }
                                } else {
                                    HMWP_Classes_Error::setError( __( 'Error: You entered the same URL twice in the URL Mapping. We removed the duplicates to prevent any redirect errors.' ) );
                                }
                            }
                        }


                        HMWP_Classes_Tools::saveOptions( 'hmwp_url_mapping', json_encode( $hmwp_url_mapping ) );

                    }

                    if ( !empty( $hmwp_url_mapping ) ) {
                        if ( !HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->clearRedirect()->setRewriteRules()->flushRewrites() ) {//show rules to be added manually
                            HMWP_Classes_Tools::saveOptions( 'error', true );
                        }
                    }
                }


                //Clear the cache if there are no errors
                if ( !HMWP_Classes_Tools::getOption( 'error' ) ) {

                    //Create the Wp-Rocket Burts Mapping for all blogs if not exists
                    HMWP_Classes_ObjController::getClass( 'HMWP_Models_Compatibility' )->rocket_burst_mapping();

                    //Flush the changes
                    HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->flushChanges();


                    if ( !HMWP_Classes_Tools::getOption( 'logout' ) ) {
                        HMWP_Classes_Tools::saveOptionsBackup();
                    }

                    HMWP_Classes_Tools::emptyCache();
                    HMWP_Classes_Error::setError( __( 'Saved' ), 'success' );

                    //Show the Nginx message to setup the config file
                    if ( HMWP_Classes_Tools::isNginx() && !HMWP_Classes_Tools::getOption( 'test_frontend' ) && HMWP_Classes_Tools::getOption( 'hmwp_mode' ) <> 'default' ) {
                        $config_file = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->getConfFile();
                        HMWP_Classes_Error::setError( sprintf( __( "NGINX detected. In case you didn't add the code in the NGINX config already, please add the following line. %s", _HMWP_PLUGIN_NAME_ ), '<br /><br /><code><strong>include ' . $config_file . ';</strong></code> <br /><br /><h5>' . __( "Don't forget to reload the Nginx service.", _HMWP_PLUGIN_NAME_ ) . ' ' . '</h5><strong><br /><a href="https://hidemywpghost.com/how-to-setup-hide-my-wp-on-nginx-server/" target="_blank" style="color: red">' . __( "Learn how to setup on Nginx server", _HMWP_PLUGIN_NAME_ ) . '</a></strong>' ) );
                    }

                }
                break;
            case 'hmwp_advsettings':

                if ( !empty( $_POST ) ) {
                    $this->model->saveValues( $_POST );

                    //Send the notification email in case of Weekly report
                    if ( HMWP_Classes_Tools::getValue( 'hmwp_send_email', false ) && HMWP_Classes_Tools::getValue( 'hmwp_email_address', false ) ) {
                        $args = array(
                            'email' => HMWP_Classes_Tools::getValue( 'hmwp_email_address' ),
                            'token' => HMWP_Classes_Tools::getOption( 'api_token' )
                        );
                        HMWP_Classes_Tools::hmwp_remote_post( _HMWP_ACCOUNT_SITE_ . '/api/log/settings', $args, array('timeout' => 5) );
                    }

                    if ( HMWP_Classes_Tools::getOption( 'hmwp_file_cache' ) ) {
                        //Flush the changes
                        HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->flushChanges();
                    }

                    if ( HMWP_Classes_Tools::getOption( 'hmwp_firstload' ) ) {
                        //Add the must use plugin to force loading before all other plugins
                        HMWP_Classes_ObjController::getClass( 'HMWP_Models_Compatibility' )->addMUPlugin();
                    }

                    //Clear the cache if there are no errors
                    if ( !HMWP_Classes_Tools::getOption( 'error' ) ) {

                        if ( !HMWP_Classes_Tools::getOption( 'logout' ) ) {
                            HMWP_Classes_Tools::saveOptionsBackup();
                        }

                        HMWP_Classes_Tools::emptyCache();
                        HMWP_Classes_Error::setError( __( 'Saved' ), 'success' );
                    }


                }
                break;
            case 'hmwp_devsettings':
                HMWP_Classes_Tools::saveOptions( 'hmwp_userroles', HMWP_Classes_Tools::getValue( 'hmwp_userroles' ) );
                HMWP_Classes_Tools::saveOptions( 'hmwp_debug', HMWP_Classes_Tools::getValue( 'hmwp_debug' ) );

                if ( !HMWP_Classes_Tools::getOption( 'hmwp_userroles' ) ) {
                    //remove Hide My WP Roles
                    HMWP_Classes_ObjController::getClass( 'HMWP_Models_RoleManager' )->removeHMWPCaps();
                    HMWP_Classes_ObjController::getClass( 'HMWP_Models_RoleManager' )->removeHMWPRoles();
                }

                break;
            case 'hmwp_devdownload':

                HMWP_Classes_Tools::setHeader( 'text' );
                $filename = preg_replace( '/[-.]/', '_', parse_url( home_url(), PHP_URL_HOST ) );
                header( "Content-Disposition: attachment; filename=" . $filename . "_hidemywp_debug.txt" );

                if ( function_exists( 'glob' ) ) {
                    $pattern = _HMWP_CACHE_DIR_ . '*.log';
                    $files = glob( $pattern, 0 );
                    if ( !empty( $files ) ) {
                        foreach ( $files as $file ) {
                            echo basename( $file ) . PHP_EOL;
                            echo "---------------------------" . PHP_EOL;
                            echo file_get_contents( $file ) . PHP_EOL . PHP_EOL . PHP_EOL . PHP_EOL;
                        }
                    }
                }

                exit();
            case 'hmwp_abort':
                $hmwp_token = HMWP_Classes_Tools::getOption( 'hmwp_token' );
                //get the safe options from database
                HMWP_Classes_Tools::$options = HMWP_Classes_Tools::getOptions( true );
                //set the previous admin path
                if ( $hmwp_token ) HMWP_Classes_Tools::saveOptions( 'hmwp_token', $hmwp_token );
                HMWP_Classes_Tools::saveOptions( 'error', false );
                //set logout to false
                HMWP_Classes_Tools::saveOptions( 'logout', false );
                //set test frontend to false
                HMWP_Classes_Tools::saveOptions( 'test_frontend', false );

                //Clear the cache and remove the redirects
                HMWP_Classes_Tools::emptyCache();
                //Flush the WordPress rewrites
                HMWP_Classes_Tools::flushWPRewrites();

                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->clearRedirect();
                //Flush the changes
                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->flushChanges();

                //Set the cookies for the current path
                $cookies = HMWP_Classes_ObjController::newInstance( 'HMWP_Models_Cookies' );
                if ( HMWP_Classes_Tools::isNginx() || $cookies->setCookiesCurrentPath() ) {


                    remove_all_filters( 'wp_redirect' );
                    remove_all_filters( 'admin_url' );
                    wp_safe_redirect( HMWP_Classes_Tools::getSettingsUrl() );
                    exit();
                }

                break;
            case 'hmwp_newpluginschange':
                //reset the change notification
                HMWP_Classes_Tools::saveOptions( 'changes', 0 );
                remove_action( 'admin_notices', array($this, 'showSaveRequires') );

                //generate unique names for plugins if needed
                if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_plugins' ) ) {
                    HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->hidePluginNames();
                }
                if ( HMWP_Classes_Tools::getOption( 'hmwp_hide_themes' ) ) {
                    HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->hideThemeNames();
                }

                //Clear the cache and remove the redirects
                HMWP_Classes_Tools::emptyCache();

                //Flush the WordPress rewrites
                HMWP_Classes_Tools::flushWPRewrites();

                //Flush the changes
                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->flushChanges();

                if ( !HMWP_Classes_Error::isError() ) {
                    HMWP_Classes_Error::setError( __( 'The list of plugins and themes was updated with success!' ), 'success' );
                }
                break;
            case 'hmwp_confirm':
                HMWP_Classes_Tools::saveOptions( 'error', false );
                HMWP_Classes_Tools::saveOptions( 'logout', false );
                HMWP_Classes_Tools::saveOptions( 'test_frontend', false );

                //Send email notification about the path changed
                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->sendEmail();

                //save to safe mode in case of db
                if ( !HMWP_Classes_Tools::getOption( 'logout' ) ) {
                    HMWP_Classes_Tools::saveOptionsBackup();
                }

                //Force the rechck security notification
                delete_option( 'hmwp_securitycheck_time' );

                break;
            case 'hmwp_logout':
                HMWP_Classes_Tools::saveOptions( 'error', false );
                HMWP_Classes_Tools::saveOptions( 'logout', false );
                HMWP_Classes_Tools::saveOptions( 'test_frontend', false );

                //Send email notification about the path changed
                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->sendEmail();

                //save to safe mode in case of db
                if ( !HMWP_Classes_Tools::getOption( 'logout' ) ) {
                    HMWP_Classes_Tools::saveOptionsBackup();
                }

                //Force the rechck security notification
                delete_option( 'hmwp_securitycheck_time' );
                //Clear the cache
                HMWP_Classes_Tools::emptyCache();

                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->flushChanges();

                wp_logout();
                wp_redirect( site_url( HMWP_Classes_Tools::getOption( 'hmwp_login_url' ) ) );
                die();
            case 'hmwp_manualrewrite':
                HMWP_Classes_Tools::saveOptions( 'error', false );
                HMWP_Classes_Tools::saveOptions( 'logout', false );
                HMWP_Classes_Tools::saveOptions( 'test_frontend', true );

                //save to safe mode in case of db
                if ( !HMWP_Classes_Tools::getOption( 'logout' ) ) {
                    HMWP_Classes_Tools::saveOptionsBackup();
                }

                //Clear the cache if there are no errors
                HMWP_Classes_Tools::emptyCache();

                if ( HMWP_Classes_Tools::isNginx() ) {
                    @shell_exec( 'nginx -s reload' );
                }

                break;
            case 'hmwp_changepathsincache':
                //Check the cache plugin
                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Compatibility' )->checkCacheFiles();
                HMWP_Classes_Tools::setHeader( 'json' );
                echo json_encode( array() );
                exit();
            case 'hmwp_connect':
                //Connect to API with the Token
                $token = HMWP_Classes_Tools::getValue( 'hmwp_token', '' );

                $redirect_to = HMWP_Classes_Tools::getSettingsUrl();
                if ( $token <> '' ) {
                    if ( preg_match( '/^[a-z0-9\-]{32}$/i', $token ) ) {
                        HMWP_Classes_Tools::checkApi( $token, $redirect_to );
                    } else {
                        HMWP_Classes_Error::setError( __( 'ERROR! Please make sure you use a valid token to activate the plugin', _HMWP_PLUGIN_NAME_ ) . " <br /> " );
                    }
                } else {
                    HMWP_Classes_Error::setError( __( 'ERROR! Please make sure you use the right token to activate the plugin', _HMWP_PLUGIN_NAME_ ) . " <br /> " );
                }
                break;
            case 'hmwp_backup':
                //Save the Settings into backup
                if ( !HMWP_Classes_Tools::userCan( 'hmwp_manage_settings' ) ) {
                    return;
                }
                HMWP_Classes_Tools::getOptions();
                HMWP_Classes_Tools::setHeader( 'text' );
                $filename = preg_replace( '/[-.]/', '_', parse_url( home_url(), PHP_URL_HOST ) );
                header( "Content-Disposition: attachment; filename=" . $filename . "_hidemywp_backup.txt" );

                if ( function_exists( 'base64_encode' ) ) {
                    echo base64_encode( json_encode( HMWP_Classes_Tools::$options ) );
                } else {
                    echo json_encode( HMWP_Classes_Tools::$options );
                }
                exit();
                break;
            case 'hmwp_restore':
                //Restore the backup
                if ( !HMWP_Classes_Tools::userCan( 'hmwp_manage_settings' ) ) {
                    return;
                }

                if ( !empty( $_FILES['hmwp_options'] ) && $_FILES['hmwp_options']['tmp_name'] <> '' ) {
                    $options = file_get_contents( $_FILES['hmwp_options']['tmp_name'] );
                    try {
                        if ( function_exists( 'base64_encode' ) && base64_decode( $options ) <> '' ) {
                            $options = base64_decode( $options );
                        }
                        $options = json_decode( $options, true );
                        if ( is_array( $options ) && isset( $options['hmwp_ver'] ) ) {
                            foreach ( $options as $key => $value ) {
                                if ( $key <> 'hmwp_token' ) {
                                    HMWP_Classes_Tools::$options[$key] = $options[$key];
                                }
                            }
                            HMWP_Classes_Tools::saveOptions();
                            HMWP_Classes_Error::setError( __( 'Great! The backup is restored.', _HMWP_PLUGIN_NAME_ ) . " <br /> ", 'success' );

                            if ( !HMWP_Classes_Tools::getOption( 'error' ) ) {
                                HMWP_Classes_Tools::emptyCache();
                                //Flush the WordPress rewrites
                                add_action( 'admin_footer', array(
                                    'HMWP_Classes_Tools',
                                    'flushWPRewrites'
                                ), PHP_INT_MAX );
                            }

                            if ( !HMWP_Classes_Tools::getOption( 'error' ) && !HMWP_Classes_Tools::getOption( 'logout' ) ) {
                                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->flushChanges();
                            }

                        } elseif ( is_array( $options ) && isset( $options['hmw_ver'] ) ) {
                            foreach ( $options as $key => $value ) {
                                if ( $key <> 'hmw_token' ) {
                                    HMWP_Classes_Tools::$options[str_replace( 'hmw_', 'hmwp_', $key )] = $options[$key];
                                }
                            }
                            HMWP_Classes_Tools::saveOptions();
                            HMWP_Classes_Error::setError( __( 'Great! The backup is restored.', _HMWP_PLUGIN_NAME_ ) . " <br /> ", 'success' );

                            if ( !HMWP_Classes_Tools::getOption( 'error' ) ) {
                                HMWP_Classes_Tools::emptyCache();
                                //Flush the WordPress rewrites
                                add_action( 'admin_footer', array(
                                    'HMWP_Classes_Tools',
                                    'flushWPRewrites'
                                ), PHP_INT_MAX );
                            }

                            if ( !HMWP_Classes_Tools::getOption( 'error' ) && !HMWP_Classes_Tools::getOption( 'logout' ) ) {
                                HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' )->flushChanges();
                            }

                        } else {
                            HMWP_Classes_Error::setError( __( 'Error! The backup is not valid.', _HMWP_PLUGIN_NAME_ ) . " <br /> " );
                        }
                    } catch ( Exception $e ) {
                        HMWP_Classes_Error::setError( __( 'Error! The backup is not valid.', _HMWP_PLUGIN_NAME_ ) . " <br /> " );
                    }
                } else {
                    HMWP_Classes_Error::setError( __( 'Error! You have to enter a previous saved backup file.', _HMWP_PLUGIN_NAME_ ) . " <br /> " );
                }
                break;

        }
    }


    public function hookFooter() {
        HMWP_Classes_Tools::saveOptions();
    }

}
