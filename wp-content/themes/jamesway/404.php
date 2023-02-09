<?php
/**
 * 404
 *
 * @package jamesway
 * @since 1.0.0
 *
 */

if( !defined('ABSPATH') ) exit; get_header(); ?>
	<div class="section margin">
        <div class="container-fluid">
            <div class="row">
            	<div class="space-lg"></div>
            	<div class="col-md-12 text-center error-block">
            		<p class="error-text text-center">404</p>
            		<a href="<?php echo home_url(); ?>" class="button"><?php esc_html_e( 'Back to home', 'jamesway' ); ?></a>
            	</div>
            	<div class="space-lg"></div>
            </div>
        </div>
	</div>
<?php
get_footer();