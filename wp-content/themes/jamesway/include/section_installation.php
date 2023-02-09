<?php if(!defined('ABSPATH')) exit; 
	$insta_image = get_sub_field( 'insta_image' ); 
	$insta_title = get_sub_field( 'insta_title' ); 
	$insta_subtitle = get_sub_field( 'insta_subtitle' ); 
	$insta_link     = get_sub_field( 'insta_link' ); 
	$custom_id = get_sub_field( 'custom_id' );
	$id_out = (!empty(custom_id)) ? ' id="'.esc_attr($custom_id).'"' : '';
	$id_out_p = (!empty(custom_id)) ? ' id="'.esc_attr($custom_id).'-p"' : '';
	$insta_link_title = get_sub_field( 'insta_link_title' ); ?>
	 <div class="section section-map" <?php echo $id_out; ?>>
        <div class="space-xlg"></div>
        <div class="bg-image" style="background-image: url(<?php echo esc_url( $insta_image ? $insta_image['url'] : '' ); ?>);"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 text-center">
                	<?php if( $insta_title || $insta_subtitle ): ?>
	                    <div class="block-title type2 size2">
	                    	<?php if( $insta_title ): ?>
		                        <h2 class="h1"><?php echo $insta_title; ?></h2>
		                    <?php endif;
		                    if( $insta_subtitle ): ?>
		                        <div class="empty-lg-25"></div>
	                        	<p <?php echo $id_out_p; ?>><?php echo $insta_subtitle; ?></p>
	                        <?php endif; ?>
	                    </div>
	                <?php endif; ?>
                    <div class="empty-lg-35"></div>
                    <?php if( $insta_link && $insta_link_title ): ?>
	                    <a href="<?php echo esc_url( $insta_link ); ?>" class="button type2"><?php echo wp_kses_post( $insta_link_title ); ?>  <svg width="16px" height="27px" viewBox="0 0 16 27" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
	                            <g id="Home" transform="translate(-1008.000000, -3475.000000)" fill-rule="nonzero">
	                                <g id="Group-12" transform="translate(604.000000, 3240.000000)">
	                                    <g id="9903" transform="translate(404.000000, 235.000000)">
	                                        <path d="M13.6623377,2.34643504 C12.1038961,0.782127438 10.2164675,0 8,0 C5.78353247,0 3.8961039,0.782127438 2.33766234,2.34643504 C0.779220779,3.91074265 0,5.80017651 0,8.01478936 C0,9.35057001 0.666649351,11.5827943 2,14.7113568 C3.33335065,17.839972 4.66664935,20.6873314 6,23.2534349 C7.33335065,25.8195385 8,27.0675255 8,26.9971852 C8.20779221,26.6104716 8.49350649,26.0831828 8.85714286,25.4153189 C9.22077922,24.7474549 9.86145455,23.4907149 10.7792208,21.6452042 C11.696987,19.7996934 12.5021818,18.1036164 13.1948052,16.5568675 C13.8874805,15.0102241 14.5281558,13.4106936 15.1168831,11.7585396 C15.7056104,10.1063857 16,8.85845139 16,8.01478936 C16,5.80017651 15.2207792,3.91074265 13.6623377,2.34643504 Z M9.71428571,9.70211343 C9.22945455,10.194232 8.64935065,10.4403177 7.97402597,10.4403177 C7.2987013,10.4403177 6.7185974,10.194232 6.23376623,9.70211343 C5.74893506,9.20999482 5.50649351,8.62117145 5.50649351,7.93569604 C5.50649351,7.25022064 5.74893506,6.67020298 6.23376623,6.19564309 C6.7185974,5.72108319 7.2987013,5.48380324 7.97402597,5.48380324 C8.64935065,5.48380324 9.22945455,5.72108319 9.71428571,6.19564309 C10.1991169,6.67020298 10.4415584,7.25022064 10.4415584,7.93569604 C10.4415584,8.62117145 10.1991169,9.20999482 9.71428571,9.70211343 Z" id="Shape"></path>
	                                    </g>
	                                </g>
	                            </g>
	                        </g>
	                    </svg></a>
	                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="space-xlg"></div>
    </div>
<?php
