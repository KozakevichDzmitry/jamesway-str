<?php if ( HMWP_Classes_Tools::isPermalinkStructure() && !HMWP_Classes_Tools::isPHPPermalink() ) {  ?>
    <div id="hmwp_wrap" class="d-flex flex-row my-3 bg-light">
        <?php echo $view->getAdminTabs( HMWP_Classes_Tools::getValue( 'tab', 'hmwp_permalinks' ) ); ?>
        <div class="hmwp_row d-flex flex-row bg-white px-3">
            <?php do_action( 'hmwp_notices' ); ?>
            <div class="hmwp_col flex-grow-1 mr-3">
                <?php echo $view->getView( 'FrontendCheck' ); ?>

                <form method="POST">
                    <?php wp_nonce_field( 'hmwp_settings', 'hmwp_nonce' ); ?>
                    <input type="hidden" name="action" value="hmwp_settings"/>
                    <input type="hidden" name="hmwp_mode" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_mode' ) ?>"/>

                    <?php do_action( 'hmwp_form_notices' ); ?>

                    <div class="card col-sm-12">
                        <div class="card-body py-2 px-0">
                            <h3 class="card-title"><?php _e( 'Levels of security', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                            <div class="group_autoload d-flex justify-content-center btn-group mt-3" role="group" data-toggle="button">
                                <button type="button" class="btn btn-lg btn-outline-info default_autoload m-1 py-3 px-4 <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'default') ? 'active' : '') ?>"><?php echo __( "Default (unsafe)", _HMWP_PLUGIN_NAME_ ) ?></button>
                                <button type="button" class="btn btn-lg btn-outline-info lite_autoload m-1 py-3 px-4 <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'lite') ? 'active' : '') ?>"><?php echo __( "Safe mode", _HMWP_PLUGIN_NAME_ ) ?></button>
                                <button type="button" class="btn btn-lg btn-outline-info ninja_autoload m-1 py-3 px-4 <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'ninja') ? 'active' : '') ?>" data-toggle="modal" data-target="#hmwp_ghost_mode_modal"><?php echo __( "Ghost mode", _HMWP_PLUGIN_NAME_ ) ?></button>
                            </div>

                            <div class="hmwp_emulate_cms col-sm-12 row justify-content-center pt-4" <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'default') ? 'style="display:none"' : '') ?>>
                                <div class="col-sm-3 py-2 px-3 text-right">
                                    <div class="font-weight-bold"><?php _e( 'Simulate CMS', _HMWP_PLUGIN_NAME_ ); ?>:</div>
                                </div>
                                <div class="col-sm-3 p-0 input-group">
                                    <select name="hmwp_emulate_cms" class="form-control bg-input mb-1">
                                        <option value="" <?php selected( '', HMWP_Classes_Tools::getOption( 'hmwp_emulate_cms' ), true ) ?>><?php _e( "No CMS", _HMWP_PLUGIN_NAME_ ) ?></option>
                                        <option value="drupal7" <?php selected( 'drupal7', HMWP_Classes_Tools::getOption( 'hmwp_emulate_cms' ), true ) ?> ><?php _e( "Drupal 7", _HMWP_PLUGIN_NAME_ ) ?></option>
                                        <option value="drupal" <?php selected( 'drupal', HMWP_Classes_Tools::getOption( 'hmwp_emulate_cms' ), true ) ?> ><?php _e( "Drupal 8", _HMWP_PLUGIN_NAME_ ) ?></option>
                                        <option value="drupal9" <?php selected( 'drupal9', HMWP_Classes_Tools::getOption( 'hmwp_emulate_cms' ), true ) ?> ><?php _e( "Drupal 9", _HMWP_PLUGIN_NAME_ ) ?></option>
                                        <option value="joomla1" <?php selected( 'joomla1', HMWP_Classes_Tools::getOption( 'hmwp_emulate_cms' ), true ) ?> ><?php _e( "Joomla 1.5", _HMWP_PLUGIN_NAME_ ) ?></option>
                                        <option value="joomla3" <?php selected( 'joomla3', HMWP_Classes_Tools::getOption( 'hmwp_emulate_cms' ), true ) ?> ><?php _e( "Joomla 3", _HMWP_PLUGIN_NAME_ ) ?></option>
                                    </select>
                                </div>

                            </div>
                            <script>
                                (function ($) {
                                    $(document).ready(function () {
                                        $(".default_autoload").on('click', function () {
                                            $('input[name=hmwp_mode]').val('default');
                                            $('.group_autoload button').removeClass('active');
                                            <?php
                                            foreach ( HMWP_Classes_Tools::$default as $name => $value ) {
                                                if ( is_string( $value ) && $value <> "0" && $value <> "1" ) {
                                                    echo '$("input[type=text][name=' . $name . ']").val("' . str_replace( '"', '\\"', $value ) . '");' . "\n";
                                                } elseif ( $value == "0" || $value == "1" ) {
                                                    echo '$("input[name=' . $name . ']").prop("checked", ' . (int)$value . '); $("input[name=' . $name . ']").trigger("change");';
                                                }
                                            }
                                            ?>
                                            $('input[name=hmwp_admin_url]').trigger('keyup');
                                            $('.tab-panel').hide();
                                            $('.tab-panel_tutorial').show();
                                            $('.hmwp_emulate_cms').hide();
                                            $('select[name="hmwp_emulate_cms"] option[value="<?php echo HMWP_Classes_Tools::$default['hmwp_emulate_cms']?>"]').prop('selected', 'selected');
                                        });
                                        $(".lite_autoload").on('click', function () {
                                            $('input[name=hmwp_mode]').val('lite');
                                            $('.group_autoload button').removeClass('active');
                                            <?php
                                            $lite = @array_merge( HMWP_Classes_Tools::$default, HMWP_Classes_Tools::$lite );
                                            foreach ( $lite as $name => $value ) {
                                                if ( is_string( $value ) && $value <> "0" && $value <> "1" ) {
                                                    echo '$("input[type=text][name=' . $name . ']").val("' . str_replace( '"', '\\"', $value ) . '");' . "\n";
                                                } elseif ( $value == "0" || $value == "1" ) {
                                                    echo '$("input[name=' . $name . ']").prop("checked", ' . (int)$value . '); $("input[name=' . $name . ']").trigger("change");';

                                                }
                                            }
                                            ?>
                                            $('input[name=hmwp_admin_url]').trigger('keyup');
                                            $('.tab-panel').show();
                                            $('.tab-panel_tutorial').hide();
                                            $('select[name="hmwp_emulate_cms"] option[value="<?php echo $lite['hmwp_emulate_cms']?>"]').prop('selected', 'selected');
                                            $('.hmwp_emulate_cms').show();
                                        });
                                        $(".ninja_autoload").on('click', function () {
                                            $('input[name=hmwp_mode]').val('ninja');
                                            $('.group_autoload button').removeClass('active');
                                            <?php
                                            $ninja = @array_merge( HMWP_Classes_Tools::$default, HMWP_Classes_Tools::$ninja );
                                            foreach ( $ninja as $name => $value ) {
                                                if ( is_string( $value ) && $value <> "0" && $value <> "1" ) {
                                                    echo '$("input[type=text][name=' . $name . ']").val("' . str_replace( '"', '\\"', $value ) . '");' . "\n";
                                                } elseif ( $value == "0" || $value == "1" ) {
                                                    echo '$("input[name=' . $name . ']").prop("checked", ' . (int)$value . '); $("input[name=' . $name . ']").trigger("change");';

                                                }
                                            }
                                            ?>
                                            $('input[name=hmwp_admin_url]').trigger('keyup');
                                            $('.tab-panel').show();
                                            $('.tab-panel_tutorial').hide();

                                            $('select[name="hmwp_emulate_cms"] option[value="<?php echo $ninja['hmwp_emulate_cms']?>"]').prop('selected', 'selected');
                                            $('.hmwp_emulate_cms').show();
                                        });


                                    });
                                })(jQuery);
                            </script>

                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 tab-panel_tutorial text-center" <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) <> 'default') ? 'style="display:none"' : '') ?>>
                        <iframe width="853" height="480" style="max-width: 100%" src="https://www.youtube.com/embed/06KvFR3IQxY?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                    <div class="card col-sm-12 p-0 tab-panel" <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'default') ? 'style="display:none"' : '') ?>>
                        <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Admin Settings', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                        <div class="card-body">
                            <?php if ( defined( 'HMWP_DEFAULT_ADMIN' ) && HMWP_DEFAULT_ADMIN && HMW_RULES_IN_CONFIG ) {
                                echo ' <div class="text-danger col-sm-12 border-bottom border-light py-3 mx-0 my-3">' . sprintf( __( 'Your admin URL is changed by another plugin/theme in %s. To activate this option, disable the custom admin in the other plugin or deativate it.', _HMWP_PLUGIN_NAME_ ), '<strong>' . HMWP_DEFAULT_ADMIN . '</strong>' ) . '</div>';
                                echo '<input type="hidden" name="hmwp_admin_url" value="' . HMWP_Classes_Tools::$default['hmwp_admin_url'] . '"/>';
                            } else {
                                if ( HMWP_Classes_Tools::isGodaddy() ) {
                                    echo ' <div class="text-danger col-sm-12 border-bottom border-light py-3 mx-0 my-3">' . sprintf( __( "Your admin URL can't be changed on %s hosting because of the %s security terms.", _HMWP_PLUGIN_NAME_ ), '<strong>Godaddy</strong>', '<strong>Godaddy</strong>' ) . '</div>';
                                    echo '<input type="hidden" name="hmwp_admin_url" value="' . HMWP_Classes_Tools::$default['hmwp_admin_url'] . '"/>';
                                } elseif ( PHP_VERSION_ID >= 70400 && HMWP_Classes_Tools::isWpengine() ) {
                                    echo ' <div class="text-danger col-sm-12 border-bottom border-light py-3 mx-0 my-3">' . sprintf( __( "Your admin URL can't be changed on %s because of the %s rules are no longer used.", _HMWP_PLUGIN_NAME_ ), '<strong>Wpengine with PHP 7 or greater</strong>', '<strong>.htaccess</strong>' ) . '</div>';
                                    echo '<input type="hidden" name="hmwp_admin_url" value="' . HMWP_Classes_Tools::$default['hmwp_admin_url'] . '"/>';
                                } else {
                                    ?>
                                    <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                        <div class="col-sm-4 p-0 font-weight-bold">
                                            <?php _e( 'Custom Admin Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                            <div class="small text-black-50"><?php _e( 'eg. adm, back', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        </div>
                                        <div class="col-sm-8 p-0 input-group input-group-lg">
                                            <input type="text" class="form-control bg-input" name="hmwp_admin_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_admin_url' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_admin_url'] ?>"/>
                                            <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_admin" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-sm-12 row mb-1 ml-1">
                                    <div class="checker col-sm-12 row my-2 py-1">
                                        <div class="col-sm-12 p-0 switch switch-sm">
                                            <input type="hidden" name="hmwp_hide_admin" value="0"/>
                                            <input type="checkbox" id="hmwp_hide_admin" name="hmwp_hide_admin" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_admin' ) ? 'checked="checked"' : '') ?> value="1"/>
                                            <label for="hmwp_hide_admin"><?php _e( 'Hide "wp-admin"', _HMWP_PLUGIN_NAME_ ); ?></label>
                                            <div class="offset-1 text-black-50"><?php _e( 'Show 404 Not Found Error when visitors access /wp-admin', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 row mb-1 ml-1 hmwp_hide_newadmin_div" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_admin_url' ) == HMWP_Classes_Tools::$default['hmwp_admin_url'] ? 'style="display:none;"' : '') ?>>
                                    <div class="checker col-sm-12 row my-2 py-1">
                                        <div class="col-sm-12 p-0 switch switch-sm">
                                            <input type="hidden" name="hmwp_hide_newadmin" value="0"/>
                                            <input type="checkbox" id="hmwp_hide_newadmin" name="hmwp_hide_newadmin" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_newadmin' ) ? 'checked="checked"' : '') ?> value="1"/>
                                            <label for="hmwp_hide_newadmin"><?php _e( 'Hide the new admin path', _HMWP_PLUGIN_NAME_ ); ?></label>
                                            <div class="offset-1 text-black-50"><?php _e( 'Let only the new login be accesible and redirect me to admin after logging in', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="admin_warning col-sm-12 my-3 text-danger p-0 text-center small" style="display: none">
                                    <?php echo sprintf( __( "Some themes don't work with custom Admin and Ajax paths. In case of ajax errors, switch back to wp-admin and admin-ajax.php.", _HMWP_PLUGIN_NAME_ ) ); ?>
                                </div>
                                <div class="col-sm-12 text-center border-light py-1 m-0">
                                    <a href="<?php echo HMWP_Classes_Tools::getSettingsUrl( 'hmwp_settings-hmwp_tweaks', true ) ?>" target="_blank">
                                        <?php _e( 'Manage Login and Logout Redirects', _HMWP_PLUGIN_NAME_ ); ?>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 tab-panel" <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'default') ? 'style="display:none"' : '') ?>>
                        <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Login Settings', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                        <div class="card-body">
                            <?php if ( defined( 'HMWP_DEFAULT_LOGIN' ) && HMWP_DEFAULT_LOGIN ) {
                                echo '<div class="text-danger col-sm-12 border-bottom border-light py-3 mx-0 my-3">' . sprintf( __( 'Your login URL is changed by another plugin/theme in %s. To activate this option, disable the custom login in the other plugin or deativate it.', _HMWP_PLUGIN_NAME_ ), '<strong>' . HMWP_DEFAULT_LOGIN . '</strong>' ) . '</div>';
                                echo '<input type="hidden" name="hmwp_login_url" value="' . HMWP_Classes_Tools::$default['hmwp_login_url'] . '"/>';
                            } else {
                                ?>
                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-sm-4 p-0 font-weight-bold">
                                        <?php _e( 'Custom Login Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                        <div class="small text-black-50"><?php _e( 'eg. login or signin', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                    <div class="col-sm-8 p-0 input-group input-group-lg">
                                        <input type="text" class="form-control bg-input" name="hmwp_login_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_login_url' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_login_url'] ?>"/>
                                        <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_login" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>

                                <div class="col-sm-12 row mb-1 ml-1 hmwp_hide_wplogin_div" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_login_url' ) == HMWP_Classes_Tools::$default['hmwp_login_url'] ? 'style="display:none;"' : '') ?>>
                                    <div class="checker col-sm-12 row my-2 py-1">
                                        <div class="col-sm-12 p-0 switch switch-sm">
                                            <input type="hidden" name="hmwp_hide_wplogin" value="0"/>
                                            <input type="checkbox" id="hmwp_hide_wplogin" name="hmwp_hide_wplogin" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_wplogin' ) ? 'checked="checked"' : '') ?> value="1"/>
                                            <label for="hmwp_hide_wplogin"><?php _e( 'Hide "wp-login.php"', _HMWP_PLUGIN_NAME_ ); ?></label>
                                            <div class="offset-1 text-black-50"><?php _e( 'Show 404 Not Found Error when visitors access /wp-login.php', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 row mb-1 ml-1 hmwp_hide_login_div" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_login_url' ) == HMWP_Classes_Tools::$default['hmwp_login_url'] ? 'style="display:none;"' : '') ?>>
                                    <div class="checker col-sm-12 row my-2 py-1">
                                        <div class="col-sm-12 p-0 switch switch-sm">
                                            <input type="hidden" name="hmwp_hide_login" value="0"/>
                                            <input type="checkbox" id="hmwp_hide_login" name="hmwp_hide_login" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_login' ) ? 'checked="checked"' : '') ?> value="1"/>
                                            <label for="hmwp_hide_login"><?php _e( 'Hide "login" path', _HMWP_PLUGIN_NAME_ ); ?></label>
                                            <div class="offset-1 text-black-50"><?php _e( 'Show 404 Not Found Error when visitors access /login', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-bottom border-gray"></div>

                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-sm-4 p-0 font-weight-bold" style="font-size: 95%">
                                        <?php _e( 'Custom Lost Password Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                        <div class="small text-black-50"><?php _e( 'eg. lostpass or forgotpass', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                    <div class="col-sm-8 p-0 input-group input-group-lg">
                                        <input type="text" class="form-control bg-input" name="hmwp_lostpassword_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_lostpassword_url' ) ?>" placeholder="?action=lostpassword"/>
                                        <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_lost_password" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>

                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-sm-4 p-0 font-weight-bold">
                                        <?php _e( 'Custom Register Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                        <div class="small text-black-50"><?php _e( 'eg. newuser or register', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                    <div class="col-sm-8 p-0 input-group input-group-lg">
                                        <input type="text" class="form-control bg-input" name="hmwp_register_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_register_url' ) ?>" placeholder="?action=register"/>
                                        <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_register" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>


                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-sm-4 p-0 font-weight-bold">
                                        <?php _e( 'Custom Logout Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                        <div class="small text-black-50"><?php _e( 'eg. logout or disconnect', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                    <div class="col-sm-8 p-0 input-group input-group-lg">
                                        <input type="text" class="form-control bg-input" name="hmwp_logout_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_logout_url' ) ?>" placeholder="?action=logout"/>
                                        <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_logout" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>

                                <?php if ( is_multisite() ) { ?>
                                    <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                        <div class="col-sm-4 p-0 font-weight-bold">
                                            <?php _e( 'Custom Activation Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                            <div class="small text-black-50"><?php _e( 'eg. multisite activation link', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        </div>
                                        <div class="col-sm-8 p-0 input-group input-group-lg">
                                            <input type="text" class="form-control bg-input" name="hmwp_activate_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_activate_url' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_activate_url'] ?>"/>
                                            <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_activation" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="col-sm-12 text-center border-light py-1 m-0">
                                    <a href="<?php echo HMWP_Classes_Tools::getSettingsUrl( 'hmwp_settings-hmwp_tweaks', true ) ?>" target="_blank">
                                        <?php _e( 'Manage Login and Logout Redirects', _HMWP_PLUGIN_NAME_ ); ?>
                                    </a>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 tab-panel" <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'default') ? 'style="display:none"' : '') ?>>
                        <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Common Paths', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                        <div class="card-body">
                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                <div class="col-sm-4 p-0 font-weight-bold">
                                    <?php _e( 'Custom admin-ajax Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                    <div class="small text-black-50"><?php _e( 'eg. ajax, json', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                    <input type="text" class="form-control bg-input" name="hmwp_admin-ajax_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_admin-ajax_url' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_admin-ajax_url'] ?>"/>
                                    <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_ajax" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>

                            <div class="col-sm-12 row mb-1 ml-1 hmwp_hideajax_admin_div">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_hideajax_admin" value="0"/>
                                        <input type="checkbox" id="hmwp_hideajax_admin" name="hmwp_hideajax_admin" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hideajax_admin' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_hideajax_admin"><?php _e( 'Hide wp-admin from ajax URL', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <div class="offset-1 text-black-50"><?php echo sprintf( __( 'Show /%s instead of /%s', _HMWP_PLUGIN_NAME_ ), HMWP_Classes_Tools::getOption( 'hmwp_admin-ajax_url' ), HMWP_Classes_Tools::getOption( 'hmwp_admin_url' ) . '/' . HMWP_Classes_Tools::getOption( 'hmwp_admin-ajax_url' ) ); ?></div>
                                        <div class="offset-1 mt-1 text-danger"><?php _e( '(works only with the custom admin-ajax path to avoid infinite loops)', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                <div class="col-sm-4 p-0 font-weight-bold">
                                    <?php _e( 'Custom wp-content Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                    <div class="small text-black-50"><?php _e( 'eg. core, inc, include', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                    <input type="text" class="form-control bg-input" name="hmwp_wp-content_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_wp-content_url' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_wp-content_url'] ?>"/>
                                    <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_wpcontent" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>

                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                <div class="col-sm-4 p-0 font-weight-bold">
                                    <?php _e( 'Custom wp-includes Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                    <div class="small text-black-50"><?php _e( 'eg. lib, library', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                    <input type="text" class="form-control bg-input" name="hmwp_wp-includes_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_wp-includes_url' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_wp-includes_url'] ?>"/>
                                    <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_wpincludes" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>


                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">

                                <div class="col-sm-4 p-0 font-weight-bold">
                                    <?php _e( 'Custom uploads Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                    <div class="small text-black-50"><?php _e( 'eg. images, files', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <?php if ( !defined( 'UPLOADS' ) ) { ?>
                                    <div class="col-sm-8 p-0 input-group input-group-lg">
                                        <input type="text" class="form-control bg-input" name="hmwp_upload_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_upload_url' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_upload_url'] ?>"/>
                                        <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_uloads" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-sm-8 text-danger p-0">
                                        <?php echo sprintf( __( "You already defined a different wp-content/uploads directory in wp-config.php %s", _HMWP_PLUGIN_NAME_ ), ': <strong>' . UPLOADS . '</strong>' ); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                <div class="col-sm-4 p-0 font-weight-bold">
                                    <?php _e( 'Custom comment Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                    <div class="small text-black-50"><?php _e( 'eg. comments, discussion', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                    <input type="text" class="form-control bg-input" name="hmwp_wp-comments-post" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_wp-comments-post' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_wp-comments-post'] ?>"/>
                                    <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_comments" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>

                            <?php if ( !HMWP_Classes_Tools::isMultisites() && !HMWP_Classes_Tools::isNginx() && !HMWP_Classes_Tools::isWpengine() ) { ?>
                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-sm-4 p-0 font-weight-bold">
                                        <?php _e( 'Custom author Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                        <div class="small text-black-50"><?php _e( 'eg. profile, usr, writer', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                    <div class="col-sm-8 p-0 input-group input-group-lg">
                                        <input type="text" class="form-control bg-input" name="hmwp_author_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_author_url' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_author_url'] ?>"/>
                                        <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_author" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <input type="hidden" name="hmwp_author_url" value="<?php echo HMWP_Classes_Tools::$default['hmwp_author_url'] ?>"/>
                            <?php } ?>
                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_hide_authors" value="0"/>
                                        <input type="checkbox" id="hmwp_hide_authors" name="hmwp_hide_authors" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_authors' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_hide_authors"><?php _e( 'Hide Author ID URL', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <div class="offset-1 text-black-50"><?php _e( "Don't let URLs like domain.com?author=1 show the user login name", _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 tab-panel" <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'default') ? 'style="display:none"' : '') ?>>
                        <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Plugin Settings', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                        <div class="card-body">
                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                <div class="col-sm-4 p-0 font-weight-bold">
                                    <?php _e( 'Custom plugins Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                    <div class="small text-black-50"><?php _e( 'eg. modules', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                    <input type="text" class="form-control bg-input" name="hmwp_plugin_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_plugin_url' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_plugin_url'] ?>"/>
                                    <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_plugins" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>
                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_hide_plugins" value="0"/>
                                        <input type="checkbox" id="hmwp_hide_plugins" name="hmwp_hide_plugins" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_plugins' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_hide_plugins"><?php _e( 'Hide plugin names', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <div class="offset-1 text-black-50"><?php _e( 'Give random names to each plugin', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_hide_all_plugins" value="0"/>
                                        <input type="checkbox" id="hmwp_hide_all_plugins" name="hmwp_hide_all_plugins" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_all_plugins' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_hide_all_plugins"><?php _e( 'Hide all the plugins', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <div class="offset-1 text-black-50"><?php _e( 'Hide both active and deactivated plugins', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 tab-panel" <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'default') ? 'style="display:none"' : '') ?>>
                        <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Theme Settings', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                        <div class="card-body">
                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                <div class="col-sm-4 p-0 font-weight-bold">
                                    <?php _e( 'Custom themes Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                    <div class="small text-black-50"><?php _e( 'eg. aspect, templates, styles', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                    <input type="text" class="form-control bg-input" name="hmwp_themes_url" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_themes_url' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_themes_url'] ?>"/>
                                    <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_themes" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>

                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_hide_themes" value="0"/>
                                        <input type="checkbox" id="hmwp_hide_themes" name="hmwp_hide_themes" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_themes' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_hide_themes"><?php _e( 'Hide theme names', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <div class="offset-1 text-black-50"><?php _e( 'Give random names to each theme (works in WP multisite)', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-bottom border-gray"></div>

                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                <div class="col-sm-4 p-0 font-weight-bold">
                                    <?php _e( 'Custom theme style name', _HMWP_PLUGIN_NAME_ ); ?>:
                                    <div class="small text-black-50"><?php _e( 'eg. main.css,  theme.css, design.css', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                    <input type="text" class="form-control bg-input" name="hmwp_themes_style" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_themes_style' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_themes_style'] ?>"/>
                                    <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#customize_themes_style" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>

                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_hide_styleids" value="0"/>
                                        <input type="checkbox" id="hmwp_hide_styleids" name="hmwp_hide_styleids" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_styleids' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_hide_styleids"><?php _e( 'Hide IDs from Stylesheets', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 tab-panel" <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'default') ? 'style="display:none"' : '') ?>>
                        <h3 class="card-title bg-brown text-white p-2"><?php _e( 'REST API Settings', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                        <div class="card-body">
                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                <div class="col-sm-4 p-0 font-weight-bold">
                                    <?php _e( 'Custom wp-json Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                    <div class="small text-black-50"><?php _e( 'eg. json, api, call', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                    <input type="text" class="form-control bg-input" name="hmwp_wp-json" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_wp-json' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_wp-json'] ?>"/>
                                    <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#hide_rest_api" target="_blank" class="position-absolute float-right" style="right: 7px;top: 25%;"><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>

                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_disable_rest_api" value="0"/>
                                        <input type="checkbox" id="hmwp_disable_rest_api" name="hmwp_disable_rest_api" class="js-switch pull-right fixed-sidebar-check" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_disable_rest_api' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_disable_rest_api"><?php _e( 'Disable Rest API access', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <div class="offset-1 text-black-50"><?php _e( "Disable Rest API access for not logged in users", _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 tab-panel" <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'default') ? 'style="display:none"' : '') ?>>
                        <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Security Settings', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                        <div class="card-body">
                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_hide_oldpaths" value="0"/>
                                        <input type="checkbox" id="hmwp_hide_oldpaths" name="hmwp_hide_oldpaths" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_oldpaths' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_hide_oldpaths"><?php _e( 'Hide WordPress Common Paths', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#hide_common_paths" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                        <div class="offset-1 text-black-50"><?php _e( 'Hide /wp-content, /wp-include, /plugins, /themes paths', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        <div class="offset-1 text-black-50"><?php _e( 'Hide upgrade.php and install.php for visitors', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        <div class="offset-1 mt-1 text-danger"><?php _e( '(may affect the fonts and images loaded through CSS)', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 row border-bottom border-light py-3 mx-1 my-3 hmwp_hide_oldpaths_div">
                                <div class="col-sm-4 p-1">
                                    <div class="font-weight-bold"><?php _e( 'Hide File Extensions', _HMWP_PLUGIN_NAME_ ); ?>:</div>
                                    <div class="text-black-50"><?php _e( "Select the file extensions you want to hide on old paths", _HMWP_PLUGIN_NAME_ ); ?></div>
                                    <div class="text-black-50 my-2 small"><?php _e( "Hold Control key to select multiple file extensions", _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <div class="col-sm-8 p-0 input-group">
                                    <select multiple name="hmwp_hide_oldpaths_types[]" class="form-control bg-input mb-1">
                                        <?php
                                        global $wp_roles;
                                        $alltypes = array('css', 'js', 'php', 'txt', 'html', 'xml');
                                        $types = (array)HMWP_Classes_Tools::getOption( 'hmwp_hide_oldpaths_types' );
                                        if ( empty( $types ) ) {
                                            $types = array('js', 'php', 'txt', 'html');
                                        }
                                        foreach ( $alltypes as $key ) {
                                            echo '<option value="' . $key . '" ' . (in_array( $key, $types ) ? 'selected="selected"' : '') . '>' . strtoupper( $key ) . ' ' . __( 'files', _HMWP_PLUGIN_NAME_ ) . '</option>';
                                        } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm ">
                                        <input type="hidden" name="hmwp_hide_commonfiles" value="0"/>
                                        <input type="checkbox" id="hmwp_hide_commonfiles" name="hmwp_hide_commonfiles" class="switch" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_hide_commonfiles' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_hide_commonfiles"><?php _e( 'Hide WordPress Common Files', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#hide_common_files" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                        <div class="offset-1 text-black-50"><?php _e( 'Hide wp-config.php , wp-config-sample.php, readme.html, license.txt files', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 row mb-1 ml-1">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="hidden" name="hmwp_security_header" value="0"/>
                                        <input type="checkbox" id="hmwp_security_header" name="hmwp_security_header" class="js-switch pull-right fixed-sidebar-check" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_security_header' ) ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="hmwp_security_header"><?php _e( 'Add Security Headers for XSS and Code Injection Attacks', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#hide_security_headers" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                        <div class="offset-1 text-black-50"><?php _e( "Add Strict-Transport-Security header", _HMWP_PLUGIN_NAME_ ); ?> <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security" target="_blank"><?php echo __('more details', _HMWP_PLUGIN_NAME_) ?></a> </div>
                                        <div class="offset-1 text-black-50"><?php _e( "Add Content-Security-Policy header", _HMWP_PLUGIN_NAME_ ); ?> <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP" target="_blank"><?php echo __('more details', _HMWP_PLUGIN_NAME_) ?></a> </div>
                                        <div class="offset-1 text-black-50"><?php _e( "Add X-XSS-Protection header", _HMWP_PLUGIN_NAME_ ); ?> <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection" target="_blank"><?php echo __('more details', _HMWP_PLUGIN_NAME_) ?></a> </div>
                                        <div class="offset-1 text-black-50"><?php _e( "Add X-Content-Type-Options header", _HMWP_PLUGIN_NAME_ ); ?> <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options" target="_blank"><?php echo __('more details', _HMWP_PLUGIN_NAME_) ?></a> </div>
                                    </div>
                                </div>
                            </div>

                            <?php if ( HMWP_Classes_Tools::isNginx() || HMWP_Classes_Tools::isApache() || HMWP_Classes_Tools::isLitespeed() ) { ?>

                                <div class="col-sm-12 row mb-1 ml-1">
                                    <div class="checker col-sm-12 row my-2 py-1">
                                        <div class="col-sm-12 p-0 switch switch-sm">
                                            <input type="hidden" name="hmwp_sqlinjection" value="0"/>
                                            <input type="checkbox" id="hmwp_sqlinjection" name="hmwp_sqlinjection" class="js-switch pull-right fixed-sidebar-check" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_sqlinjection' ) ? 'checked="checked"' : '') ?> value="1"/>
                                            <label for="hmwp_sqlinjection"><?php _e( 'Firewall Against Script Injection', _HMWP_PLUGIN_NAME_ ); ?></label>
                                            <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#firewall_script_injection" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                            <div class="offset-1 text-black-50"><?php echo __( 'Most WordPress installations are hosted on the popular Apache, Nginx and IIS web servers.', _HMWP_PLUGIN_NAME_ ); ?></div>
                                            <div class="offset-1 text-black-50"><?php echo __( 'A thorough set of rules can prevent many types of SQL Injection and URL hacks from being interpreted.', _HMWP_PLUGIN_NAME_ ); ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 row mb-1 ml-1">
                                    <div class="checker col-sm-12 row my-2 py-1">
                                        <div class="col-sm-12 p-0 switch switch-sm">
                                            <?php $uploads = wp_upload_dir() ?>
                                            <input type="hidden" name="hmwp_disable_browsing" value="0"/>
                                            <input type="checkbox" id="hmwp_disable_browsing" name="hmwp_disable_browsing" class="js-switch pull-right fixed-sidebar-check" <?php echo(HMWP_Classes_Tools::getOption( 'hmwp_disable_browsing' ) ? 'checked="checked"' : '') ?> value="1"/>
                                            <label for="hmwp_disable_browsing"><?php _e( 'Disable Directory Browsing', _HMWP_PLUGIN_NAME_ ); ?></label>
                                            <a href="https://hidemywpghost.com/kb/customize-paths-in-hide-my-wp-ghost/#disable_browsing" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                            <div class="offset-1 text-black-50"><?php echo sprintf( __( "Don't let hackers see any directory content. See %sUploads Directory%s", _HMWP_PLUGIN_NAME_ ), '<a href="' . $uploads['baseurl'] . '" target="_blank">', '</a>' ); ?></div>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>



                        </div>
                    </div>
                    <div class="card col-sm-12 p-0 tab-panel" <?php echo((HMWP_Classes_Tools::getOption( 'hmwp_mode' ) == 'default') ? 'style="display:none"' : '') ?>>
                        <div class="card-body">
                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                <div class="col-sm-4 p-0 font-weight-bold">
                                    <?php _e( 'Custom category Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                    <div class="small text-black-50"><?php _e( 'eg. cat, dir, list', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                    <input type="text" class="form-control bg-input" name="hmwp_category_base" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_category_base' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_category_base'] ?>"/>
                                </div>
                            </div>

                            <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                <div class="col-sm-4 p-0 font-weight-bold">
                                    <?php _e( 'Custom tags Path', _HMWP_PLUGIN_NAME_ ); ?>:
                                    <div class="small text-black-50"><?php _e( 'eg. keyword, topic', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                    <input type="text" class="form-control" name="hmwp_tag_base" value="<?php echo HMWP_Classes_Tools::getOption( 'hmwp_tag_base' ) ?>" placeholder="<?php echo HMWP_Classes_Tools::$default['hmwp_tag_base'] ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ( HMWP_Classes_Tools::getOption( 'test_frontend' ) || HMWP_Classes_Tools::getOption( 'logout' ) || HMWP_Classes_Tools::getOption( 'error' ) ) { ?>
                        <div class="col-sm-12 m-0 p-2">
                            <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mr-5 save"><?php _e( 'Save', _HMWP_PLUGIN_NAME_ ); ?></button>
                            <a href="https://wordpress.org/support/plugin/hide-my-wp/reviews/?rate=5#new-post" target="_blank" style="color: #ff005e;"><?php echo sprintf( __( 'Love Hide My WP %s? Show us ;)', _HMWP_PLUGIN_NAME_ ), _HMWP_VER_NAME_ ); ?></a>
                        </div>
                    <?php } else { ?>
                        <div class="col-sm-12 m-0 p-2 bg-light text-center" style="position: fixed; bottom: 0; right: 0; z-index: 100; box-shadow: 0 0 8px -3px #444;">
                            <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mr-5 save"><?php _e( 'Save', _HMWP_PLUGIN_NAME_ ); ?></button>
                            <a href="https://wordpress.org/support/plugin/hide-my-wp/reviews/?rate=5#new-post" target="_blank" style="color: #ff005e;"><?php echo sprintf( __( 'Love Hide My WP %s? Show us ;)', _HMWP_PLUGIN_NAME_ ), _HMWP_VER_NAME_ ); ?></a>
                        </div>
                    <?php } ?>
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
                            <h1>
                                <a href="https://wordpress.org/support/plugin/hide-my-wp/reviews/?rate=5#new-post" target="_blank" class="px-4"><i class="fa fa-heart text-danger"></i></a>
                            </h1>
                            <?php echo __( 'Please help us and support our plugin on WordPress.org', _HMWP_PLUGIN_NAME_ ) ?>
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
    <?php if ( HMWP_Classes_Tools::isApache() || HMWP_Classes_Tools::isLitespeed() ) { ?>
        <div id="hmwp_ghost_mode_modal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Ghost Mode Alert</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p style="font-size: 16px"><?php echo __( 'The Ghost Mode will add rewrites rules in the config file to hide the old paths from hackers.', _HMWP_PLUGIN_NAME_ ) ?></p>
                        <p style="font-size: 16px"><?php echo __( 'Some themes may not work in Ghost Mode and we encourage you to check the plugin in Safe Mode first.', _HMWP_PLUGIN_NAME_ ) ?></p>
                        <p class="mt-3" style="font-size: 16px"><?php echo __( 'If you notice any functionality issue please contact us and we can set the plugin for you.', _HMWP_PLUGIN_NAME_ ) ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
