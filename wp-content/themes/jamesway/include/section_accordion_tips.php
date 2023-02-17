<?php if (!defined('ABSPATH')) exit;
$accordion_tips = get_sub_field('accordion_tips');
?>

<div class="section margin tips">
    <div class="container-fluid">
        <div class="accordion__tips">
            <?php foreach ($accordion_tips as $tip):
                $description = '';
                $excerpt = '';
                if (array_key_exists('description', $tip) && !empty($tip['description'])) {
                    $description = $tip['description'];
                    $excerpt = mb_strimwidth($description, 0, 215, '...');;
                }
                ?>
                <div class="accordion__tips-element">
                    <div class="accordion__tips-image">
                        <div class="accordion__tips-image-wrapper">
                            <?php if (array_key_exists('image', $tip) && !empty($tip['image'])) {
                                echo wp_get_attachment_image ( $tip['image'], 'medium');
                            } ?>
                        </div>
                    </div>
                    <div class="accordion__tips-element-wrapper">
                        <div class="accordion__tips-header">
                            <h3 class="accordion__tips-title">
                                <?php if (array_key_exists('title', $tip) && !empty($tip['title'])) {
                                    echo $tip['title'];
                                } ?>
                            </h3>
                            <div class="accordion__tips-excerpt"><?php echo $excerpt; ?></div>
                        </div>
                        <div class="accordion__tips-content">
                            <?php echo $description; ?>
                        </div>
                        <span class="accordion_arrow"></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
</div>