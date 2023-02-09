<div class="popup-wrapper">
    <div class="bg-layer"></div>
    <div class="popup-content" id="video-popup">
        <div class="layer-close"></div>
        <div class="popup-container size-3">
            <div class="popup-align">
                <div class="embed-responsive embed-responsive-16by9">

                </div>
            </div>
            <div class="button-close">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <?php
        $video_form = get_field( 'video_form', 'option' );
        if( $video_form['form'] ): ?>
    <div class="popup-content" data-rel="1">
        <div class="layer-close"></div>
        <div class="popup-container size-2">
            <div class="popup-align">
                <div class="form-bg">
                    <?php if( $video_form['title'] ): ?>
                    <div class="title"><?php echo wp_kses_post( $video_form['title'] ); ?></div>
                </div>
                <?php endif;
                            echo $video_form['form'] ? do_shortcode( '[contact-form-7 id="'.$video_form['form'] .'" title="Contact form - '.$video_form['form'] .'"]' ) : ''; ?>
            </div>
        </div>
        <div class="button-close type2">
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<?php endif; ?>


<div class="popup-content test" id="thank-popup" data-rel="thank-you">
    <div class="layer-close"></div>
    <div class="popup-container size-2">
        <div class="popup-align">
            <div class="thank-you-popup">
                <?php $thanks_title = $thanks_desc = '';
                    if(is_page_template( 'page-ressources.php' )){
                        $thanks_title = get_field('res_thanks_title');
                        $thanks_desc = get_field('res_thanks_description');
                    } else {
                        $popup_text = get_field( 'popup_text', 'option' );
                        $thanks_title = !empty($popup_text['title']) ? $popup_text['title'] : '';
                        $thanks_desc = !empty($popup_text['text']) ? $popup_text['text'] : '';
                    }

                    if( $thanks_title ): ?>
                <div class="block-title">
                    <h3 class="h3"><?php echo wp_kses_post( $thanks_title ); ?></h3>
                </div>
                <?php endif;
                    if( $thanks_desc ): ?>
                <p><?php echo wp_kses_post( $thanks_desc ); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="button-close">
            <span></span>
            <span></span>
        </div>
    </div>
</div>

<div class="popup-content" id="recovery-popup">
    <div class="layer-close"></div>
    <div class="popup-container size-2">
        <div class="popup-align">
            <div class="thank-you-popup">
                <?php $recovery = get_field( 'recovery_form', 'option' );
                    if( $recovery['title'] ): ?>
                <div class="block-title">
                    <h3 class="h3"><?php echo wp_kses_post( $recovery['title'] ); ?></h3>
                </div>
                <?php endif;
                    if( $recovery['text'] ): ?>
                <p><?php echo wp_kses_post( $recovery['text'] ); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="button-close">
            <span></span>
            <span></span>
        </div>
    </div>
</div>

</div>
