<?php if( !defined('ABSPATH') ) exit;
    $acc_image = get_sub_field( 'image' );
    $acc_list  = get_sub_field( 'accordion_list' ); 
    if( $acc_list ): ?>
    <div class="section">
        <div class="accordion-container">
            <div class="accordion-bg" style="background-image: url(<?php echo esc_url( $acc_image ? $acc_image['url'] : '' ); ?>);"></div>
            <div class="accordion">
                <?php foreach( $acc_list as $acc_item ): ?>
                    <div class="accordion-element">
                        <?php if( $acc_item['title'] ): ?>
                            <div class="accordion-title h6"><?php echo $acc_item['title']; ?><span></span></div>
                        <?php endif; ?>
                        <div class="accordion-content">
                            <?php echo $acc_item['content'] ? $acc_item['content'] : ''; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif;