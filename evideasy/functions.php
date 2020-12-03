<?php
// Title - tag <title> 
add_theme_support( 'title-tag' );
// Posta Thumbnails
add_theme_support( 'post-thumbnails' );
//Register Custom Navigation Walker 
//require_once get_template_directory().'/class-wp-bootstrap-navwalker.php';
add_action('wp_enqueue_scripts','style_top');
function style_top(){
//Add Styles Top
	wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
	wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
	wp_enqueue_style('acessibilidade',get_stylesheet_directory_uri().'/css/accessibility.css');
	wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/fontawesome/css/all.css');
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
	wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.4.1.min.js');
	wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
	wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
	wp_enqueue_script('accessibility',get_stylesheet_directory_uri().'/js/accessibility.js');
	wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
}
// Menus Topo
add_action('init', 'action_init');
function action_init()
{
	register_nav_menu('main-nav', 'Main Menu');
	register_nav_menu('Language', 'Language');
}
//Custom Post Type
add_action('init', 'custon_posts');
function custon_posts(){
	registrar_custom_post_type();
}
//Custom Post Type
function registrar_custom_post_type() {
		// Banners
	$descritivosBanner = array(
		'name' => 'Banner',
		'singular_name' => 'Banner',
		'add_new' => 'Add New Banner',
		'add_new_item' => 'Add Banner',
		'edit_item' => 'Edit Banner',
		'new_item' => 'New Banner',
		'view_item' => 'View Banner',
		'search_items' => 'Search Banner',
		'not_found' =>  'No Banner Found',
		'not_found_in_trash' => 'No Banner in Trash',
		'parent_item_colon' => '',
		'menu_name' => 'Banner'
	);
	$argsBanner = array(
			'labels' => $descritivosBanner,
			'public' => true,
			'hierarchical' => false,
			'menu_position' => 11,
			'supports' => array('title')
		);
	register_post_type( 'banners' , $argsBanner );
}
//Adicionar tamanhos de imagem no Wordpress
add_image_size('banners', 1200, 400, true);
add_image_size('banners-mobile', 600, 300, true);

	// Tradução Polylang
add_action('init', function() {
		//Home
	#pll_register_string('What is EVID @ Easy?', 'What is EVID@Easy?', 'Home');
	#pll_register_string('How does EVID @ Easy work?', 'How does EVID@Easy work?', 'Home');
	#pll_register_string('In which databases does EVID@Easy search?', 'In which databases does EVID@Easy search?', 'Home');
	#pll_register_string('EVID@Easy incorporates the following databases from the Virtual Health Library:', 'EVID@Easy incorporates the following databases from the Virtual Health Library:', 'Home');
			// Temo de Uso
	pll_register_string('Terms and conditions of use', 'Terms and conditions of use', 'Terms'); 
	pll_register_string('Privacy Policy', 'Privacy Policy', 'Terms'); 
	        //Accessibility
	pll_register_string('Main content', 'Main content', 'Accessibility');
	pll_register_string('Menu', 'Menu', 'Accessibility');
	pll_register_string('Search', 'Search', 'Accessibility');
	pll_register_string('Footer', 'Footer', 'Accessibility');
	pll_register_string('High contrast', 'High contrast', 'Accessibility'); 
});
?>