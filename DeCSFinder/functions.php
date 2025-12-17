<?php
// Title - tag <title>
add_theme_support('title-tag');
//Post Thmbnails
add_theme_support('post-thmbnails');
//Menus Top/Language
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
	wp_enqueue_style('bootstrap-icons',get_stylesheet_directory_uri().'/css/bootstrap-icons-1.10.5/font/bootstrap-icons.css');
	wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
	wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.6.4.min.js');
	wp_enqueue_script('popper',get_stylesheet_directory_uri().'/js/popper.min.js');
	wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js');
	wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
}
// WIDGETS
register_sidebar([
  'name'        => 'footer',
  'id'          => 'footer',
  'description'   => 'Footer',
  'before_title'  => '<h5>',
  'after_title'   => '</h5>'
]);
// Polylang
add_action('init', function() {
	pll_register_string('Reserved', 'All rights are reserved', 'Default'); 
});