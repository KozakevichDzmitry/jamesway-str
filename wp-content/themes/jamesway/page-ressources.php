<?php

/**

 * Template name: Ressources

 *

 * @package jamesway

 * @since 1.0.0

 *

 */



if( !defined('ABSPATH') ) exit;

$page_title = get_field('page_title');

get_header(); ?>

	<div class="section banner">

        <div class="clip-wrapper">

            <div class="bg-image" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/Rectangle.png);">

            </div>

        </div>

        <div class="svg-element counter-wrapper full-height countEnd">

            <svg version="1.1" width="100%" height="120px" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none">

                <polygon fill="#ffffff" points="0,100 -10,20  50,0 110,20 100,100"></polygon>

            </svg>

        </div>

        <div class="container-fluid padding">

            <div class="row padding">

                <div class="col-lg-12 padding">

                    <div class="banner-content type4">

                        <div class="banner-content-cell">

                            <div class="big-title"><?php echo (!empty($page_title) ? esc_html($page_title) : get_the_title()); ?></div>

                            <h1 class="h1"><?php echo (!empty($page_title) ? esc_html($page_title) : get_the_title()); ?></h1>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

<?php 

$direct_download = get_field('direct_download');

$is_user_logged = is_user_logged_in();

$user_type = ($is_user_logged) ? get_user_meta( get_current_user_id(), 'user_type_role', true ) : array();

file_put_contents(__DIR__.'/is_user_logged.txt', print_r($is_user_logged, true));

