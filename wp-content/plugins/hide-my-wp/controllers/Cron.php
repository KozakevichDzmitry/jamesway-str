<?php

class HMWP_Controllers_Cron {

    /**
     * HMWP_Controllers_Cron constructor.
     */
    public function __construct() {
        add_filter('cron_schedules', array($this, 'setInterval'));

        //activate the cron job if not exists
        if (!wp_next_scheduled('hmwp_cron_process')) {
            wp_schedule_event(time(), 'hmwp_every_minute', 'hmwp_cron_process');
        }
    }

    /**
     * Specify the Cron interval
     * @param $schedules
     * @return mixed
     */
    function setInterval($schedules) {
        $schedules['hmwp_every_minute'] = array(
            'display' => 'every 1 minute',
            'interval' => 60
        );
        return $schedules;
    }

    /**
     * Process Cron
     * @throws Exception
     */
    public function processCron() {
        //Check the cache plugin
        HMWP_Classes_ObjController::getClass('HMWP_Models_Compatibility')->checkCacheFiles();
    }


}
