<?php if(!defined('ABSPATH')) exit;
	$news_title = get_sub_field( 'news_title' );
	$news_link  = get_sub_field( 'news_link' );

	$args = array(
		'post_type' => 'post',
		'status'	=> 'publish',
		'order_by'	=> 'date',
		'order'		=> 'DESC',
		'posts_per_page' => 3
	);
	$query = new WP_Query( $args );
	if( $query->have_posts() ): 
		$n_i = 0;
		$news_1 = '';
		$news_2 = '';
		while ( $query->have_posts() ): $query->the_post();
    		$n_i++;
    		$news_full  = has_post_thumbnail() ? get_the_post_thumbnail_url() : '';
    		$news_image = !strpos( $news_full, '.svg' ) ? aq_resize( $news_full, 1115, 756, true, true, true ) : $news_full;
			$news_img_sm = aq_resize( $news_full, 540, 362, true, true, true );
    		if( $n_i == 1 ):
    			$news_1 .= '<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            <a href="'.get_the_permalink().'" class="news-item">
                                <div class="img" style="background-image: url('.$news_image.');"></div>
                                <div class="news-content">
                                    <div class="date" id="dateid'.get_the_date( 'dFY' ).'">'.get_the_date( 'd F Y' ).'</div>
                                    <div class="title h3">'.get_the_title().'</div><p>'.get_the_excerpt().'</p>
                                </div>
                            </a>
                            <div class="empty-md-30 empty-xs-15"></div>
                        </div>';
    		else:
    			$news_2 .= '<div class="col-lg-12 col-sm-6">
                                    <a href="'.get_the_permalink().'" class="news-item type2">
                                        <div class="img" style="background-image: url('.$news_img_sm.');"></div>
                                        <div class="news-content">
                                            <div class="date" id="dateid'.get_the_date( 'dFY' ).'">'.get_the_date( 'd F Y' ).'</div>
                                            <div class="title">'.get_the_title().'</div>
                                        </div>
                                    </a>                                    
                                    <div class="empty-lg-30 empty-sm-0 empty-xs-15"></div>
                                </div>';
    		endif;
    	endwhile;
		wp_reset_postdata(); ?>
		<div class="section news">
            <div class="space-lg"></div>
            <?php if( $news_title || $news_link ): ?>
	            <div class="news-block-title">
	            	<?php if( $news_title ): ?>
		                <div class="block-title">
		                    <h4 class="h4"><?php echo $news_title; ?></h4>
		                </div>
	                <?php endif;
	                if( $news_link ): ?>
		                <a href="<?php echo esc_url( $news_link ); ?>" class="button type3"><?php esc_html_e( 'See All', 'jamesway' ); ?></a>
		            <?php endif; ?>
	            </div>
	            <div class="space-md"></div>
	        <?php endif; ?>
            <div class="news-wrapp">
                <div class="container-fluid">
                    <div class="row">
                        <?php echo $news_1 ? $news_1 : ''; 
                        if( $news_2 ): ?>
	                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
	                            <div class="row">
	                                <?php echo $news_2; ?>
	                            </div>
	                        </div>
	                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="space-lg"></div>
        </div>
<?php endif;