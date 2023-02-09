<?php if(!defined('ABSPATH')) exit;
	$carousel_type  = get_sub_field( 'type' );
	$carousel 	    = get_sub_field( 'carousel' );
	$carousel_title = get_sub_field( 'title' );
	$carousel_text  = get_sub_field( 'text' ); ?>
		<div class="section">
            <div class="space-lg"></div>
            <div class="container-fluid padding">
                <div class="row vert-align">
                	<?php if( $carousel_title || $carousel_text ): ?>
	                    <div class="<?php echo esc_attr( !$carousel ? 'col-lg-12' : 'col-lg-4'.( $carousel_type == 1 ? ' col-lg-push-8' : '' ) ); ?> col-md-12 col-sm-12 col-xs-12">
	                        <div class="simple-article type4 career-block">
	                        	<?php if( $carousel_title ): ?>
		                            <div class="title type2 h3"><?php echo $carousel_title; ?></div>
		                        <?php endif; 
		                        if( $carousel_text ): ?>
		                            <div class="empty-lg-20"></div>
		                            <?php echo wp_kses_post( $carousel_text ); ?>
		                        <?php endif; ?>
	                        </div>
	                    </div>
	                <?php endif; 
	                if( $carousel ): ?>
	                    <div class="<?php echo esc_attr( !$carousel_title && !$carousel_text ? 'col-lg-12' : 'col-lg-8'.( $carousel_type == 1 ? ' col-lg-pull-4' : '' ) ); ?> col-md-12 col-sm-12 col-xs-12">
	                        <div class="swiper-main-wrapper accessories-swiper type2 change-pagination">
	                            <div class="swiper-container swiper-content" data-breakpoints="1" data-slides-per-view="2" data-lg-slides="2" data-md-slides="2" data-sm-slides="2" data-xs-slides="1" data-pagination-type="progress">
	                                <div class="swiper-wrapper">
	                                	<?php foreach( $carousel as $car ): ?>
		                                    <div class="swiper-slide">
		                                        <div class="img-wrapper slide-item type2">
		                                            <div class="img-item">
		                                                <div class="big-img" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/shadow.png),  url(<?php echo esc_url( $car['url'] ); ?>);">
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                <?php endforeach; ?>
	                                </div>
	                            </div>
	                            <div class="swiper-navigation progressbar type1">
	                                <div class="swiper-button-prev custom-arrow-prev"></div>
	                                <div class="swiper-pagination"></div>
	                                <div class="swiper-button-next custom-arrow-next"></div>
	                            </div>
	                        </div>
	                    </div>
	                <?php endif; ?>
                </div>
            </div>
            <div class="space-lg"></div>           
        </div>