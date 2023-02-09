<?php if( !defined('ABSPATH') ) exit;
$tabs_type = get_sub_field( 'tabs_type' );
$tab_title = get_sub_field( 'tab_title' );
if( have_rows( 'tabs_section' ) ): ?>
	<div class="section margin <?php echo esc_attr( $tabs_type == 2 ? 'more-info-block-bg' : '' ); ?>">
		<?php echo $tabs_type == 2 ? '<div class="empty-lg-100 empty-xs-60"></div>' : ''; ?>
        <div class="container-fluid">
            <div class="row">
            	<?php if( $tab_title ): ?>
            		<div class="col-xs-12">
                        <div class="block-title type3">
                            <h3 class="h3"><?php echo $tab_title; ?></h3>
                        </div>
                        <div class="empty-lg-45 empty-xs-10"></div>
                    </div>
                <?php endif; ?>
                <div class="<?php echo esc_attr( $tabs_type == 2 ? 'col-lg-10 col-lg-offset-1' : 'col-lg-10 col-lg-offset-1' ); ?>">
                    <div class="more-info-block <?php echo esc_attr( $tabs_type == 2 ? 'type2' : '' ); ?>">
					<?php while ( have_rows( 'tabs_section' ) ) : the_row();
							if( get_row_layout() == 'tab' ): 
								$tab_title   = get_sub_field( 'title' );
								$tab_visible = get_sub_field( 'visible_content' );
								$tab_hidden  = get_sub_field( 'hidden_content' ); ?>
								<div class="more-info-content simple-article">
	                                <div class="more-info-article" <?php if(!wp_is_mobile()){?> style="height: 180px;" <?php } else {?>style="height: 174px;" <?php }?>>
	                                    <div class="article">
	                                    	<?php if( $tab_title ): ?>
			                                        <div class="title h4"><?php echo $tab_title; ?></div>
		                                    <?php endif; 
		                                    echo wp_kses_post( $tab_visible ? $tab_visible : '' ); 
		                                    if( $tab_hidden ): 
		                                    	if( $tabs_type == 1 ): ?>
			                                        <div class="table">
			                                            <div class="table-body">
			                                            	<?php foreach( $tab_hidden as $tab_hid ): ?>
				                                                <div class="table-row">
				                                                    <div class="table-column">
				                                                        <div class="table-title h6"><?php echo $tab_hid['title'] ? $tab_hid['title'] : ''; ?></div>
				                                                    </div>
				                                                    <div class="table-column">
				                                                        <?php echo wp_kses_post( $tab_hid['text'] ? $tab_hid['text'] : '' ); ?>
				                                                    </div>
				                                                </div>
				                                            <?php endforeach; ?>
			                                            </div>
			                                        </div>
		                            			<?php elseif( $tabs_type == 2 ):
		                            				foreach( $tab_hidden as $tab_hid ): 
		                            					if( $tab_hid['title'] ): ?>
			                            					<div class="title h4">
					                                           <?php echo $tab_hid['title']; ?>
					                                        </div>
                                                        <?php endif;
                                                        echo wp_kses_post( $tab_hid['text'] ? $tab_hid['text'] : '' ); ?>
		                                            <?php endforeach;
		                            			endif; 
	                            			endif; ?>
	                                    </div>
	                                </div>
	                                <div class="more-button size-l" data-text-hide="View Less" data-text-show="Read More">
	                                    <i><?php esc_html_e( 'Read More', 'jamesway' ); ?></i>
	                                </div>
	                            </div>
								<?php 
							endif; 
						endwhile; ?>
					</div>
                </div>
            </div>
        </div>
        <?php echo $tabs_type == 2 ? '<div class="empty-lg-100 empty-xs-60"></div>' : '<div class="space-xl"></div>'; ?>
    </div>
<?php endif;