<?php if(!defined('ABSPATH')) exit; 
	$it_image = get_sub_field( 'image' );
	$it_title = get_sub_field( 'title' );
	$it_text  = get_sub_field( 'text' );
	$it_link  = get_sub_field( 'link' ); ?>
	<div class="section margin side-decor type2">
        <div class="space-lg"></div>
        <div class="container-fluid">
            <div class="row vert-align">
                <div class="col-md-6 col-sm-12 col-xs-12  <?php if(!wp_is_mobile()){?>padding <?php } ?>">
                    <div class="general-info">
                        <div class="img" style="background-image: url(<?php echo esc_url( $it_image ? $it_image['url'] : '' ); ?>);"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 <?php if(!wp_is_mobile()){?>padding <?php } ?>">
                    <div class="simple-article type3">
                    	<?php if( $it_title ): ?>
	                        <div class="title h3"><?php echo $it_title; ?></div>
	                    <?php endif; 
	                    if( $it_text ): ?>
                        	<div class="empty-lg-20"></div>
                        	<p><?php echo wp_kses_post( $it_text ); ?></p>
                        <?php endif; 

                        if(!empty($it_link['link_title'])){
                            if(!isset($it_link['link']) or empty($it_link['link']) or ($it_link['link'] == '#')){?>
                                <a href="<?php echo esc_url( $it_link['link'] ); ?>" class="button scrolltocontact"><?php echo $it_link['link_title']; ?></a>
                            <?php } elseif(!empty($it_link['link'])){?>
                                <a href="<?php echo esc_url( $it_link['link'] ); ?>" class="button"><?php echo $it_link['link_title']; ?></a>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-lg"></div>            
    </div>