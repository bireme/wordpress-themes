<?php
// Title - tag <title> 
add_theme_support( 'title-tag' );
// Posta Thumbnails
add_theme_support( 'post-thumbnails' );
//Register Custom Navigation Walker 
require_once get_template_directory().'/class-wp-bootstrap-navwalker.php';
add_action('wp_enqueue_scripts','style_top');
function style_top(){
//Add Styles Top
	wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
	wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
	wp_enqueue_style('slick',get_stylesheet_directory_uri().'/css/slick.css');
	wp_enqueue_style('theme-slick',get_stylesheet_directory_uri().'/css/slick-theme.css');
	wp_enqueue_style('acessibilidade',get_stylesheet_directory_uri().'/css/accessibility.css');
	wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/fontawesome/css/all.css');
	wp_enqueue_style('Fontes','https://fonts.googleapis.com/css2?family=Hind:wght@300;400;600;700&family=Lato&display=swap');
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
	wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.4.1.min.js');
	wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
	wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
	wp_enqueue_script('slick',get_stylesheet_directory_uri().'/js/slick.min.js');
	wp_enqueue_script('accessibility',get_stylesheet_directory_uri().'/js/accessibility.js');
	wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
}
// Menus Topo
add_action('init', 'action_init');
function action_init()
{
	register_nav_menu('main-nav', 'Main Menu (top)');
}
//Custom Post Type
add_action('init', 'custon_posts');
function custon_posts(){
	registrar_custom_post_type();
}
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
		'supports' => array('title','thumbnail')
	);
	register_post_type( 'banners' , $argsBanner );
	//MiniBanners
	$MiniBanners = array(
		'name' 					=> 'Mini Banners',
		'singular_name' 		=> 'Mini Banner',
		'add_new' 				=> 'Add Mini Banner',
		'add_new_item' 			=> 'Add Mini Banners Item',
		'edit_item' 			=> 'Edit Mini Banner',
		'new_item' 				=> 'New Item',
		'view_item' 			=> 'View Mini Banners',
		'search_items' 			=> 'Search Mini Banners',
		'not_found' 			=> 'No Mini Banners Found',
		'not_found_in_trash' 	=> 'No Mini Banners in Trash',
		'parent_item_colon' 	=> '',
		'menu_name' 			=> 'Mini Banners'
	);
	$MiniBanners = array(
		'labels' 		=> $MiniBanners,
		'public' 		=> true,
		'hierarchical' 	=> false,
		'menu_position' => 12,
		'supports'		=> array('title'),
		'menu_icon'		=> 'dashicons-screenoptions'
	);
	register_post_type( 'MiniBanners' , $MiniBanners );
	//Serviços
	$Servicos = array(
		'name' 					=> 'Serviços',
		'singular_name' 		=> 'Serviços',
		'add_new' 				=> 'Add Serviços',
		'add_new_item' 			=> 'Add Servicos Item',
		'edit_item' 			=> 'Edit Serviços',
		'new_item' 				=> 'New Item',
		'view_item' 			=> 'View Serviços',
		'search_items' 			=> 'Search Serviços',
		'not_found' 			=> 'No Serviços Found',
		'not_found_in_trash' 	=> 'No Serviços in Trash',
		'parent_item_colon' 	=> '',
		'menu_name' 			=> 'Serviços Home'
	);
	$Servicos = array(
		'labels' 		=> $Servicos,
		'public' 		=> true,
		'hierarchical' 	=> false,
		'menu_position' => 12,
		'supports'		=> array('title','editor','excerpt'),
		'menu_icon'		=> 'dashicons-table-col-after'
	);
	register_post_type( 'Servicos' , $Servicos );
	flush_rewrite_rules();
}
	// WIDGETS
	register_sidebar([
		'name'			=> 'Rodape 1',
		'id'			=> 'footer1',
		'description'	=> 'Coluna 1',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	]);
	register_sidebar([
		'name'			=> 'Rodape 2',
		'id'			=> 'footer2',
		'description'	=> 'Coluna 2',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	]);
	register_sidebar([
		'name'			=> 'Rodape 3',
		'id'			=> 'footer3',
		'description'	=> 'Coluna 3',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	]);
	//Adicionar tamanhos de imagem no Wordpress
	add_image_size('banners', 1200, 400, true);
	add_image_size('banners-mobile', 600, 300, true);
	add_image_size('mini-banners',576,240,true);
	// Excerpt Pages
	add_post_type_support( 'page', 'excerpt');
?>