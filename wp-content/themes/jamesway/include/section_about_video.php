<?php if( !defined('ABSPATH') ) exit;
	$video_content = get_sub_field( 'about_video' ); 
	if( $video_content['image'] ): ?>
	<div class="margin section type2">
        <div class="empty-lg-80 empty-md-60"></div>
        <div class="container-fluid">
            <div class="row vert-align">
                <div class="col-lg-10 col-lg-offset-1 col-sm-12 col-xs-12">
                    <div class="video-block">
                        <div class="bg-image" style="background-image: url(<?php echo esc_url( $video_content['image']['url'] ); ?>);"></div>
                        <?php if( $video_content['link'] ): ?>
	                        <div class="video-button open-video" data-src="https://www.youtube.com/embed/<?php echo esc_attr( $video_content['link'] ); ?>?feature=oembed&autoplay=1&rel=0&showinfo=0">
	                            <div class="img">
	                                <div class="triangle"></div>
	                            </div>
	                        </div>
	                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="empty-lg-80 empty-md-60 empty-xs-0"></div>            
    </div>
<?php endif; 