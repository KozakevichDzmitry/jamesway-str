<div id="hmwp_wrap" class="d-flex flex-row my-3 bg-light">
    <?php echo $view->getAdminTabs(HMWP_Classes_Tools::getValue('tab', 'hmwp_permalinks')); ?>
    <?php echo '<script>var hmwpQuery = {"ajaxurl": "' . admin_url('admin-ajax.php') . '","nonce": "' . wp_create_nonce(_HMWP_NONCE_ID_) . '"}</script>'; ?>
    <div class="hmwp_row d-flex flex-row bg-white px-3">
        <div class="hmwp_col row justify-content-center flex-grow-1">
            <?php foreach ($view->plugins as $name => $plugin) { ?>
                <div class="card p-0 col-sm-5 mt-3 m-2">
                    <div class="card-body p-3">
                        <h3 class="card-title my-2"><a href="<?php echo $plugin['url']; ?>" class="text-link" target="_blank"><?php echo $plugin['title']; ?></a></h3>
                        <div class="card-text">
                            <a href="<?php echo $plugin['url']; ?>" target="_blank">
                                <img class="col-sm-12 p-0" src="<?php echo $plugin['banner']; ?>"  style="max-height: 94px;">
                            </a>
                        </div>
                        <div class="card-text small text-secondary my-2" style="min-height: 120px;"><?php echo $plugin['description']; ?></div>
                        <div class="card-footer row text-right">
                            <a href="<?php echo $plugin['url']; ?>" class="btn rounded-0 btn-light" target="_blank"><?php _e('More details', _HMWP_PLUGIN_NAME_) ?></a>
                            <?php if (!HMWP_Classes_Tools::isPluginActive($plugin['path'])) { ?>
                                <a href="<?php echo $plugin['url']; ?>" target="_blank" class="btn rounded-0 btn-info"><?php _e('Go To Plugin', _HMWP_PLUGIN_NAME_) ?></a>
                            <?php } else { ?>
                                <button class="btn rounded-0 plugin btn-light" disabled><?php _e('Plugin Installed', _HMWP_PLUGIN_NAME_) ?></button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
        <div class="hmwp_col hmwp_col_side">
            <div class="card col-sm-12 p-0 mt-3">
                <div class="card-body f-gray-dark text-left">
                    <h3 class="panel-title"><?php _e('Plugins', _HMWP_PLUGIN_NAME_); ?></h3>
                    <div class="text-info mt-3"><?php echo __("We are testing every week the latest version of these plugins and <strong>we make sure they are working with Hide My WP</strong> plugin.
                     <br /><br />You don't need to install all these plugin in your website. If you're already using a cache plugin you don't need to install another one. <strong>We recommend using only one cache plugin</strong>.
                     <br /><br />You can also install either <strong>iThemes Security</strong> plugin or <strong>Sucuri Security</strong> plugin to work with Hide My Wp plugin.
                     <br /><br />If your plugins directory is not writable you will need to install the plugins manually.", _HMWP_PLUGIN_NAME_); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>