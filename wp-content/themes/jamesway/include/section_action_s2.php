<?php if (!defined('ABSPATH')) exit;

$action_s2 = get_sub_field('action_s2');

$image = $action_s2['image'];
$title = $action_s2['title'];
$content_repeater = $action_s2['content_repeater'];

if (!empty($image) || !empty($title) || !empty($content_repeater)): ?>
    <div class="section request">
        <div class="space-lg"></div>
        
        <div class="request-wrapp">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-9 col-md-7 col-12">
                        <?php if (!empty($title)) { ?>
                            <div class="block-title">
                                <div class="h3"><?php echo wp_kses_post($title); ?></div>
                            </div>
                        <?php } ?>
                        <?php if (!empty($content_repeater)) { ?>
                            <div class="request-inner">
                                <?php foreach ($content_repeater as $item) {
                                    if ($item['title'] || (!empty($item['link_text']) && !empty($item['link_url']))) { ?>
                                        <div class="request-item">
                                            <?php if (!empty($item['title'])) { ?>
                                                <div class="title h4"><?php echo esc_html($item['title']); ?></div>
                                            <?php } ?>
                                            <?php if (!empty($item['link_text']) && !empty($item['link_url'])) { ?>
                                                <a href="<?php echo esc_url($item['link_url']); ?>" class="button" <?php if($item['open_in_new_tab']){ echo 'target="_blank"'; } else { echo 'target="_self"';}?> ><?php echo esc_html($item['link_text']); ?></a>
                                            <?php } ?>
                                        </div>
                                    <?php }
                                } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if (!empty($image['url'])) { ?>
                        <div class="col-lg-3 col-md-5 col-12">
                            <div class="request-img">
                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_url($image['alt']); ?>">
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="space-xl"></div>

    </div>
<?php endif;