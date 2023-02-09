<?php if(!defined('ABSPATH')) exit;
    $banner = get_field( 'banner_2' ); ?>
<div class="section banner">
    <div class="clip-wrapper">
        <div class="bg-image"
            style="background-image: url(<?php echo THEME_URI; ?>/assets/img/product-bannner-bg.png);">
        </div>
    </div>
    <div class="svg-element counter-wrapper full-height countEnd">
        <svg version="1.1" width="100%" height="170px" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 100 100"
            preserveAspectRatio="none">
            <polygon fill="#ffffff" points="0,100 -10,20  50,0 110,20 100,100"></polygon>
        </svg>
    </div>
    <div class="container-fluid padding">
        <div class="row">
            <div class="col-lg-12">
                <div class="banner-content type3">


                    <div class="banner-content-cell">
                        <?php if( $banner['breadcrumbs'] ): ?>
                            <!-- BREADCRUMBS -->
                            <ul class="breadcrumbs relative">
                                <?php foreach ($banner['breadcrumbs'] as $breadcrumb_id) { ?>
                                    <li><a href="<?php echo get_permalink($breadcrumb_id); ?>"><?php echo get_the_title($breadcrumb_id); ?></a></li>
                                <?php } ?>
                                <li class="active"><?php echo the_title(); ?></li>
                            </ul>
                        <?php endif; ?>
                        <?php if( $banner['title'] ): ?>
                        <h1 class="h1"><?php echo $banner['title']; ?></h1>
                        <?php endif;
	                        if( $banner['text'] ): ?>
                        <div class="space-md"></div>
                        <div class="content">
                            <div class="h6 subtitle">
                                <p><?php echo wp_kses_post( $banner['text'] ); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if( $banner['image'] ): ?>
                    <div class="element-img">
                        <img src="<?php echo esc_url( $banner['image']['url'] ); ?>">
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>