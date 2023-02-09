<?php if(!defined('ABSPATH')) exit; 
    $simple_title  = get_sub_field( 'simple_title' );
    $simple_content  = get_sub_field( 'content' );
	if( $simple_content): ?>
	<div class="section margin type-2">
        <div class="space-lg"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-12 simple-article">
                    <?php if( $simple_title ): ?>
                        <h1 class="h1"><?php echo $simple_title; ?></h1>
                    <?php endif; ?>
                    <?php echo wp_kses_post( $simple_content ); ?>
                </div>
            </div>
        </div>
        <div class="space-lg"></div>
    </div>
<?php endif;