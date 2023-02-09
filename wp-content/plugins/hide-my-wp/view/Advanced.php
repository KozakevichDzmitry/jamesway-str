<?php if ( HMWP_Classes_Tools::isPermalinkStructure() ) { ?>
    <div id="hmwp_wrap" class="d-flex flex-row my-3 bg-light">
        <?php echo $view->getAdminTabs( HMWP_Classes_Tools::getValue( 'tab', 'hmwp_permalinks' ) ); ?>
        <div class="hmwp_row d-flex flex-row bg-white px-3">
            <div class="hmwp_col flex-grow-1 mr-3">
                <form method="POST">
                    <?php wp_nonce_field( 'hmwp_advsettings', 'hmwp_nonce' ) ?>
                    <input type="hidden" name="action" value="hmwp_advsettings"/>

                    <div class="card p-0 col-sm-12 tab-panel">
                        <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Rollback Settings', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                        <div class="card-body">

                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                <div class="col-sm-4 p-0 font-weight-bold">
                                    <?php _e( 'Custom Safe URL Param', _HMWP_PLUGIN_NAME_ ); ?>:
                                    <div class="small text-black-50"><?php _e( "eg. disable_url, safe_url", _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                    <input type="text" class="form-control bg-input" name="hmwp_disable_name" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_disable_name' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_disable_name' ) ?>"/>
                                    <a href="https://hidemywpghost.com/kb/advanced-wp-security/#custom_safe_url" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                </div>
                                <div class="col-sm-12 pt-4">
                                    <div class="small text-black-50 text-center"><?php _e( "The Safe URL will set all the settings to default. Use it only if you're locked out.", _HMWP_PLUGIN_NAME_ ); ?></div>
                                    <div class="text-danger text-center"><?php echo '<strong>' . __( "Safe URL:", _HMWP_PLUGIN_NAME_ ) . '</strong>' . ' ' . site_url() . "/wp-login.php?" . HMWP_Classes_Tools::getOption( 'hmwp_disable_name' ) . "=" . HMWP_Classes_Tools::getOption( 'hmwp_disable' ) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-0 col-sm-12 tab-panel">
                        <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Loading Speed Settings', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                        <div class="card-body">
                            <?php if ( !HMWP_Classes_Tools::isIIS() ) { ?>
                                <div class="col-sm-12 row mb-1 ml-1">
                                    <div class="checker col-sm-12 row my-2 py-1">
                                        <div class="col-sm-12 p-0 switch switch-sm">
                                            <input type="hidden" name="hmwp_file_cache" value="0"/>
                                            <input type="checkbox" id="hmwp_file_cache" name="hmwp_file_cache" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_file_cache' ) ? 'checked="checked"' : '') ?> value="1"/>
                                            <label for="hmwp_file_cache"><?php _e( 'Optimize CSS and JS files', _HMWP_PLUGIN_NAME_ ); ?></label>
                                            <a href="https://hidemywpghost.com/kb/advanced-wp-security/#optimize_css" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                            <div class="offset-1 text-black-50"><?php echo __( 'Cache CSS, JS and Images to increase the frontend loading speed.', _HMWP_PLUGIN_NAME_ ); ?></div>
                                            <div class="offset-1 text-black-50"><?php echo sprintf( __( 'Check the website loading speed with %sPingdom Tool%s', _HMWP_PLUGIN_NAME_ ), '<a href="https://tools.pingdom.com/" target="_blank">', '</a>' ); ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card p-0 col-sm-12 tab-panel">
                        <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Compatibility Settings', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                        <div class="card-body">

                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_firstload" value="0"/>
                                        <input type="checkbox" id="hmwp_firstload" name="hmwp_firstload" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_firstload' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_firstload"><?php _e( 'Load As Must Use Plugin', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <a href="https://hidemywpghost.com/kb/advanced-wp-security/#firstload" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                        <div class="offset-1 text-black-50"><?php _e( 'Force Hide My WP Ghost to load as a Must Use plugin.', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        <div class="offset-1 text-black-50"><?php _e( '(compatibility with Manage WP plugin and Token based login plugins)', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_laterload" value="0"/>
                                        <input type="checkbox" id="hmwp_laterload" name="hmwp_laterload" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_laterload' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_laterload"><?php _e( 'Late Loading', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <a href="https://hidemywpghost.com/kb/advanced-wp-security/#late_loading" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                        <div class="offset-1 text-black-50"><?php echo __( 'Load HMWP after all plugins are loaded.', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        <div class="offset-1 text-black-50"><?php echo __( '(compatibility with CDN Enabler and other cache plugins)', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_remove_third_hooks" value="0"/>
                                        <input type="checkbox" id="hmwp_remove_third_hooks" name="hmwp_remove_third_hooks" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_remove_third_hooks' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_remove_third_hooks"><?php _e( 'Clean Login Page', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <a href="https://hidemywpghost.com/kb/advanced-wp-security/#clean_login_page" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                        <div class="offset-1 text-black-50"><?php _e( 'Cancel the login hooks from other plugins and themes to prevent them from changing the Hide My WP redirects.', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        <div class="offset-1 text-black-50"><?php _e( '(useful when the theme is adding wrong admin redirects or infinite redirects)', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="card p-0 col-sm-12 tab-panel">
                        <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Notification Settings', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                        <div class="card-body">

                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_send_email" value="0"/>
                                        <input type="checkbox" id="hmwp_send_email" name="hmwp_send_email" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_send_email' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_send_email"><?php _e( 'Email notification', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <a href="https://hidemywpghost.com/kb/advanced-wp-security/#email_notification" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                        <div class="offset-1 text-black-50"><?php _e( 'Send me an email with the changed admin and login URLs', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                <div class="col-sm-4 p-1 font-weight-bold">
                                    <?php _e( 'Email Address', _HMWP_PLUGIN_NAME_ ); ?>:
                                </div>
                                <div class="col-sm-8 p-0 input-group input-group">
                                    <?php
                                    $email = HMWP_Classes_Tools::getOption( 'hmwp_email_address' );
                                    if ( $email == '' ) {
                                        global $current_user;
                                        $email = $current_user->user_email;
                                    }
                                    ?>
                                    <input type="text" class="form-control bg-input" name="hmwp_email_address" value="<?php echo $email ?>" placeholder="Email address ..."/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 m-0 p-2 bg-light text-center" style="position: fixed; bottom: 0; right: 0; z-index: 100; box-shadow: 0px 0px 8px -3px #444;">
                        <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mr-5 save"><?php _e( 'Save', _HMWP_PLUGIN_NAME_ ); ?></button>
                        <a href="https://wordpress.org/support/plugin/hide-my-wp/reviews/?rate=5#new-post" target="_blank" style="color: #ff005e;"><?php echo sprintf( __( 'Love Hide My WP %s? Show us ;)', _HMWP_PLUGIN_NAME_ ), _HMWP_VER_NAME_ ); ?></a>
                    </div>
                </form>

            </div>
            <div class="hmwp_col hmwp_col_side">
                <div class="hmwp_col hmwp_col_side">
                    <div class="card col-sm-12 p-0">
                        <div class="card-body f-gray-dark text-center">
                            <h3 class="card-title"><?php _e( 'Check Your Website', _HMWP_PLUGIN_NAME_ ); ?></h3>
                            <div class="card-text text-muted">
                                <?php echo __( 'Check if your website is secured with the current settings.', _HMWP_PLUGIN_NAME_ ) ?>
                            </div>
                            <div class="card-text text-info m-3">
                                <a href="<?php echo HMWP_Classes_Tools::getSettingsUrl( 'hmwp_securitycheck' ) ?>" class="btn rounded-0 btn-warning btn-lg text-white px-4 securitycheck"><?php _e( 'Security Check', _HMWP_PLUGIN_NAME_ ); ?></a>
                            </div>
                            <div class="card-text text-muted small">
                                <?php echo __( 'Make sure you save the settings and empty the cache before checking your website with our tool.', _HMWP_PLUGIN_NAME_ ) ?>
                            </div>

                            <div class="card-text m-3 ">
                                <a class="bigbutton text-center" href="https://hidemywpghost.com/" target="_blank"><?php echo __( "Learn more about Hide My WP", _HMWP_PLUGIN_NAME_ ); ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="card col-sm-12 p-0">
                        <div class="card-body f-gray-dark text-center">
                            <h3 class="card-title"><?php echo __( 'Love Hide My WP?', _HMWP_PLUGIN_NAME_ ); ?></h3>
                            <div class="card-text text-muted">
                                <h1><i class="fa fa-heart text-danger"></i></h1>
                                <?php echo __( 'Give us 5 stars on WordPress.org', _HMWP_PLUGIN_NAME_ ) ?>
                            </div>
                            <div class="card-text text-info m-3">
                                <a href="https://wordpress.org/support/plugin/hide-my-wp/reviews/?rate=5#new-post" target="_blank" class="btn rounded-0 btn-success btn-lg px-4"><?php echo __( 'Rate Hide My WP', _HMWP_PLUGIN_NAME_ ); ?></a>
                            </div>

                        </div>
                    </div>

                    <div class="card col-sm-12 p-0">
                        <div class="card-body f-gray-dark text-center">
                            <h3 class="card-title"><?php echo __( 'Activate Dev Mode', _HMWP_PLUGIN_NAME_ ); ?></h3>
                            <div class="col-sm-12 row mb-1 mx-0 p-0">
                                <div class="checker col-sm-12 row my-3 mx-0 p-0">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <form id="hmwp_devsettings" method="POST">
                                            <?php wp_nonce_field( 'hmwp_devsettings', 'hmwp_nonce' ) ?>
                                            <input type="hidden" name="action" value="hmwp_devsettings"/>
                                            <input type="hidden" name="hmwp_userroles" value="0"/>
                                            <input type="checkbox" id="hmwp_userroles" name="hmwp_userroles" onchange="jQuery('#hmwp_devsettings').submit()" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_userroles' ) ? 'checked="checked"' : '') ?> value="1"/>
                                            <label for="hmwp_userroles"><?php _e( 'Add Dev Role', _HMWP_PLUGIN_NAME_ ); ?></label>

                                            <div class="text-black-50"><?php echo __( "Add HideMyWP developer role if you want to create a dev account for support.", _HMWP_PLUGIN_NAME_ ); ?></div>

                                            <div class="border-top mt-3 pt-3"></div>
                                            <input type="hidden" name="hmwp_debug" value="0"/>
                                            <input type="checkbox" id="hmwp_debug" name="hmwp_debug" onchange="jQuery('#hmwp_devsettings').submit()" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_debug' ) ? 'checked="checked"' : '') ?> value="1"/>
                                            <label for="hmwp_debug"><?php _e( 'Debug Mode', _HMWP_PLUGIN_NAME_ ); ?></label>
                                            <div class="text-black-50"><?php echo __( "Activate info and logs for faster debugging.", _HMWP_PLUGIN_NAME_ ); ?></div>

                                        </form>

                                        <?php if ( HMWP_Classes_Tools::getOption( 'hmwp_debug' ) ) { ?>
                                            <form id="hmwp_devsettings" method="POST">
                                                <?php wp_nonce_field( 'hmwp_devdownload', 'hmwp_nonce' ) ?>
                                                <input type="hidden" name="action" value="hmwp_devdownload"/>
                                                <button type="submit" class="btn btn-link"><?php _e( 'Download Log', _HMWP_PLUGIN_NAME_ ); ?></button>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
