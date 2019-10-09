<?php 
	// Register Custom Navigation Walker 
	require_once get_template_directory().'/class-wp-bootstrap-navwalker.php';
	// Title - tag <title>
	add_theme_support('title-tag');
	// Menus Top/Language
	add_action('init', 'action_init');
	function action_init()
	{
		register_nav_menu('main-nav', 'Main Menu (top)');
		register_nav_menu('Language', 'Language');
		register_nav_menu('home1', 'Home Column 1');
		register_nav_menu('home2', 'Home Column 2');
		register_nav_menu('home3', 'Home Column 3');
	}
	add_action('wp_enqueue_scripts','style_top');
	function style_top(){
	//Add Styles Top
		wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
		wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
		wp_enqueue_style('slick',get_stylesheet_directory_uri().'/css/slick.css');
		wp_enqueue_style('theme-slick',get_stylesheet_directory_uri().'/css/slick-theme.css');
		wp_enqueue_style('acessibilidade',get_stylesheet_directory_uri().'/css/acessibilidade.css');
		wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/fontawesome/css/all.css');
	}
	//Add Scripts Footer
	add_action('wp_footer','scripts_footer');
	function scripts_footer(){
		wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.4.1.min.js');
		wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
		wp_enqueue_script('popper',get_stylesheet_directory_uri().'/js/popper.min.js');
		wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
		wp_enqueue_script('slick',get_stylesheet_directory_uri().'/js/slick.min.js');
		wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
		wp_enqueue_script('accessibility',get_stylesheet_directory_uri().'/js/accessibility.js');
	}
	//Adiciona suporte a miniaturas (imagem destacada)
	add_theme_support('post-thumbnails');
	//Adicionar tamanhos de imagem no Wordpress
	add_image_size('Partners', 600, 200, true);
	//Custo post type
	add_action('init', 'custon_posts');
	function custon_posts(){
		registrar_custom_post_type();
	}
	function registrar_custom_post_type() {
		//HOME
		$home = array(
			'name' 				=> 'Home'
		);
		$argsHome = array(
			'labels' 		=> $home,
			'public' 		=> true,
			'hierarchical' 	=> false,
			'menu_position' => 10,
			'supports' 		=> array('title'),
			'menu_icon'		=> 'dashicons-admin-home',
		);
		register_post_type( 'home' , $argsHome );
		//News
		$News = array(
			'name' 					=> 'News',
			'singular_name' 		=> 'Novelty',
			'add_new' 				=> 'Add News',
			'add_new_item' 			=> 'Add News Item',
			'edit_item' 			=> 'Edit News',
			'new_item' 				=> 'New Item',
			'view_item' 			=> 'View News',
			'search_items' 			=> 'Search News',
			'not_found' 			=> 'No News Found',
			'not_found_in_trash' 	=> 'No News in Trash',
			'parent_item_colon' 	=> '',
			'menu_name' 			=> 'News'
		);
		$argsNews = array(
			'labels' 		=> $News,
			'public' 		=> true,
			'hierarchical' 	=> false,
			'menu_position' => 11,
			'supports' => array('title','editor'),
			'menu_icon'		=> 'dashicons-clipboard'
		);
		register_post_type( 'News' , $argsNews );
		//Partners
		$Partners = array(
			'name' 					=> 'Partners',
			'singular_name' 		=> 'Partner',
			'add_new' 				=> 'Add Partners',
			'add_new_item' 			=> 'Add Partners Item',
			'edit_item' 			=> 'Edit Partners',
			'new_item' 				=> 'New Item',
			'view_item' 			=> 'View Partners',
			'search_items' 			=> 'Search Partners',
			'not_found' 			=> 'No Partners Found',
			'not_found_in_trash' 	=> 'No Partners in Trash',
			'parent_item_colon' 	=> '',
			'menu_name' 			=> 'Partners'
		);
		$argsPartners = array(
			'labels' 		=> $Partners,
			'public' 		=> true,
			'hierarchical' 	=> false,
			'menu_position' => 12,
			'supports'		=> array('title'),
			'menu_icon'		=> 'dashicons-screenoptions'
		);
		register_post_type( 'Partners' , $argsPartners );
		//Banners
		$Banners = array(
			'name' 					=> 'Banners',
			'singular_name' 		=> 'Banner',
			'add_new' 				=> 'Add Banners',
			'add_new_item' 			=> 'Add Banners Item',
			'edit_item' 			=> 'Edit Banners',
			'new_item' 				=> 'New Item',
			'view_item' 			=> 'View Banners',
			'search_items' 			=> 'Search Banners',
			'not_found' 			=> 'No Banners Found',
			'not_found_in_trash' 	=> 'No Banners in Trash',
			'parent_item_colon' 	=> '',
			'menu_name' 			=> 'Banners'
		);
		$argsBanners = array(
			'labels' 		=> $Banners,
			'public' 		=> true,
			'hierarchical' 	=> false,
			'menu_position' => 13,
			'supports' => array('title'),
			'menu_icon'		=> 'dashicons-images-alt'
		);
		register_post_type( 'Banners' , $argsBanners );
	}
	//widgets - Home
	register_sidebar(array(
		'name'			=> 'Home',
		'id'			=> 'home_widget',
		'description'	=> 'Widgets Home',
		'class'			=> 'list-unstyled',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	));
	add_action('init', function() {
		pll_register_string('Search', 'Search', 'Form'); 
		pll_register_string('Search for:', 'Search for:', 'Text default');
		pll_register_string('Page:', 'Page:', 'Text default');
		pll_register_string('Term', 'Terms and conditions of use', 'Text default'); 
		pll_register_string('Privacy policy', 'Privacy policy', 'Text default'); 
		pll_register_string('All Descriptor Terms', 'All Descriptor Terms', 'Text default');
		pll_register_string('Main Heading (Descriptor) Terms', 'Main Heading (Descriptor) Terms', 'Text default');
		pll_register_string('Unique ID', 'Unique ID', 'Text default');
		pll_register_string('Concept ID', 'Concept ID', 'Text default');
		pll_register_string('Tree number ID', 'Tree number ID', 'Text default');
		pll_register_string('All Qualifier Terms', 'All Qualifier Terms', 'Text default');
		pll_register_string('Meet DeCS', 'Meet DeCS', 'Text default');
		pll_register_string('Contact us', 'Contact us', 'Text default');
		pll_register_string('For Developers', 'For Developers', 'Text default');
		pll_register_string('How to use DeCS', 'How to use DeCS', 'Text default');
		pll_register_string('Partners', 'Partners', 'Text default');
	});
?>