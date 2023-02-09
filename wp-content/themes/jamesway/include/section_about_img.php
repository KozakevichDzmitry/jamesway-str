<?php if( !defined('ABSPATH') ) exit;
    $position = get_sub_field( 'position' );
	$content  = get_sub_field( 'about_image_text' );
    $custom_id = get_sub_field( 'custom_id' );
    $id_out = (!empty(custom_id)) ? ' id="'.esc_attr($custom_id).'"' : '';

	if( $content ): 
        if( $position == 1 ): ?>
    		<div class="margin type2 section <?php echo esc_attr($custom_id); ?>" <?php echo $id_out; ?>>
                <div class="empty-lg-80 empty-md-60"></div>
                <div class="container-fluid">
                    <div class="row vert-align">
                        <div class="col-md-4 col-md-push-8 col-sm-12 col-xs-12">
                            <div class="simple-article type3">
                            	<?php if( $content['title'] ): ?>
    	                            <div class="title type2 h4"><?php echo $content['title']; ?></div>
    	                        <?php endif; 
    	                        if( $content['text'] ): ?>
    	                            <div class="empty-lg-30 empty-xs-15"></div>
    	                            <?php echo wp_kses_post( $content['text'] ); ?>
    	                        <?php endif; ?>
                            </div>
                        </div>
                         <div class="col-md-8 col-md-pull-4 col-sm-12 col-xs-12">
                            <div class="general-info">
                                <div class="img" style="background-image: url(<?php echo esc_url( $content['image'] ? $content['image']['url'] : '' ); ?>);"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="empty-lg-200 empty-md-60 empty-xs-0"></div>            
            </div>
        <?php else: ?>
            <div class="margin type2 section <?php echo esc_attr($custom_id); ?>" <?php echo $id_out; ?>>
                <div class="empty-lg-80 empty-md-60"></div>
                <div class="container-fluid ">
                    <div class="row vert-align">
                        <div class="col-md-8 col-md-push-4 col-sm-12 col-xs-12">
                            <div class="general-info">
                                <div class="img" style="background-image: url(<?php echo esc_url( $content['image'] ? $content['image']['url'] : '' ); ?>);"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-md-pull-8 col-sm-12 col-xs-12">
                            <div class="simple-article type3">
                                <<?php if( $content['title'] ): ?>
                                    <div class="title type2 h4"><?php echo $content['title']; ?></div>
                                <?php endif; 
                                if( $content['text'] ): ?>
                                    <div class="empty-lg-30"></div>
                                    <?php echo wp_kses_post( $content['text'] ); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="empty-lg-80 empty-md-60"></div>            
            </div>
        <?php endif;
    endif;