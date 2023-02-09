<?php

if(!defined('ABSPATH')) exit; 

    $banner= get_field( 'banner_3'); ?>

    <div class="section banner">

        <div class="clip-wrapper">

            <div class="bg-image" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/Rectangle.png);">

            </div>

        </div>

        <div class="svg-element counter-wrapper full-height countEnd">

            <svg version="1.1" width="100%" height="120px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none">

                <polygon fill="#ffffff" points="0,100 -10,20  50,0 110,20 100,100"></polygon>

            </svg>

        </div>

        <div class="container-fluid padding">

            <div class="row padding">

                <div class="col-lg-12 padding">

                    <div class="banner-content type4">

                        <div class="banner-content-cell">

                            <div class="big-title"><?php the_title(); ?></div>

                            <?php if( $banner['title'] ): ?>

                                <h1 class="h1"><?php echo $banner['title']; ?></h1>

                            <?php endif; ?>

                            <div class="banner-content-logos type2">
                            <?php
                               
                               if(!empty($banner['logos']['jamesway_logo']['url'] )):
                                ?>
                                   <img src="<?php echo esc_url($banner['logos']['jamesway_logo']['url'])?>" alt="<?php echo esc_attr($banner['logos']['jamesway_logo']['alt'])?>">
                               <?php endif;?>
                               
                               <?php
                               
                               if(!empty($banner['logos']['chick_master_logo']['url'] )):
                                ?>
                                   <img src="<?php echo esc_url($banner['logos']['chick_master_logo']['url'])?>" alt="<?php echo esc_attr($banner['logos']['chick_master_logo']['alt'])?>">
                               <?php endif;?>
                               <?php 
                            //    <img src="http://jamesway-stg.itwdev.info/wp-content/uploads/2019/04/jamesway-mobile-logo-square.png" alt="">

                            //     <img src="http://jamesway-stg.itwdev.info/wp-content/uploads/2021/11/chick-master-logo.png" alt="">

                                ?>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="section">

        <div class="container-fluid padding">

            <div class="row">

                <div class="col-md-5 col-sm-12 col-xs-12">

                    <div class="simple-article type8">

                        <?php if( $banner['subtitle'] ): ?>

                            <div class="title type2 h5"><?php echo $banner['subtitle']; ?></div>

                        <?php endif; 

                        if( $banner['text'] ): ?>

                            <div class="empty-lg-30"></div>

                            <?php echo wp_kses_post( $banner['text'] ); ?>

                        <?php endif; 

                        if( $banner['link']['link'] && $banner['link']['link_title'] ): ?>

                            <a href="<?php echo esc_url( $banner['link']['link'] ); ?>"><?php echo $banner['link']['link_title']; ?></a>

                        <?php endif; ?>

                    </div>

                </div>

                <div class="col-md-7 col-sm-12 col-xs-12">

                    <div class="general-info type3">

                        <div class="img" style="background-image: url(<?php echo esc_url( $banner['image'] ? $banner['image']['url'] : '' ); ?>);"></div>

                    </div>

                </div>

                <?php if( $banner['action']['title'] || ( $banner['action']['link'] && $banner['action']['link_title'] ) ): ?>

                    <div class="col-xs-12">

                        <div class="request-block type2" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/decor-egg-blue2.svg);">

                            <?php if( $banner['action']['title'] ): ?>

                               <div class="title h5"><?php echo $banner['action']['title']; ?></div>

                            <?php endif;

                            if( $banner['action']['link_title'] && $banner['action']['link'] ): ?>

                                <a href="<?php echo esc_url( $banner['action']['link'] ); ?>" class="button"><?php echo $banner['action']['link_title']; ?></a>

                            <?php endif; ?>

                        </div>                        

                    </div>

                <?php endif; ?>

            </div>

        </div>

        <div class="space-lg"></div>            

    </div>