<?php

if (!defined('ABSPATH')) exit;

$banner = get_field('banner_1');



if ($banner['banner_gallery']) : 
?>

    <div class="section banner 55">

        <div class="clip-wrapper">

            <div class="swiper-container swiper-no-swiping h-100" data-autoplay="3000" data-effect="fade">

                <div class="swiper-wrapper">

                   <!-- <div class="swiper-slide">

                           <div class="bg-image" style="background-image: url(<?php echo esc_url($banner['image'] ? $banner['image']['url'] : ''); ?>);">

                            <div class="shade"></div>

                          <?php if ($banner['video']) : ?>

                                <div class="video-position">

                                    <video autoplay="" loop="" muted="muted" controls="false">

                                        <source src="<?php echo esc_url($banner['video'] ? $banner['video']['url'] : ''); ?>" type="video/mp4">

                                    </video>

                                    <div class="close-video <?php echo (is_front_page()) ? 'hide' : ''; ?>">

                                        <span></span>

                                        <span></span>

                                    </div>

                                </div>

                            <?php endif; ?>

                        </div>

                    </div> -->
                    <?php 
                    foreach ($banner['banner_gallery'] as $banner_image):
                     
                    ?>           
                    <div class="swiper-slide">

                        <div class="bg-image" style="background-image: url('<?php echo $banner_image['url']; ?>');"></div>

                    </div>
                    <?php endforeach;?>
                 

                </div>

            </div>            

        </div>

        <div class="container-fluid padding">

            <div class="row padding">

                <div class="col-lg-12 padding">

                    <div class="banner-content banner-overflow">

                        <div class="banner-content-cell">

                            <div class="banner-content-wrapper">
                               
                            <?php if($banner['logos']['logos_position'] == 'abovetitle'):?>
                                        <div class="banner-content-logos">
                                        <?php
                                                                    
                                        if(!empty($banner['logos']['jamesway_logo']['url'] )):                                            
                                            $link_target1 = $banner['logos']['link_1']['target'] ? $banner['logos']['link_1']['target'] : '_self';
                                        ?>
                                           <a href="<?php echo $banner['logos']['link_1']["url"] ?>" target="<?php echo $link_target1?>"> <img src="<?php echo esc_url($banner['logos']['jamesway_logo']['url'])?>" alt="<?php echo esc_attr($banner['logos']['jamesway_logo']['alt'])?>"> </a>
                                        <?php endif;?>
                                        
                                        <?php
                                        
                                        if(!empty($banner['logos']['chick_master']['url'] )):
                                            $link_target2 = $banner['logos']['link_2']['target'] ? $banner['logos']['link_2']['target'] : '_self';
                                        ?>
                                           <a href="<?php echo $banner['logos']['link_2']["url"] ?>" target="<?php echo $link_target2?>"><img src="<?php echo esc_url($banner['logos']['chick_master']['url'])?>" alt="<?php echo esc_attr($banner['logos']['chick_master']['alt'])?>"> </a>
                                        <?php endif;?>


                                            <!-- <img src="http://jamesway-stg.itwdev.info/wp-content/uploads/2021/11/chick-master-logo.png" alt=""> -->

                                        </div>
                                <?php endif;?>
                                    
                                <?php if ($banner['title']) : ?>

                                    <h1 class="only-home-page"><?php echo wp_kses_post($banner['title']); ?></h1>

                                <?php endif; ?>


                                <?php if($banner['logos']['logos_position'] == 'undettitle'):?>
                                <?php
                               
                               if(!empty($banner['logos']['jamesway_logo']['url'] )):
                                $link_target1 = $banner['logos']['link_1']['target'] ? $banner['logos']['link_1']['target'] : '_self';
                                ?>
                                   <a href="<?php echo $banner['logos']['link_1']["url"] ?>" target="<?php echo $link_target1?>"> <img src="<?php echo esc_url($banner['logos']['jamesway_logo']['url'])?>" alt="<?php echo esc_attr($banner['logos']['jamesway_logo']['alt'])?>"> </a>
                                <?php endif;?>
                                
                                <?php
                                
                                if(!empty($banner['logos']['chick_master']['url'] )):
                                    $link_target2 = $banner['logos']['link_2']['target'] ? $banner['logos']['link_2']['target'] : '_self';
                                ?>
                                   <a href="<?php echo $banner['logos']['link_2']["url"] ?>" target="<?php echo $link_target2?>"><img src="<?php echo esc_url($banner['logos']['chick_master']['url'])?>" alt="<?php echo esc_attr($banner['logos']['chick_master']['alt'])?>"> </a>
                                <?php endif;?>


                                    <!-- <img src="http://jamesway-stg.itwdev.info/wp-content/uploads/2021/11/chick-master-logo.png" alt=""> -->

                                </div>
                                <?php endif;?>


                                <?php    if ($banner['subtitle'] || $banner['video']) : ?>

                                    <div class="empty-lg-40 empty-ds-30"></div>

                                    <div class="content">

                                        <?php if ($banner['subtitle']) : ?>

                                            <div class="size-l subtitle mobile-hide">

                                                <p class="p1"><?php echo wp_kses_post($banner['subtitle']); ?></p>

                                            </div>

                                        <?php endif;

                                                if ($banner['video']) : ?>

                                            <?php if ($banner['video_popup']) { ?>

                                                <div class="open-video video-button" data-src="https://www.youtube.com/embed/<?php echo esc_attr($banner['video_popup']); ?>?feature=oembed&autoplay=1&rel=0&showinfo=0">

                                                <?php } else { ?>

                                                    <div class="video-button">

                                                    <?php } ?>

                                                    <div class="img">

                                                        <div class="triangle"></div>

                                                    </div>

                                                    <?php if ($banner['video_title']) : ?>

                                                        <div class="text"><?php echo $banner['video_title']; ?></div>

                                                    <?php endif; ?>

                                                    </div>

                                                <?php endif; ?>



                                                </div>

                                            <?php endif; ?>

                                    </div>

                            </div>

                            <div class="egg-bg">

                                <span class="egg-wrap">

                                    <i></i>

                                    <i></i>

                                    <img src="<?php echo THEME_URI; ?>/assets/img/banner-egg.svg" alt="" />

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    <?php else :

        echo '<div class="space-lg"></div>';

    endif;

