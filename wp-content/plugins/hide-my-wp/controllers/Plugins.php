<?php
defined('ABSPATH') || die('Cheatin\' uh?');

require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

class QuietSkin extends \WP_Upgrader_Skin {
    public function feedback($string) { /* no output */ }
}

class HMWP_Controllers_Plugins extends HMWP_Classes_FrontController {

    /**
     * Called when an action is triggered
     * @throws Exception
     */
    public function action() {
        parent::action();

        if (!HMWP_Classes_Tools::userCan('install_plugins')) {
            return;
        }

        switch (HMWP_Classes_Tools::getValue('action')) {
            case 'hmwp_plugin_install':
                HMWP_Classes_Tools::setHeader('json');

                if (HMWP_Classes_Tools::getValue('plugin', '') <> '') {
                    $plugins = HMWP_Classes_ObjController::getClass('HMWP_Models_Settings')->getPlugins();
                    $pluginPath = false;

                    foreach ($plugins as $plugin => $details) {
                        if ($plugin == HMWP_Classes_Tools::getValue('plugin')) {
                            $pluginPath = WP_PLUGIN_DIR . '/' . $details['path'];
                            break;
                        }
                    }

                    if (!empty($plugin) && $pluginPath) {
                        if (!file_exists($pluginPath)) {

                            //includes necessary for Plugin_Upgrader and Plugin_Installer_Skin
                            require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
                            include_once(ABSPATH . 'wp-admin/includes/file.php');
                            include_once(ABSPATH . 'wp-admin/includes/misc.php');
                            include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

                            remove_all_actions('upgrader_process_complete');


                            $api = plugins_api('plugin_information', array(
                                'slug' => $plugin,
                                'fields' => array(
                                    'short_description' => false,
                                    'sections' => false,
                                    'requires' => false,
                                    'rating' => false,
                                    'ratings' => false,
                                    'downloaded' => false,
                                    'last_updated' => false,
                                    'added' => false,
                                    'tags' => false,
                                    'compatibility' => false,
                                    'homepage' => false,
                                    'donate_link' => false,
                                ),
                            ));

                            ob_start();
                            // Replace with new QuietSkin for no output
                            $upgrader = new Plugin_Upgrader(new QuietSkin(array('api' => $api)));
                            $upgrader->install($api->download_link);
                            ob_get_clean();
                        }

                        if (file_exists($pluginPath)) {
                            activate_plugin($pluginPath);
                            echo json_encode(array('success' => true));
                        } else {
                            echo json_encode(array('success' => false));
                        }
                    }

                }
                exit();
        }
    }
}
