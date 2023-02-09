<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class HMWP_Models_Settings {
    /**
     * Get the admin Menu Tabs
     * @return array
     */
    public function getTabs() {
        return array(
            'hmwp_permalinks' => array(
                'title' => __("Permalinks", _HMWP_PLUGIN_NAME_),
                'description' => __("Change common paths", _HMWP_PLUGIN_NAME_),
                'icon' => 'link'
            ),
            'hmwp_mapping' => array(
                'title' => __("Mapping", _HMWP_PLUGIN_NAME_),
                'description' => __("Text and URL mapping", _HMWP_PLUGIN_NAME_),
                'icon' => 'arrows-h'
            ),
            'hmwp_tweaks' => array(
                'title' => __("Tweaks", _HMWP_PLUGIN_NAME_),
                'description' => __("Add WordPress Tweaks", _HMWP_PLUGIN_NAME_),
                'icon' => 'puzzle-piece'
            ),
            'hmwp_brute' => array(
                'title' => __("Brute Force", _HMWP_PLUGIN_NAME_),
                'description' => __("Add Login Protection", _HMWP_PLUGIN_NAME_),
                'icon' => 'user-secret'
            ),
            'hmwp_log' => array(
                'title' => __("Log Events", _HMWP_PLUGIN_NAME_),
                'description' => __("Website Events Log", _HMWP_PLUGIN_NAME_),
                'icon' => 'database'
            ),
            'hmwp_securitycheck' => array(
                'title' => __("Security Check", _HMWP_PLUGIN_NAME_),
                'description' => __('Test Your Website', _HMWP_PLUGIN_NAME_),
                'icon' => '	fa fa-search',
                'class' => 'HMWP_Controllers_SecurityCheck'
            ),
            'hmwp_plugins' => array(
                'title' => __("Plugins", _HMWP_PLUGIN_NAME_),
                'description' => 'Compatible Free Plugins',
                'icon' => 'plug'
            ),
            'hmwp_backup' => array(
                'title' => __("Backup/Restore", _HMWP_PLUGIN_NAME_),
                'description' => __('Save your settings', _HMWP_PLUGIN_NAME_),
                'icon' => 'save'
            ),
            'hmwp_advanced' => array(
                'title' => __("Advanced", _HMWP_PLUGIN_NAME_),
                'description' => '',
                'icon' => 'cogs'
            ),
        );
    }

    /**
     * Get the known plugins and themes
     * @return array
     */
    public function getPlugins() {
        return array(
            'squirrly-seo' => array(
                'title' => __("SEO SQUIRRLY"),
                'banner' => '//ps.w.org/squirrly-seo/assets/banner-772x250.png?rev=2302934',
                'description' => __("A.I.-based Private SEO Consultant. In a Plugin. Powered by Machine Learning and Cloud Services. Over 300 functionalities for SEO now available when you need them.") . '<div class="text-success my-2">' . 'SEO Plugin' . '</div>',
                'path' => 'squirrly-seo/squirrly.php',
                'url' => 'https://wpplugins.tips/plugin/squirrly-seo'
            ),
            'wp-rocket' => array(
                'title' => __("WP-Rocket"),
                'banner' => _HMWP_THEME_URL_ . 'img/plugins/wp-rocket-banner.jpg',
                'description' => __("WP Rocket is in fact the only cache plugin which integrates more than 80% of web performance best practices even without any options activated. ") . '<div class="text-success my-2">' . 'Cache Plugin' . '</div>',
                'path' => 'wp-rocket/wp-rocket.php',
                'url' => 'https://wpplugins.tips/plugin/wp-rocket'
            ),
            'autoptimize' => array(
                'title' => __("Autoptimize"),
                'banner' => '//ps.w.org/autoptimize/assets/banner-772x250.jpg?rev=1315920',
                'description' => __("Autoptimize speeds up your website by optimizing JS, CSS and HTML, async-ing JavaScript, removing emoji cruft, optimizing Google Fonts and more.") . '<div class="text-success my-2">' . 'Cache plugin' . '</div>',
                'path' => 'autoptimize/autoptimize.php',
                'url' => 'https://wordpress.org/plugins/autoptimize/'
            ),
            'ninjaforms' => array(
                'title' => __("Ninja Forms"),
                'banner' => '//ps.w.org/ninja-forms/assets/banner-772x250.png?rev=2069024',
                'description' => __("Use Ninja Forms to create beautiful, user friendly WordPress forms that will make you feel like a professional web developer") . '<div class="text-success my-2">' . 'Form Plugin' . '</div>',
                'path' => 'minify-html-markup/minify-html.php',
                'url' => 'https://wpplugins.tips/plugin/ninja-forms'
            ),
            'wpforms' => array(
                'title' => __("WP Forms"),
                'banner' => '//ps.w.org/wpforms-lite/assets/banner-772x250.png?rev=1371112',
                'description' => __("WPForms allows you to create beautiful contact forms, feedback form, subscription forms, payment forms, and other types of forms for your site in minutes, not hours!") . '<div class="text-success my-2">' . 'Form Plugin' . '</div>',
                'path' => 'wpforms-lite/wpforms.php',
                'url' => 'https://wpplugins.tips/plugin/wp-forms'
            ),
            'better-wp-security' => array(
                'title' => __("iThemes Security"),
                'banner' => '//ps.w.org/better-wp-security/assets/banner-772x250.png?rev=881897',
                'description' => __("iThemes Security gives you over 30+ ways to secure and protect your WP site. WP sites can be an easy target for attacks because of plugin vulnerabilities, weak passwords and obsolete software.") . '<div class="text-success my-2">' . 'Security Plugin' . '</div>',
                'path' => 'better-wp-security/better-wp-security.php',
                'url' => 'https://wpplugins.tips/plugin/ithemes'
            ),
            'sucuri-scanner' => array(
                'title' => __("Sucuri Security"),
                'banner' => '//ps.w.org/sucuri-scanner/assets/banner-772x250.png?rev=1235419',
                'description' => __("The Sucuri WordPress Security plugin is a security toolset for security integrity monitoring, malware detection and security hardening.") . '<div class="text-success my-2">' . 'Security Plugin' . '</div>',
                'path' => 'sucuri-scanner/sucuri.php',
                'url' => 'https://wordpress.org/plugins/sucuri-scanner/'
            ),
            'backupwordpress' => array(
                'title' => __("Back Up WordPress"),
                'banner' => '//ps.w.org/backupwordpress/assets/banner-772x250.jpg?rev=904756',
                'description' => __("Simple automated backups of your WordPress-powered website. Back Up WordPress will back up your entire site including your database and all your files on a schedule that suits you.") . '<div class="text-success my-2">' . 'Backup Plugin' . '</div>',
                'path' => 'backupwordpress/backupwordpress.php',
                'url' => 'https://wordpress.org/plugins/backupwordpress/'
            ),
            'elementor' => array(
                'title' => __("Elementor Builder"),
                'banner' => '//ps.w.org/elementor/assets/banner-772x250.png?rev=1475479',
                'description' => __("The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.") . '<div class="text-success my-2">' . 'Page Builder' . '</div>',
                'path' => 'elementor/elementor.php',
                'url' => 'https://wpplugins.tips/plugin/elementor'
            ),
            'weglot' => array(
                'title' => __("Weglot Translate"),
                'banner' => '//ps.w.org/weglot/assets/banner-772x250.png?rev=2186774',
                'description' => __("Translate your website into multiple languages without any code. Weglot Translate is fully SEO compatible and follows Google's best practices.") . '<div class="text-success my-2">' . 'Multilingual' . '</div>',
                'path' => 'weglot/weglot.php',
                'url' => 'https://wordpress.org/plugins/weglot/'
            ),
            'facebook-pixel' => array(
                'title' => __("Facebook Pixel"),
                'banner' => '//ps.w.org/pixelyoursite/assets/banner-772x250.jpg?rev=2163168',
                'description' => __("Manage your Facebook Pixel or Google Analytics code with a single plugin and add ANY other script (Head & Footer feature). The Pinterest Tag can be implemented via free add-on.") . '<div class="text-success my-2">' . 'Tracking Plugin' . '</div>',
                'path' => 'pixelyoursite/pixelyoursite.php',
                'url' => 'https://wpplugins.tips/plugin/facebook-pixel'
            ),
            'maintenance' => array(
                'title' => __("Maintenance"),
                'banner' => '//ps.w.org/maintenance/assets/banner-772x250.png?rev=1637471',
                'description' => __("Maintenance plugin allows the WordPress site administrator to close the website for maintenance, set a temporary page with authorization, which can be edited via the plugin settings.") . '<div class="text-success my-2">' . 'Tracking Plugin' . '</div>',
                'path' => 'add-to-any/add-to-any.php',
                'url' => 'https://wordpress.org/plugins/maintenance/'
            ),
        );
    }
    /**
     * Set the permalinks in database
     *
     * @param $params
     * @throws Exception
     */
    public function savePermalinks($params) {
        HMWP_Classes_Tools::saveOptions('error', false);
        HMWP_Classes_Tools::saveOptions('changes', false);

        if ($params['hmwp_admin_url'] == $params['hmwp_login_url'] && $params['hmwp_admin_url'] <> '') {
            HMWP_Classes_Tools::saveOptions('error', true);
            HMWP_Classes_Error::setError(__("You can't set both ADMIN and LOGIN with the same name. Please use different names", _HMWP_PLUGIN_NAME_));
            return;
        }

        //send email when the admin is changed
        if (isset($params['hmwp_send_email'])) {
            HMWP_Classes_Tools::$default['hmwp_send_email'] = $params['hmwp_send_email'];
        }

        if ($params['hmwp_mode'] == 'default') {
            $params = HMWP_Classes_Tools::$default;
        }

        ////////////////////////////////////////////
        //Set the Category and Tags dirs
        global $wp_rewrite;
        $blog_prefix = '';
        if (is_multisite() && !is_subdomain_install() && is_main_site() && 0 === strpos(get_option('permalink_structure'), '/blog/')) {
            $blog_prefix = '/blog';
        }

        if (isset($params['hmwp_category_base']) && method_exists($wp_rewrite, 'set_category_base')) {
            $category_base = $params['hmwp_category_base'];
            if (!empty($category_base))
                $category_base = $blog_prefix . preg_replace('#/+#', '/', '/' . str_replace('#', '', $category_base));
            $wp_rewrite->set_category_base($category_base);
        }

        if (isset($params['hmwp_tag_base']) && method_exists($wp_rewrite, 'set_tag_base')) {
            $tag_base = $params['hmwp_tag_base'];
            if (!empty($tag_base))
                $tag_base = $blog_prefix . preg_replace('#/+#', '/', '/' . str_replace('#', '', $tag_base));
            $wp_rewrite->set_tag_base($tag_base);
        }
        ////////////////////////////////////////////

        //If the admin is changed, require a logout if necessary
        $lastsafeoptions = HMWP_Classes_Tools::getOptions(true);
        if ($lastsafeoptions['hmwp_admin_url'] <> $params['hmwp_admin_url']) {
            HMWP_Classes_Tools::saveOptions('logout', true);
        } elseif ($lastsafeoptions['hmwp_login_url'] <> $params['hmwp_login_url']) {
            HMWP_Classes_Tools::saveOptions('logout', true);
        }


        //Save all values
        $this->saveValues($params, true);

        //Some values need to be save as blank is case no data is received
        //Set them to blank or value
        HMWP_Classes_Tools::saveOptions('hmwp_lostpassword_url', HMWP_Classes_Tools::getValue('hmwp_lostpassword_url', ''));
        HMWP_Classes_Tools::saveOptions('hmwp_register_url', HMWP_Classes_Tools::getValue('hmwp_register_url', ''));
        HMWP_Classes_Tools::saveOptions('hmwp_logout_url', HMWP_Classes_Tools::getValue('hmwp_logout_url', ''));


        //generate unique names for plugins if needed
        if (HMWP_Classes_Tools::getOption('hmwp_hide_plugins')) {
            HMWP_Classes_ObjController::getClass('HMWP_Models_Rewrite')->hidePluginNames();
        }
        if (HMWP_Classes_Tools::getOption('hmwp_hide_themes')) {
            HMWP_Classes_ObjController::getClass('HMWP_Models_Rewrite')->hideThemeNames();
        }

        //Save the rules and add the rewrites
        $this->saveRules();

        //check if the config file is writable or is WP-engine server
        if (!HMWP_Classes_ObjController::getClass('HMWP_Models_Rules')->isConfigWritable() || HMWP_Classes_Tools::isWpengine()) {
            //if not writeable, call the rules to show manually changes
            if (!HMWP_Classes_ObjController::getClass('HMWP_Models_Rewrite')->clearRedirect()
                ->setRewriteRules()
                ->flushRewrites() //show rules to be added manually
            ) {
                HMWP_Classes_Tools::saveOptions('error', true);
            }
        }


    }

    /**
     * Save the Values in database
     * @param $params
     * @param bool $validate
     */
    public function saveValues($params, $validate = false) {
        //Save the option values
        foreach ($params as $key => $value) {
            if (in_array($key, array_keys(HMWP_Classes_Tools::$options))) {
                //Make sure is set in POST
                if (HMWP_Classes_Tools::getIsset($key)) {
                    //sanitize the value first
                    $value = HMWP_Classes_Tools::getValue($key);

                    //set the default value in case of nothing to prevent empty paths and errors
                    if ($value == '') {
                        if (isset(HMWP_Classes_Tools::$default[$key])) {
                            $value = HMWP_Classes_Tools::$default[$key];
                        } elseif (isset(HMWP_Classes_Tools::$init[$key])) {
                            $value = HMWP_Classes_Tools::$init[$key];
                        }
                    }

                    //Detect Invalid Names
                    if ($validate) {
                        if (isset($params['hmwp_mode']) && $params['hmwp_mode'] <> 'default') {
                            if (!$this->invalidName($key, $value)) { //if the name is valid
                                //Detect Weak Names
                                $this->weakName($value); //show weak names
                                HMWP_Classes_Tools::saveOptions($key, $value);
                            }
                        } else {
                            HMWP_Classes_Tools::saveOptions($key, $value);
                        }
                    } else {
                        HMWP_Classes_Tools::saveOptions($key, $value);
                    }
                }
            }
        }
    }

    /**
     * Save the rules in the config file
     *
     * @throws Exception
     */
    public function saveRules() {
        //CLEAR RULES ON DEFAULT
        if (HMWP_Classes_Tools::getOption('hmwp_mode') == 'default') {
            HMWP_Classes_ObjController::getClass('HMWP_Models_Rules')->writeToFile('', 'HMWP_VULNERABILITY');
            return;
        }


        //INSERT SEURITY RULES
        if (!HMWP_Classes_Tools::isIIS()) {
            //For Nginx and Apache the rules can be inserted separately
            $rules = HMWP_Classes_ObjController::getClass('HMWP_Models_Rules')->getInjectionRewrite();
            if (HMWP_Classes_Tools::getOption('hmwp_hide_oldpaths')) {
                $rules .= HMWP_Classes_ObjController::getClass('HMWP_Models_Rules')->getHideOldPathRewrite();
            }

            if(strlen($rules) > 1) {
                if ( !HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->writeToFile( $rules, 'HMWP_VULNERABILITY' ) ) {
                    $config_file = HMWP_Classes_ObjController::getClass( 'HMWP_Models_Rules' )->getConfFile();
                    HMWP_Classes_Error::setError( sprintf( __( 'Config file is not writable. You need to update your %s file with the following lines: %s', _HMWP_PLUGIN_NAME_ ), '<strong>' . $config_file . '</strong>', '<br /><br /><pre><strong># BEGIN HMWP_VULNERABILITY<br />' . htmlentities( str_replace( '    ', ' ', $rules ) ) . '# END HMWP_VULNERABILITY</strong></pre>' ) );
                }
            }
        }

    }

    /**
     * Check invalid name and avoid errors
     * @param string $key DB Option name
     * @param string $name Option value
     * @return bool
     */
    public function invalidName($key, $name) {
        if(!is_string($name)) {
            return false;
        }

        $invalid_paths = array(
            'index.php',
            'readme.html',
            'sitemap.xml',
            '.htaccess',
            'license.txt',
            'wp-blog-header.php',
            'wp-config.php',
            'wp-config-sample.php',
            'wp-activate.php',
            'wp-cron.php',
            'wp-mail.php',
            'wp-load.php',
            'wp-links-opml.php',
            'wp-settings.php',
            'wp-signup.php',
            'wp-trackback.php',
            'xmlrpc.php',
            'content',
            'includes',
            'css',
            'js',
            'font',
        );

        if(($key <> 'hmwp_themes_url' && $name == 'themes') || ($key == 'hmwp_themes_url' && $name == 'assets') ||  ($key <> 'hmwp_upload_url' && $name == 'uploads')){
            HMWP_Classes_Error::setError(sprintf(__("Invalid name detected: %s. Add only the final path name to avoid WordPress errors.", _HMWP_PLUGIN_NAME_), '<strong>' . $name . '</strong>'));
            return true;
        }

        if (is_string($name) && strlen($name) > 1 && strlen($name) < 3) {
            HMWP_Classes_Error::setError(sprintf(__("Short name detected: %s. You need to use unique paths with more than 4 chars to avoid WordPress errors.", _HMWP_PLUGIN_NAME_), '<strong>' . $name . '</strong>'));
            return true;
        }
        if (in_array($name, $invalid_paths)) {
            HMWP_Classes_Error::setError(sprintf(__("Invalid name detected: %s. You need to use another name to avoid WordPress errors.", _HMWP_PLUGIN_NAME_), '<strong>' . $name . '</strong>'));
            return true;
        }

        if (strpos($name, '//') !== false) {
            HMWP_Classes_Error::setError(sprintf(__("Invalid name detected: %s. Add only the final path name to avoid WordPress errors.", _HMWP_PLUGIN_NAME_), '<strong>' . $name . '</strong>'));
            return true;
        }
        if (strpos($name, '/') !== false && strpos($name, '/') == 0) {
            HMWP_Classes_Error::setError(sprintf(__("Invalid name detected: %s. The name can't start with / to avoid WordPress errors.", _HMWP_PLUGIN_NAME_), '<strong>' . $name . '</strong>'));
            return true;
        }
        if (strpos($name, '/') !== false && substr($name, -1) == '/') {
            HMWP_Classes_Error::setError(sprintf(__("Invalid name detected: %s. The name can't end with / to avoid WordPress errors.", _HMWP_PLUGIN_NAME_), '<strong>' . $name . '</strong>'));
            return true;
        }
        $array = explode('/', $name);
        if (!empty($array)) {
            foreach ($array as $row) {
                if (substr($row, -1) == '.') {
                    HMWP_Classes_Error::setError(sprintf(__("Invalid name detected: %s. The paths can't end with . to avoid WordPress errors.", _HMWP_PLUGIN_NAME_), '<strong>' . $name . '</strong>'));
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Check if the name is week for security
     * @param $name
     */
    public function weakName($name) {
        $invalit_paths = array(
            'login',
            'mylogin',
            'wp-login',
            'admin',
            'wp-mail.php',
            'wp-settings.php',
            'wp-signup.php',
            'wp-trackback.php',
            'xmlrpc.php',
            'wp-include',
        );

        if (in_array($name, $invalit_paths)) {
            HMWP_Classes_Error::setError(sprintf(__("Weak name detected: %s. You need to use another name to increase your website security.", _HMWP_PLUGIN_NAME_), '<strong>' . $name . '</strong>'));
        }
    }
}
