<?php
/**
 * Template name: Accessories
 *
 * @package jamesway
 * @since 1.0.0
 *
 */

if( !defined('ABSPATH') ) exit; get_header();
	$banner = get_field( 'access_banner' );
	if( have_rows( 'access_sections' ) ):
		$sections_title  = '';
		$sections_slider = '';
		$s_i = 0;
		while ( have_rows( 'access_sections' ) ) : the_row();
			if( get_row_layout() == 'section' ):
				$s_i++;
				$title = get_sub_field( 'title' );
				$pull_class   = $s_i % 2 == 0 ? 'col-lg-push-8' : '';
				$pull_class_2 = $s_i % 2 == 0 ? 'col-lg-pull-4' : '';
				if( $title )
					$sections_title .= '<li><a href="#section-'.$s_i.'"><span>'.$title.'</span></a></li>';

				$slider = get_sub_field( 'slider' );
				if( $slider )
					$number = $s_i < 10 ? '0'.$s_i : $s_i;
					$sections_slider .= '<div class="section section-scroll" id="section-'.$s_i.'">
								            <div class="space-lg"></div>
								            <div class="container-fluid padding">
								                <div class="row vert-align">
								                    <div class="col-lg-4 '.$pull_class.' col-md-12 col-sm-12 col-xs-12">
								                        <div class="simple-article type2">
								                            <div class="number">'.$number.'</div>
								                            <div class="title h3">'.$title.'</div>
								                        </div>
								                    </div>
								                    <div class="col-lg-8 '.$pull_class_2.' col-md-12 col-sm-12 col-xs-12">
								                        <div class="swiper-main-wrapper accessories-swiper change-pagination">
								                            <div class="swiper-container swiper-content" data-breakpoints="1" data-slides-per-view="2" data-lg-slides="2" data-md-slides="2" data-sm-slides="2" data-xs-slides="1" data-pagination-type="progress">
								                                <div class="swiper-wrapper">';
																// <div class="swiper-container swiper-content" data-breakpoints="1" data-slides-per-view="2" data-space="50" data-lg-slides="2" data-md-slides="2" data-sm-slides="2" data-xs-slides="1" data-pagination-type="progress">
								                                foreach( $slider as $slide ):
								                                	$slide_img = $slide['image'] ? $slide['image']['url'] : '';
								                                	$slide_image_crop = aq_resize( $slide_img, 530, 580, true, true, true );
								                                    $sections_slider .= '<div class="swiper-slide">
													                                        <div class="img-wrapper slide-item">
													                                            <div class="img-item">
													                                                <div class="big-img" style="background-image: url('.THEME_URI.'/assets/img/shadow.png), url('.$slide_image_crop.');">
													                                                    <div class="content-hide" style="transform: translateY(172px);">
													                                                        <h4 class="h4">'.$slide['title'].'</h4>
													                                                        <p>'.$slide['subtitle'].'</p>
													                                                    </div>
													                                                </div>
													                                            </div>
													                                        </div>
								                                    					</div>';
								                                endforeach;
								                                    
		                                   $sections_slider .= '</div>
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
								        </div>';
			elseif( get_row_layout() == 'testimonials' ):
				$testimonial_title  = get_sub_field( 'title' );
				$testimonial_slider = get_sub_field( 'slider' );
				if( $testimonial_title || $testimonial_slider ):
					$sections_slider .= '<div class="section">';
			            $sections_slider .= '<div class="space-lg"></div>';
			            if( $testimonial_title ):
				            $sections_slider .= '<div class="block-title size3 type3">';
				                $sections_slider .= '<div class="size-xl">' . $testimonial_title . '</div>';
				            $sections_slider .= '</div>';
				        endif; 
				        if( $testimonial_slider ):
				            $sections_slider .= '<div class="swiper-main-wrapper change-pagination">';
				                $sections_slider .= '<div class="swiper-container swiper-content fade-effect" data-breakpoints="1" data-space="50" data-slides-per-view="1" data-lg-slides="1" data-md-slides="1" data-sm-slides="2" data-xs-slides="1" data-effect="fade">';
				                    $sections_slider .= '<div class="space-md"></div>';
				                    $sections_slider .= '<div class="swiper-wrapper">';
				                    	foreach( $testimonial_slider as $testimonial_slide ): 
				                    		$testimonial_name     = get_the_title( $testimonial_slide );
											$testimonial_position = get_field( 'testimonial_position', $testimonial_slide );
											$testimonial_content  = get_field( 'testimonial_content', $testimonial_slide );
											$testimonial_full     = has_post_thumbnail( $testimonial_slide ) ? get_the_post_thumbnail_url( $testimonial_slide ) : '';
											$testimonial_image 	  = aq_resize( $testimonial_full, 132, 132, true, true, true );
					                        $sections_slider .= '<div class="swiper-slide">';
				                            $sections_slider .= '<div class="testimonials-wrapper">';
			                                $sections_slider .= '<div class="author-img">';
			                                $sections_slider .= '<img src="' . $testimonial_image . '" alt="" />';
			                                $sections_slider .= '</div>';
			                                $sections_slider .= '<div class="content">' . $testimonial_content;
			                                $sections_slider .= '<div class="space-md"></div>';
			                                $sections_slider .= '<div class="name h6">' . $testimonial_name . '</div>';
					                        if( $testimonial_position ):
			                                    $sections_slider .= '<div class="position size-m">' . $testimonial_position . '</div>';
						                    endif;
			                                $sections_slider .= '</div>';
				                            $sections_slider .= '</div>';
					                        $sections_slider .= '</div>';
					                    endforeach;
				                    $sections_slider .= '</div>';
				                $sections_slider .= '</div>';
				                $sections_slider .= '<div class="swiper-navigation type2 type3 remove-pagination">';
			                    $sections_slider .= '<div class="swiper-button-prev custom-arrow-prev"></div>';
			                    $sections_slider .= '<div class="swiper-pagination"></div>';
			                    $sections_slider .= '<div class="swiper-button-next custom-arrow-next"></div>';
				                $sections_slider .= '</div>';
				            $sections_slider .= '</div>';
				            $sections_slider .= '<div class="space-lg"></div>';
				        endif;
				    $sections_slider .= '</div>';
				endif;
			endif;
		endwhile;
	endif; ?>
		<div class="section banner">
            <div class="clip-wrapper">
                <div class="bg-image" style="background-image: url(<?php echo esc_url( $banner['image'] ? $banner['image']['url'] : '' ); ?>);">
                </div>
            </div>
            <div class="svg-element counter-wrapper full-height countEnd">
                <svg version="1.1" width="100%" height="170px" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon fill="#ffffff" points="0,100 -10,20  50,0 110,20 100,100"></polygon>
                </svg>
            </div>
            <div class="container-fluid padding">
                <div class="row padding">
                    <div class="col-lg-12 padding">
                        <div class="banner-content type2">
                            <div class="banner-content-cell">
                                <?php if( $banner['breadcrumbs'] ): ?>
                                    <!-- BREADCRUMBS -->
                                    <ul class="breadcrumbs">
                                        <?php foreach ($banner['breadcrumbs'] as $breadcrumb_id) { ?>
                                            <li><a href="<?php echo get_permalink($breadcrumb_id); ?>"><?php echo get_the_title($breadcrumb_id); ?></a></li>
                                        <?php } ?>
                                        <li class="active"><?php echo the_title(); ?></li>
                                    </ul>
                                <?php endif; ?>

                                <h1 class="h1"><?php the_title(); ?></h1>
                                <div class="space-md"></div>
                                <?php if( $banner['text'] ): ?>
	                                <div class="content">
	                                    <div class="h6 subtitle"><p><?php echo $banner['text']; ?></p></div>
	                                </div>
	                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section page-navigation">
            <div class="row padding">
                <div class="col-lg-12 padding">
                    <?php if( $banner['logo']['url'] ): ?>
                        <div class="product-img">
                            <img src="<?php echo esc_url( !empty($banner['logo']['url']) ? $banner['logo']['url'] : '' ); ?>" alt="<?php echo esc_attr( !empty($banner['logo']['alt']) ? $banner['logo']['alt'] : '' ); ?>">
                        </div>
                        <div class="space-md"></div>
                    <?php endif; ?>

                    <?php if( isset( $sections_title ) ): ?>   
	                    <div class="page-navigation-FixWrapper">
	                        <div class="page-navigation-wrapper">
		                        <div class="page-navigation-title" data-placeholder="Select filter"><?php esc_html_e( 'Select filter', 'jamesway' ); ?></div>
		                        <ul>
		                            <?php echo $sections_title; ?>
		                        </ul>
		                    </div>
	                    </div>                     
	                        
	                    <div class="space-lg"></div>
	                <?php endif; ?>
                </div>
            </div>
        </div>


	<?php echo isset( $sections_slider ) ? $sections_slider : ''; 
	$form_block = get_field( 'access_form' );
	if( $form_block ): ?>
		<div class="section">
            <div class="space-lg"></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    	<?php if ($form_block['title'] || $form_block['bg_title']): ?>
                            <div class="form-title">
                                <?php if ($form_block['bg_title']): ?>
                                    <div class="big-title"><?php echo $form_block['bg_title']; ?></div>
                                <?php endif; ?>
                                <?php if ($form_block['title']): ?>
                                    <div class="small-title type2"><?php echo $form_block['title']; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="empty-lg-60 empty-xs-30"></div>
                        <?php endif;
                        if( $form_block['form'] ): ?>
	                        <div class="form-wrapper">
	                            <?php echo do_shortcode( '[contact-form-7 id="'.$form_block['form'].'" title="contact-form-'.$form_block['form'].'"]' ); ?>
	                        </div>
	                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="space-xl"></div>            
        </div>
		<?php 
	endif;
get_footer();