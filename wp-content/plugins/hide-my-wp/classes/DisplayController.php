<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * The class handles the theme part in WP
 */
class HMWP_Classes_DisplayController {

    private static $cache;

    /**
     * echo the css link from theme css directory
     *
     * @param string $uri The name of the css file or the entire uri path of the css file
     * @param array $dependency
     *
     * @return void
     */
    public static function loadMedia($uri = '', $dependency = null) {
        $css_uri = '';
        $js_uri = '';

        if (HMWP_Classes_Tools::isAjax()) {
            return;
        }

        if (isset(self::$cache[$uri]))
            return;

        self::$cache[$uri] = true;

        /* if is a custom css file */
        if (strpos($uri, '//') === false) {
            $name = strtolower($uri);
            if (file_exists(_HMWP_THEME_DIR_ . 'css/' . $name .'.min.css')) {
                $css_uri = _HMWP_THEME_URL_ . 'css/' . $name . '.min.css?ver=' . HMWP_VERSION_ID;
            }
            if (file_exists(_HMWP_THEME_DIR_ . 'css/' . $name . '.min.scss')) {
                $css_uri = _HMWP_THEME_URL_ . 'css/' . $name . '.min.scss?ver=' . HMWP_VERSION_ID;
            }
            if (file_exists(_HMWP_THEME_DIR_ . 'js/' . $name . '.min.js')) {
                $js_uri = _HMWP_THEME_URL_ . 'js/' . $name . '.min.js?ver=' . HMWP_VERSION_ID;
            }
        } else {
            $name = strtolower(basename($uri));
            if (strpos($uri, '.css') !== FALSE) {
                $css_uri = $uri;
            } elseif (strpos($uri, '.scss') !== FALSE) {
                $css_uri = $uri;
            } elseif (strpos($uri, '.js') !== FALSE) {
                $js_uri = $uri;
            }
        }

        if ($css_uri <> '') {
            if (!wp_style_is($name)) {
                if (did_action('wp_print_styles')) {
                    echo "<link rel='stylesheet' id='$name-css'  href='$css_uri' type='text/css' media='all' />";
                } elseif (is_admin()) { //load CSS for admin or on triggered
                    wp_enqueue_style($name, $css_uri, $dependency, HMWP_VERSION_ID, 'all');
                    wp_print_styles(array($name));
                }else{
                    wp_register_style($name, $css_uri, $dependency, HMWP_VERSION_ID, 'all');
                }
            }
        }

        if ($js_uri <> '') {
            if (!wp_script_is($name)) {
                if (did_action('wp_print_scripts')) {
                    echo "<script type='text/javascript' src='$js_uri'></script>";
                } elseif (is_admin()) {
                    wp_enqueue_script($name, $js_uri, $dependency, HMWP_VERSION_ID, true);
                    wp_print_scripts(array($name));
                }else{
                    wp_register_script($name, $js_uri, $dependency, HMWP_VERSION_ID, true);
                }
            }
        }
    }

    /**
     *
     * return the block content from theme directory
     *
     * @param $block
     * @param HMWP_Classes_FrontController $view
     * @return null|string
     */
    public function getView($block, $view) {
        $output = null;

        if (file_exists(_HMWP_THEME_DIR_ . $block . '.php')) {
            ob_start();
            include(_HMWP_THEME_DIR_ . $block . '.php');
            $output .= ob_get_clean();
        }

        return $output;
    }

}