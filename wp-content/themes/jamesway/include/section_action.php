<?php if(!defined('ABSPATH')) exit;
	$action_title = get_sub_field( 'action_title' );
	$action_link  = get_sub_field( 'action_link' );

	if( $action_title || $action_link ): ?>
		<div class="section">
            <div class="request-block">
            	<?php if( $action_title ): ?>
	                <div class="title h4"><?php echo $action_title; ?></div>
	            <?php endif;
	            if( $action_link['link_title'] && $action_link['link'] ): ?>
	                <a href="<?php echo esc_url( $action_link['link'] ); ?>" class="button"><?php echo $action_link['link_title']; ?></a>
	            <?php endif; ?>
            </div> 
        </div>
<?php endif;