<?php
/**
 * Template name: Projects
 *
 * @package jamesway
 * @since 1.0.0
 *
 */

if( !defined('ABSPATH') ) exit; get_header();
	$banner = get_field( 'projects_banner' ); 
	$projects_title    = get_field( 'projects_title' );
	$projects_subtitle = get_field( 'projects_subtitle' );
	$map = get_field( 'projects_map' ); ?>
	<div class="section banner">
        <div class="clip-wrapper">
            <div class="bg-image" style="background-image: url(<?php echo esc_url( $banner ? $banner['url'] : '' ); ?>);">
            </div>
        </div>
        <div class="svg-element counter-wrapper full-height countEnd">
            <svg version="1.1" width="100%" height="170px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="#ffffff" points="0,100 -10,20  50,0 110,20 100,100"></polygon>
            </svg>
        </div>
        <div class="container-fluid padding">
            <div class="row padding">
                <div class="col-lg-12 padding">
                    <div class="banner-content type2">
                        <div class="banner-content-cell">
                            
                            <ul class="breadcrumbs">
                                <li><a href="<?php echo home_url('/'); ?>"><?php esc_html_e('Home', 'jamesway'); ?></a></li>
                                <li class="active"><?php echo $projects_title; ?></li>
                            </ul>

                        	<?php if( $projects_title ): ?>
	                            <h1 class="h1"><?php echo $projects_title; ?></h1>
	                        <?php endif; 
	                        if( $projects_subtitle ): ?>
	                            <div class="space-md"></div>
	                            <div class="content">
	                                <div class="h6 subtitle"><p><?php echo wp_kses_post( $projects_subtitle ); ?></p></div>
	                            </div>
	                        <?php endif; ?>
                        </div>
                    </div>
                    <div class="space-lg"></div>
                </div>
            </div>
        </div>
    </div>
	<?php if( $map ): ?>
	   <?php /*  <div class="section margin">
	        <div class="container-fluid">
	            <div class="row">
	                <div class="col-lg-12">
	                	<?php if( $map['title'] ): ?>
		                    <div class="block-title type3">
		                        <h5 class="h5"><?php echo $map['title']; ?></h5>
		                    </div>
		                <?php endif; 
		                if( $map['markers'] ): ?>
		                    <div class="map-markers">
		                        <ul>
		                        	<?php foreach( $map['markers'] as $point ): ?>
			                            <li>
			                            	<?php if( $point == 1 ): ?>
			                                	<img src="<?php echo THEME_URI; ?>/assets/img/chickens.png" alt="" />
			                                	<?php esc_html_e( 'Chickens', 'option' ); ?>
			                                <?php elseif( $point == 2 ): ?>
			                                	<img src="<?php echo THEME_URI; ?>/assets/img/ducks-marker.png" alt="" />
		                                		<?php esc_html_e( 'Turkeys, Ducks and Geese', 'option' ); ?>
			                                <?php elseif( $point == 3 ): ?>
			                                	<img src="<?php echo THEME_URI; ?>/assets/img/pharmaceutical.png" alt="" />
		                                		<?php esc_html_e( 'Pharmaceutical', 'option' ); ?>
			                                <?php elseif( $point == 4 ): ?>
			                                	<img src="<?php echo THEME_URI; ?>/assets/img/other.png" alt="" />
	                                			<?php esc_html_e( 'Other', 'option' ); ?>
			                                <?php endif; ?>
			                            </li>
			                        <?php endforeach; ?>
		                        </ul>
		                    </div>
		                <?php endif; ?>
	                </div>
	            </div>
	        </div>
	        <div class="space-lg"></div>
	    </div> */?>
	    <div class="section">
	    	<?php if( $map['base_coordinats']['longitude'] && $map['base_coordinats']['latitude'] ): ?>
	            <div id="map" data-lat="<?php echo esc_attr( $map['base_coordinats']['latitude'] ); ?>" data-lng="<?php echo esc_attr( $map['base_coordinats']['longitude'] ); ?>" data-zoom="3" data-map-marker="<?php echo THEME_URI; ?>/assets/img/map-marker.png" data-chickens="<?php echo THEME_URI; ?>/assets/img/chickens.png" data-ducks="<?php echo THEME_URI; ?>/assets/img/ducks-marker.png" data-pharmaceutical="<?php echo THEME_URI; ?>/assets/img/pharmaceutical.png" data-other="<?php echo THEME_URI; ?>/assets/img/other.png"></div>
	        <?php endif; ?>
            <div class="space-xl"></div>
	    </div>
	<?php endif;

	$map_points = get_field( 'projects_map_points' );
	if( $map_points ):
		$point_arr = [];
		foreach( $map_points as $map_p ):
			if( $map_p['status'] == 1 ):
				$status = 'Chickens';
			elseif( $map_p['status'] == 2 ):
				$status = 'Ducks';
			elseif( $map_p['status'] == 3 ):
				$status = 'Pharmaceutical';
			elseif( $map_p['status'] == 4 ):
				$status = 'Other';
			endif;
			$lng = $map_p['longitude'] ? $map_p['longitude'] : '';
			$lat = $map_p['latitude'] ? $map_p['latitude'] : '';

			$p_title    = $map_p['title'] ? '<div class="title">'.strip_tags($map_p['title']).'</div>' : '';
			$p_date  	= $map_p['date'] ? '<br><div class="date">'.strip_tags($map_p['date']).'</div>' : '';
            $p_subtitle = $map_p['subtitle'] ? '<br><div class="subtitle">'.strip_tags($map_p['subtitle']).'</div>' : '';
			$p_text  	= $map_p['text'] ? '<br><p>'.strip_tags($map_p['text']).'</p>' : '';


			$p_link_one = $map_p['link_one']['title'] && $map_p['link_one']['link'] ? '<br><a href="'.$map_p['link_one']['link'].'">'.$map_p['link_one']['title'].'</a>' : '';
			$p_link_two = $map_p['link_two']['title'] && $map_p['link_two']['link'] ? '<br><a href='.$map_p['link_two']['link'].'">'.$map_p['link_two']['title'].'</a>' : '';

			$point_arr[] = array(
				'status' => $status,
				'location' => array(
					'lat' => $lat,
  					'lng' => $lng,
  				),
  				'info' => '<div class="map-info" style="background-image: url(' . THEME_URI . '/assets/img/decor-egg-white.svg);"><div class="btn-close"></div>'.$p_title.$p_date.$p_subtitle.$p_text.$p_link_one.$p_link_two.'</div>'
			);
		endforeach; ?>
		<script> var mapJSON = <?php echo wp_json_encode( $point_arr ); ?> </script>
		<?php
	endif;

	wp_enqueue_script( 'googleapis' );
	wp_enqueue_script( 'snazzy-info-window' );
	wp_enqueue_script( 'map' );
get_footer();