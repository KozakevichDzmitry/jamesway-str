<?php if ( HMWP_Classes_Tools::getOption( 'test_frontend' ) && HMWP_Classes_Tools::getOption( 'hmwp_mode' ) <> 'default' ) {
    add_action( 'home_url', array(HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rewrite' ), 'home_url'), PHP_INT_MAX, 1 );
    ?>
    <div class="col-sm-12 border-bottom border-light py-3 mx-0 my-3">

        <div class="col-sm-12 border-warning bg-light border py-3 mx-0 my-0">
            <h4><?php _e( 'Next Steps', _HMWP_PLUGIN_NAME_ ); ?></h4>
            <div class="col-sm-12 text-center my-2">
                <button type="button" class="btn btn-lg btn-success frontend_test" data-remote="<?php echo home_url() . '/' . HMWP_Classes_Tools::getOption( 'hmwp_login_url' ) ?>" data-target="#frontend_test_modal" data-toggle="modal"><?php _e( 'Frontend Login Test', _HMWP_PLUGIN_NAME_ ); ?></button>
            </div>

            <ol>
                <li><?php echo sprintf( __( "Run %sFrontend Login Test%s and login inside the popup. ", _HMWP_PLUGIN_NAME_ ), '<strong>', '</strong>' ); ?></li>
                <li><?php _e( 'Make sure you follow the server config instruction before moving forward.', _HMWP_PLUGIN_NAME_ ); ?></li>
                <li><?php _e( "If you're able to login, you've set the new paths correctly.", _HMWP_PLUGIN_NAME_ ); ?></li>
                <li><?php _e( 'Do not logout from this browser until you are confident that the Login Page is working and you will be able to login again.', _HMWP_PLUGIN_NAME_ ); ?></li>
                <li><?php echo sprintf( __( "If you can't configure Hide My WP Ghost, switch to Default mode and %scontact us%s.", _HMWP_PLUGIN_NAME_ ), '<a href="https://hidemywpghost.com/contact/" target="_blank" >', '</a>' ); ?></li>
            </ol>

            <div class="wp-admin_warning col-sm-12 my-2 mt-4 text-danger p-0 text-center">
                <div class="my-1"><?php echo sprintf( __( "%sWARNING:%s Use the custom login URL to login to admin.", _HMWP_PLUGIN_NAME_ ), '<span class="font-weight-bold">', '</span>' ); ?></div>
                <div class="mb-3"><?php echo sprintf( __( "Your login URL will be: %s In case you can't re-login, use the safe URL: %s", _HMWP_PLUGIN_NAME_ ), '<strong>' . home_url() . '/' . HMWP_Classes_Tools::getOption( 'hmwp_login_url' ) . '</strong><br /><br />', "<strong><br />" . site_url() . "/wp-login.php?" . HMWP_Classes_Tools::getOption( 'hmwp_disable_name' ) . "=" . HMWP_Classes_Tools::getOption( 'hmwp_disable' ) . "</strong>" ); ?></div>
            </div>

            <div class="hmwp_logout">
                <form method="POST">
					<?php wp_nonce_field( 'hmwp_confirm', 'hmwp_nonce' ); ?>
                    <input type="hidden" name="action" value="hmwp_confirm"/>
                    <input type="submit" class="hmwp_btn hmwp_btn-success" value="<?php echo __( "Yes, it's working", _HMWP_PLUGIN_NAME_ ) ?>"/>
                </form>
            </div>
            <div class="hmwp_abort" style="display: inline-block; margin-left: 5px;">
                <form method="POST">
					<?php wp_nonce_field( 'hmwp_abort', 'hmwp_nonce' ); ?>
                    <input type="hidden" name="action" value="hmwp_abort"/>
                    <input type="submit" class="hmwp_btn hmwp_btn-warning" value="<?php echo __( "No, abort", _HMWP_PLUGIN_NAME_ ) ?>"/>
                </form>
            </div>
        </div>
        <div class="modal fade" id="frontend_test_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php _e( 'Frontend login Test', _HMWP_PLUGIN_NAME_ ); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <iframe class="modal-body" style="min-height: 500px;"></iframe>
                </div>
            </div>
        </div>
        <script>
            (function ($) {
                $('button.frontend_test').on('click', function () {
                    $($(this).data("target") + ' .modal-body').attr('src', $(this).data("remote"));
                });
            })(jQuery);

        </script>

    </div>
<?php } ?>
