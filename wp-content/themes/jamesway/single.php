<?php
/**
 * Single Page
 * @package jamesway
 * @since 1.0.0
 */

if( !defined('ABSPATH') ) exit; get_header();
	while ( have_posts() ): the_post();
		$banner = get_field( 'single_banner' ); 
        $single_post_banner_bg = get_field('single_post_banner_bg', 'option');
        $sb_background_image = get_field('sb_background_image');
        $bgimage = '';
        $blog_id = get_option('page_for_posts');

        if($sb_background_image){
            $bgimage = $sb_background_image;
        } elseif($single_post_banner_bg){
            $bgimage = $single_post_banner_bg;
        }
        ?>
			<div class="section banner">
	            <div class="clip-wrapper">
	                <div class="bg-image" style="background-image: url(<?php echo $bgimage; ?>);"></div>
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
		                        <div class="banner-content type4 post-detail">
                                    <!-- BREADCRUMBS -->
                                    <ul class="breadcrumbs">
                                        <li><a href="<?php echo home_url('/'); ?>"><?php esc_html_e("Home", 'jamesway'); ?></a></li>
                                        <li><a href="<?php echo get_permalink($blog_id);?>"><?php echo esc_html(get_the_title($blog_id));?></a></li>
                                        <li class="active"><?php the_title(); ?></li>
                                    </ul>

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
                            <div class="empty-lg-20"></div>
                            <h1 class="h1"><?php the_title(); ?></h1>
                            <div class="empty-lg-20"></div>
                            <div class="block-title-info">
                                <div class="date size-l"><?php echo get_the_date( 'd F Y'); ?></div>
                                <?php
                                	$parent_cat = get_the_terms( $post->ID, 'category' );
                                	$parent_tag = get_the_terms( $post->ID, 'post_tag' );
                                	if( $parent_cat ):
                                		$ci = 0; ?>
                                		<div class="date size-l">
	                            			<?php esc_html_e( 'Category: ', 'jamesway' );
	                                		foreach( $parent_cat as $cat ): 
	                                			echo $cat->name;
	                                			if( ++$ci == 1 )
	                                				break;

	                                		endforeach; ?>
                                		</div>
                                		<?php
                            		endif;
                                	if( $parent_tag ):
                                		$ti = 0;
                                		foreach( $parent_tag as $tag ): 
                                			$link = get_term_link( $tag, 'category' ); ?>
                                			<a href="<?php echo $link; ?>" class="size-l"><?php echo $tag->name; ?></a>
                                			<?php 
                                			if( ++$ti == 1 )
                                				break;

                                		endforeach;
                            		endif;
                            	?>
                                
                                <a href="<?php echo get_permalink($blog_id);?>" class="link"><?php esc_html_e('News', 'jamesway');?></a>
                            
                            </div>
                        </div>
                        <div class="simple-article type5 post-detail">
                            <?php the_content(); ?>
                        </div>
                        <?php jmw_share(); ?>
                        <div class="space-lg"></div>
                    </div>
                </div>
            </div>
        </div>
		<?php
	endwhile; 
get_footer();
