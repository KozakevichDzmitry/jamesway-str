<?php if(!defined('ABSPATH')) exit; 
	$point_title = get_sub_field( 'title' );
	$point_image = get_sub_field( 'image' );
	$pintswrap = get_sub_field( 'pintswrap' ); 
	$text = get_sub_field( 'text' ); 
	if( $point_image || $text ): ?>
		<div class="section margin">
            <div class="space-lg"></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
	                    <?php if( $point_title ): ?>
	                        <div class="block-title">
	                            <h3 class="h3"><?php echo $point_title; ?></h3>
	                        </div>
                        <?php endif; ?>
                        <div class="empty-lg-60"></div>
                        <div class="technical-block">
	                        <?php if( $point_image ): ?>
	                            <div class="img" style="background-image: url(<?php echo esc_url( $point_image['url'] ); ?>);">
		                            <?php if($pintswrap){
		                            	foreach ($pintswrap as $points_val) {
											$text_point = !empty($points_val['text']) ? $points_val['text'] : '';
											$position_left = !empty($points_val['position_left']) ? ' left:'.$points_val['position_left'].'%;' : '';
											$position_top = !empty($points_val['position_top']) ? ' top:'.$points_val['position_top'].'%;' : '';
											$position = !empty($points_val['position']) ? $points_val['position'] : '';
											$position = ($position == 'right') ? 'type2' : '';
											echo '<div class="point" style="'.$position_left.$position_top.'">
													<span></span>
													<div class="detail '.$position.'"><p><i class="innerContent">'.$text_point.'</i></p></div>
												</div>';
		                            	}
		                            } ?>
	                            </div>
                            <?php endif;
                            if( $text ): ?>
	                            <div class="technical-block-desc">
	                                <?php echo wp_kses_post( $text ); ?>
	                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-lg"></div>            
        </div> 
<?php endif;