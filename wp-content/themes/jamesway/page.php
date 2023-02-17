<?php

/**
 * Index Page
 *
 * @package jamesway
 * @since 1.0.0
 *
 */

if (!defined('ABSPATH')) exit;
get_header();
$banner_type = get_field('banner_type');
if ($banner_type == 1) :
	get_template_part('include/section_banner');
elseif ($banner_type == 2) :
	get_template_part('include/section_banner_v2');
elseif ($banner_type == 3) :
	get_template_part('include/section_banner_v3');
endif;
if (have_rows('template_content')) :
	while (have_rows('template_content')) : the_row();
		if (get_row_layout() == 'testimonial_slider') :
			get_template_part('include/section_testimonial_slider');
		elseif (get_row_layout() == 'tabs') :
			get_template_part('include/section_tabs');
		elseif (get_row_layout() == 'support_events') :
			get_template_part('include/section_support');
		elseif (get_row_layout() == 'simple_slider') :
			get_template_part('include/section_slider_content');
		elseif (get_row_layout() == 'simple_text') :
			get_template_part('include/section_simple_text');
		elseif (get_row_layout() == 'products') :
			get_template_part('include/section_product_slider');
		elseif (get_row_layout() == 'our-products') :
			get_template_part('include/section_our_products');
		elseif (get_row_layout() == 'partners') :
			get_template_part('include/section_partners_slider');
		elseif (get_row_layout() == 'news') :
			get_template_part('include/section_news');
		elseif (get_row_layout() == 'map') :
			get_template_part('include/section_installation');
		elseif (get_row_layout() == 'action') :
			get_template_part('include/section_action');
		elseif (get_row_layout() == 'action_s2') :
			get_template_part('include/section_action_s2');
		elseif (get_row_layout() == 'video') :
			get_template_part('include/section_about_video');
		elseif (get_row_layout() == 'text_bg') :
			get_template_part('include/section_about_text');
		elseif (get_row_layout() == 'image_sides') :
			get_template_part('include/section_about_img');
		elseif (get_row_layout() == 'timeline') :
			get_template_part('include/section_timeline');
		elseif (get_row_layout() == 'text_file') :
			get_template_part('include/section_text_file');
		elseif (get_row_layout() == 'form') :
			get_template_part('include/section_form');
		elseif (get_row_layout() == 'image_3cols') :
			get_template_part('include/section_image3col');
		elseif (get_row_layout() == 'heading') :
			get_template_part('include/section_heading');
		elseif (get_row_layout() == 'accordion') :
			get_template_part('include/section_accordion');
		elseif (get_row_layout() == 'carousel_text') :
			get_template_part('include/section_carousel');
		elseif (get_row_layout() == 'specification') :
			get_template_part('include/section_specification');
		elseif (get_row_layout() == 'image_text') :
			get_template_part('include/section_image_text');
		elseif (get_row_layout() == 'simple_content') :
			get_template_part('include/section_simple_content');
		elseif (get_row_layout() == 'iframe_content') :
			get_template_part('include/section_iframe_content');
		elseif (get_row_layout() == 'text-bg-wave') :
			get_template_part('include/section_about_wave_text');
		elseif (get_row_layout() == 'content-slider') :
			get_template_part('include/section_content_slider');
        elseif (get_row_layout() == 'tips') :
            get_template_part('include/section_accordion_tips');
        elseif (get_row_layout() == 'title_left_text_right_&_bg_title') :
            get_template_part('include/section_title_left_text_right');
        endif;
	endwhile;
endif;

get_footer();
