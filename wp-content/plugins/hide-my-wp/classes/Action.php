<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * Set the ajax action and call for wordpress
 */
class HMWP_Classes_Action extends HMWP_Classes_FrontController {

    /** @var array with all form and ajax actions */
    var $actions = array();

    /** @var array from core config */
    private static $config;


    /**
     * The hookAjax is loaded as custom hook in hookController class
     *
     * @return void
     * @throws Exception
     */
    public function hookInit() {
        if (HMWP_Classes_Tools::isAjax()) {
            $this->getActions(true);
        }
    }

    /**
     * Hook Frontend
     * @throws Exception
     */
    function hookFrontinit() {
        /* Only if post */
        if (HMWP_Classes_Tools::isAjax()) {
            $this->getActions();
        }
    }

    /**
     * The hookSubmit is loaded when action si posted
     *
     * @throws Exception
     * @return void
     */
    function hookMenu() {
        /* Only if post */
        if (!HMWP_Classes_Tools::isAjax()) {
            $this->getActions();
        }
    }

    /**
     * Hook the Multisite Menu
     * @throws Exception
     */
    function hookMultisiteMenu() {
        /* Only if post */
        if (!HMWP_Classes_Tools::isAjax()) {
            $this->getActions();
        }
    }

    /**
     * Get the list with all the plugin actions
     * @return array
     */
    public function getActionsTable(){
       return array(
            array(
                "name" => "HMWP_Controllers_Settings",
                "actions" => array(
                    "action" => array(
                        "hmwp_settings",
                        "hmwp_tweakssettings",
                        "hmwp_confirm",
                        "hmwp_newpluginschange",
                        "hmwp_logout",
                        "hmwp_abort",
                        "hmwp_manualrewrite",
                        "hmwp_mappsettings",
                        "hmwp_advsettings",
                        "hmwp_devsettings",
                        "hmwp_devdownload",
                        "hmwp_changepathsincache",
                        "hmwp_backup",
                        "hmwp_restore",
                        "hmwp_connect"
                    )
                ),
                "admin" => "1",
                "active" => "1"
            ),
            array(
                "name" => "HMWP_Controllers_Plugins",
                "actions" => array(
                    "action" => array(
                        "hmwp_plugin_install"
                    )
                ),
                "admin" => "1",
                "active" => "1"
            ),
            array(
                "name" => "HMWP_Controllers_SecurityCheck",
                "actions" => array(
                    "action" => array(
                        "hmwp_securitycheck",
                        "hmwp_fixsettings",
                        "hmwp_fixconfig",
                        "hmwp_securityexclude",
                        "hmwp_resetexclude"
                    )
                ),
                "admin" => "1",
                "active" => "1"
            ),
            array(
                "name" => "HMWP_Controllers_Brute",
                "actions" => array(
                    "action" => array(
                        "hmwp_brutesettings",
                        "hmwp_blockedips",
                        "hmwp_deleteip",
                        "hmwp_deleteallips"
                    )
                ),
                "admin" => "1",
                "active" => "1"
            ),
            array(
                "name" => "HMWP_Controllers_Log",
                "actions" => array(
                    "action" => array(
                        "hmwp_logsettings"
                    )
                ),
                "admin" => "1",
                "active" => "1"
            ),
            array(
                "name" => "HMWP_Controllers_Widget",
                "actions" => array(
                    "action" => "hmwp_widget_securitycheck"
                ),
                "admin" => "1",
                "active" => "1"
            )
        );
    }


    /**
     * Get all actions from config.json in core directory and add them in the WP
     *
     * @param bool $ajax
     * @throws Exception
     */
    public function getActions($ajax = false) {

        if ( ! is_admin() && ! is_network_admin() ) {
            return;
        }

        $this->actions = array();
        $action = HMWP_Classes_Tools::getValue('action');
        $nonce = HMWP_Classes_Tools::getValue('hmwp_nonce');

        if ($action == '' || $nonce == '') {
            return;
        }

        $actions = $this->getActionsTable();

        foreach ( $actions as $block ) {
            if ( isset( $block['active'] ) && $block['active'] == 1 ) {
                /* if there is a single action */
                if ( isset( $block['actions']['action'] ) ) {
                    /* if there are more actions for the current block */
                    if ( ! is_array( $block['actions']['action'] ) ) {
                        /* add the action in the actions array */
                        if ( $block['actions']['action'] == $action ) {
                            $this->actions[] = array( 'class' => $block['name'] );
                        }
                    } else {
                        /* if there are more actions for the current block */
                        foreach ( $block['actions']['action'] as $value ) {
                            /* add the actions in the actions array */
                            if ( $value == $action ) {
                                $this->actions[] = array( 'class' => $block['name'] );
                            }
                        }
                    }
                }
            }
        }


        if ($ajax) {
            check_ajax_referer(_HMWP_NONCE_ID_, 'hmwp_nonce');
        } else {
            check_admin_referer($action, 'hmwp_nonce');
        }
        /* add the actions in WP */
        foreach ($this->actions as $actions) {
            HMWP_Classes_ObjController::getClass($actions['class'])->action();
        }
    }

}