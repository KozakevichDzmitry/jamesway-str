<?php
$megamenu_left_column = get_field('megamenu_left_column', 'option');
$megamenu_right_column = get_field('megamenu_right_column', 'option');
?>

<ul class="sub-menu categories">
    <div class="categories-inner decor-popup">
        <div class="categories-wrapper">
            <?php if (!empty($megamenu_left_column['mini_menu_links']) || !empty($megamenu_left_column['menu_links']) || !empty($megamenu_left_column['button_name']) || !empty($megamenu_left_column['button_link'])) { ?>
                <div class="category-item">
                    <?php if (!empty($megamenu_left_column['logo']['url'])) { ?>
                        <div class="category-img">
                            <img src="<?php echo esc_url($megamenu_left_column['logo']['url']); ?>" alt="<?php echo esc_url($megamenu_left_column['logo']['alt']); ?>">
                        </div>
                    <?php } ?>
                    <?php if (!empty($megamenu_left_column['title'])) { ?>
                        <div class="title"><?php echo esc_html($megamenu_left_column['title']); ?></div>
                    <?php } ?>
                    <?php if (!empty($megamenu_left_column['mini_menu_links'])) { ?>
                        <ul class="main-cat">
                            <?php foreach ($megamenu_left_column['mini_menu_links'] as $item) {
                                $link_name = $link_url = '';
                                if ($item['menus_link_type'] == 'custom') {
                                    $link_name = $item['link_name'];
                                    $link_url = $item['link_url'];
                                } else if ($item['menus_link_type'] == 'page') {
                                    $link_name = get_the_title($item['page']);
                                    $link_url = get_permalink($item['page']);
                                }
                                if (!empty($link_name) && !empty($link_url)) { ?>
                                    <li><a href="<?php echo esc_url($link_url); ?>"><?php echo esc_html($link_name); ?></a></li>
                            <?php }
                            } ?>
                        </ul>
                    <?php } ?>

                    <?php if (!empty($megamenu_left_column['menu_links'])) { ?>
                        <ul class="sub-cat">
                            <?php foreach ($megamenu_left_column['menu_links'] as $item) {
                                $link_name = $link_url = '';
                                if ($item['menus_link_type'] == 'custom') {
                                    $link_name = $item['link_name'];
                                    $link_url = $item['link_url'];
                                } else if ($item['menus_link_type'] == 'page') {
                                    $link_name = get_the_title($item['page']);
                                    $link_url = get_permalink($item['page']);
                                }
                                if (!empty($link_name) && !empty($link_url)) { ?>
                                    <li><a href="<?php echo esc_url($link_url); ?>"><?php echo esc_html($link_name); ?></a></li>
                            <?php }
                            } ?>
                        </ul>
                    <?php } ?>
                    <?php if (!empty($megamenu_left_column['button_name']) || !empty($megamenu_left_column['button_link'])) { ?>
                        <a href="<?php echo esc_url($megamenu_left_column['button_link']); ?>" class="link"><?php echo esc_html($megamenu_left_column['button_name']); ?></a>
                    <?php } ?>
                </div>
            <?php }

            if (!empty($megamenu_right_column['mini_menu_links']) || !empty($megamenu_right_column['menu_links']) || !empty($megamenu_right_column['button_name']) || !empty($megamenu_right_column['button_link'])) { ?>
                <div class="category-item">
                    <?php if (!empty($megamenu_right_column['logo']['url'])) { ?>
                        <div class="category-img">
                            <img src="<?php echo esc_url($megamenu_right_column['logo']['url']); ?>" alt="<?php echo esc_url($megamenu_right_column['logo']['alt']); ?>">
                        </div>
                    <?php } ?>
                    <?php if (!empty($megamenu_right_column['title'])) { ?>
                        <div class="title"><?php echo esc_html($megamenu_right_column['title']); ?></div>
                    <?php } ?>
                    <?php if (!empty($megamenu_right_column['mini_menu_links'])) { ?>
                        <ul class="main-cat">
                            <?php foreach ($megamenu_right_column['mini_menu_links'] as $item) {
                                $link_name = $link_url = '';
                                if ($item['menus_link_type'] == 'custom') {
                                    $link_name = $item['link_name'];
                                    $link_url = $item['link_url'];
                                } else if ($item['menus_link_type'] == 'page') {
                                    $link_name = get_the_title($item['page']);
                                    $link_url = get_permalink($item['page']);
                                }
                                if (!empty($link_name) && !empty($link_url)) { ?>
                                    <li><a href="<?php echo esc_url($link_url); ?>"><?php echo esc_html($link_name); ?></a></li>
                            <?php }
                            } ?>
                        </ul>
                    <?php } ?>

                    <?php if (!empty($megamenu_right_column['menu_links'])) { ?>
                        <ul class="sub-cat">
                            <?php foreach ($megamenu_right_column['menu_links'] as $item) {
                                $link_name = $link_url = '';
                                if ($item['menus_link_type'] == 'custom') {
                                    $link_name = $item['link_name'];
                                    $link_url = $item['link_url'];
                                } else if ($item['menus_link_type'] == 'page') {
                                    $link_name = get_the_title($item['page']);
                                    $link_url = get_permalink($item['page']);
                                }
                                if (!empty($link_name) && !empty($link_url)) { ?>
                                    <li><a href="<?php echo esc_url($link_url); ?>"><?php echo esc_html($link_name); ?></a></li>
                            <?php }
                            } ?>
                        </ul>
                    <?php } ?>
<!--                    --><?php //if (!empty($megamenu_right_column['button_name_copy']) || !empty($megamenu_right_column['button_link_copy'])) { ?>
<!--                        <a href="--><?php //echo esc_url($megamenu_right_column['button_link']); ?><!--" class="link mega-menu-link">--><?php //echo esc_html($megamenu_right_column['button_name']); ?><!--</a>-->
<!--                    --><?php //} ?>
<!--                    --><?php //if (!empty($megamenu_right_column['button_name_copy']) || !empty($megamenu_right_column['button_link_copy'])) { ?>
<!--                        <a href="--><?php //echo esc_url($megamenu_right_column['button_link_copy']); ?><!--" class="link mega-menu-link">--><?php //echo esc_html($megamenu_right_column['button_name_copy']); ?><!--</a>-->
<!--                    --><?php //} ?>
                </div>
            <?php } ?>
        </div>
    </div>
</ul>
<span></span>