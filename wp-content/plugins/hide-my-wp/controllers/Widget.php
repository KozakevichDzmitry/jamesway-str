<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class HMWP_Controllers_Widget extends HMWP_Classes_FrontController {

    public $riskreport = array();
    public $risktasks;

    /**
     * Called when dashboard is loaded
     * @throws Exception
     */
    public function dashboard() {
        $this->risktasks = HMWP_Classes_ObjController::getClass('HMWP_Controllers_SecurityCheck')->getRiskTasks();
        $this->riskreport = HMWP_Classes_ObjController::getClass('HMWP_Controllers_SecurityCheck')->getRiskReport();

        echo $this->getView('Dashboard');
    }

    /**
     * Called when an action is triggered
     * @throws Exception
     */
    public function action() {
        parent::action();

        if (!HMWP_Classes_Tools::userCan('hmwp_manage_settings')) {
            return;
        }

        switch (HMWP_Classes_Tools::getValue('action')) {
            case 'hmwp_widget_securitycheck':
                HMWP_Classes_ObjController::getClass('HMWP_Controllers_SecurityCheck')->doSecurityCheck();

                ob_start();
                $this->dashboard();
                $output = ob_get_clean();

                HMWP_Classes_Tools::setHeader('json');
                echo json_encode(array('data' => $output));
                exit();

        }
    }
}
