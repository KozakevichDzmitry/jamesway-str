<?php if(!defined('ABSPATH')) exit;
    $form_type  = get_sub_field( 'form_type' ); 
    $form_title = get_sub_field( 'title' );
	$form_text  = get_sub_field( 'text' );
	$form_id    = get_sub_field( 'form' );
	if( $form_title['title'] || $form_title['subtitle'] || $form_id || $form_text ): 
        if( $form_type == 1 ): ?>
<div class="section contact-form-shortcode">
    <div class="space-xl"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <?php if( $form_title['title'] || $form_title['subtitle'] ): ?>
                <div class="form-title">
                    <?php if( $form_title['title'] ): ?>
                    <div class="big-title"><?php echo $form_title['title']; ?></div>
                    <?php endif;
                                    if( $form_title['subtitle'] ): ?>
                    <div class="small-title"><?php echo $form_title['subtitle']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="empty-lg-60 empty-xs-30"></div>
                <?php endif; 
                            if( $form_id ): ?>
                <div class="form-wrapper">
                    <?php echo do_shortcode( '[contact-form-7 id="'.$form_id.'" title="contact-form-'.$form_id.'"]' ); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="space-xl"></div>
</div>
<?php elseif( $form_type == 2 ): ?>
<div class="section">
    <div class="space-lg"></div>
    <div class="container-fluid">
        <div class="row">
            <div
                class="<?php echo esc_attr( !$form_id ? 'col-lg-12 col-md-12' : 'col-lg-7 col-md-6' ); ?> col-sm-12 col-xs-12">
                <div class="wrapper">
                    <?php if( $form_title['title'] || $form_title['subtitle'] ): ?>
                    <div class="form-title">
                        <?php if( $form_title['title'] ): ?>
                        <div class="big-title type2"><?php echo $form_title['title']; ?></div>
                        <?php endif;
                                        if( $form_title['subtitle'] ): ?>
                        <div class="small-title"><?php echo $form_title['subtitle']; ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endif; 
                                if( $form_text ): ?>
                    <div class="simple-article"><?php echo wp_kses_post( $form_text ); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if( $form_id ): ?>
            <div
                class="<?php echo esc_attr( ( !$form_title['title'] && !$form_title['subtitle'] ) && $form_text ? 'col-lg-12 col-md-12' : 'col-lg-5 col-md-6' ); ?> col-sm-12 col-xs-12">
                <div class="empty-lg-60 empty-xs-30"></div>
                <div class="form-wrapper type2">
                    <?php echo do_shortcode( '[contact-form-7 id="'.$form_id.'" title="Contact form-'.$form_id.'"]' ); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="empty-lg-180 empty-md-100 empty-sm-80 empty-xs-60"></div>
</div>
<?php endif;
    endif;