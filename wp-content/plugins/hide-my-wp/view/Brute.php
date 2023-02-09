<div id="hmwp_wrap" class="d-flex flex-row my-3 bg-light">
    <?php echo $view->getAdminTabs(HMWP_Classes_Tools::getValue('tab', 'hmwp_permalinks')); ?>
    <div class="hmwp_row d-flex flex-row bg-white px-3">
        <div class="hmwp_col flex-grow-1 mr-3">
            <form method="POST">
                <?php wp_nonce_field('hmwp_brutesettings', 'hmwp_nonce') ?>
                <input type="hidden" name="action" value="hmwp_brutesettings"/>

                <div class="card p-0 col-sm-12 tab-panel">
                    <div class="card-body">
                        <div class="col-sm-12 row mb-1 py-3 mx-2 ">
                            <div class="checker col-sm-12 row my-2 py-1">
                                <div class="col-sm-12 p-0 switch switch-sm">
                                    <input type="checkbox" id="hmwp_bruteforce" name="hmwp_bruteforce" class="switch" <?php echo(HMWP_Classes_Tools::getOption('hmwp_bruteforce') ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="hmwp_bruteforce"><?php _e('Use Brute Force Protection', _HMWP_PLUGIN_NAME_); ?></label>
                                    <a href="https://hidemywpghost.com/kb/brute-force-attack-protection/#activate_brute_force" target="_blank" class="d-inline-block ml-2" ><i class="fa fa-question-circle"></i></a>
                                    <div class="offset-1 text-black-50"><?php _e('Protects your website against brute force login attacks', _HMWP_PLUGIN_NAME_); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="hmwp_brute_enabled" <?php echo(!HMWP_Classes_Tools::getOption('hmwp_bruteforce') ? 'style="display:none"' : '') ?> >

                            <div class="border-top"></div>
                            <input type="hidden" value="<?php echo(HMWP_Classes_Tools::getOption('brute_use_math') ? '1' : '0') ?>" name="brute_use_math">
                            <input type="hidden" value="<?php echo(HMWP_Classes_Tools::getOption('brute_use_captcha') ? '1' : '0') ?>" name="brute_use_captcha">

                            <div class="col-sm-12 group_autoload d-flex justify-content-center btn-group mt-3" role="group" data-toggle="button">
                                <button type="button" class="btn btn-lg btn-outline-info brute_use_math m-1 py-3 px-4 <?php echo(HMWP_Classes_Tools::getOption('brute_use_math') ? 'active' : '') ?>"><?php _e('Math Check protection', _HMWP_PLUGIN_NAME_); ?></button>
                                <button type="button" class="btn btn-lg btn-outline-info brute_use_captcha m-1 py-3 px-4 <?php echo(HMWP_Classes_Tools::getOption('brute_use_captcha') ? 'active' : '') ?>"><?php echo __("reCAPTCHA protection", _HMWP_PLUGIN_NAME_) ?></button>
                            </div>

                            <script>
                                (function ($) {
                                    $(document).ready(function () {
                                        $("button.brute_use_math").on('click', function () {
                                            $('input[name=brute_use_math]').val(1);
                                            $('input[name=brute_use_captcha]').val(0);
                                            $('.group_autoload button').removeClass('active');

                                            $('.tab-panel.brute_use_math').show();
                                            $('.tab-panel.brute_use_captcha').hide();
                                        });
                                        $("button.brute_use_captcha").on('click', function () {
                                            $('input[name=brute_use_captcha]').val(1);
                                            $('input[name=brute_use_math]').val(0);
                                            $('.group_autoload button').removeClass('active');

                                            $('.tab-panel.brute_use_captcha').show();
                                            $('.tab-panel.brute_use_math').hide();
                                        });
                                    });
                                })(jQuery);
                            </script>
                            <div class="tab-panel brute_use_math" <?php echo(!HMWP_Classes_Tools::getOption('brute_use_math') ? 'style="display:none"' : '') ?>>
                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-md-4 p-0 font-weight-bold">
                                        <?php _e('Max fail attempts', _HMWP_PLUGIN_NAME_); ?>:
                                        <div class="small text-black-50"><?php _e('Block IP on login page', _HMWP_PLUGIN_NAME_); ?></div>
                                    </div>
                                    <div class="col-md-2 p-0 input-group">
                                        <input type="text" class="form-control bg-input" name="brute_max_attempts" value="<?php echo HMWP_Classes_Tools::getOption('brute_max_attempts') ?>"/>
                                    </div>
                                </div>
                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-md-4 p-0 font-weight-bold">
                                        <?php _e('Ban duration', _HMWP_PLUGIN_NAME_); ?>:
                                        <div class="small text-black-50"><?php _e('No. of seconds', _HMWP_PLUGIN_NAME_); ?></div>
                                    </div>
                                    <div class="col-md-2 p-0 input-group input-group">
                                        <input type="text" class="form-control bg-input" name="brute_max_timeout" value="<?php echo HMWP_Classes_Tools::getOption('brute_max_timeout') ?>"/>
                                    </div>
                                </div>
                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-md-4 p-0 font-weight-bold">
                                        <?php _e('Lockout Message', _HMWP_PLUGIN_NAME_); ?>:
                                        <div class="small text-black-50"><?php _e('Show message instead of login form', _HMWP_PLUGIN_NAME_); ?></div>
                                    </div>
                                    <div class="col-md-8 p-0 input-group input-group">
                                        <textarea type="text" class="form-control bg-input" name="hmwp_brute_message" style="height: 80px"><?php echo HMWP_Classes_Tools::getOption('hmwp_brute_message') ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-panel brute_use_captcha" <?php echo(!HMWP_Classes_Tools::getOption('brute_use_captcha') ? 'style="display:none"' : '') ?>>
                                <div class="col-sm-12 text-center border-bottom border-light py-3 mx-0 my-3">
                                    <?php echo sprintf(__("%sClick here%s to create or view keys for Google reCAPTCHA v2.", _HMWP_PLUGIN_NAME_), '<a href="https://www.google.com/recaptcha/admin#list" class="mx-1 text-link font-weight-bold text-uppercase" target="_blank">', '</a>'); ?>
                                </div>
                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-md-4 p-0 font-weight-bold">
                                        <?php _e('Site key', _HMWP_PLUGIN_NAME_); ?>:
                                        <div class="small text-black-50"><?php echo sprintf(__("Site keys for %sGoogle reCaptcha%s.", _HMWP_PLUGIN_NAME_), '<a href="https://www.google.com/recaptcha/admin#list" class="text-link" target="_blank">', '</a>'); ?></div>
                                    </div>
                                    <div class="col-md-8 p-0 input-group">
                                        <input type="text" class="form-control bg-input" name="brute_captcha_site_key" value="<?php echo HMWP_Classes_Tools::getOption('brute_captcha_site_key') ?>"/>
                                    </div>
                                </div>
                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-md-4 p-0 font-weight-bold">
                                        <?php _e('Secret Key', _HMWP_PLUGIN_NAME_); ?>:
                                        <div class="small text-black-50"><?php echo sprintf(__("Secret keys for %sGoogle reCAPTCHA%s.", _HMWP_PLUGIN_NAME_), '<a href="https://www.google.com/recaptcha/admin#list" class="text-link" target="_blank">', '</a>'); ?></div>
                                    </div>
                                    <div class="col-md-8 p-0 input-group">
                                        <input type="text" class="form-control bg-input" name="brute_captcha_secret_key" value="<?php echo HMWP_Classes_Tools::getOption('brute_captcha_secret_key') ?>"/>
                                    </div>
                                </div>
                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-sm-4 p-1">
                                        <div class="font-weight-bold"><?php _e('reCaptcha Theme', _HMWP_PLUGIN_NAME_); ?>:</div>
                                    </div>
                                    <div class="col-sm-8 p-0 input-group">
                                        <select name="brute_captcha_theme" class="form-control bg-input mb-1">
                                            <?php
                                            $themes = array(__('light', _HMWP_PLUGIN_NAME_), __('dark', _HMWP_PLUGIN_NAME_));
                                            foreach ($themes as $theme) {
                                                echo '<option value="' . $theme . '" ' . selected($theme, HMWP_Classes_Tools::getOption('brute_captcha_theme'), true) . '>' . ucfirst($theme) . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-sm-4 p-1">
                                        <div class="font-weight-bold"><?php _e('reCaptcha Language', _HMWP_PLUGIN_NAME_); ?>:</div>
                                    </div>
                                    <div class="col-sm-8 p-0 input-group">
                                        <select name="brute_captcha_language" class="form-control bg-input mb-1">
                                            <?php
                                            $languages = array(
                                                __('Auto Detect', _HMWP_PLUGIN_NAME_) => '',
                                                __('English', _HMWP_PLUGIN_NAME_) => 'en',
                                                __('Arabic', _HMWP_PLUGIN_NAME_) => 'ar',
                                                __('Bulgarian', _HMWP_PLUGIN_NAME_) => 'bg',
                                                __('Catalan Valencian', _HMWP_PLUGIN_NAME_) => 'ca',
                                                __('Czech', _HMWP_PLUGIN_NAME_) => 'cs',
                                                __('Danish', _HMWP_PLUGIN_NAME_) => 'da',
                                                __('German', _HMWP_PLUGIN_NAME_) => 'de',
                                                __('Greek', _HMWP_PLUGIN_NAME_) => 'el',
                                                __('British English', _HMWP_PLUGIN_NAME_) => 'en_gb',
                                                __('Spanish', _HMWP_PLUGIN_NAME_) => 'es',
                                                __('Persian', _HMWP_PLUGIN_NAME_) => 'fa',
                                                __('French', _HMWP_PLUGIN_NAME_) => 'fr',
                                                __('Canadian French', _HMWP_PLUGIN_NAME_) => 'fr_ca',
                                                __('Hindi', _HMWP_PLUGIN_NAME_) => 'hi',
                                                __('Croatian', _HMWP_PLUGIN_NAME_) => 'hr',
                                                __('Hungarian', _HMWP_PLUGIN_NAME_) => 'hu',
                                                __('Indonesian', _HMWP_PLUGIN_NAME_) => 'id',
                                                __('Italian', _HMWP_PLUGIN_NAME_) => 'it',
                                                __('Hebrew', _HMWP_PLUGIN_NAME_) => 'iw',
                                                __('Jananese', _HMWP_PLUGIN_NAME_) => 'ja',
                                                __('Korean', _HMWP_PLUGIN_NAME_) => 'ko',
                                                __('Lithuanian', _HMWP_PLUGIN_NAME_) => 'lt',
                                                __('Latvian', _HMWP_PLUGIN_NAME_) => 'lv',
                                                __('Dutch', _HMWP_PLUGIN_NAME_) => 'nl',
                                                __('Norwegian', _HMWP_PLUGIN_NAME_) => 'no',
                                                __('Polish', _HMWP_PLUGIN_NAME_) => 'pl',
                                                __('Portuguese', _HMWP_PLUGIN_NAME_) => 'pt',
                                                __('Romanian', _HMWP_PLUGIN_NAME_) => 'ro',
                                                __('Russian', _HMWP_PLUGIN_NAME_) => 'ru',
                                                __('Slovak', _HMWP_PLUGIN_NAME_) => 'sk',
                                                __('Slovene', _HMWP_PLUGIN_NAME_) => 'sl',
                                                __('Serbian', _HMWP_PLUGIN_NAME_) => 'sr',
                                                __('Swedish', _HMWP_PLUGIN_NAME_) => 'sv',
                                                __('Thai', _HMWP_PLUGIN_NAME_) => 'th',
                                                __('Turkish', _HMWP_PLUGIN_NAME_) => 'tr',
                                                __('Ukrainian', _HMWP_PLUGIN_NAME_) => 'uk',
                                                __('Vietnamese', _HMWP_PLUGIN_NAME_) => 'vi',
                                                __('Simplified Chinese', _HMWP_PLUGIN_NAME_) => 'zh_cn',
                                                __('Traditional Chinese', _HMWP_PLUGIN_NAME_) => 'zh_tw'
                                            );
                                            foreach ($languages as $key => $language) {
                                                echo '<option value="' . $language . '"  ' . selected($language, HMWP_Classes_Tools::getOption('brute_captcha_language'), true) . '>' . ucfirst($key) . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 border-bottom border-light py-3 mx-0 my-3">
                                    <?php if (HMWP_Classes_Tools::getOption('brute_captcha_site_key') <> '' && HMWP_Classes_Tools::getOption('brute_captcha_secret_key') <> '') { ?>
                                        <button type="button" class="btn btn-lg btn-success brute_recaptcha_test" data-remote="<?php echo site_url('wp-login.php') ?>" data-target="#brute_recaptcha_modal" data-toggle="modal"><?php _e('reCAPTCHA Test', _HMWP_PLUGIN_NAME_); ?></button>

                                        <h4 class="mt-5 mb-3"><?php _e('Next Steps', _HMWP_PLUGIN_NAME_); ?></h4>
                                        <ol>
                                            <li><?php echo sprintf(__("Run %sreCAPTCHA Test%s and login inside the popup. ", _HMWP_PLUGIN_NAME_), '<strong>', '</strong>'); ?></li>
                                            <li><?php _e("If you're able to login, you've set reCAPTCHA correctly.", _HMWP_PLUGIN_NAME_); ?></li>
                                            <li><?php _e('If the reCAPTCHA displays any error, please make sure you fix them before moving forward.', _HMWP_PLUGIN_NAME_); ?></li>
                                            <li><?php _e('Do not logout from this browser until you are confident that reCAPTCHA is working and you will be able to login again.', _HMWP_PLUGIN_NAME_); ?></li>
                                            <li><?php _e("If you can't configure reCAPTCHA, switch to Math Check protection", _HMWP_PLUGIN_NAME_); ?></li>
                                        </ol>

                                        <div class="modal fade" id="brute_recaptcha_modal" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><?php _e('reCAPTCHA Test', _HMWP_PLUGIN_NAME_); ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <iframe class="modal-body" style="min-height: 500px;"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            (function ($) {
                                                $('button.brute_recaptcha_test').on('click', function () {
                                                    $($(this).data("target") + ' .modal-body').attr('src', $(this).data("remote"));
                                                });
                                            })(jQuery);

                                        </script>
                                    <?php } ?>
                                </div>

                            </div>
                            <div class="border-top">
                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-md-4 p-0 font-weight-bold">
                                        <?php _e('Whitelist IPs', _HMWP_PLUGIN_NAME_); ?>:
                                        <a href="https://hidemywpghost.com/kb/brute-force-attack-protection/#whitelist_ip_address" target="_blank" class="d-inline-block ml-2" ><i class="fa fa-question-circle"></i></a>
                                        <div class="small text-black-50"><?php echo sprintf(__('You can white-list a single IP like 192.168.0.1 or a range of 245 IPs like 192.168.0.*. Find your IP with %s', _HMWP_PLUGIN_NAME_), '<a href="https://whatismyipaddress.com/" target="_blank">https://whatismyipaddress.com/</a>') ?></div>
                                    </div>
                                    <div class="col-md-8 p-0 input-group input-group">
                                        <?php
                                        $ips = array();
                                        if (HMWP_Classes_Tools::getOption('whitelist_ip')) {
                                            $ips = json_decode(HMWP_Classes_Tools::getOption('whitelist_ip'), true);
                                        }
                                        ?>
                                        <textarea type="text" class="form-control bg-input" name="whitelist_ip" style="height: 100px"><?php echo(!empty($ips) ? implode(PHP_EOL, $ips) : '') ?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12 row border-bottom border-light py-3 mx-0 my-3">
                                    <div class="col-md-4 p-0 font-weight-bold">
                                        <?php _e('Ban IPs', _HMWP_PLUGIN_NAME_); ?>:
                                        <a href="https://hidemywpghost.com/kb/brute-force-attack-protection/#ban_ip_address" target="_blank" class="d-inline-block ml-2" ><i class="fa fa-question-circle"></i></a>
                                        <div class="small text-black-50"><?php echo __('You can ban a single IP like 192.168.0.1 or a range of 245 IPs like 192.168.0.*. These IPs will not be able to access the login page.', _HMWP_PLUGIN_NAME_) ?></div>
                                    </div>
                                    <div class="col-md-8 p-0 input-group input-group">
                                        <?php
                                        $ips = array();
                                        if (HMWP_Classes_Tools::getOption('banlist_ip')) {
                                            $ips = json_decode(HMWP_Classes_Tools::getOption('banlist_ip'), true);
                                        }
                                        ?>
                                        <textarea type="text" class="form-control bg-input" name="banlist_ip" style="height: 100px"><?php echo(!empty($ips) ? implode(PHP_EOL, $ips) : '') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-sm-12 m-0 p-2 bg-light text-center" style="position: fixed; bottom: 0; right: 0; z-index: 100; box-shadow: 0px 0px 8px -3px #444;">
                    <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mr-5 save"><?php _e( 'Save', _HMWP_PLUGIN_NAME_ ); ?></button>
                    <a href="https://wordpress.org/support/plugin/hide-my-wp/reviews/?rate=5#new-post" target="_blank"><?php echo sprintf( __( 'Love Hide My WP %s? Show us ;)', _HMWP_PLUGIN_NAME_ ), _HMWP_VER_NAME_ ); ?></a>
                </div>
            </form>

            <div class="card p-0 col-sm-12 tab-panel">
                <div class="card-body">
                    <h3 class="card-title"><?php _e('Blocked IPs', _HMWP_PLUGIN_NAME_); ?>:</h3>
                    <div class="mt-3 mb-1" style="display: block;">
                        <div class="float-right py-1">
                            <form method="POST">
                                <?php wp_nonce_field('hmwp_deleteallips', 'hmwp_nonce') ?>
                                <input type="hidden" name="action" value="hmwp_deleteallips"/>
                                <button type="submit" class="btn rounded-0 btn-light save py-0"><?php _e('Unlock all', _HMWP_PLUGIN_NAME_); ?></button>
                            </form>
                        </div>
                        <div id="hmwp_blockedips" class="col-sm-12 p-0"></div>
                    </div>
                </div>
            </div>
            <?php echo '<script>var hmwpQuery = {"ajaxurl": "' . admin_url('admin-ajax.php') . '","nonce": "' . wp_create_nonce(_HMWP_NONCE_ID_) . '"}</script>'; ?>
        </div>
        <div class="hmwp_col hmwp_col_side">
            <div class="card col-sm-12 p-0">
                <div class="card-body f-gray-dark text-left border-bottom">
                    <h3 class="card-title"><?php _e('Brute Force Login Protection', _HMWP_PLUGIN_NAME_); ?></h3>
                    <div class="text-info"><?php echo __("Protects your website against brute force login attacks using Hide My WP <br /><br /> A common threat web developers face is a password-guessing attack known as a brute force attack. A brute-force attack is an attempt to discover a password by systematically trying every possible combination of letters, numbers, and symbols until you discover the one correct combination that works. ", _HMWP_PLUGIN_NAME_); ?>
                    </div>
                </div>
            </div>
            <div class="card col-sm-12 p-0">
                <div class="card-body f-gray-dark text-left border-bottom">
                    <h3 class="card-title"><?php _e('Features', _HMWP_PLUGIN_NAME_); ?></h3>
                    <ul class="text-info" style="margin-left: 16px; list-style: circle;">
                        <li><?php echo __("Limit the number of allowed login attempts using normal login form", _HMWP_PLUGIN_NAME_); ?></li>
                        <li><?php echo __("Math problem verification while logging in", _HMWP_PLUGIN_NAME_); ?></li>
                        <li><?php echo __("Manually block/unblock IP addresses", _HMWP_PLUGIN_NAME_); ?></li>
                        <li><?php echo __("Manually whitelist trusted IP addresses", _HMWP_PLUGIN_NAME_); ?></li>
                        <li><?php echo __("Option to inform user about remaining attempts on login page", _HMWP_PLUGIN_NAME_); ?></li>
                        <li><?php echo __("Custom message to show to blocked users", _HMWP_PLUGIN_NAME_); ?></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
