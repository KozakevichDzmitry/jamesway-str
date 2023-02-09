<?php 
if( !defined('ABSPATH') ) exit; get_header(); ?>
	<div class="section banner">
	    <div class="clip-wrapper">
	        <div class="bg-image" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/Rectangle.png);">
	        </div>
	    </div>
	    <div class="svg-element counter-wrapper full-height countEnd">
	        <svg version="1.1" width="100%" height="120px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none">
	            <polygon fill="#ffffff" points="0,100 -10,20  50,0 110,20 100,100"></polygon>
	        </svg>
	    </div>
	    <div class="container-fluid padding">
	        <div class="row padding">
	            <div class="col-lg-12 padding">
	                <div class="banner-content type4">
	                    <div class="banner-content-cell">
	                        <div class="big-title"><?php esc_html_e( 'Search', 'jamesway' ); ?></div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="space-lg"></div>

	<div class="section margin">
	    <div class="container-fluid">
	        <div class="row">
	            <?php if ( have_posts() ) : ?>
	                <div class="col-xs-12">
	                    <div class="block-title type3 type4">
	                        <h1 class="h2"><?php esc_html_e( 'Search results for', 'jamesway' ); ?> <span>“<?php echo get_search_query(); ?>”</span></h1>
	                    </div>
	                    <div class="empty-lg-50"></div>
	                    <div class="search-result">
	                        <ol>
	                            <?php while( have_posts() ): the_post(); ?>
	                                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	                            <?php endwhile; ?>
	                        </ol>
	                    </div>
	                </div>
	            <?php else: ?>
	            	<div class="col-xs-12">
                        <div class="block-title type3 type4">
                            <h1 class="h2"><?php esc_html_e( 'Search results for', 'jamesway' ); ?> <span>“<?php echo get_search_query(); ?>”</span></h1>
                        </div>
                        <div class="empty-lg-50"></div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="simple-article">
                            <div class="title h5 type2"><?php esc_html_e( 'Product Not Found', 'jamesway' ); ?></div>
                            <div class="empty-lg-50"></div>
                            <p><?php echo esc_html_e( 'We are sorry. Your search does not match any content in the website.', 'jamesway' ); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6">
                        <div class="search-form search-input">
                            <div class="title"><?php echo esc_html_e( 'Rather search for something else?', 'jamesway' ); ?></div>
                            <form role="search" method="get" id="searchform-search" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <div class="inline-form">
                                    <input type="search" placeholder="<?php esc_html_e( 'Search', 'jamesway' ); ?>" name="s" >
                                    <div class="search-icon-inline">
                                        <img src="<?php echo THEME_URI; ?>/assets/img/search.svg" alt="">
                                        <input type="submit">
                                    </div>
                                </div>
                                <div class="button type3"><?php esc_html_e( 'Submit', 'jamesway' ); ?>
                                    <input type="submit" name="submit" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
	            <?php endif; ?>
	        </div>
	    </div>
	    <div class="space-xl"></div>
	</div>
<?php get_footer();