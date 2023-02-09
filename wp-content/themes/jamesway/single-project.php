<?php
/**
 * Single Project
 * @package jamesway
 * @since 1.0.0
 */

if( !defined('ABSPATH') ) exit; get_header();
	while ( have_posts() ): the_post();
		$banner = get_field( 'single_banner' ); ?>
			<div class="section banner">
            <div class="clip-wrapper">
                <div class="bg-image" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/gettyimages-623208264-1024x1024.png);">
                </div>
            </div>
            <div class="svg-element counter-wrapper full-height countEnd">
                <svg version="1.1" width="100%" height="170px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon fill="#ffffff" points="0,100 -10,20  50,0 110,20 100,100"></polygon>
                </svg>
            </div>
            <?php if( $banner ): 
            	$banner = aq_resize( $banner['url'], 859, 503, true, true, true ); ?>
	            <div class="container-fluid padding">
	                <div class="row padding">
	                    <div class="col-lg-12 padding">
	                        <div class="banner-content type4">
	                            <div class="element-img center">
	                                <img src="<?php echo esc_url( $banner ); ?>" alt="" />
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        <?php else: ?>
	        	<div class="empty-lg-150"></div>
	        <?php endif; ?>
        </div>
        <div class="section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="block-title type3">
                            <div class="date size-l"><?php echo get_the_date( 'd F Y'); ?></div>
                            <div class="empty-lg-20"></div>
                            <h1 class="h2"><?php the_title(); ?></h1>
                            <?php $subtitle = get_field( 'short_description' );
                            if( $subtitle ): ?>
	                            <div class="empty-lg-20"></div>
	                            <div class="subtitle h6"><?php echo $subtitle; ?></div>
	                        <?php endif; ?>
                        </div>
                        <div class="simple-article type5">
                            <?php the_content(); ?>
                        </div>
                        <?php jmw_share(); ?>
                        <div class="space-md"></div>
                    </div>
                </div>
            </div>
        </div>
		<?php
	endwhile; 
get_footer();
