<?php if (!defined('ABSPATH')) exit;

$content_slider = get_sub_field('content-slider');

$title = $content_slider['title'];
$button_text = $content_slider['button_text'];
$button_url = $content_slider['button_url'];
$slider_items = $content_slider['slider_items'];

if (!empty($slider_items)) { ?>
    <div class="section margin our-services">
        <div class="space-lg"></div>
        <div class="services-block-title">
            <?php if (!empty($title)) { ?>
                <div class="block-title">
                    <h4 class="h4"><?php echo wp_kses_post($title); ?></h4>
                </div>
            <?php } ?>
            <?php if (!empty($button_text) && !empty($button_url)) { ?>
                <a href="<?php echo esc_url($button_url); ?>" class="button type3"><?php echo esc_html($button_text); ?></a>
            <?php } ?>
        </div>

        <div class="empty-lg-20"></div>

        <div class="container-fluid">
            <div class="row vert-align">
                <div class="col-lg-12 col-xs-12">
                    <div class="swiper-main-wrapper change-pagination services-slider">
                        <div class="swiper-container swiper-content" data-breakpoints="1" data-slides-per-view="4"
                             data-space="50" data-lg-slides="3" data-md-slides="2" data-sm-slides="2" data-xs-slides="1"
                             data-pagination-type="progress">
                            <div class="swiper-wrapper">
                                <?php foreach ($slider_items as $slide) {
                                    $slider_type = $slide['slider_type'];
                                    $date = $slide['date'];
                                    $title = $slide['title'];
                                    $image = $slide['image'];
                                    $url = $slide['url'];
                                    $slider_style = $slide['slider_style'];
                                    if (!empty($title)) {?>
                                        <div class="swiper-slide">
                                            <?php if (!empty($url)) { ?>
                                                <a href="#" class="img-wrapper slide-item">
                                            <?php } else { ?>
                                                <div class="img-wrapper slide-item">
                                            <?php } ?>
                                                <div class="img-item">
                                                    <?php if ($slider_type == 'no_image') { ?>
                                                        <div class="big-img" style="background-color: <?php echo $slider_style === 'blue' ? '#0f3f93' : '#D9DADA' ?>;">
                                                            <div class="service-info">
                                                                <?php if (!empty($date)) { ?>
                                                                    <div class="date <?php echo $slider_style === 'blue' ? 'yellow' : 'black' ?>"><?php echo esc_html($date); ?></div>
                                                                <?php } ?>
                                                                <div class="text <?php echo $slider_style === 'blue' ? 'white' : 'black' ?>"><?php echo wp_kses_post($title); ?></div>
                                                            </div>
                                                        </div>
                                                    <?php } else if ($slider_type == 'image') { ?>
                                                        <div class="big-img opacity" style="background-image: url(<?php echo THEME_URI; ?>/img/shadow.png), url(<?php echo $image['url'] ?? ''; ?>);">
                                                            <div class="service-info">
                                                                <?php if (!empty($date)) { ?>
                                                                    <div class="date white"><?php echo esc_html($date); ?></div>
                                                                <?php } ?>
                                                                <div class="title"><?php echo wp_kses_post($title); ?></div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                            <?php if (!empty($url)) { ?>
                                                </a>
                                            <?php } else { ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                <?php } 
                                } ?>
                            </div>
                        </div>
                        <div class="swiper-navigation progressbar type1">
                            <div class="swiper-button-prev custom-arrow-prev"></div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next custom-arrow-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-lg"></div>
    </div>
<?php }
