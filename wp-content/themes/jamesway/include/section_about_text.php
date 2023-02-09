<?php if( !defined('ABSPATH') ) exit;
	$about_text = get_sub_field( 'about_simple_text' );
	if( $about_text ): ?>
<div class="margin section">
    <div class="space-lg"></div>
    <div class="container-fluid">
        <div class="row vert-align">
            <div class="col-xs-12">
                <div class="simple-article type7 text-center">
                    <?php if( $about_text['bg_title'] ): ?>
                    <div class="number"><?php echo $about_text['bg_title']; ?></div>
                    <?php endif;
	                        if( $about_text['title'] ): ?>
                    <div class="title type2 h3"><?php echo $about_text['title']; ?></div>
                    <?php endif;
	                        echo wp_kses_post( $about_text['text'] ? $about_text['text'] : '' ); ?>

                    <?php if( $about_text['link'] ): ?>
                    <div class="ovation-block">
                        <a href="<?php echo $about_text['link']['url']; ?>">
                            <span class="text-ovation-block"><?php echo $about_text['link']['title']; ?></span>
                        </a>
                        <div class="image-ovation">
                            <?php echo wp_get_attachment_image($about_text['image']); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="space-lg"></div>
</div>
<?php endif;