<?php if(!defined('ABSPATH')) exit;
	$testimonial_title  = get_sub_field( 'title' );
	$testimonial_slider = get_sub_field( 'slider' );
	  
	if( $testimonial_title || $testimonial_slider ): ?>
		<div class="section testimonial">
            <div class="space-lg"></div>
            <?php if( $testimonial_title ): ?>
	            <div class="block-title size3 type3">
	                <div class="h6"><?php echo wp_kses_post( $testimonial_title ); ?></div>
	            </div>
	        <?php endif; 
	        if( $testimonial_slider ): ?>
	            <div class="swiper-main-wrapper change-pagination">
	                <div class="swiper-container swiper-content fade-effect" data-breakpoints="1" data-slides-per-view="1" data-lg-slides="1" data-md-slides="1" data-sm-slides="2" data-xs-slides="1" data-effect="fade" data-auto-height="1">
	                    <div class="space-md"></div>
	                    <div class="swiper-wrapper">
	                    	<?php foreach( $testimonial_slider as $testimonial_slide ): 
	                    		$testimonial_name     = get_the_title( $testimonial_slide );
								$testimonial_position = get_field( 'testimonial_position', $testimonial_slide );
								$testimonial_content  = get_field( 'testimonial_content', $testimonial_slide );
								$testimonial_full     = has_post_thumbnail( $testimonial_slide ) ? get_the_post_thumbnail_url( $testimonial_slide ) : '';
								$testimonial_image 	  = aq_resize( $testimonial_full, 132, 132, true, true, true ); ?>
		                        <div class="swiper-slide">
		                            <div class="testimonials-wrapper">
		                                <div class="author-img">
                                            <div class="img-wrapp">
                                                <img src="<?php echo esc_url( $testimonial_image ); ?>" alt="" />
                                            </div>		                                     
		                                </div>
		                                <div class="content">
		                                    <?php echo wp_kses_post( $testimonial_content ); ?>
		                                    <div class="name h6"><?php echo $testimonial_name; ?></div>
		                                    <?php if( $testimonial_position ): ?>
			                                    <div class="position size-m"><?php echo $testimonial_position; ?></div>
			                                <?php endif; ?>
		                                </div>
		                            </div>
		                        </div>
		                    <?php endforeach; ?>
	                    </div>
	                </div>
	                <div class="swiper-navigation type2 type3 remove-pagination">
	                    <div class="swiper-button-prev custom-arrow-prev"></div>
	                    <div class="swiper-pagination"></div>
	                    <div class="swiper-button-next custom-arrow-next"></div>
	                </div>
	            </div>
	            <div class="space-lg space-none"></div>
	        <?php endif; ?>
	    </div>
<?php endif;