(function ($) {
    "use strict";

    $.fn.hmwp_loading = function (state) {
        var $this = this;
        var loading = '<i class="fa fa-circle-o-notch fa-spin mr-1 hmwp_loading"></i>';
        $this.find('i').remove();
        if (state) {
            $this.prepend(loading);
        } else {
            $('.hmwp_loading').remove();
        }

        return $this;
    };

    $.fn.hmwp_fixSettings = function (name, value) {
        var $div = $('#hmwp_wrap');
        var $this = this;
        $this.hmwp_loading(true);
        $.post(
            hmwpQuery.ajaxurl,
            {
                action: 'hmwp_fixsettings',
                name: name,
                value: value,
                hmwp_nonce: hmwpQuery.nonce
            }
        ).done(function (response) {
            $this.hmwp_loading(false);
            if (typeof response.success !== 'undefined' && typeof response.message !== 'undefined') {
                if (response.success) {
                    $div.prepend('<div class="fixed-top mt-4 pt-4 alert alert-success text-center hmwp_alert" role="alert"><strong>' + response.message + '</strong></div>');
                    $this.hide();
                } else {
                    $div.prepend('<div class="fixed-top mt-4 pt-4 alert alert-danger text-center hmwp_alert" role="alert"><strong>' + response.message + '</strong></div>');
                }
            }
            setTimeout(function () {
                $('.hmwp_alert').remove();
            }, 5000)
        }).error(function () {
            $this.hmwp_loading(false);
            $div.prepend('<div class="fixed-top mt-4 pt-4 alert alert-danger text-center hmwp_alert" role="alert"><strong>Ajax Error.</strong></div>');
            setTimeout(function () {
                $('.hmwp_alert').remove();
            }, 5000)
        }, 'json');
    };

    $.fn.hmwp_fixConfig = function (name, value) {
        var $div = $('#hmwp_wrap');
        var $this = this;
        $this.hmwp_loading(true);
        $.post(
            hmwpQuery.ajaxurl,
            {
                action: 'hmwp_fixconfig',
                name: name,
                value: value,
                hmwp_nonce: hmwpQuery.nonce
            }
        ).done(function (response) {
            $this.hmwp_loading(false);
            if (typeof response.success !== 'undefined' && typeof response.message !== 'undefined') {
                if (response.success) {
                    $div.prepend('<div class="fixed-top mt-4 pt-4 alert alert-success text-center hmwp_alert" role="alert"><strong>' + response.message + '</strong></div>');
                    $this.hide();
                } else {
                    $div.prepend('<div class="fixed-top mt-4 pt-4 alert alert-danger text-center hmwp_alert" role="alert"><strong>' + response.message + '</strong></div>');
                }
            }
            setTimeout(function () {
                $('.hmwp_alert').remove();
            }, 5000)
        }).error(function () {
            $this.hmwp_loading(false);
            $div.prepend('<div class="fixed-top mt-4 pt-4 alert alert-danger text-center hmwp_alert" role="alert"><strong>Ajax Error.</strong></div>');
            setTimeout(function () {
                $('.hmwp_alert').remove();
            }, 5000)
        }, 'json');
    };

    $.fn.hmwp_changePaths = function (name, value) {
        var $this = this;
        $this.hmwp_loading(true);
        $.post(
            hmwpQuery.ajaxurl,
            {
                action: 'hmwp_changepathsincache',
                hmwp_nonce: hmwpQuery.nonce
            }
        ).done(function (response) {
            $this.hmwp_loading(false);
        }).error(function () {
            $this.hmwp_loading(false);
        }, 'json');
    };

    $.fn.hmwp_securityExclude = function (name) {
        var $div = $('#hmwp_wrap');
        var $this = this;
        $.post(
            hmwpQuery.ajaxurl,
            {
                action: 'hmwp_securityexclude',
                name: name,
                hmwp_nonce: hmwpQuery.nonce
            }
        ).done(function (response) {
            if (typeof response.success !== 'undefined' && typeof response.message !== 'undefined') {
                if (response.success) {
                    $this.parents('tr:last').fadeOut();
                    $div.prepend('<div class="fixed-top mt-4 pt-4 alert alert-success text-center hmwp_alert" role="alert"><strong>' + response.message + '</strong></div>');
                } else {
                    $div.prepend('<div class="fixed-top mt-4 pt-4 alert alert-danger text-center hmwp_alert" role="alert"><strong>' + response.message + '</strong></div>');
                }
            }
            setTimeout(function () {
                $('.hmwp_alert').remove();
            }, 5000)
        }).error(function () {
            $div.prepend('<div class="fixed-top mt-4 pt-4 alert alert-danger text-center hmwp_alert" role="alert"><strong>Ajax Error.</strong></div>');
            setTimeout(function () {
                $('.hmwp_alert').remove();
            }, 5000)
        }, 'json');
    };


    $.fn.hmwp_settingsListen = function () {
        var $this = this;

        $this.find('input[name=hmwp_admin_url]').on('keyup', function () {
            if ($(this).val() !== 'wp-admin' && $(this).val() != '') {
                //hmwp_hide_newadmin
                $this.find('.admin_warning').show();
                $this.find('.hmwp_hide_newadmin_div').show();
            } else {
                $this.find('.admin_warning').hide();
                $this.find('.hmwp_hide_newadmin_div').hide();
            }
        });

        $this.find('input[name=hmwp_login_url]').on('keyup', function () {
            if ($(this).val() !== 'wp-login.php'  && $(this).val() != '') {
                $this.find('.hmwp_hide_wplogin_div').show();
            } else {
                $this.find('.hmwp_hide_wplogin_div').hide();
            }

            if ($(this).val() !== 'login'  && $(this).val() != '') {
                $this.find('.hmwp_hide_login_div').show();
            } else {
                $this.find('.hmwp_hide_login_div').hide();
            }
        });

        $this.find('input[name=hmwp_login_url]').trigger('keyup');


        $this.find("input[name=hmwp_hide_admin].switch").change(function () {
            if ($(this).prop('checked')) {
                $this.find('.wp-admin_warning').show();
                $this.find('.hmwp_hide_newadmin_div').show();
            } else {
                $this.find('.wp-admin_warning').hide();
                $this.find('.hmwp_hide_newadmin_div').hide();
            }
        });


        $this.find("input[name=hmwp_hide_oldpaths].switch").change(function () {
            if ($(this).prop('checked')) {
                $this.find('.hmwp_hide_oldpaths_div').show();
            } else {
                $this.find('.hmwp_hide_oldpaths_div').hide();
            }
        });

        if (!$this.find("input[name=hmwp_hide_oldpaths].switch").prop('checked')){
            $this.find('.hmwp_hide_oldpaths_div').hide();
        }


        $this.find('select[name=hmwp_mode]').on('change', function () {
            $this.find('.tab-panel').hide();
            $this.find('.hmwp_' + $(this).val()).show();
        });


        $this.find("input[name=hmwp_bruteforce].switch").change(function () {
            if ($(this).prop('checked')) {
                $this.find('.hmwp_brute_enabled').show();
            } else {
                $this.find('.hmwp_brute_enabled').hide();
            }
        });

        if ($this.find('#hmwp_blockedips').length > 0) {
            $.post(
                hmwpQuery.ajaxurl,
                {
                    action: 'hmwp_blockedips',
                    hmwp_nonce: hmwpQuery.nonce
                }
            ).done(function (response) {
                if (typeof response.data !== 'undefined') {
                    $('#hmwp_blockedips').html(response.data);
                }
            }).error(function () {
                $('#hmwp_blockedips').html('no blocked ips');
            }, 'json');
        }

        $this.find('.start_securitycheck').find('button').on('click', function () {
            var $div = $this.find('.start_securitycheck');
            $div.after('<div class="wp_loading"></div>');
            $div.hide();
            $.post(
                hmwpQuery.ajaxurl,
                {
                    action: 'hmwp_securitycheck',
                    hmwp_nonce: hmwpQuery.nonce
                }
            ).done(function (response) {
                location.reload();
            }).error(function () {
                location.reload();
            });
            return false;
        });

        $this.find('button.hmwp_resetexclude').on('click', function () {
            var $div = $this.find('.start_securitycheck');
            $.post(
                hmwpQuery.ajaxurl,
                {
                    action: 'hmwp_resetexclude',
                    hmwp_nonce: hmwpQuery.nonce
                }
            ).done(function (response) {
                if (typeof response.success !== 'undefined' && typeof response.message !== 'undefined') {
                    if (response.success) {
                        $div.prepend('<div class="fixed-top mt-4 pt-4 alert alert-success text-center hmwp_alert" role="alert"><strong>' + response.message + '</strong></div>');
                    } else {
                        $div.prepend('<div class="fixed-top mt-4 pt-4 alert alert-danger text-center hmwp_alert" role="alert"><strong>' + response.message + '</strong></div>');
                    }
                }
                setTimeout(function () {
                    $('.hmwp_alert').remove();
                }, 5000)
            }).error(function () {
                $div.prepend('<div class="fixed-top mt-4 pt-4 alert alert-danger text-center hmwp_alert" role="alert"><strong>Ajax Error.</strong></div>');
                setTimeout(function () {
                    $('.hmwp_alert').remove();
                }, 5000)
            });
            return false;
        });


        $this.find('.hmwp_plugin_install').on('click', function () {
            var button = $(this);
            button.hmwp_loading(true);
            $.post(
                hmwpQuery.ajaxurl,
                {
                    action: 'hmwp_plugin_install',
                    plugin: button.data('plugin'),
                    hmwp_nonce: hmwpQuery.nonce
                }
            ).done(function (response) {
                if (typeof response.success !== 'undefined' && response.success) {
                    location.reload();
                } else {
                    button.hmwp_loading(false);
                    button.html("Error.. Try again");
                }
            }).error(function () {
                button.removeClass('wp_loading');
                button.after('<div class="text-danger m-2">Could not install the plugin.</div>');
            });
        });

        $('#frontend_test_modal').on('hidden.bs.modal', function () {
            $('button.frontend_test').hmwp_loading(true);
            location.reload();
        })
    };

    $(document).ready(function () {
        $('#hmwp_wrap').hmwp_settingsListen();
    });
})(jQuery);




