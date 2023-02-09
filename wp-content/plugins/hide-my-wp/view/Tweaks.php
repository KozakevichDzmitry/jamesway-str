<div id="hmwp_wrap" class="d-flex flex-row my-3 bg-light">
    <?php echo $view->getAdminTabs( HMWP_Classes_Tools::getValue( 'tab', 'hmwp_permalinks' ) ); ?>
    <div class="hmwp_row d-flex flex-row bg-white px-3">
        <div class="hmwp_col flex-grow-1 mr-3">
            <form method="POST">
                <?php wp_nonce_field( 'hmwp_tweakssettings', 'hmwp_nonce' ) ?>
                <input type="hidden" name="action" value="hmwp_tweakssettings"/>

                <div class="card p-0 col-sm-12 tab-panel">
                    <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Redirect Settings', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                    <div class="card-body">
                        <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                            <div class="col-sm-4 p-1">
                                <div class="font-weight-bold"><?php _e( 'Redirect Hidden Paths', _HMWP_PLUGIN_NAME_ ); ?>:</div>
                            </div>
                            <div class="col-sm-8 p-0 input-group input-group-lg mb-1">
                                <select name="hmwp_url_redirect" class="form-control bg-input">
                                    <option value="." <?php selected( '.', HMWP_Classes_Tools::getOption( 'hmwp_url_redirect' ), true ) ?>><?php _e( "Front page", _HMWP_PLUGIN_NAME_ ) ?></option>
                                    <option value="404" <?php selected( '404', HMWP_Classes_Tools::getOption( 'hmwp_url_redirect' ), true ) ?> ><?php _e( "404 page", _HMWP_PLUGIN_NAME_ ) ?></option>
                                    <option value="NFError" <?php selected( 'NFError', HMWP_Classes_Tools::getOption( 'hmwp_url_redirect' ), true ) ?> ><?php _e( "404 HTML Error", _HMWP_PLUGIN_NAME_ ) ?></option>
                                    <option value="NAError" <?php selected( 'NAError', HMWP_Classes_Tools::getOption( 'hmwp_url_redirect' ), true ) ?> ><?php _e( "403 HTML Error", _HMWP_PLUGIN_NAME_ ) ?></option>
                                    <?php
                                    $pages = get_pages();
                                    foreach ( $pages as $page ) {
                                        if ( $page->post_title <> '' ) {
                                            $option = '<option value="' . $page->post_name . '" ' . selected( $page->post_name, HMWP_Classes_Tools::getOption( 'hmwp_url_redirect' ), true ) . '>';
                                            $option .= $page->post_title;
                                            $option .= '</option>';
                                            echo $option;
                                        }
                                    } ?>
                                </select>
                                <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#redirect_paths" target="_blank" class="position-absolute float-right" style="right: 27px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                            </div>
                            <div class="p-1">
                                <div class="text-black-50"><?php echo __( 'Redirect the protected paths /wp-admin, /wp-login to a Page or trigger an HTML Error.', _HMWP_PLUGIN_NAME_ ); ?></div>
                                <div class="text-black-50"><?php echo __( 'You can create a new page and come back to choose to redirect to that page.', _HMWP_PLUGIN_NAME_ ); ?></div>
                            </div>
                        </div>

                        <?php
                        /** @var $wp_roles WP_Roles */
                        global $wp_roles;

                        $allroles = array();
                        if ( function_exists( 'wp_roles' ) ) {
                            $allroles = wp_roles()->get_names();
                            if ( !empty( $allroles ) ) {
                                $allroles = array_keys( $allroles );
                            }
                        }

                        $urlRedirects = HMWP_Classes_Tools::getOption( 'hmwp_url_redirects' );
                        ?>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#default" role="tab" aria-controls="default" aria-selected="true"><?php echo __( "Default", _HMWP_PLUGIN_NAME_ ) ?></a>
                            </li>
                            <?php if ( !empty( $allroles ) ) { ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo __( "User Role", _HMWP_PLUGIN_NAME_ ) ?></a>
                                    <div class="dropdown-menu" style="height: auto; max-height: 200px; overflow-x: hidden;">
                                        <?php foreach ( $allroles as $role ) { ?>
                                            <a class="dropdown-item" data-toggle="tab" href="#nav-<?php echo esc_attr( $role ) ?>" role="tab" aria-controls="nav-<?php echo esc_attr( $role ) ?>" aria-selected="false"><?php echo esc_attr( ucwords( str_replace( '_', ' ', $role ) ) ) ?></a>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content border-right border-left border-bottom p-0 m-0">
                            <div class="tab-pane fade show active" id="default" role="tabpanel" aria-labelledby="nav-home-tab">

                                <div class="col-sm-12 row border-bottom border-light py-4 m-0">
                                    <div class="col-sm-4 p-0 py-2 font-weight-bold">
                                        <?php _e( 'Login Redirect URL', _HMWP_PLUGIN_NAME_ ); ?>:
                                        <div class="small text-black-50"><?php echo __( "eg.", _HMWP_PLUGIN_NAME_ ) . ' ' . admin_url( '', 'relative' ); ?></div>
                                    </div>
                                    <div class="col-sm-8 p-0 input-group input-group-lg">
                                        <input type="text" class="form-control bg-input" name="hmwp_url_redirects[default][login]" value="<?php echo(isset( $urlRedirects['default']['login'] ) ? $urlRedirects['default']['login'] : '') ?>" />
                                        <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#redirect_on_login" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>

                                <div class="col-sm-12 row border-bottom border-light py-4 mx-0">
                                    <div class="col-sm-4 p-0 py-2 font-weight-bold">
                                        <?php _e( 'Logout Redirect URL', _HMWP_PLUGIN_NAME_ ); ?>:
                                        <div class="small text-black-50"><?php echo __( "eg. /logout or ", _HMWP_PLUGIN_NAME_ ) . ' ' . home_url( '', 'relative' ); ?></div>
                                    </div>
                                    <div class="col-sm-8 p-0 input-group input-group-lg">
                                        <input type="text" class="form-control bg-input" name="hmwp_url_redirects[default][logout]" value="<?php echo(isset( $urlRedirects['default']['logout'] ) ? $urlRedirects['default']['logout'] : '') ?>" />
                                        <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#redirect_on_login" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>

                                <div class="p-3">
                                    <div class="text-danger"><?php echo sprintf(__( "%s Note! %s Make sure you that the redirect URLs exist on your website. %sThe User Role redirect URL has higher priority than the Default redirect URL.", _HMWP_PLUGIN_NAME_ ),'<strong>','</strong>', '<br />'); ?></div>
                                </div>
                            </div>

                            <?php if ( !empty( $allroles ) ) {
                                foreach ( $allroles as $role ) { ?>
                                    <div class="tab-pane fade" id="nav-<?php echo esc_attr( $role ) ?>" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <h5 class="card-title pt-3 pb-1 mx-3 text-black-50 border-bottom border-light"><?php echo ucwords( str_replace( '_', ' ', $role ) ) . ' ' . __( "redirects", _HMWP_PLUGIN_NAME_ ); ?>:</h5>
                                        <div class="col-sm-12 row border-bottom border-light py-4 m-0">
                                            <div class="col-sm-4 p-0 py-2 font-weight-bold">
                                                <?php _e( 'Login Redirect URL', _HMWP_PLUGIN_NAME_ ); ?>:
                                                <div class="small text-black-50"><?php echo __( "eg.", _HMWP_PLUGIN_NAME_ ) . ' ' . admin_url( '', 'relative' ); ?></div>
                                            </div>
                                            <div class="col-sm-8 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="hmwp_url_redirects[<?php echo $role ?>][login]" value="<?php echo(isset( $urlRedirects[$role]['login'] ) ? $urlRedirects[$role]['login'] : '') ?>"/>
                                                <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#redirect_on_login" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 row border-bottom border-light py-4 m-0">
                                            <div class="col-sm-4 p-0 py-2 font-weight-bold">
                                                <?php _e( 'Logout Redirect URL', _HMWP_PLUGIN_NAME_ ); ?>:
                                                <div class="small text-black-50"><?php echo __( "eg. /logout or ", _HMWP_PLUGIN_NAME_ ) . ' ' . home_url( '', 'relative' ); ?></div>
                                            </div>
                                            <div class="col-sm-8 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="hmwp_url_redirects[<?php echo $role ?>][logout]" value="<?php echo(isset( $urlRedirects[$role]['logout'] ) ? $urlRedirects[$role]['logout'] : '') ?>"/>
                                                <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#redirect_on_login" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                            </div>
                                        </div>

                                        <div class="p-3">
                                            <div class="text-danger"><?php echo sprintf(__( "%s Note! %s Make sure you that the redirect URLs exist on your website. %sThe User Role redirect URL has higher priority than the Default redirect URL.", _HMWP_PLUGIN_NAME_ ),'<strong>','</strong>', '<br />'); ?></div>
                                        </div>
                                    </div>
                                <?php }
                            } ?>


                        </div>

                    </div>
                </div>

                <div class="card col-sm-12 p-0 tab-panel">
                    <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Change Options', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                    <div class="card-body">

                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_hide_loggedusers" value="0"/>
                                    <input type="checkbox" id="hmwp_hide_loggedusers" name="hmwp_hide_loggedusers" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_loggedusers' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_hide_loggedusers"><?php _e( 'Change Paths for Logged Users', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#change_paths_logged_users" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php _e( "Change WordPress paths while you're logged in", _HMWP_PLUGIN_NAME_ ); ?></div>
                                    <div class="offset-1 mt-1 text-danger"><?php _e( "(not recommended, may affect other plugins functionality in admin)", _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                            </div>
                        </div>

                        <?php if ( WP_CACHE ||
                            HMWP_Classes_Tools::isPluginActive( 'elementor/elementor.php' ) ||
                            HMWP_Classes_Tools::isPluginActive( 'beaver-builder-lite-version/fl-builder.php' ) ||
                            HMWP_Classes_Tools::isPluginActive( 'beaver-builder/fl-builder.php' ) ||
                            HMWP_Classes_Tools::isPluginActive( 'wp-rocket/wp-rocket.php' ) ||
                            HMWP_Classes_Tools::isPluginActive( 'wp-super-cache/wp-cache.php' ) ||
                            HMWP_Classes_Tools::isPluginActive( 'autoptimize/autoptimize.php' ) ||
                            HMWP_Classes_Tools::isPluginActive( 'hummingbird-performance/wp-hummingbird.php' ) ||
                            HMWP_Classes_Tools::isPluginActive( 'cache-enabler/cache-enabler.php' ) ||
                            HMWP_Classes_Tools::isPluginActive( 'wp-fastest-cache/wpFastestCache.php' ) ||
                            HMWP_Classes_Tools::isPluginActive( 'powered-cache/powered-cache.php' ) ||
                            HMWP_Classes_Tools::isPluginActive( 'fusion-builder/fusion-builder.php' ) ||
                            HMWP_Classes_Tools::isPluginActive( 'hyper-cache/plugin.php' )
                        ) { ?>
                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_change_in_cache" value="0"/>
                                        <input type="checkbox" id="hmwp_change_in_cache" name="hmwp_change_in_cache" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_change_in_cache' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_change_in_cache"><?php _e( 'Change Paths in Cached Files', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#change_paths_logged_users" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                        <a href="javascript:void(0);" onclick="jQuery(this).hmwp_changePaths();" class="d-inline-block ml-2"><?php _e( 'Change Paths Now', _HMWP_PLUGIN_NAME_ ); ?></a>
                                        <?php echo '<script>var hmwpQuery = {"ajaxurl": "' . admin_url( 'admin-ajax.php' ) . '","nonce": "' . wp_create_nonce( _HMWP_NONCE_ID_ ) . '"}</script>'; ?>
                                        <div class="offset-1 text-black-50"><?php echo __( 'Change the WordPress common paths in the cached files from /wp-content/cache directory', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        <div class="offset-1 mt-1 text-danger"><?php echo __( '(runs in background and it needs up to one minute after the cache is cleared)', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_hideajax_paths" value="0"/>
                                    <input type="checkbox" id="hmwp_hideajax_paths" name="hmwp_hideajax_paths" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hideajax_paths' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_hideajax_paths"><?php _e( 'Change Paths in Ajax Calls', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#change_paths_ajax" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php echo __( 'This will prevent from showing the old paths when an image or font is called through ajax', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_fix_relative" value="0"/>
                                    <input type="checkbox" id="hmwp_fix_relative" name="hmwp_fix_relative" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_fix_relative' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_fix_relative"><?php _e( 'Change Relative URLs to Absolute URLs', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#fix_relative_urls" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php echo sprintf( __( 'Convert links like /wp-content/* into  %s/wp-content/*.', _HMWP_PLUGIN_NAME_ ), site_url() ); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_shutdownload" value="0"/>
                                    <input type="checkbox" id="hmwp_shutdownload" name="hmwp_shutdownload" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_shutdownload' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_shutdownload"><?php _e( 'Change Paths in Sitemaps XML', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#fix_sitemap_xml" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php echo __( 'Double check the Sitemap XML files and make sure the paths are changed.', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_robots" value="0"/>
                                    <input type="checkbox" id="hmwp_robots" name="hmwp_robots" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_robots' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_robots"><?php _e( 'Change Paths in Robots.txt', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#fix_robots_txt" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php echo __( 'Hide WordPress paths from robots.txt file', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-sm-12 p-0 tab-panel">
                    <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Hide/Show Options', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                    <div class="card-body">

                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm switch-red">
                                    <input type="hidden" name="hmwp_in_dashboard" value="0"/>
                                    <input type="checkbox" id="hmwp_in_dashboard" name="hmwp_in_dashboard" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_in_dashboard' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_in_dashboard"><?php _e( 'Hide Admin Toolbar', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#admin_toolbar" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php _e( 'Hide admin bar for logged users.', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    <div class="offset-1 mt-1 text-danger"><?php _e( "(this option hides the admin toolbar for all the logged users)", _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_hide_version" value="0"/>
                                    <input type="checkbox" id="hmwp_hide_version" name="hmwp_hide_version" class="js-switch pull-right fixed-sidebar-check" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_version' ) ? 'checked="checked"' : '') ?>value="1"/>
                                    <label for="hmwp_hide_version"><?php _e( 'Hide Versions and WordPress Tags', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#hide_wordpress_version" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php _e( "Hide WordPress and Plugin versions from the end of any image, css and js files", _HMWP_PLUGIN_NAME_ ); ?></div>
                                    <div class="offset-1 text-black-50"><?php _e( "Hide the WP Generator META", _HMWP_PLUGIN_NAME_ ); ?></div>
                                    <div class="offset-1 text-black-50"><?php _e( "Hide the WP DNS Prefetch META", _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_hide_header" value="0"/>
                                    <input type="checkbox" id="hmwp_hide_header" name="hmwp_hide_header" class="js-switch pull-right fixed-sidebar-check" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_header' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_hide_header"><?php _e( 'Hide RSD (Really Simple Discovery) header', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#hide_rsd" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php _e( "Don't show any WordPress information in HTTP header request", _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_hide_comments" value="0"/>
                                    <input type="checkbox" id="hmwp_hide_comments" name="hmwp_hide_comments" class="js-switch pull-right fixed-sidebar-check" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_comments' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_hide_comments"><?php _e( 'Hide WordPress HTML Comments', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#hide_comments" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php _e( "Hide the HTML Comments left by theme and plugins", _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_disable_emojicons" value="0"/>
                                    <input type="checkbox" id="hmwp_disable_emojicons" name="hmwp_disable_emojicons" class="js-switch pull-right fixed-sidebar-check" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_disable_emojicons' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_disable_emojicons"><?php _e( 'Hide Emojicons', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#hide_emojicons" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php _e( "Don't load Emoji Icons if you don't use them", _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-sm-12 p-0 tab-panel">
                    <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Disable Options', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                    <div class="card-body">
                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_disable_xmlrpc" value="0"/>
                                    <input type="checkbox" id="hmwp_disable_xmlrpc" name="hmwp_disable_xmlrpc" class="js-switch pull-right fixed-sidebar-check" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_disable_xmlrpc' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_disable_xmlrpc"><?php _e( 'Disable XML-RPC access', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#disable_xml_rpc_access" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php echo sprintf( __( "Don't load XML-RPC to prevent %sBrute force attacks via XML-RPC%s", _HMWP_PLUGIN_NAME_ ), '<a href="https://hidemywpghost.com/should-you-disable-xml-rpc-on-wordpress/" target="_blank">', '</a>' ); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_disable_embeds" value="0"/>
                                    <input type="checkbox" id="hmwp_disable_embeds" name="hmwp_disable_embeds" class="js-switch pull-right fixed-sidebar-check" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_disable_embeds' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_disable_embeds"><?php _e( 'Disable Embed scripts', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#disable_embed_scripts" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php _e( "Don't load oEmbed service if you don't use oEmbed videos", _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_disable_manifest" value="0"/>
                                    <input type="checkbox" id="hmwp_disable_manifest" name="hmwp_disable_manifest" class="js-switch pull-right fixed-sidebar-check" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_disable_manifest' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_disable_manifest"><?php _e( 'Disable WLW Manifest scripts', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#disable_wlw_scripts" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php _e( "Don't load WLW if you didn't configure Windows Live Writer for your site", _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 row mb-1 ml-1">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="hidden" name="hmwp_disable_debug" value="0"/>
                                    <input type="checkbox" id="hmwp_disable_debug" name="hmwp_disable_debug" class="js-switch pull-right fixed-sidebar-check" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_disable_debug' ) ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_disable_debug"><?php _e( 'Disable DB Debug in Frontent', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/activate-security-tweaks/#disable_db_debug" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php _e( "Don't load DB Debug if your website is live", _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
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
        </div>

    </div>
</div>