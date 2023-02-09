<?php
/**
 * Template name: Products
 *
 * @package jamesway
 * @since 1.0.0
 *
 */

if( !defined('ABSPATH') ) exit; get_header();
	$current_lang = 'en'; //wpm_get_language();
	$banner = get_field( 'products_banner' );
	if( have_rows( 'products_tabs' ) ):
		$block_title  = '';
		$block_content = '';
		$block_i = 0;
		while ( have_rows( 'products_tabs' ) ) : the_row();
			$block_i++;
			if( get_row_layout() == 'slider_text' ):
				$title 	  = get_sub_field( 'title' );
				$text     = get_sub_field( 'text' );
				$position = get_sub_field( 'position' );
				$pull_class   = $position == 2 ? 'col-lg-push-8' : '';
				$pull_class_2 = $position == 2 ? 'col-lg-pull-4' : '';
				if( $title )
					$block_title .= '<li><a href="#section-'.$block_i.'"><span>'.$title.'</span></a></li>';

				$slider = get_sub_field( 'slider' );
				if( $slider ):
					$number = $block_i < 10 ? '0'.$block_i : $block_i;
					$block_content .= '<div class="section margin type2 section-scroll" id="section-'.$block_i.'">
						            <div class="container-fluid padding-mobile">
						                <div class="row vert-align">
						                    <div class="col-lg-4 '.$pull_class.' col-sm-12 col-xs-12">
						                        <div class="simple-article type2">
						                            <div class="number">'.$number.'</div>
						                            <div class="title h3">'.$title.'</div>';
						                            if( $text ):
						                            	$block_content .='<div class="empty-lg-20"></div><p>'.$text.'</p>';
							                        endif;
		                         $block_content .= '</div>
						                    </div>
						                    <div class="col-lg-8 '.$pull_class_2.' col-sm-12 col-xs-12">
						                    	<div class="img-wrapper w50_">
						                    		<div class="swiper-main-wrapper accessories-swiper change-pagination">
								                        <div class="swiper-container swiper-content" data-space="50" data-breakpoints="1" data-slides-per-view="2" data-lg-slides="2" data-md-slides="2" data-sm-slides="2" data-xs-slides="1" data-pagination-type="progress">
								                    	        <div class="swiper-wrapper">';
						                                foreach( $slider as $slide ):
						                                	$hide_only_for_cn = isset($slide['hide_only_for_cn'][0]) ? $slide['hide_only_for_cn'][0] : "";
						                                	$show_only_for_cn = isset($slide['show_only_for_cn'][0]) ? $slide['show_only_for_cn'][0] : "";
						                                	if($hide_only_for_cn == 'yes' && $current_lang == 'cn' || $show_only_for_cn == 'yes' && $current_lang != 'cn'){
						                                		continue;
						                                	}
						                                	else if($show_only_for_cn == 'yes' && $current_lang == 'cn'){
						                                		$slide_img = $slide['image'] ? $slide['image']['url'] : '';
							                                	$slide_image_crop = aq_resize( $slide_img, 530, 580, true, true, true );
							                                    $block_content .= '<div class="swiper-slide" data-qq="string">
														                            <div class="img-wrapper slide-item">
							                                    						<div class="img-item">
									                                                		<div class="big-img" style="background-image: url('.THEME_URI.'/assets/img/shadow.png), url('.$slide_image_crop.');">
									                                                    		<div class="content-hide" style="">
									                                                    			<h4 class="h4">'.$slide['title'].'</h4>
									                                                        		<p>'.$slide['subtitle'].'</p>';
										                                                    		if( $slide['link']['link'] && $slide['link']['link_title'] ):
										                                                    			$block_content .= '<a href="'.$slide['link']['link'].'" class="button">'.$slide['link']['link_title'].'</a>';
										                                                    		endif;
						                                        			$block_content .= '</div>
									                                                		</div>
									                                            		</div>
									                                                </div>
									                                            </div>';
															}
															else{
																$slide_img = $slide['image'] ? $slide['image']['url'] : '';
							                                	$slide_image_crop = aq_resize( $slide_img, 530, 580, true, true, true );
							                                    $block_content .= '<div class="swiper-slide">
														                            <div class="img-wrapper slide-item">
							                                    						<div class="img-item">
									                                                		<div class="big-img" style="background-image: url('.THEME_URI.'/assets/img/shadow.png), url('.$slide_image_crop.');">
									                                                    		<div class="content-hide" style="">
									                                                    			<h4 class="h4">'.$slide['title'].'</h4>
									                                                        		<p>'.$slide['subtitle'].'</p>';
										                                                    		if( $slide['link']['link'] && $slide['link']['link_title'] ):
										                                                    			$block_content .= '<a href="'.$slide['link']['link'].'" class="button">'.$slide['link']['link_title'].'</a>';
										                                                    		endif;
						                                        			$block_content .= '</div>
									                                                		</div>
									                                            		</div>
									                                                </div>
									                                            </div>';
															}
					                                		
						                                	
						                                endforeach;
                               	 $block_content .= '</div>
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
			            	</div>
			            	<div class="empty-lg-230 empty-md-180 empty-sm-130 empty-xs-100"></div>          
			        	</div>';
				endif;
			elseif( get_row_layout() == 'image_text_link' ):
				$title = get_sub_field( 'title' );
				$text  = get_sub_field( 'text' );
				$image = get_sub_field( 'image' );
				$img = $image['image'] ? $image['image']['url'] : '';
				$position = get_sub_field( 'position' );

				$pull_class   = $position == 2 ? 'col-md-push-8' : '';
				$pull_class_2 = $position == 2 ? 'col-md-pull-4' : '';

				if( $title )
					$block_title .= '<li><a href="#section-'.$block_i.'"><span>'.$title.'</span></a></li>';

				$number = $block_i < 10 ? '0'.$block_i : $block_i;

				$block_content .= '<div class="section margin type2 section-scroll" id="section-'.$block_i.'">
					            <div class="container-fluid padding-mobile">
					                <div class="row vert-align">
					                    <div class="col-md-4 '.$pull_class.' col-sm-12 col-xs-12">
					                        <div class="simple-article type2">
					                            <div class="number">'.$number.'</div>';
					                            if( $title ):
						                            $block_content .= '<div class="title h3">'.$title.'</div>';
						                        endif; 
						                        if( $text ):
						                            $block_content .= '<div class="empty-lg-20"></div>
						                            <p>'.$text.'</p>';
						                        endif;
		                      $block_content .= '</div>
					                    </div>
					                    <div class="col-md-8 '.$pull_class_2.' col-sm-12 col-xs-12">
					                        <div class="img-wrapper">
					                            <div class="img-item">
					                                <div class="big-img" style="background-image: url('.THEME_URI.'/assets/img/shadow.png), url('.$img.');">';
					                                if( $image['title'] || $image['subtitle'] || ( $image['link']['link'] && $image['link']['link_title'] ) ):
					                                    $block_content .= '<div class="content-hide">';
						                                    	if( $image['title'] ):
							                                        $block_content .= '<h4 class="h4">'.$image['title'].'</h4>';
							                                    endif; 
							                                    if( $image['subtitle'] ):
							                                        $block_content .= '<p>'.$image['subtitle'].'</p>';
							                                    endif;
							                                    if( $image['link']['link'] && $image['link']['link_title'] ):
							                                        $block_content .= '<a href="'.$image['link']['link'].'" class="button">'.$image['link']['link_title'].'</a>';
							                                    endif;
			                                    	    $block_content .= '</div>';
						                            endif;
		                              $block_content .= '</div>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <div class="empty-lg-230 empty-md-180 empty-sm-130 empty-xs-100"></div>
					        </div>';
			elseif( get_row_layout() == 'text_image' ):
				$title = get_sub_field( 'title' );
				$image = get_sub_field( 'image' );
				$img = $image['image'] ? $image['image']['url'] : '';
				$text  = get_sub_field( 'text' );
				if( $title )
					$block_title .= '<li><a href="#section-'.$block_i.'"><span>'.$title.'</span></a></li>';

				$block_content .= '<div class="section margin type2 section-bg section-scroll" id="section-'.$block_i.'">
					            <div class="container-fluid padding-mobile">
					                <div class="row vert-align">
					                    <div class="col-md-4 col-sm-12 col-xs-12">
					                        <div class="simple-article type2">
					                            <div class="number">'.$number.'</div>
					                            <div class="title h3">'.$title.'</div>
					                            <div class="empty-lg-20"></div>
					                            <p>'.$text.'</p>
					                        </div>
					                    </div>
					                    <div class="col-md-8 col-sm-12 col-xs-12">
					                        <div class="img-wrapper">';
					                        if( $image['link'] ):
					                            $block_content .= '<a href="'.$image['link'].'" class="single-product">';
					                        endif;
			                                $block_content .= '<div class="img" style="background-image: url('.$img.');">
					                                </div>
					                                <div class="single-product-bg" style="background-image: url('.THEME_URI.'/assets/img/single-product-bg.svg);">
					                                </div>';
			                                if( $image['link'] ):
					                            $block_content .= '</a>';
					                        endif;
	                          $block_content .= '</div>
					                    </div>
					                </div>
					            </div>
					            <div class="empty-lg-230 empty-md-180 empty-sm-130 empty-xs-100"></div>
					        </div>';
			endif;
		endwhile;
	endif; ?>
