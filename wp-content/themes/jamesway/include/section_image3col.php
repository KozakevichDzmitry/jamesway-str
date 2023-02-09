<?php if( !defined('ABSPATH') ) exit;
	$i_image  = get_sub_field( 'image' );
	$i_title  = get_sub_field( 'title' );
	$i_text   = get_sub_field( 'text' );
	$i_column = get_sub_field( 'columns' ); ?>
	<div class="section">
        <div class="container-fluid padding">
            <div class="row vert-align">
                <div class="col-md-7 col-sm-12 col-xs-12">
                    <div class="general-info type2">
                        <div class="img" style="background-image: url(<?php echo esc_url( $i_image ? $i_image['url'] : '' ); ?>);"></div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12">
                    <div class="simple-article type4">
                    	<?php if( $i_title ): ?>
                            <div class="title h3"><?php echo $i_title; ?></div>
                        <?php endif; 
                        if( $i_text ): ?>
                        <div class="empty-lg-20"></div>
                            <p><?php echo wp_kses_post( $i_text ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if( $i_column ): 
                	$i_i = 0; ?>
                    <div class="col-xs-12">
                    	<?php foreach( $i_column as $i_col ):
                    		$i_i++; 
                    		if( $i_col['title'] || $i_col['subtitle'] ): ?>
		                        <div class="number-wrapper">
		                            <div class="number"><?php echo esc_attr( $i_i < 10 ? '0'.$i_i : '' ); ?></div>
		                            <?php if( $i_col['title'] ): ?>
		                            	<div class="title"><?php echo $i_col['title']; ?></div>
		                            <?php endif;
		                            if( $i_col['subtitle'] ): ?>
			                            <p><?php echo $i_col['subtitle']; ?></p>
			                        <?php endif; ?>
		                        </div>
	                    <?php endif;
	                	endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="space-lg"></div>            
    </div>