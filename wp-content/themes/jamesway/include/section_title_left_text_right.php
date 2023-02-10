<?php
if (!defined('ABSPATH')) exit;
$big_title = get_sub_field('tl_tr_big_title');
$title = get_sub_field('tl_tr_title');
$text = get_sub_field('tl_tr_text');
?>
<div class="margin section">
    <div class="space-lg"></div>
    <div class="container-fluid">
        <div class="tl_tr_box">
            <?php if ($big_title): ?>
                <div class="tl_tr_big_title"><?php echo $big_title; ?></div>
            <?php endif;?>
            <div class="tl_tr_content">
            <?php if ($title): ?>
                <h3 class="tl_tr_title"><?php echo $title; ?></h3>
            <?php endif;?>
            <?php if ($text): ?>
                <div class="subtitle-text"><?php echo $text; ?></div>
            <?php endif;?>
            </div>
        </div>
    </div>
    <div class="space-lg"></div>
</div>

