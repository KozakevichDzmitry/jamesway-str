<?php if(!defined('ABSPATH')) exit; 
$product_slider = get_sub_field( 'products_slider' );
if( $product_slider ): ?>

<div class="section">
    <div class="space-lg"></div>
    <?php if( $product_slider['title'] ): ?>
    <div class="block-title">
        <h2 class="h2"><?php echo wp_kses_post( $product_slider['title'] ); ?></h2>
    </div>
    <div class="space-md"></div>
    <?php endif; 
	    if( $product_slider['products'] ): ?>
    <div
        class="swiper-main-wrapper product-swiper swiper-animation for-3-slide anination-newspadding change-pagination">
        <div class="swiper-navigation navigation-relative type2">
            <div class="swiper-button-prev custom-arrow-prev"></div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next custom-arrow-next"></div>
        </div>
        <div class="swiper-container swiper-content" data-breakpoints="1" data-slides-per-view="3" data-lg-slides="3"
            data-md-slides="2" data-sm-slides="2" data-xs-slides="1">
            <div class="swiper-wrapper">
                <?php foreach( $product_slider['products'] as $product ): ?>
                <div class="swiper-slide">
                    <div class="product-wrapper">
                        <?php
		                        		$tmb_full = has_post_thumbnail( $product ) ? get_the_post_thumbnail_url( $product ) : '';
										$tmb 	  = aq_resize( $tmb_full, 245, 275, true, true, true ); 
										if( $tmb ): ?>
                        <a href="<?php echo get_the_permalink( $product ); ?>" class="img">
                            <img src="<?php echo $tmb; ?>" alt="" />
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo get_the_permalink( $product ); ?>"
                            class="product-title h5"><?php echo get_the_title( $product ); ?></a>
                        <?php if( $tmb ): ?>
                        <div class="image-bg"
                            style="background-image: url(<?php echo THEME_URI; ?>/assets/img/image-bg.png);"></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="space-lg"></div>
    <?php endif; ?>
</div>

<?php endif;