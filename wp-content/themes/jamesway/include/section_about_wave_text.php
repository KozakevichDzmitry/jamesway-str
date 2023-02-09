<?php if( !defined('ABSPATH') ) exit;
$about_wave_text_left = get_sub_field( 'about_wave_text_left' );
$about_wave_text_right = get_sub_field( 'about_wave_text_right' );
if( !empty($about_wave_text_left) || !empty($about_wave_text_right) ) : ?>
    <div class="section about-text" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/wave.svg);">
        <!--NEW SECTION ON ABOUT PAGE-->
        <div class="container-fluid">
            <div class="row">
                <?php if (!empty($about_wave_text_left['bg_title']) || !empty($about_wave_text_left['title']) || !empty($about_wave_text_left['text'])) { ?>
                    <div class="col-lg-4 col-lg-offset-2 col-md-6 col-12">
                        <div class="simple-content">
                            <?php if (!empty($about_wave_text_left['bg_title'])) { ?>
                                <div class="big-title"><?php echo wp_kses_post($about_wave_text_left['bg_title']); ?></div>
                            <?php } ?>
                            <?php if (!empty($about_wave_text_left['title'])) { ?>
                                <div class="title"><?php echo wp_kses_post($about_wave_text_left['title']); ?></div>
                            <?php } ?>
                            <?php if (!empty($about_wave_text_left['text'])) echo wp_kses_post($about_wave_text_left['text']); ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if (!empty($about_wave_text_right['bg_title']) || !empty($about_wave_text_right['title']) || !empty($about_wave_text_right['text'])) { ?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="simple-content">
                            <?php if (!empty($about_wave_text_right['bg_title'])) { ?>
                                <div class="big-title"><?php echo wp_kses_post($about_wave_text_right['bg_title']); ?></div>
                            <?php } ?>
                            <?php if (!empty($about_wave_text_right['title'])) { ?>
                                <div class="title"><?php echo wp_kses_post($about_wave_text_right['title']); ?></div>
                            <?php } ?>
                            <?php if (!empty($about_wave_text_right['text'])) echo wp_kses_post($about_wave_text_right['text']); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php endif;