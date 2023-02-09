<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );

class HMWP_Classes_Error extends HMWP_Classes_FrontController {

    /** @var array */
    private static $errors = array();

    /**
     * The error controller for Hide My WP
     */
    function __construct() {
        parent::__construct();

        /* Verify dependences */
        if (!function_exists('get_class')) {
            self::setError(__("Function get_class does not exist! It's required for Hide My WP to work properly.", _HMWP_PLUGIN_NAME_));
        }
        if (!function_exists('file_exists')) {
            self::setError(__("Function file_exists does not exist! It's required for Hide My WP to work properly.", _HMWP_PLUGIN_NAME_));
        }

        if (!defined('ABSPATH'))
            self::setError(__("The home directory is not set!", _HMWP_PLUGIN_NAME_), 'fatal');

        /* Check the PHP version */
        if (PHP_VERSION_ID < 5100) {
            self::setError(__("The PHP version has to be greater than 5.1", _HMWP_PLUGIN_NAME_), 'fatal');
        }
    }

    /**
     * Show version error
     */
    public function phpVersionError() {
        echo '<div class="update-nag"><span style="color:red; font-weight:bold;">' . __('For Hide My WP to work, the PHP version has to be equal or greater than 5.1', _HMWP_PLUGIN_NAME_) . '</span></div>';
    }

    /**
     * Show the error in wrodpress
     *
     * @param string $error
     * @param string $type
     * @param null $index
     */
    public static function setError($error = '', $type = 'notice', $index = null) {
        if (!isset($index)) {
            $index = count(self::$errors);
        }

        self::$errors[$index] = array(
            'type' => $type,
            'text' => $error);
    }

    /**
     * Return if error
     * @return bool
     */
    public static function isError() {
        return !empty(self::$errors);
    }

    /**
     * This hook will show the error in WP header
     */
    public function hookNotices() {
        if (is_array(self::$errors) &&
            ((is_string(HMWP_Classes_Tools::getValue('page', '')) && stripos(HMWP_Classes_Tools::getValue('page', ''), _HMWP_NAMESPACE_) !== false) ||
                (is_string(HMWP_Classes_Tools::getValue('plugin', '')) && stripos(HMWP_Classes_Tools::getValue('plugin', ''), _HMWP_PLUGIN_NAME_) !== false))
        ) {
            foreach (self::$errors as $error) {

                switch ($error['type']) {
                    case 'fatal':
                        self::showError(ucfirst(_HMWP_PLUGIN_NAME_ . " " . $error['type']) . ': ' . $error['text'], $error['type']);
                        die();
                        break;
                    default:
                        self::showError($error['text'], $error['type']);
                }
            }
        }
        self::$errors = array();
    }

    /**
     * Show the notices to WP
     *
     * @param $message
     * @param string $type
     */
    public static function showError($message, $type = '') {
        if (file_exists(_HMWP_THEME_DIR_ . 'Notices.php')) {
            include(_HMWP_THEME_DIR_ . 'Notices.php');
        } else {
            echo $message;
        }
    }

}