if( have_rows( 'res_content' )):

	$rows_count = get_field( 'res_content' );

	$row_int    = 0;

	while ( have_rows( 'res_content' ) ) : the_row();

		$row_int++;

		if( get_row_layout() == 'res_accordion' ):

			$res_ac_title = get_sub_field( 'title' );

			$res_ac_tabs  = get_sub_field( 'tabs' ); 

			$res_ac_permissions  = get_sub_field( 'permissions' );

			$res_ac_permissions = is_array($res_ac_permissions) ? $res_ac_permissions : array();

			$visible = true;

			file_put_contents(__DIR__.'/res_ac_permissions.txt', print_r($res_ac_permissions, true));

			if(($res_ac_permissions != NULL) or (!empty($res_ac_permissions)) and ((array_search($user_type, $res_ac_permissions) === false) or (array_search($user_type, $res_ac_permissions) === NULL)))$visible = false;



			if((array_search($user_type, $res_ac_permissions) != false) or (array_search($user_type, $res_ac_permissions) != NULL) or (array_search($user_type, $res_ac_permissions)===0))$visible = true;

			file_put_contents(__DIR__.'/visible.txt', print_r($visible, true));

			if($visible === false) continue;

			?>

			<div class="section">

	            <div class="container-fluid padding">

	                <div class="row">

	                    <div class="col-xs-12">

	                        <div class="accordion type2 <?php echo esc_attr( $row_int != 1  ? 'margin-top-none' : '' ); ?>">

	                            <div class="accordion-element">

	                            	<?php if( $res_ac_title ): ?>

		                                <div class="accordion-title h3"><?php echo wp_kses_post( $res_ac_title ); ?><span></span></div>

		                            <?php endif;

		                            $tab_list = 0; 

		                            if( have_rows( 'tabs' ) ):?>

		                                <div class="accordion-content" style="display: none;">

		                                	<?php while ( have_rows( 'tabs' ) ) : the_row();

		                                		$tab_list++; 

		                                		if( get_row_layout() == 'tab' ):

		                                			$type = get_sub_field( 'list_type' );  

		                                			$tab_title 	 = get_sub_field( 'title' );

		                                			$tab_content = get_sub_field( 'content' ); 

		                                			if( $tab_title ): ?>

					                                    <div class="list-title">

					                                        <b><?php echo wp_kses_post( $tab_title ); ?></b>

					                                    </div>

					                                <?php endif; 

					                                if( $tab_content ): 

					                                	$tab_int = 0; ?>

					                                    <?php echo $type == 2 ? '<ol data-list-id="'.$tab_list.'">' : '<ul data-id="'.$tab_list.'">'; ?>

					                                    	<?php foreach( $tab_content as $tab ): 

					                                    		$file_name = !empty($tab['title']) ? $tab['title'] : '';

					                                    		$file_url = $file_id = $you_id = '';

					                                    		if(!empty($tab['file_url'])){

					                                    			$file_id = jmw_get_image_id($tab['file_url']);

					                                    			$file_url = $tab['file_url'];

																	$you_id  = $tab['youtube_id'];

					                                    		} elseif(!empty($tab['file'])){

					                                    			$file_id = $tab['file']['ID'];

					                                    			$file_url = $tab['file']['url'];

																	$you_id  = $tab['youtube_id'];

					                                    		} elseif(!empty($tab['youtube_id'])) {

																	$you_id  = $tab['youtube_id'];
																}

																

					                                    		// if( empty($tab['title']) or empty($file_id)  or empty($file_url)) continue;
																// if( empty($tab['title']) or empty($file_id)) continue;

																

				                                    			$tab_int++; 

																$icons = $tab['icon'];

																if(empty($icons)){ $icons = '/wp-content/themes/jamesway/assets/img/download-icon.svg'; }



					                                    		if(!isset($_COOKIE["resDownload"]) and empty($direct_download) ){ ?>
																	
					                                        		<li class="downloadres open-popup <?php echo esc_attr( $file_id ? 'file-li ' : '' ).' '.esc_attr( $tab_int > 5 ? 'hidden' : '' ); ?>" data-rel="1" data-link="<?php echo $file_id; ?>">

					                                        			<b><?php echo $tab['title']; ?></b>

					                                        			<?php echo ( $tab['date'] && $type == 1 ? '<i>'.$tab['date'].'</i>' : '' ); 

					                                        			echo $file_id ? ' <span>'.__( 'Download', 'jamesway' ).'</span>' : ''; ?>

					                                        		</li>

					                                        	<?php } elseif (isset($_COOKIE["resDownload"]) or $direct_download) { ?>

																	<?php
																		
																		if(!empty($file_url)){?>
					                                        			<li class="<?php echo esc_attr( $tab_int > 5 ? 'hidden' : '' ); ?>">

					                                        			<a class="resourcelink" href="<?php echo esc_url($file_url); ?>" target="_blank" download>

					                                        				<b><?php echo $tab['title']; ?></b><?php echo ( $tab['date'] && $type == 1 ? '<i>'.$tab['date'].'</i>' : '' ); echo $file_url ? ' <span>'.__( 'Download', 'jamesway' ).'<img src="'.$icons.'" style ="position: absolute;top: 0;right: 10px;width: 32px;height: 35px;"></span>' : ''; ?>

					                                        			</a>

					                                        		</li>
																	<?php } else { ?>
																		
																		<li class="<?php echo esc_attr( $tab_int > 5 ? 'hidden' : '' ); ?>">
																		<a class="resourcelink open-video" data-id="<?php echo $you_id?>" data-src="https://www.youtube.com/embed/<?php echo esc_attr($you_id) ?>?feature=oembed&amp;autoplay=1&amp;rel=0&amp;showinfo=0">

					                                        				<b><?php echo $tab['title']; ?></b><?php echo ( $tab['date'] && $type == 1 ? '<i>'.$tab['date'].'</i>' : '' ); echo $you_id ? ' <span>'.__( 'Watch video', 'jamesway' ).'<img src="'.$icons.'" style ="position: absolute;top: 0;right: 10px;width: 32px;height: 35px;"></span>' : ''; ?>

					                                        			</a>
																		
																		</li>

																		<?php }  ?>
					                                        	<?php }  ?>
																
					                                    	<?php
																
														endforeach; ?>

					                                     <?php echo $type == 2 ? '</ol>' : '</ul>'; ?>

					                                    <?php if( (count( $tab_content ) > 5) and ($tab_int > 5) ): ?>

					                                    	<div class="space-md"></div>

					                                    	<a href="#" data-link-id="<?php echo esc_attr( $tab_list ); ?>" class="show-more-button"><span><?php esc_html_e( 'View All In  This Category', 'jamesway' ); ?></span></a>

						                                <?php endif; 

						                            endif; ?>

				                                    <div class="space-lg"></div>

			                                	<?php endif;

			                            	endwhile; ?>

										</div>

		                            <?php endif; ?>

	                            </div>

	                        </div>

	                    </div>

	                </div>

	            </div>

	        </div>

			<?php

		elseif( get_row_layout() == 'res_text_block' ):

			$title     = get_sub_field('title');
          	$text      = get_sub_field('text');
          	$img 	   = get_sub_field('img');
          	$red_block = get_sub_field('red_block'); ?>

	      <div class="section">
        <div class="space-lg"></div>
        <div class="container-fluid padding">
          <div class="row">
            <div class="col-lg-11 col-lg-offset-1">
              <div class="row vert-align type2 margin">
                <div class="col-lg-2 img-col">
                <?php if ($img) : ?>
                      <div class="img_logo"><img src="<?php echo esc_url($img) ?>" alt="logo_web_img"></div>
                    <?php endif; ?>
                </div>
                <div class="<?php echo esc_attr(!$red_block ? 'col-lg-8' : 'col-lg-5'); ?>">
                  <div class="simple-article type9">
                    <?php if ($title) : ?>
                      <div class="title h3"><?php echo wp_kses_post($title); ?></div>
                    <?php endif; ?>
                    <div class="empty-lg-25"></div>
                    <?php echo wp_kses_post($text ? $text : ''); ?>
                  </div>
                  <div class="empty-lg-130 empty-md-40"></div>
                </div>
                <?php if ($red_block) : ?>
                  <div class="<?php echo esc_attr(!$title && !$text ? 'col-lg-8' : 'col-lg-5'); ?> padding-right">
                    <div class="webinars-info">
                      <?php if ($red_block['title']) : ?>
                        <div class="title">
                          <span><?php echo $red_block['bg_title']; ?></span>
                          <div class="date"><?php echo $red_block['title']; ?></div>
                        </div>
                        <?php endif;
                                if ($red_block['text'] || $red_block['author']) :
                                  if ($red_block['text']) : ?>
                          <div class="title-desc"><?php echo wp_kses_post($red_block['text']); ?></div>
                        <?php endif;
                                  if ($red_block['author']) : ?>
                          <p><?php echo wp_kses_post($red_block['author']); ?></p>
                      <?php endif;
                              endif; ?>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php echo $row_int == count($rows_count) ? '<div class="space-lg"></div>' : ''; ?>
      </div>

			<?php

		elseif( get_row_layout() == 'res_video_list' ):

			$video_items = get_sub_field( 'video_item' );

			$button_text = get_sub_field( 'button_text' );
			$button_url = get_sub_field( 'button_url' );
			$title = get_sub_field( 'title' );

			$text  = get_sub_field( 'text' ); ?>

				<div class="section">

		            <div class="container-fluid padding">

		                <div class="row">

		                    <div class="col-lg-11 col-lg-offset-1 col-md-12 padding-mobile">

		                        <div class="row webinar-list" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/decor-egg-blue.svg);">

		                        	<?php if( $title || $text ): ?>

			                            <div class="col-lg-3 col-md-5 padding-mobile">

			                            	<?php if( $title ): ?>

				                                <div class="title"><?php echo wp_kses_post( $title ); ?></div>

				                            <?php endif; 

				                            if( $text ): ?>

				                                <div class="space-md"></div>                                

				                                <p><?php echo wp_kses_post( $text ); ?></p>

				                            <?php endif; ?>

			                            </div>

			                        <?php endif; 

			                        if( $video_items ): 

			                        	$vid_int = 0; ?>

			                            <div class="col-lg-9 col-md-7 padding-mobile">

			                                <div class="webinar-items">

			                                	<?php foreach( $video_items as $item ): 

			                                		$vid_int++; ?>

				                                    <div class="webinar-item <?php //echo esc_attr( $vid_int > 5 ? 'hidden' : '' ); ?>">

				                                    	<?php if( $item['title'] ): ?>

					                                        <div class="title h6"><?php echo wp_kses_post( $item['title'] ); ?></div>

					                                    <?php endif;

					                                    if( $item['text'] || $item['link'] ): ?>

					                                        <div class="desc">

					                                            <p><?php echo wp_kses_post( $item['text'] ); ?></p>

					                                            <?php if( $item['link'] || !empty($item['presentation']) ): ?>

						                                            <div class="video-button">

						                                            	<?php if($item['link']){ ?>

						                                            	<div class="open-video" data-src="https://www.youtube.com/embed/<?php echo esc_attr( $item['link'] ); ?>?feature=oembed&autoplay=1&rel=0&showinfo=0">

							                                                <div class="img"><div class="triangle"></div></div>

							                                                <div class="text"><?php esc_html_e( 'Watch video', 'jamesway' ); ?></div>

							                                            </div>

							                                        	<?php } ?>



							                                        	<?php if(!empty($item['presentation'])){ ?>

							                                            <div class="download-presentation">

							                                            	<a href="<?php echo esc_url( $item['presentation'] ); ?>" target="_blank">

								                                                <div class="img"><div class="presentation-icon">

                                                                                        <svg width="32px" height="26px" viewBox="0 0 32 26" version="1.1" xmlns="http://www.w3.org/2000/svg">

																					    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

																					        <g id="ressources1" transform="translate(-1517.000000, -834.000000)" fill="#FFFFFF" fill-rule="nonzero" stroke="#FFFFFF">

																					            <g id="docs/UX-Copy-7" transform="translate(404.000000, 827.000000)">

																					                <path d="M1129.08645,27.0436949 C1128.98808,27.0436949 1128.87003,27.0067291 1128.8091,26.9566755 L1120.33724,19.9951282 C1120.18206,19.8698552 1120.17301,19.6339979 1120.31824,19.5001622 C1120.46349,19.3662916 1120.73683,19.3585295 1120.89194,19.4838026 L1128.68303,25.8906886 L1128.68303,7.89944669 C1128.68021,7.71555742 1128.8733,7.54642662 1129.08645,7.54642662 C1129.2996,7.54642662 1129.49289,7.71555742 1129.48987,7.89944669 L1129.48987,25.8906886 L1137.28095,19.483907 C1137.43607,19.3585295 1137.7094,19.3662916 1137.85465,19.5002666 C1137.9999,19.6341024 1137.99085,19.8699596 1137.83565,19.9952326 L1129.36379,26.95678 C1129.27829,27.027022 1129.16509,27.0947926 1129.08644,27.0437993 C1129.08641,27.0437645 1129.08645,27.0436949 1129.08645,27.0436949 Z M1114.70028,31.268229 C1114.44789,31.268229 1114.35878,31.4322937 1114.35775,31.5768534 C1114.35673,31.7232648 1114.52015,31.8854777 1114.70028,31.8854777 L1143.47262,31.8854777 C1143.65362,31.8854777 1143.81619,31.7232648 1143.81515,31.5768534 C1143.81412,31.4322937 1143.6536,31.268229 1143.47262,31.268229 L1114.70028,31.268229 Z" id="Shape"></path>

																					            </g>

																					        </g>

																					    </g>

																					</svg>

								                                                </div></div>

								                                                <div class="text"><?php esc_html_e( 'View Presentation', 'jamesway' ); ?></div>

								                                            </a>

							                                            </div>

							                                            <?php } ?>

						                                            </div>







						                                            <!-- <div class="video-button open-video" data-src="https://www.youtube.com/embed/<?php echo esc_attr( $item['link'] ); ?>?feature=oembed&autoplay=1&rel=0&showinfo=0">

						                                                <div class="img">

						                                                    <div class="triangle"></div>

						                                                </div>

						                                                <div class="text"><?php esc_html_e( 'Watch the video', 'jamesway' ); ?></div>

						                                            </div> -->

						                                        <?php endif; ?>

					                                        </div>

					                                    <?php endif; ?>

				                                    </div>

				                                <?php endforeach; 

				                                if( count( $video_items ) > 3 ): ?>

				                                    <div class="space-lg"></div>  

                                                    <?php if (!empty($button_text) && !empty($button_url)) { ?>
                                                        <a href="<?php echo esc_url($button_url); ?>" class="button webinar-show-more-button"><?php echo esc_html($button_text); ?></a>
                                                    <?php } ?>
				                                <?php endif; ?>

			                                </div>

			                            </div>

			                        <?php endif; ?>

		                        </div>

		                    </div>

		                </div>

		            </div>

                    <div class="space-xl"></div>

		        </div>

			<?php

		endif;

	endwhile;

endif;

get_footer();