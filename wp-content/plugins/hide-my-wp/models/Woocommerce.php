<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class HMWP_Models_Woocommerce {

    public function __construct() {
        add_action('wp_default_scripts', array($this, 'remove_password_strength_meter'));
    }

    public function remove_password_strength_meter($scripts) {
        if (function_exists('is_user_logged_in') && !is_user_logged_in()) {
            if (method_exists($scripts, 'remove')) {
                $scripts->remove('password-strength-meter');
            }
        }
        return $scripts;
    }


}