<div class="section banner">
    <div class="clip-wrapper">
        <div class="bg-image"
            style="background-image: url(<?php echo esc_url( $banner['image'] ? $banner['image']['url'] : '' ); ?>);">
        </div>
    </div>
    <div class="svg-element counter-wrapper full-height countEnd">
        <svg version="1.1" width="100%" height="170px" xmlns="http://www.w3.org/2000/svg"
             xml:space="preserve" viewBox="0 0 100 100"
             preserveAspectRatio="none">
            <polygon fill="#ffffff" points="0,100 -10,20  50,0 110,20 100,100"></polygon>
        </svg>
    </div>
    <div class="container-fluid padding">
        <div class="row padding">
            <div class="col-lg-12 padding">
                <div class="banner-content type2">
                    <div class="banner-content-cell">
                        <?php if( $banner['title'] ): ?>
                        <h1 class="h1"><?php echo wp_kses_post( $banner['title'] ); ?></h1>
                        <?php endif; ?>
                        <?php if( $banner['text'] ): ?>
                        <div class="space-md"></div>
                        <div class="content">
                            <div class="h6 subtitle">
                                <p><?php echo $banner['text']; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="space-lg"></div>
                
            </div>  
        </div>
    </div>
</div>

<div class="section page-navigation">
        <div class="row padding">
            <div class="col-lg-12 padding">
                <?php if (!empty($banner['logo']['url'])) { ?>
                    <div class="product-img">
                        <img src="<?php echo esc_url($banner['logo'] ? $banner['logo']['url'] : ''); ?>" alt="<?php echo esc_attr($banner['logo'] ? $banner['logo']['alt'] : ''); ?>">
                    </div>
                <?php } ?>
                <div class="space-md"></div>
                <?php if( isset( $block_title ) ): ?>
                <div class="page-navigation-FixWrapper">
                    <div class="page-navigation-wrapper">
                        <div class="page-navigation-title" data-placeholder="Select filter">
                            <?php esc_html_e( 'Select filter', 'jamesway' ); ?></div>
                        <ul><?php echo $block_title; ?></ul>
                    </div>
                </div>
                <div class="space-lg space-md-none space-sm-none"></div>
                <div class="space-lg space-md-none space-sm-none"></div>
                <div class="space-lg"></div>
                <?php endif; ?>
            </div>
        </div>
</div>
<?php echo isset( $block_content ) ? $block_content : '';
get_footer();