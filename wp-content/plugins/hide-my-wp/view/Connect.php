<div id="hmwp_wrap" class="d-flex flex-row my-3 bg-light">
    <?php echo $view->getAdminTabs( HMWP_Classes_Tools::getValue( 'tab', 'hmwp_permalinks' ) ); ?>
    <div class="hmwp_row d-flex flex-row bg-white px-3">
        <?php do_action( 'hmwp_notices' ); ?>
        <div class="hmwp_col flex-grow-1 mr-3">
            <form method="POST">
                <?php wp_nonce_field( 'hmwp_connect', 'hmwp_nonce' ) ?>
                <input type="hidden" name="action" value="hmwp_connect"/>

                <?php do_action( 'hmwp_form_notices' ); ?>
                <div class="card p-0 col-sm-12 tab-panel">
                    <h3 class="card-title bg-brown text-white p-2"><?php _e( 'Activate Your Plugin', _HMWP_PLUGIN_NAME_ ); ?></h3>
                    <div class="card-body">

                        <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                            <div class="col-sm-6 p-1 font-weight-bold">
                                <?php _e( 'Licence Token', _HMWP_PLUGIN_NAME_ ); ?>:
                                <div class="small text-black-50"><?php echo sprintf( __( 'Enter the 32 chars token from Order/Licence on %s', _HMWP_PLUGIN_NAME_ ), '<a href="' . _HMWP_ACCOUNT_SITE_ . '/user/auth/orders" target="_blank" style="font-weight: bold">' . _HMWP_ACCOUNT_SITE_ . '</a>' ); ?></div>
                            </div>
                            <div class="col-sm-6 p-0 input-group ">
                                <input type="text" class="form-control" name="hmwp_token" value=""/>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 my-3 p-0">
                    <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 save"><?php _e( 'Activate', _HMWP_PLUGIN_NAME_ ); ?></button>
                </div>
            </form>
        </div>
        <div class="hmwp_col hmwp_col_side">
            <div class="card col-sm-12 p-0">
                <div class="card-body f-gray-dark text-left border-bottom">
                    <h3 class="card-title"><?php _e( 'Activation Help', _HMWP_PLUGIN_NAME_ ); ?></h3>
                    <div class="text-info my-3">
                        <?php echo __( "Once you bought the plugin, you will receive the WPPlugins credentials for your account by email.", _HMWP_PLUGIN_NAME_ ); ?>
                    </div>
                    <div class="text-info my-3">
                        <?php echo sprintf( __( "Please visit %s to check your purchase and to get the license token.", _HMWP_PLUGIN_NAME_ ), '<a href="' . _HMWP_ACCOUNT_SITE_ . '" target="_blank" style="font-weight: bold">' . _HMWP_ACCOUNT_SITE_ . '</a>' ); ?>
                    </div>
                    <div class="text-info my-3">
                        <?php echo sprintf( __( "%sNOTE:%s If you didn't receive the credentials, please access %s.", _HMWP_PLUGIN_NAME_ ), '<strong>', '</strong>', '<a href="https://wpplugins.tips/lostpass" target="_blank" style="font-weight: bold">https://wpplugins.tips/lostpass</a>' ); ?>
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