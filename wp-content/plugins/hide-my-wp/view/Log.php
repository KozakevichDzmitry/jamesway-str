<div id="hmwp_wrap" class="d-flex flex-row my-3 bg-light">
	<?php echo $view->getAdminTabs( HMWP_Classes_Tools::getValue( 'tab', 'hmwp_permalinks' ) ); ?>
    <div class="hmwp_row d-flex flex-row bg-white px-3">
        <div class="hmwp_col flex-grow-1 mr-3">
            <form method="POST">
				<?php wp_nonce_field( 'hmwp_logsettings', 'hmwp_nonce' ) ?>
                <input type="hidden" name="action" value="hmwp_logsettings"/>

                <div class="card p-0 col-sm-12 tab-panel">
                    <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Events Settings', _HMWP_PLUGIN_NAME_ ); ?>:</h3>
                    <div class="card-body">
                        <div class="col-sm-12 row mb-1 py-3 mx-2 ">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="checkbox" id="hmwp_activity_log" name="hmwp_activity_log" class="switch" <?php echo( HMWP_Classes_Tools::getOption( 'hmwp_activity_log' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                    <label for="hmwp_activity_log"><?php _e( 'Log Users Events', _HMWP_PLUGIN_NAME_ ); ?></label>
                                    <a href="https://hidemywpghost.com/kb/users-activity-log/#activate_user_events_log" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php _e( 'Track and Log events that happens on your WordPress site!', _HMWP_PLUGIN_NAME_ ); ?></div>
                                </div>
                            </div>
                        </div>


						<?php if ( HMWP_Classes_Tools::getOption( 'hmwp_bruteforce' ) ) { ?>
                            <div class="col-sm-12 row mb-1 py-3 mx-2 ">
                                <div class="checker col-sm-12 row my-2 py-1">
                                    <div class="col-sm-12 p-0 switch switch-sm">
                                        <input type="checkbox" id="hmwp_bruteforce_log" name="hmwp_bruteforce_log" class="switch" <?php echo( HMWP_Classes_Tools::getOption( 'hmwp_bruteforce_log' ) ? 'checked="checked"' : '' ) ?> value="1"/>
                                        <label for="hmwp_bruteforce_log"><?php _e( 'Log Brute Force Attempts', _HMWP_PLUGIN_NAME_ ); ?></label>
                                        <a href="https://hidemywpghost.com/kb/users-activity-log/#log_brute_force" target="_blank" class="d-inline-block ml-2"><i class="fa fa-question-circle"></i></a>
                                        <div class="offset-1 text-black-50"><?php _e( 'Track and Log brute force attempts', _HMWP_PLUGIN_NAME_ ); ?></div>
                                    </div>
                                </div>
                            </div>
						<?php } ?>

                        <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                            <div class="col-sm-4 p-1">
                                <div class="font-weight-bold"><?php _e( 'Log Use Roles', _HMWP_PLUGIN_NAME_ ); ?>:</div>
                                <div class="text-black-50"><?php _e( 'Hold Control key to select multiple user roles', _HMWP_PLUGIN_NAME_ ); ?></div>
                                <div class="text-black-50"><?php _e( "Don't select any role if you want to log all user roles", _HMWP_PLUGIN_NAME_ ); ?></div>
                            </div>
                            <div class="col-sm-8 p-0 input-group">
                                <select multiple name="hmwp_activity_log_roles[]" class="form-control bg-input mb-1">
									<?php
									global $wp_roles;
									$roles = $wp_roles->get_names();
									foreach ( $roles as $key => $role ) {
										echo '<option value="' . $key . '" ' . ( in_array( $key, (array) HMWP_Classes_Tools::getOption( 'hmwp_activity_log_roles' ) ) ? 'selected="selected"' : '' ) . '>' . $role . '</option>';
									} ?>
                                </select>
                            </div>

                        </div>
						<?php if ( apply_filters( 'hmwp_showaccount', true ) ) { ?>
                            <div class="col-sm-12 text-center my-3">
                                <a href="<?php echo _HMWP_ACCOUNT_SITE_ . '/api/auth/' . HMWP_Classes_Tools::getOption( 'api_token' ) ?>" class="btn rounded-0 btn-warning btn-lg text-white px-4 securitycheck" target="_blank"><?php _e( 'Go to Events Log Panel', _HMWP_PLUGIN_NAME_ ); ?></a>
                                <a href="https://hidemywpghost.com/kb/users-activity-log/#check_user_events" target="_blank" class="d-inline-block ml-0"><i class="fa fa-question-circle"></i></a>
                                <div class="text-black-50"><?php _e( 'Search in user events log and manage the email alerts', _HMWP_PLUGIN_NAME_ ); ?></div>
                            </div>
						<?php } ?>
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
                <div class="card-body f-gray-dark text-left border-bottom">
                    <h3 class="card-title"><?php _e( 'Log Events', _HMWP_PLUGIN_NAME_ ); ?></h3>
                    <div class="text-info mb-3"><?php echo __( "Monitor everything that happens on your WordPress site!", _HMWP_PLUGIN_NAME_ ); ?></div>
                    <div class="text-info mb-3"><?php echo __( "It's safe to know what happened on your website at any time, in admin and on frontend.", _HMWP_PLUGIN_NAME_ ); ?></div>
                    <div class="text-info mb-3"><?php echo __( "All the logs are saved on our Cloud Servers and your data is safe in case you reinstall the plugin", _HMWP_PLUGIN_NAME_ ); ?></div>
                </div>
            </div>
            <div class="card col-sm-12 p-0">
                <div class="card-body f-gray-dark text-left border-bottom">
                    <h3 class="card-title"><?php _e( 'Features', _HMWP_PLUGIN_NAME_ ); ?></h3>
                    <ul class="text-info" style="margin-left: 16px; list-style: circle;">
                        <li class="mb-2"><?php echo __( "Monitor, track and log events on your website", _HMWP_PLUGIN_NAME_ ); ?></li>
                        <li class="mb-2"><?php echo __( "Know what the other users are doing on your website and when", _HMWP_PLUGIN_NAME_ ); ?></li>
                        <li class="mb-2"><?php echo __( "You can set to receive email with alerts for one or more actions", _HMWP_PLUGIN_NAME_ ); ?></li>
                        <li class="mb-2"><?php echo __( "Filter events and users", _HMWP_PLUGIN_NAME_ ); ?></li>
                        <li><?php echo __( "Compatible with all themes and plugins", _HMWP_PLUGIN_NAME_ ); ?></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
