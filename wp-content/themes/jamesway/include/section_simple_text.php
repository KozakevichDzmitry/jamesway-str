<?php if(!defined('ABSPATH')) exit; 
$simple_title = get_sub_field( 'simple_title' );
$simple_text  = get_sub_field( 'simple_text' );
if( $simple_title || $simple_text): ?>
	<div class="section after-banner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9 col-lg-offset-3 padding">
                    <div class="row info-block" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/decor-egg-blue.svg);">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                        	<?php if( $simple_title ): ?>
	                            <h2 class="title">
	                                <?php echo wp_kses_post( $simple_title ); ?>
	                            </h2>
	                        <?php endif; ?>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                        	<?php if( $simple_text ): ?>
	                            <p><?php echo wp_kses_post( $simple_text ); ?></p>
	                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-xl"></div>
    </div>
<?php endif;