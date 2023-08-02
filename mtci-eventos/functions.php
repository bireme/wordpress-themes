<?php 
// Register Custom Navigation Walker 
#require_once get_template_directory().'/includes/class-wp-bootstrap-navwalker.php';
// Title - tag <title>
add_theme_support('title-tag');
// Posta Thumbnails
add_theme_support( 'post-thumbnails' ); 
// Menus
add_action('init', 'action_init');
function action_init()
{
	register_nav_menu('main-nav', 'Main Menu (top)');
	register_nav_menu('Language', 'Language');
}
//Add Styles Top
add_action('wp_enqueue_scripts','style_top');
function style_top(){
	wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
	wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
	wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/fontawesome/css/all.css');
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
	wp_enqueue_script('popper',get_stylesheet_directory_uri().'/js/popper.min.js');
	wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
	wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
}
//Custom post type
add_action('init', 'custon_posts');
function custon_posts(){
	registrar_custom_post_type();
}
function registrar_custom_post_type() {
	$events = array(
		'name'               => 'Events',
		'singular_name'      => 'Event',
		'add_new'            => 'Add new event',
		'add_new_item'       => 'Add event',
		'edit_item'          => 'Edit event',
		'new_item'           => 'New Event',
		'view_item'          => 'See Event',
		'search_items'       => 'Search event',
		'not_found'          => 'Event not found',
		'not_found_in_trash' => 'Event not found in trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Events'
	);
	$argsEvents = array(
		'labels'            => $events,
		'public'            => true,
		'hierarchical'      => false,
		'menu_position'     => 11,
		'show_in_rest'		=> true,
		'supports'          => array('title', 'editor'),
		'menu_icon'         => 'dashicons-schedule'
	);
	register_post_type( 'event' , $argsEvents );
	flush_rewrite_rules();
}
