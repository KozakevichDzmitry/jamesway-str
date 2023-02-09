<?php if( !defined('ABSPATH') ) exit;
	$points = get_sub_field( 'points' );
	if( $points ): ?>
		<div class="section">
			<?php
				$point_images   = ''; //point background image
				$point_content  = ''; //point description and title content
				// $point_position = 'max-width:'.(100/sizeof($points)).'%;'; //point position for time line
				// $point_html  	= ''; //point circle
				$point_i 		= ''; //point number
				foreach( $points as $point ):
					$point_i++;
					// if( $point_i == 1 || $point_i == 9 ):
					// 	$point_position = $point_i == 1 ? 'right:33%' : 'left:33%';
					// elseif( $point_i == 2 || $point_i == 8 ):
					// 	$point_position = $point_i == 2 ? 'right:29%' : 'left:29%';
					// elseif( $point_i == 3 || $point_i == 7):
					// 	$point_position = $point_i == 3 ? 'right:20%' : 'left:20%';
					// elseif( $point_i == 4 || $point_i == 6):
					// 	$point_position = $point_i == 4 ? 'right:15%' : 'left:15%';
					// elseif( $point_i == 5 ):
					// 	$point_position = 'left:0';
					// endif;

					if( $point['image'] ):
						$point_images .= '<div class="bg" style="background-image: url('.$point['image']['url'].');">
					                    <div class="shade"></div>
					                </div>';
					endif;
					if( $point['title'] || $point['description'] ):
						$point_content .= '<div class="swiper-slide">
			                                <div class="slide-item">';
			                                if( $point['title'] ):
			                                   $point_content .= '<div class="year">'.$point['title'].'</div>';
			                                endif;
			                                if( $point['description'] ):
			                                    $point_content .= '<div class="desc">'.$point['description'].'</div>';
			                                endif;
                        $point_content .= '</div>
			                              </div>';
					endif;
					// $point_html  .= '<div class="swiper-slide" style="'.$point_position.'; top: 0;"><div class="slide-padination"></div></div>';

				endforeach; ?>
            <div class="swiper-main-wrapper year-slider">
            	<?php echo $point_images ? $point_images : ''; 
            	if( $point_content ): ?>
	                <div class="swiper-wrap year-slider-top">
	                    <div class="swiper-container" data-auto-height="1" data-pagination-type="bullets" data-centered="1" data-init="1" data-slides-per-view="2" data-space="30" data-breakpoints="1" data-lg-slides="3" data-md-slides="3" data-sm-slides="2" data-xs-slides="1">
	                        <div class="swiper-wrapper">
	                            <?php echo $point_content; ?>
	                        </div>
	                    </div>
	                    <div class="swiper-navigation">
                        	<div class="swiper-pagination"></div>
	                        <div class="swiper-button-prev custom-arrow-prev"></div>
	                        <div class="swiper-button-next custom-arrow-next"></div>
	                    </div>
	                </div>
	            <?php endif;?>
	            <div class="swiper-wrap"></div>
	            <?php /*if( $point_html ): ?>
	                <div class="swiper-wrap">
	                    <!-- <div class="swiper-container"> 
	                        <div class="swiper-wrapper">
	                            <?php echo $point_html; ?>
	                        </div>
	                    </div>
	                    <div class="swiper-navigation">
	                        <div class="swiper-button-prev custom-arrow-prev"></div>
	                        <div class="swiper-button-next custom-arrow-next"></div>
	                    </div> -->
	                </div>
	            <?php endif;*/ ?>
            </div>
        </div>
<?php endif;