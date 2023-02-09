<?php if(!defined('ABSPATH')) exit; 
	$support_title   = get_sub_field( 'support_title' );
	$support_link    = get_sub_field( 'support_link' );
	$support_updates = get_sub_field( 'support_updates' );
if( $support_updates ): ?>
	<div class="section">
	    <div class="space-lg"></div>
	    <?php if( $support_title || $support_link ): ?>
		    <div class="news-block-title">
		    	<?php if( $support_title ): ?>
		        <div class="block-title">
		            <h4 class="h4"><?php echo $support_title; ?></h4>
		        </div>
		        <?php endif;
		        if( $support_link ): ?>
		        	<a href="<?php echo esc_url( $support_link ); ?>" class="button type3"><?php esc_html_e( 'See All', 'jamesway' ); ?></a>
		        <?php endif; ?>
		    </div>
		    <div class="space-md"></div>
		<?php endif; ?>
	    <div class="swiper-main-wrapper swiper-animation for-4-slide anination-newspadding">
	        <div class="swiper-container" data-breakpoints="1" data-slides-per-view="4" data-lg-slides="4" data-md-slides="3" data-sm-slides="2" data-xs-slides="1" data-pagination-type="progress" data-space="40">
	            <div class="swiper-wrapper">
	            	<?php 
	            	$s_i = 0;
	            	foreach( $support_updates as $support_up ): ?>
		                <div class="swiper-slide">
		                    <div class="about-item">
		                        <div class="bg" style="<?php echo esc_attr( $support_up['type'] == 1 && $support_up['image'] ? 'background-image: url('.THEME_URI.'/assets/img/shadow.png), url('.$support_up['image']['url'].');' : 'background-color: '.( $support_up['color'] == 1 ? '#DA322A;' : '#174489;' ) ); ?>"></div>
		                        <div class="content">
		                        	<?php if( $support_up['title'] ): ?>
			                            <div class="date"><?php echo $support_up['title']; ?></div>
			                        <?php endif; 
			                        if( $support_up['text'] ): ?>
			                            <div class="title h6"><?php echo $support_up['text']; ?></div>
			                        <?php endif; ?>
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
	    <div class="space-lg"></div>
	</div>
<?php endif; 