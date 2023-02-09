<?php

/**

 * The main template file.

 *

 * @package jamesway

 * @since 1.0.0

 *

 */

if( !defined('ABSPATH') ) exit; get_header();

    $page = get_queried_object();

    if( is_archive() || is_home() && !is_front_page() ): 

        $subtitle = get_field( 'blog_subtitle', get_option( 'page_for_posts' ) ); ?>

		<div class="section banner">

            <div class="clip-wrapper">

                <div class="bg-image" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/Rectangle.png);">

                </div>

            </div>

            <div class="svg-element counter-wrapper full-height countEnd">

                <svg version="1.1" width="100%" height="170px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none">

                    <polygon fill="#ffffff" points="0,100 -10,20  50,0 110,20 100,100"></polygon>

                </svg>

            </div>

            <div class="container-fluid padding">

                <div class="row padding">

                    <div class="col-lg-12 padding">

                        <div class="banner-content type4">

                            <div class="banner-content-cell">

                                <div class="big-title"><?php echo get_the_title( get_option( 'page_for_posts' ) ); ?></div>

                                <?php if( $subtitle ): ?>

                                    <h1 class="h1 ml-105"><?php echo $subtitle; ?></h1>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="section margin">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="search-input type2">

                            <form role="search" method="get" id="searchform-search" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">

                                <div class="inline-form">

                                    <input type="search" placeholder="<?php _e('Search', 'jamesway'); ?>" name="s" >

                                    <div class="search-icon-inline">

                                        <img src="<?php echo THEME_URI; ?>/assets/img/search.svg" alt="" />

                                        <input type="submit">

                                    </div>

                                </div>

                            </form>

                        </div>                        

                    </div>

                </div>

            </div>

        </div>

        <div class="section margin news-items">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-7 col-md-7 col-sm-12">

                        <?php 

                        if( have_posts() ):

                            $post_int = 0;

                            while ( have_posts() ): the_post();

                                    $tmb_full = has_post_thumbnail() ? get_the_post_thumbnail_url() : '';

                                    $parent_tag = get_the_terms( get_the_ID(), 'post_tag' );

                                    !(empty($tmb_full)) ? $tmb = aq_resize( $tmb_full, 1030, 388, true, true, true ) : $tmb = '';

                                    ?>

                                <div class="news-content<?php echo esc_attr( !$tmb ? ' type2' : '' ); ?>">

                                    <?php if( $tmb && $post_int == 0 ): ?>

                                        <div class="img">

                                            <a href="<?php the_permalink(); ?>" style="background-image: url('<?php echo esc_url( $tmb );?>');"></a>

                                        </div>

                                    <?php endif;?>

                                    <?php if($post_int == 0 ): ?>

                                    <div class="marker">

                                        <?php 

                                        if( $parent_tag ):

                                            $ti = 0;

                                            foreach( $parent_tag as $tag ):

                                                $link = get_term_link( $tag, 'category' );

                                                echo $tag->name;

                                                if( ++$ti == 1 )

                                                    break;

                                            endforeach;

                            		    else :

                                            esc_html_e('News', 'jamesway');

                                        endif; ?>

                                    </div>


                                    <?php endif; $post_int++;?>

                                    <div class="news-info">

                                        <div class="date"><?php echo '<span>'.get_the_date('d').'</span> <br>'.get_the_date('M').' <br>'.get_the_date('Y'); ?></div>

                                        <div class="name">

                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

                                            <?php $desc = get_field( 'short_description' );

                                            if( $desc ): ?>

                                                <div class="empty-lg-20 empty-xs-15"></div>

                                                <p><?php echo wp_kses_post( $desc ); ?></p>

                                            <?php endif; ?>

                                            <div class="empty-lg-25 empty-md-20 empty-xs-15"></div>

                                            <a href="<?php the_permalink(); ?>" class="link">Read More</a>

                                        </div>

                                    </div>

                                </div>

                            <?php endwhile;

                            jmw_pagination();

                        else:

                            echo '<p class="h4">'.__( 'Posts not found.', 'jamesway' ).'</p>'; 

                        endif; ?>

                        <div class="space-lg"></div>

                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-12">

                        <div class="side-block-wrapper">

                            <div class="side-block-button">

                                <span></span>

                                <span></span>

                            </div>

                            <?php

                            	$terms = get_terms( array(

									    'taxonomy' => 'category',

									    'hide_empty' => false,

									) );

                            	$tags = get_terms( array(

									    'taxonomy' => 'post_tag',

									    'hide_empty' => false,

									) );

							if( $terms || $tags ): ?>

	                            <div class="side-block">

	                            	<?php if( $terms ): ?>

	                                	<div class="title h3"><?php esc_html_e( 'Category', 'jamesway' ); ?></div>

		                                <ul>

		                                	<?php foreach( $terms as $term ): ?>

			                                    <li class="category-item h6"><a href="<?php echo get_term_link( $term->term_id, 'category' ); ?>"><?php echo $term->name; echo $term->count < 10 && $term->count != 0 ? ' (0'.$term->count.')' : ' ('.$term->count.')' ;?></a></li>

			                                <?php endforeach; ?>

		                                </ul>

		                            <?php endif; 

		                            if( $tags ): ?>

		                                <div class="empty-lg-100 empty-ds-80 empty-md-70"></div>

		                                <div class="title h3"><?php esc_html_e( 'Tags', 'jamesway' ); ?></div>

		                                <ul class="tags-wrapper">

		                                	<?php foreach( $tags as $tag ): ?>

			                                    <li class="tags-item h6"><a href="<?php echo get_term_link( $tag->term_id, 'post_tag' ); ?>"><?php echo $tag->name; ?></a></li>

			                                <?php endforeach; ?>

		                                </ul>

		                            <?php endif; ?>

	                            </div>

	                        <?php endif; ?>

                        </div>

                    </div>

                </div>



                <div class="space-xl"></div>

                

            </div>

        </div>

	<?php endif;

get_footer();

