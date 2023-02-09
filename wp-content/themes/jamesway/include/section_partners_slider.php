<?php if(!defined('ABSPATH')) exit;

	$partners_title  = get_sub_field( 'partners_title' );

	$partners_slider = get_sub_field( 'partners_slider' );

    $partners_slider_autoscroll = get_sub_field( 'enable_autoscroll' );

    $partners_slider_dalay = get_sub_field( 'delay' );

	if( $partners_slider ): ?>

	 	<div class="section partners">

            <div class="space-xl"></div>

            <?php if( $partners_title ): ?>

	            <div class="block-title size4">

	                <h4 class="h4"><?php echo $partners_title; ?></h4>

	            </div>

	        <?php endif; ?>

            <div class="swiper-main-wrapper swiper-animation for-6-slide anination-newspadding change-pagination">

                <div class="swiper-container" data-breakpoints="1" data-slides-per-view="6" data-lg-slides="6" data-md-slides="5" data-sm-slides="4" data-xs-slides="1" <?php if(!empty($partners_slider_dalay) && $partners_slider_autoscroll ){?>data-autoplay="<?php echo (1000* $partners_slider_dalay)?>" <?php } ?>>

                    <div class="swiper-wrapper">

                    	<?php foreach( $partners_slider as $partner_slide ): 

                    		$partner_full  = $partner_slide ? $partner_slide['url'] : '';

    						$partner_image = !strpos( $partner_full, '.svg' ) ? aq_resize( $partner_full, 268, 100, false, true, true ) : $partner_full; ?>

	                        <div class="swiper-slide">

	                            <div class="logos" style="background-image: url(<?php echo esc_url( $partner_image ); ?>);"></div>

	                        </div>

                        <?php endforeach; ?>

                    </div>

                </div>

                <div class="swiper-navigation type2 type4 remove-pagination">

                    <div class="swiper-button-prev custom-arrow-prev"></div>

                    <div class="swiper-pagination"></div>

                    <div class="swiper-button-next custom-arrow-next"></div>

                </div>

            </div>

            <div class="space-xl"></div>

        </div> 

<?php endif;