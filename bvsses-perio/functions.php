<?php
	// Title - tag <title> 
	add_theme_support( 'title-tag' );
	// Post Thumbnails
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
	}
	//Add Scripts Footer
	add_action('wp_footer','scripts_footer');
	function scripts_footer(){
		wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.5.1.min.js');
		wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
		wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
		wp_enqueue_script('slick',get_stylesheet_directory_uri().'/js/slick.min.js');
		wp_enqueue_script('accessibility',get_stylesheet_directory_uri().'/js/accessibility.js');
		wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
	}
	// Menus
	add_action('init', 'action_init');
	function action_init()
	{
		register_nav_menu('main-nav', 'Main Menu (top)');
		register_nav_menu('language', 'Language');
	}
	//Custom Post Type
	add_action('init', 'custon_posts');
	function custon_posts(){
		registrar_custom_post_type();
	}
	function registrar_custom_post_type() {
		// Banners
		$descritivosBanner = array(
			'name' 					=> 'Banner',
			'singular_name'		 	=> 'Banner',
			'add_new' 				=> 'Add New Banner',
			'add_new_item' 			=> 'Add Banner',
			'edit_item'				=> 'Edit Banner',
			'new_item' 				=> 'New Banner',
			'view_item' 			=> 'View Banner',
			'search_items' 			=> 'Search Banner',
			'not_found' 			=>  'No Banner Found',
			'not_found_in_trash' 	=> 'No Banner in Trash',
			'parent_item_colon' 	=> '',
			'menu_name' 			=> 'Banner'
		);
		$argsBanner = array(
			'labels' => $descritivosBanner,
			'public' => true,
			'hierarchical' => false,
			'menu_position' => 11,
			'supports' => array('title')
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
		// Revista
		$descritivosRevistas = array(
			'name' 					=> 'Revista',
			'singular_name'		 	=> 'Revista',
			'add_new' 				=> 'Add New Revista',
			'add_new_item' 			=> 'Add Revista',
			'edit_item'				=> 'Edit Revista',
			'new_item' 				=> 'New Revista',
			'view_item' 			=> 'View Revista',
			'search_items' 			=> 'Search Revista',
			'not_found' 			=>  'No Revista Found',
			'not_found_in_trash' 	=> 'No Revista in Trash',
			'parent_item_colon' 	=> '',
			'menu_name' 			=> 'Revista'
		);
		$argsRevistas = array(
			'labels' 		=> $descritivosRevistas,
			'public' 		=> true,
			'hierarchical' 	=> false,
			'menu_position' => 11,
			'supports' 		=> array('title'),
			'menu_icon'		=> 'dashicons-text-page'
		);
		register_post_type( 'revista' , $argsRevistas );

		flush_rewrite_rules();
	}
	// WIDGETS
	register_sidebar([
		'name'			=> 'Footer 1',
		'id'			=> 'footer1',
		'description'	=> 'Footer Left',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	]);
	register_sidebar([
		'name'			=> 'Social',
		'id'			=> 'social',
		'description'	=> 'Redes Sociais',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	]);
	//Add size images
	add_image_size('banners', 1300, 400, true);
	add_image_size('banners-mobile', 600, 300, true);
	add_image_size('mini-banners',576,240,true);
	add_image_size('revista',576,240,true);

	add_action('init', function() {
		//Default
		pll_register_string('About', 'About', 'Default');
		
		//Accessibility
		pll_register_string('Main content', 'Main content', 'Accessibility');
		pll_register_string('Menu', 'Menu', 'Accessibility');
		pll_register_string('Search', 'Search', 'Accessibility');
		pll_register_string('Footer', 'Footer', 'Accessibility');
		pll_register_string('High contrast', 'High contrast', 'Accessibility');

		//Revistas
		pll_register_string('Acessar revista', 'Acessar revista', 'Revistas');
		pll_register_string('Edição Atual', 'Edição Atual', 'Revistas');

	});


?>