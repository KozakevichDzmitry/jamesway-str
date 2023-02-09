<?php if(!defined('ABSPATH')) exit; 

 $simple_slider = get_sub_field( 'simple_slider' );

 $side_decor    = get_sub_field( 'side_decor' ); 

 $slider_type    = get_sub_field( 'slider_type' );

 $slider_type = (!empty($slider_type)) ? $slider_type : 'homepage';





 if( $simple_slider ): 

 	$simple_images = '';

 	$s_i = 0; ?>

	 <div class="section">

        <div class="swiper-main-wrapper type1">

            <div class="swiper-wrap swiper-content swiper-decor">

                <div class="swiper-container swiper-control-bottom" data-breakpoints="1" data-slides-per-view="1" data-lg-slides="1" data-md-slides="1" data-sm-slides="1" data-xs-slides="1" data-auto-height="1">

                    <div class="swiper-wrapper">

                    	<?php foreach( $simple_slider as $simle_slide ):

                    		$s_i++;

	                    	if ( $simle_slide['image']['url'] ) 

	                    		$simple_images .= '<div class="swiper-slide">

						                            <div class="slide-bg" style="background-image: url('.$simle_slide['image']['url'].');"></div>

						                         </div>'; ?>

	                        <div class="swiper-slide">

	                            <div class="slide-content">

	                                <?php /* ?><div class="number"><?php echo $s_i < 10 ? '0'.$s_i : $s_i; ?> </div> */?>

                                    

                                    <?php /*if( $simle_slide['title'] ): ?>

		                                <div class="slide-title h4"><?php echo $simle_slide['title']; ?></div>

		                            <?php endif; */ ?>



                                    

                                    <?php if($slider_type == 'homepage'){ ?>

                                        <?php /* if (!empty($simle_slide['quantity'])) { ?>

                                            <div class="quantity"><?php echo esc_html($simle_slide['quantity']); ?></div>

                                        <?php } */ ?>

                                        <?php if (!empty($simle_slide['custom_icon'])) { ?>
                                        <div class="slide-icon">

                                            <img src="<?php echo esc_url($simle_slide['custom_icon']['url']);?>" alt="<?php echo esc_attr($simle_slide['custom_icon']['alt']);?>">    

                                        </div>
                                        <?php } ?>
                                        

                                        <?php if (!empty($simle_slide['title'])) { ?>

                                            <div class="quantity"><?php echo esc_html($simle_slide['title']); ?></div>

                                        <?php } ?>



                                        <?php if( $simle_slide['text'] ): ?>

		                                    <p> <?php echo wp_kses_post( $simle_slide['text'] ); ?></p>

		                                <?php endif; 

		                            

                                        if(!empty($simle_slide['link_title'])){

                                            if(!isset($simle_slide['link']) or empty($simle_slide['link']) or ($simle_slide['link'] == '#')){?>

                                                <a href="<?php echo esc_url( $simle_slide['link'] ); ?>" class="button scrolltocontact"><?php echo $simle_slide['link_title']; ?></a>

                                            <?php } elseif(!empty($simle_slide['link'])){?>

                                                <a href="<?php echo esc_url( $simle_slide['link'] ); ?>" class="button"><?php echo $simle_slide['link_title']; ?></a>

                                            <?php }

                                        } ?>



                                    <?php } ?>



                                    <?php if($slider_type == 'detailpage'){ ?>

                                        <?php ?><div class="number"><?php echo $s_i < 10 ? '0'.$s_i : $s_i; ?> </div>



                                        <?php if( $simle_slide['title'] ): ?>

		                                    <div class="slide-title h3"><?php echo $simle_slide['title']; ?></div>

		                                <?php endif; ?>



                                        <?php if( $simle_slide['text'] ): ?>

		                                    <p> <?php echo wp_kses_post( $simle_slide['text'] ); ?></p>

		                                <?php endif; 

		                            

                                        if(!empty($simle_slide['link_title'])){

                                            if(!isset($simle_slide['link']) or empty($simle_slide['link']) or ($simle_slide['link'] == '#')){?>

                                                <a href="<?php echo esc_url( $simle_slide['link'] ); ?>" class="button scrolltocontact"><?php echo $simle_slide['link_title']; ?></a>

                                            <?php } elseif(!empty($simle_slide['link'])){?>

                                                <a href="<?php echo esc_url( $simle_slide['link'] ); ?>" class="button"><?php echo $simle_slide['link_title']; ?></a>

                                            <?php }

                                        } ?>



                                    <?php } ?>



                                    <?php ?>



	                            </div>



	                        </div>

                        <?php endforeach; ?>

                    </div>

                </div>

                <div class="swiper-navigation">

                    <div class="swiper-button-prev custom-arrow-prev"></div>

                    <div class="swiper-pagination"></div>

                    <div class="swiper-button-next custom-arrow-next"></div>

                </div>

            </div>

            <div class="swiper-wrap">

                <div class="swiper-container swiper-control-top fade-effect" data-effect="fade">

                    <div class="swiper-wrapper">

                        <?php echo $simple_images; ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

<?php endif;