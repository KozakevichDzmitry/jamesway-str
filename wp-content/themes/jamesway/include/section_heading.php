<?php if( !defined('ABSPATH') ) exit;
	$h_title = get_sub_field( 'title' );
	if( $h_title ): ?>
		<div class="section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="block-title">
                            <h3 class="h3"><?php echo $h_title; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php endif;