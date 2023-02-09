<?php if (!defined('ABSPATH')) exit;

$our_products = get_sub_field('our-products');

$show_background_image = $our_products['show_background_image'];
$title = $our_products['title'];
$spaser = $our_products['add_spacer'];
$description = $our_products['description'];
$left_block = $our_products['content_left'];
$right_block = $our_products['right_block'];

if (!empty($left_block) || !empty($right_block) || !empty($title) || !empty($description)): ?>

    <div class="section our-products">
        <?php if($spaser):?>
        <div class="space-xl"></div>
        <?php endif;?>

        <div class="container-fluid">
            <?php if (!empty($title) || !empty($description)) { ?>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="simple-content">
                            <?php if (!empty($show_background_image)) { ?>
                                <div class="decor-title" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/jamesway-chick-master-three-eggs.svg);"></div> 
                                <?php // decor-egg.svg ?>
                            <?php } ?>
                            <?php if (!empty($title)) { ?>
                                <div class="block-title">
                                    <h2 class="h3"><?php echo esc_html($title); ?></h2>
                                </div>
                            <?php } ?>
                            <?php if (!empty($description)) {
                                echo wp_kses_post($description);
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="space-lg"></div>
            <?php } ?>
            <?php if (!empty($left_block) && !empty($right_block['title'])) { ?>
                <div class="row our-products-wrapper">
                    <?php if (!empty($left_block['title']) && !empty($left_block['description'])) { ?>
                        <div class="col-md-6">
                            <div class="img-wrapper">
                                <div class="img-item">
                                    <div class="big-img type-2" style="background-image: url(<?php echo esc_url($left_block['image']); ?>);">
                                        <div class="content-hide type-2">
                                            <div class="title-wrapper">
                                                <h4 class="h3"><?php echo esc_html($left_block['title']); ?></h4>
                                                <?php if (!empty($left_block['logo_icon'])) { ?>
                                                    <div class="title-img">
                                                        <img src="<?php echo esc_url($left_block['logo_icon']); ?>" alt="">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php echo wp_kses_post($left_block['description']); ?>
                                            <?php if (!empty($left_block['link_title']) && !empty($left_block['link_url'])) { ?>
                                                <a href="<?php echo esc_url($left_block['link_url']); ?>" class="button"><?php echo esc_html($left_block['link_title']); ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($right_block['title']) && !empty($right_block['description'])) { ?>
                        <div class="col-md-6">
                            <div class="img-wrapper">
                                <div class="img-item">
                                    <div class="big-img type-2" style="background-image: url(<?php echo esc_url($right_block['image']); ?>)">
                                       <div class="content-hide type-2">
                                          <div class="title-wrapper">
                                               <h4 class="h3"><?php echo esc_html($right_block['title']); ?></h4>
                                                <?php if (!empty($right_block['logo_icon'])) { ?>
                                                    <div class="title-img">
                                                        <img src="<?php echo esc_url($right_block['logo_icon']); ?>" alt="">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php echo wp_kses_post($right_block['description']); ?>
                                            <?php if (!empty($right_block['link_title']) && !empty($right_block['link_url'])) { ?>
                                                <a href="<?php echo esc_url($right_block['link_url']); ?>" class="button"><?php echo esc_html($right_block['link_title']); ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (!empty($left_block) && empty($right_block['title'])) { ?>
                <div class="row our-products-wrapper">
                    <?php if (!empty($left_block['title']) && !empty($left_block['description'])) { ?>
                        <div class="col-md-12">
                            <div class="img-wrapper">
                                <div class="img-item">
                                    <div class="big-img type-2" style="background-image: url(<?php echo esc_url($left_block['image']); ?>);">
                                        <div class="content-hide type-2">
                                            <div class="title-wrapper">
                                                <h4 class="h3"><?php echo esc_html($left_block['title']); ?></h4>
                                                <?php if (!empty($left_block['logo_icon'])) { ?>
                                                    <div class="title-img">
                                                        <img src="<?php echo esc_url($left_block['logo_icon']); ?>" alt="">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php echo wp_kses_post($left_block['description']); ?>
                                            <?php if (!empty($left_block['link_title']) && !empty($left_block['link_url'])) { ?>
                                                <a href="<?php echo esc_url($left_block['link_url']); ?>" class="button"><?php echo esc_html($left_block['link_title']); ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

        </div>

    </div>

<?php endif;