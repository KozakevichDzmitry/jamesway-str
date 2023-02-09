<?php

/*
Plugin Name: ITW Admin Panel
Author: ITW Consulting
Description: ITW Customization Plugin
Author uri: https://www.itwconsulting.com
Version: 1.0
*/

define('RS_DIR', plugin_dir_url( __FILE__ ));

//Initialize plugin
function m3c_settings_init() {
    register_setting( 'm3c_plugin_settings', 'm3c_option' );
}
function register_m3c_menu_page() {
	add_menu_page( 'Options', 'ITW Panel', 'manage_options', 'itwpanel', 'm3c_admin_page', 'dashicons-album' );
}
add_action( 'admin_init', 'm3c_settings_init' );
add_action( 'admin_menu', 'register_m3c_menu_page' );
function m3c_admin_page(){
	require_once 'inc/admin_page.php';
}

//Globalize options variable
$option = get_option( 'm3c_option' ); 

//Redirect in admin menu
$req_uri = substr($_SERVER['REQUEST_URI'],-17);
if($req_uri == '/wp-admin/itwpanel' || $req_uri == 'wp-admin/itwpanel/'){
	header("Location: admin.php?page=itwpanel");
	die();
}


//Remove menus
function m3c_remove_menus(){
	global $option;
	$option = get_option( 'm3c_option' );
	$pages_old = $GLOBALS[ 'admin_page_hooks' ];
	$pages_new = get_option('m3c_menu_positions', true);
	$pages = explode(',', $pages_new);
	if($pages[0]=='dashboard' || $pages_new=='1'){
		$pages = array_keys($pages_old);
	}
	foreach ($pages as $page) {
		if(isset($option[$page])==1) { remove_menu_page( $page ); }
	}

}
add_action( 'admin_menu', 'm3c_remove_menus',999 );

//Add gilpanel view
if(isset($option['gil'])){
	$color = $option['color'];
	$oldHash = get_transient('m3c_color');
	$currentHash =  $option['color'];
	if($oldHash !== $currentHash){
	  set_transient('m3c_color', $currentHash, 60 * 60 * 24 * 14);
	}
	function gil_custom_fonts() {
	  include_once ('inc/rs_view.php');
	}
	add_action('admin_footer', 'gil_custom_fonts');
	function gil_login_logo() {
	   include_once ('inc/rs_view.php');
	}
	add_action( 'login_enqueue_scripts', 'gil_login_logo' );
	

	//Change footer text

	function gil_remove_footer_admin () 
	{
	    echo '<span id="footer-thankyou">Styled by <a href="https://www.itwconsulting.com/" target="_blank" rel="nofollow">ITW Consulting</a></span>';
	}
	add_filter('admin_footer_text', 'gil_remove_footer_admin');

	add_action( 'admin_enqueue_scripts', 'register_plugin_styles' );
	function register_plugin_styles() {
		wp_register_style( 'default_rs_style', RS_DIR . 'assets/css/default_rs_style.css'  );
		wp_enqueue_style( 'default_rs_style' );
	}

	
}
if( $option['admin_css']) { 
	function m3c_admin_css() {
		$option = get_option( 'm3c_option' ); 
		echo '<style>'.$option["admin_css"].'</style>'; 
	}
	add_action('admin_head' , 'm3c_admin_css' );
	
}

function m3c_admin_head_func(){
	echo '<style>
	#advanced-custom-fields-pro,#toplevel_page_edit-post_type-acf-field-group{display:none}
	</style>';
}
//add_action('admin_head','m3c_admin_head_func');


//Add script to admin panel
if(isset($option['js'])){
	function m3c_enqueue() {    
	    wp_enqueue_script( 'm3c_custom_script', RS_DIR . 'assets/js/admin.js' );
	}
	add_action('admin_enqueue_scripts', 'm3c_enqueue');
}

//Add Dasboard and Login CSS
if(isset($option['css'])){
	function m3c_custom_fonts() {
	  echo '<link rel="stylesheet" href="'. RS_DIR .'assets/css/admin_style.css" type="text/css" media="all" />';
	}
	add_action('admin_head', 'm3c_custom_fonts');
	function m3c_login_logo() {
	    echo '<link rel="stylesheet" href="'. RS_DIR .'assets/css/admin_style.css" type="text/css" media="all" />';
	 }
	add_action( 'login_enqueue_scripts', 'm3c_login_logo' );
}


//Change login logo url
if(isset($option['logo_url'])){
	function m3c_login_logo_url() {
	    return home_url();
	}
	add_filter( 'login_headerurl', 'm3c_login_logo_url' );
}

//Change footer text
if(isset($option['footer_admin'])){
	function m3c_remove_footer_admin () {
		global $option;
	    echo '<span id="footer-thankyou">'.$option['footer_text'].'</span>';
	}
	add_filter('admin_footer_text', 'm3c_remove_footer_admin');
}


//Remove admin bar on front-end
if(isset($option['admin_bar'])){
	add_filter('show_admin_bar', '__return_false', 999);
}

//Remove sortable
if(isset($option['sortable'])!=1){
	include_once ('inc/rs_order.php');
}

//Hide ACF settings
if(isset($option['hide_acf'])){
 add_filter('acf/settings/show_admin', '__return_false');
}

add_action('wp_ajax_update_menu_positions', 'm3c_update_menu_positions');
add_action('admin_enqueue_scripts', 'm3c_admin_enqueues');

/* Filters */
add_filter('custom_menu_order', 'm3c_custom_menu_order');
add_filter('menu_order', 'm3c_custom_menu_order');

/* Functions */
function m3c_update_menu_positions() {
    update_option('m3c_menu_positions', str_replace('admin.php?page=', '', $_REQUEST['menu_item_positions'])); // str_replace (support for custom added menu items)

}

function m3c_admin_enqueues() {
	
	    wp_enqueue_script('jquery-ui-sortable');
	    wp_enqueue_script('jsdelivr', 'https://cdn.jsdelivr.net/ace/1.2.3/min/ace.js', array('jquery-ui-sortable'));
	    wp_enqueue_script('jquery');
	    wp_enqueue_script('thickbox');
	    wp_enqueue_style('thickbox');
	    wp_enqueue_script('media-upload');
   
}

function m3c_custom_menu_order($menu_order) {
    if (!$menu_order)
        return true;

    $new_menu_order = get_option('m3c_menu_positions', true);

    if ($new_menu_order) {
        $new_menu_order = explode(',', $new_menu_order);

        return $new_menu_order;
    } else {
        return $menu_order;
    }
}

//Change login logo url
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
	return 'https://www.itwconsulting.com/';
}

