<div id="hmwp_wrap" class="d-flex flex-row my-3 bg-light">
    <?php echo $view->getAdminTabs(HMWP_Classes_Tools::getValue('tab', 'hmwp_permalinks')); ?>
    <div class="hmwp_row d-flex flex-row bg-white px-3">
        <div class="hmwp_col flex-grow-1 mr-3">

            <div class="card p-0 col-sm-12 tab-panel">
                <h3 class="card-title bg-brown text-white p-2"><?php _e('Backup/Restore Settings', _HMWP_PLUGIN_NAME_); ?>:</h3>
                <div class="card-body">
                    <div class="text-black-50 mb-2"><?php _e('Click Backup and the download will start automatically. You can use the Backup for all your websites.', _HMWP_PLUGIN_NAME_); ?></div>

                    <div class="hmwp_settings_backup">
                        <form action="" target="_blank" method="POST">
                            <?php wp_nonce_field('hmwp_backup', 'hmwp_nonce'); ?>
                            <input type="hidden" name="action" value="hmwp_backup"/>
                            <input type="submit" class="btn rounded-0 btn-light" name="hmwp_backup" value="<?php _e('Backup Settings', _HMWP_PLUGIN_NAME_) ?>"/>
                            <input type="button" class="btn rounded-0 btn-light hmwp_restore" onclick="jQuery('.hmwp_settings_restore').modal()" name="hmwp_restore" value="<?php _e('Restore Settings', _HMWP_PLUGIN_NAME_) ?>"/>
                        </form>
                    </div>


                    <!-- Modal -->
                    <div class="modal hmwp_settings_restore"  tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" ><?php _e('Hide My Wp Restore', _HMWP_PLUGIN_NAME_) ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div><?php _e('Upload the file with the saved Hide My Wp Settings', _HMWP_PLUGIN_NAME_) ?></div>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <?php wp_nonce_field('hmwp_restore', 'hmwp_nonce'); ?>
                                        <input type="hidden" name="action" value="hmwp_restore"/>
                                        <div class="py-2">
                                            <input type="file" name="hmwp_options" id="favicon"/>
                                        </div>

                                        <input type="submit" style="margin-top: 10px;" class="btn rounded-0 btn-success" name="hmwp_restore" value="<?php _e('Restore Backup', _HMWP_PLUGIN_NAME_) ?>"/>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="hmwp_col hmwp_col_side">
            <div class="card col-sm-12 p-0">
                <div class="card-body f-gray-dark text-left">
                    <h3 class="panel-title"><?php _e('Backup Settings', _HMWP_PLUGIN_NAME_); ?></h3>
                    <div class="text-info mt-3"><?php echo sprintf(__("It's important to <strong>save your settings every time you change them</strong>. You can use the backup to configure other websites you own.", _HMWP_PLUGIN_NAME_), site_url()); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>