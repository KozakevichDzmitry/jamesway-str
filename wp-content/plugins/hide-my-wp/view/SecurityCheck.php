<?php
$do_check = false;
//Set the alert if security wasn't check
if (HMWP_Classes_Tools::getOption('hmwp_security_alert')) {
    if (!get_option('hmwp_securitycheck')) {
        $do_check = true;
    } elseif ($securitycheck_time = get_option('hmwp_securitycheck_time')) {
        if ((isset($securitycheck_time['timestamp']) && time() - $securitycheck_time['timestamp'] > (3600 * 24 * 7))) {
            $do_check = true;
        }
    } else {
        $do_check = true;
    }
}
?>
<div id="hmwp_wrap" class="d-flex flex-row my-3 bg-light">
    <?php echo HMWP_Classes_ObjController::getClass('HMWP_Controllers_Settings')->getAdminTabs('hmwp_securitycheck'); ?>
    <div class="hmwp_row d-flex flex-row bg-white px-3">
        <div class="hmwp_col flex-grow-1 mr-3">
            <div class="card col-sm-12 p-0">
                <h3 class="card-title bg-brown text-white p-2"><?php _e('WordPress Security Check', _HMWP_PLUGIN_NAME_); ?>:
                    <a href="https://hidemywpghost.com/kb/website-security-check/" target="_blank" class="d-inline-block ml-2" style="color: white"><i class="fa fa-question-circle"></i></a>
                </h3>
                <div class="card-body">
                    <?php if (HMWP_Classes_Tools::getOption('api_token') <> '' && apply_filters('hmwp_showaccount',true)) { ?>
                        <div class="col-sm-12 my-0 text-center">
                            <a href="<?php echo _HMWP_ACCOUNT_SITE_ . '/api/auth/' . HMWP_Classes_Tools::getOption('api_token') ?>" target="_blank"><img src="<?php echo _HMWP_THEME_URL_ . 'img/monitor_panel.png' ?>" style="width: 100%; max-width: 800px;"/></a>
                        </div>
                    <?php } ?>
                    <div class="col-sm-12 border-bottom border-light py-3 m-0">
                        <div class="card col-sm-12 p-4 bg-light ">
                            <div class="card-body text-center p-0">
                                <div class="start_securitycheck">
                                    <?php if (!$do_check) { ?>
                                        <div class="row">
                                            <div class="col-sm-5" style="text-align: center">
                                                <?php if (((count($view->riskreport) * 100) / count($view->risktasks)) > 90) { ?>
                                                    <img src="<?php echo _HMWP_THEME_URL_ . 'img/speedometer_danger.png' ?>" style="max-width: 60%; margin: 10px auto;"/>
                                                    <div style="font-size: 14px; font-style: italic; text-align: center; color: red;"><?php echo sprintf(__("Your website security %sis extremely weak%s. %sMany hacking doors are available.", _HMWP_PLUGIN_NAME_), '<strong>', '</strong>', '<br />') ?></div>
                                                <?php } elseif (((count($view->riskreport) * 100) / count($view->risktasks)) > 50) { ?>
                                                    <img src="<?php echo _HMWP_THEME_URL_ . 'img/speedometer_low.png' ?>" style="max-width: 60%; margin: 10px auto;"/>
                                                    <div style="font-size: 14px; font-style: italic; text-align: center; color: red;"><?php echo sprintf(__("Your website security %sis very weak%s. %sMany hacking doors are available.", _HMWP_PLUGIN_NAME_), '<strong>', '</strong>', '<br />') ?></div>
                                                <?php } elseif (((count($view->riskreport) * 100) / count($view->risktasks)) > 20) { ?>
                                                    <img src="<?php echo _HMWP_THEME_URL_ . 'img/speedometer_medium.png' ?>" style="max-width: 60%; margin: 10px auto;"/>
                                                    <div style="font-size: 14px; font-style: italic; text-align: center; color: orangered;"><?php echo sprintf(__("Your website security is still weak. %sSome of the main hacking doors are still available.", _HMWP_PLUGIN_NAME_), '<br />') ?></div>
                                                <?php } elseif (((count($view->riskreport) * 100) / count($view->risktasks)) > 0) { ?>
                                                    <img src="<?php echo _HMWP_THEME_URL_ . 'img/speedometer_better.png' ?>" style="max-width: 60%; margin: 10px auto;"/>
                                                    <div style="font-size: 14px; font-style: italic; text-align: center; color: orangered;"><?php echo sprintf(__("Your website security is getting better. %sJust make sure you complete all the security tasks.", _HMWP_PLUGIN_NAME_), '<br />') ?></div>
                                                <?php } else { ?>
                                                    <img src="<?php echo _HMWP_THEME_URL_ . 'img/speedometer_high.png' ?>" style="max-width: 60%; margin: 10px auto;"/>
                                                    <div style="font-size: 14px; font-style: italic; text-align: center; color: green;"><?php echo sprintf(__("Your website security is strong. %sKeep checking the security every week.", _HMWP_PLUGIN_NAME_), '<br />') ?></div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-7 my-4">
                                                <button type="button" class="btn rounded-0 btn-warning btn-lg text-white px-5 "><?php _e('Start Scan', _HMWP_PLUGIN_NAME_); ?></button>


                                                <?php
                                                if (!empty($view->report)) {
                                                    $overview = array('success' => 0, 'warning' => 0, 'total' => 0);
                                                    foreach ($view->report as $row) {
                                                        $overview['success'] += (int)$row['valid'];
                                                        $overview['warning'] += (int)$row['warning'];
                                                        $overview['total'] += 1;
                                                    }
                                                    echo '<table class="offset-2 col-sm-8 mt-3 mb-0">';
                                                    echo '<tbody>';
                                                    echo '
                                            <tr>
                                                <td class="text-success border-right"><h6>' . __('Passed', _HMWP_PLUGIN_NAME_) . '</h6><h2>' . $overview['success'] . '</h2></td>
                                                <td class="text-danger"><h6>' . __('Failed', _HMWP_PLUGIN_NAME_) . '</h6><h2>' . ($overview['total'] - $overview['success']) . '</h2></td>
                                            </tr>';
                                                    echo '</tbody>';
                                                    echo '</table>';

                                                    if (($overview['total'] - $overview['success']) == 0) { ?>
                                                        <div class="text-center text-success font-weight-bold mt-4"><?php echo __("Congratulations! You completed all the security tasks. Make sure you check your site once a week.", _HMWP_PLUGIN_NAME_) ?></div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <button type="button" class="btn rounded-0 btn-warning btn-lg text-white px-5 "><?php _e('Start Scan', _HMWP_PLUGIN_NAME_); ?></button>
                                    <?php } ?>

                                    <?php if (isset($view->securitycheck_time['timestamp'])) { ?>
                                        <div class="text-center text-black-50 my-1">
                                            <strong><?php _e('Last check:', _HMWP_PLUGIN_NAME_); ?></strong> <?php echo date(get_option('date_format') . ' ' . get_option('time_format'), ($view->securitycheck_time['timestamp'] + (get_option('gmt_offset') * HOUR_IN_SECONDS))); ?>
                                        </div>
                                    <?php } ?>
                                    <div class="text-center small text-black-50 mt-4"><?php echo sprintf(__("According to %sGoogle latest stats%s, over 20k websites are hacked every week and over 30&#37; of them are made in WordPress. <br />It's better to prevent an attack than to spend a lot of money and time to recover your data after an attack not to mention the situation when your clients' data are stollen.", _HMWP_PLUGIN_NAME_), '<a href="https://transparencyreport.google.com/safe-browsing/overview" target="_blank">', '</a>') ?></div>
                                </div>
                                <?php echo '<script>var hmwpQuery = {"ajaxurl": "' . admin_url('admin-ajax.php') . '","nonce": "' . wp_create_nonce(_HMWP_NONCE_ID_) . '"}</script>'; ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3 p-0 input-group">
                            <?php
                            if (!empty($view->report)) {
                                echo '<table class="table table-striped table_securitycheck">';
                                echo '
                                <thead>
                                    <tr>
                                        <th scope="col">' . __('Name', _HMWP_PLUGIN_NAME_) . '</th>
                                        <th scope="col">' . __('Value', _HMWP_PLUGIN_NAME_) . '</th>
                                        <th scope="col">' . __('Valid', _HMWP_PLUGIN_NAME_) . '</th>
                                        <th scope="col">' . __('Action', _HMWP_PLUGIN_NAME_) . '</th>
                                    </tr>
                                </thead>';

                                echo '<tbody>';
                                foreach ($view->report as $index => $row) {
                                    echo '
                                            <tr>
                                                <td style="min-width: 250px">' . $row['name'] . '</td>
                                                <td style="min-width: 200px; font-weight: bold">' . $row['value'] . '</td>
                                                <td class="' . ($row['valid'] ? 'text-success' : 'text-danger') . '">' . ($row['valid'] ? '<i class="fa fa-check mx-2"></i>' : '<i class="fa fa-times mx-2"></i>' . (isset($row['solution']) ? $row['solution'] : '')) . '</td>
                                                <td style="min-width: 180px; padding-right: 0!important;" >
                                                    <div class="modal fade" id="hmwp_securitydetail' . $index . '" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">' . $row['name'] . '</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                               <div class="modal-body">' . $row['message'] . '</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-light" type="button"  data-toggle="modal" data-target="#hmwp_securitydetail' . $index . '">' . __('Info', _HMWP_PLUGIN_NAME_) . '</button>
                                                    ' . ((!$row['valid'] && isset($row['javascript']) && $row['javascript'] <> '' && HMWP_Classes_ObjController::getClass('HMWP_Models_Rules')->isConfigWritable()) ? '<button class="btn btn-success mx-0" onclick="' . $row['javascript'] . '">' . __('Fix it', _HMWP_PLUGIN_NAME_) . '</button>' : '') . '
                                                    <button type="button" class="close m-1" aria-label="Close" style="display: none" onclick="if (confirm(\'' . __('Are you sure you want to ignore this task in the future?') . '\')) {jQuery(this).hmwp_securityExclude(\'' . $index . '\');}">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>                                             
                                                </td>
                                            </tr>';
                                }
                                echo '</tbody>';
                                echo '</table>';

                            }
                            ?>
                        </div>
                        <div class="col-sm-12 text-right">
                            <button class="btn btn-light hmwp_resetexclude" type="button"><?php echo __('Show all ingnored tasks', _HMWP_PLUGIN_NAME_) ?></button>
                        </div>
                    </div>
                    <?php if (!HMWP_Classes_Tools::getOption('api_token') <> '') { ?>
                        <div class="col-sm-12 border-bottom border-light py-3 mx-0 my-3">
                            <div class="card col-sm-12 p-0 input-group">
                                <div class="card-body text-center">
                                    <a href="https://wpplugins.tips/wordpress-vulnerability-detector/?url=<?php echo urlencode(home_url()) ?>" target="_blank"><img src="<?php echo _HMWP_THEME_URL_ . 'img/security_check.png' ?>" style="width: 100%"></a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</div>