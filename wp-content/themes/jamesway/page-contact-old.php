<?php
/**
 * Template name: Contact-old
 *
 * @package jamesway
 * @since 1.0.0
 *
 */

if( !defined('ABSPATH') ) exit; get_header();
	$cp_title     = get_field( 'cp_title' );
	$cp_bg_title  = get_field( 'cp_bg_title' );
	$cp_subtitle  = get_field( 'cp_subtitle' );
	$cp_locations = get_field( 'cp_locations' );
    $count_cp = 0; ?>
	<div class="section banner">
        <div class="clip-wrapper">
            <div class="bg-image" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/Rectangle.png);">
            </div>
        </div>
        <div class="svg-element counter-wrapper full-height countEnd">
            <svg version="1.1" width="100%" height="120px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="#ffffff" points="0,100 -10,20  50,0 110,20 100,100"></polygon>
            </svg>
        </div>
        <div class="container-fluid padding">
            <div class="row padding">
                <div class="col-lg-12 padding">
                    <div class="banner-content type4">
                        <div class="banner-content-cell">
                        	<?php if( $cp_bg_title ): ?>
	                            <div class="big-title"><?php echo $cp_bg_title; ?></div>
	                        <?php endif; 
	                        if( $cp_title ): ?>
                            	<h1 class="h1"><?php echo $cp_title; ?></h1>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section margin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="empty-lg-30"></div>
                    <div class="row">
                    	<?php if( $cp_subtitle ): ?>
                            <div class="col-lg-12">
                                <div class="block-title type4">
                                    <h3 class="h3"><?php echo $cp_subtitle; ?></h3>
                                </div>  
                                <div class="empty-lg-90 empty-ds-70 empty-sm-50 empty-xs-30"></div>
                            </div>
                        <?php endif;                         
                        if( $cp_locations ):
							foreach( $cp_locations as $location ): 
                            if($count_cp == 0 || $count_cp == 4){echo '<div class="row countrow'.$count_cp.'">';}   $count_cp++;
                                ?>

								<div class="col-md-3 col-sm-6 col-xs-12">
	                                <div class="contact-item">
	                                	<?php if( $location['title'] ): ?>
		                                    <div class="country"><?php echo $location['title']; ?></div>
		                                <?php endif; 
		                                if( $location['subtitle'] ): ?>
		                                    <div class="empty-lg-20 empty-md-15 empty-sm-10"></div>
		                                    <div class="desc"><?php echo $location['subtitle']; ?></div>
		                                <?php endif; 
		                                if( $location['address'] ): ?>
		                                    <div class="empty-lg-25 empty-md-15"></div>
		                                    <div class="address"><?php echo $location['address']; ?></div>
		                                <?php endif; 
		                                if( $location['contacts'] ): ?>
		                                	<div class="empty-lg-40 empty-md-20 empty-xs-10"></div>
	                                    	<ul>
			                                	<?php foreach( $location['contacts'] as $contact ):
			                                		if( $contact['number'] ):
														if( $contact['type'] == 1 ):
															echo wp_kses_post( '<li>Phone: <a href="tel:'.preg_replace( '![^0-9]+!', '', $contact['number'] ).'">'.$contact['number'].'</a></li>' );
														elseif( $contact['type'] == 2 ):
															echo wp_kses_post( '<li>Fax: <a href="fax:'.preg_replace( '![^0-9]+!', '', $contact['number'] ).'">'.$contact['number'].'</a></li>' );
														elseif( $contact['type'] == 3 ):
															echo wp_kses_post( '<li>Toll Free: <a href="tel:'.preg_replace( '![^0-9]+!', '', $contact['number'] ).'">'.$contact['number'].'</a></li>' );
														elseif( $contact['type'] == 4 ):
															echo wp_kses_post( '<li>Email: <a href="mailto:'.$contact['number'].'">'.$contact['number'].'</a></li>' );
														endif;
													endif;
												endforeach; ?>
											</ul>
										<?php endif; ?>
	                                </div>
	                                <div class="empty-sm-40 empty-xs-25"></div>
	                            </div>
                                
							<?php if($count_cp == 4 || $count_cp == 7){echo '</div>';}  
                            endforeach;
						endif; ?>
                    </div>                   
                </div>
            </div>
        </div>
        <div class="space-md"></div>
    </div>
    <?php
    	$reg_title 	  = get_field( 'cp_reg_title' );
        $reg_subtitle = get_field( 'cp_reg_subtitle' );
        $regions 	  = get_field( 'cp_regions' );
        $form         = get_field( 'cp_form' );

        $regions_list = '';
        $regions_html = ''; 

        if( $regions ):
        	foreach( $regions as $reg ):
        		if( $reg['country'] )
        			$regions_list .= '<option value="'.$reg['country'].'">'.$reg['country'].'</option>';

        		if( $reg['photo'] || $reg['name'] || $reg['position'] || $reg['phone'] || $reg['email'] ):
            		$regions_html .= '<div class="detail-info" data-type="'.$reg['country'].'">';
            						if( $reg['photo'] ):
		                                $regions_html .= '<div class="img" style="background-image: url('.$reg['photo']['url'].');"></div>';
		                            endif;
                        $regions_html .= '<div class="detail-info-desc">';
                        					if( $reg['country'] ):
			                                    $regions_html .= '<div class="country">'.$reg['country'].'</div>';
			                                endif;
			                                if( $reg['name'] ):
			                                    $regions_html .= '<div class="name">'.$reg['name'].'</div>';
			                                endif;
			                                if( $reg['position'] ):
			                                    $regions_html .= '<div class="empty-lg-20 empty-ds-10"></div>
			                                    <p>'.$reg['position'].'</p>';
			                                endif;
			                                if( $reg['phone'] ):
			                                    $regions_html .= '<div class="empty-lg-40 empty-ds-25"></div>
			                                    <div class="info-item">Phone: <a href="tel:'.preg_replace( '![^0-9]+!', '', $reg['phone'] ).'">'.$reg['phone'].'</a></div>';
			                                endif;
			                                if( $reg['email'] ):
			                                    $regions_html .= '<div class="info-item">Email: <a href="mailto:'.$reg['email'].'">'.$reg['email'].'</a></div>';
			                                endif;
                        $regions_html .= '</div>
		                            </div>';
		        endif;

        	endforeach;
        endif;
    ?>
    <div class="section margin">
        <div class="container-fluid">
            <div class="row">
                <?php if( $form ): ?>
                    <div class="<?php echo esc_attr( !$regions_list ? 'col-lg-12' : 'col-lg-7' ); ?>">
                        <div class="empty-lg-220 empty-md-0 empty-sm-0"></div>
                        <?php if( $form['title'] ): ?>
                        <div class="block-title type4">
                            <h3 class="h3"><?php echo $form['title']; ?></h3>
                        </div>
                    <?php endif; 
                    if( $form['form'] ):?>
                        <div class="space-md"></div>
                        <?php echo do_shortcode( '[contact-form-7 id="'.$form['form'].'" html_class="type2" title="Contact form - '.$form['form'].'"]' ); ?>
                    <?php endif; ?>
                    </div>
                <?php endif;
                if( $regions_list ): ?> 
                    <div class="<?php echo esc_attr( !$form ? 'col-lg-12' : 'col-lg-5 padding' ); ?>">
                        <div class="space-lg"></div>
                        <div class="contact-drop-down">
                        	<?php if( $reg_title ): ?>
	                            <div class="title h3"><?php echo $reg_title; ?></div>
	                        <?php endif; 
	                        if( $reg_subtitle ): ?>
	                            <div class="desc"><?php echo $reg_subtitle; ?></div>
	                        <?php endif; ?>
                            <div class="empty-lg-60 empty-ds-50 empty-xs-30"></div>
                            <div class="drop-down">
                                <div class="sumoWrapper">
                                    <select name="interest" class="SelectBox">
                                        <option value="" selected disabled><?php esc_html_e( 'Select Country', 'jamesway' ); ?></option>
                                        <?php echo $regions_list; ?>
                                    </select>
                                </div>
                            </div>
                            <?php echo $regions_html; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="empty-lg-140 empty-ds-100 empty-sm-80 empty-xs-60"></div>
    </div>
<?php get_footer();