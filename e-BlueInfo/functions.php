<?php
	define( 'PLUGIN_PATH',  plugin_dir_path(__FILE__) );
	require_once(PLUGIN_PATH . '/template_functions.php');
	
	// Title - tag <title>
	add_theme_support('title-tag');
	//Adiciona suporte a miniaturas (imagem destacada)
	add_theme_support('post-thumbnails');
	// Menus Top/Language
	add_action('init', 'action_init');
	function action_init()
	{
		register_nav_menu('main-nav', 'Main Menu (top)');
		register_nav_menu('Language', 'Language');
	}
	//
	add_action('wp_enqueue_scripts','style_top');
	function style_top(){
	//Add Styles Top
		wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
		wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
		wp_enqueue_style('accessibility',get_stylesheet_directory_uri().'/css/accessibility.css');
		wp_enqueue_style('aos',get_stylesheet_directory_uri().'/css/aos.css');
		wp_enqueue_style('slick',get_stylesheet_directory_uri().'/css/slick.css');
		wp_enqueue_style('theme-slick',get_stylesheet_directory_uri().'/css/slick-theme.css');
		wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/fontawesome/css/all.css');
		wp_enqueue_style('fontes','https://fonts.googleapis.com/css?family=Abel|Francois+One&display=swap');
	}
	//Add Scripts Footer
	add_action('wp_footer','scripts_footer');
	function scripts_footer(){
		wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.4.1.min.js');
		wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
		wp_enqueue_script('popper',get_stylesheet_directory_uri().'/js/popper.min.js');
		wp_enqueue_script('aos',get_stylesheet_directory_uri().'/js/aos.js');
		wp_enqueue_script('slick',get_stylesheet_directory_uri().'/js/slick.min.js');
		wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
		wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
		wp_enqueue_script('accessibility',get_stylesheet_directory_uri().'/js/accessibility.js');
	}
	//Custo post type
	add_action('init', 'custon_posts');
	function custon_posts(){
		registrar_custom_post_type();
	}
	function registrar_custom_post_type() {
		//HOME
		$home = array(
			'name' => 'Home'
		);
		$argsHome = array(
			'labels' 		=> $home,
			'public' 		=> true,
			'hierarchical' 	=> false,
			'menu_position' => 10,
			'supports' 		=> array('title'),
			'menu_icon'		=> 'dashicons-admin-home'
		);
		register_post_type( 'home' , $argsHome );
		//Countries
		$countries = array(
			'name' => 'Countries'
		);
		$argsCountries = array(
			'labels' 		=> $countries,
			'public' 		=> true,
			'hierarchical' 	=> false,
			'menu_position' => 10,
			'supports' 		=> array('title'),
			'menu_icon'		=> 'dashicons-admin-site'
		);
		register_post_type( 'countries' , $argsCountries );
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
	add_action('init', function() {
		pll_register_string('More Countries','See more interested countries', 'Home');
		pll_register_string('Terns','Terms and conditions of use', 'Default');
		pll_register_string('Privacy policy','Privacy policy', 'Default');
		pll_register_string('QR Code','Scan QR Code with Mobile', 'Modal');
		pll_register_string('Store','Dados dos países participantes', 'Modal');
		pll_register_string('Interested Countries','Interested Countries', 'Modal');
		pll_register_string('Or if you prefer click here to access the store','Or if you prefer click here to access the store', 'Modal');
		pll_register_string('Main content', 'Main content', 'Accessibility');
		pll_register_string('Menu', 'Menu', 'Accessibility');
		pll_register_string('Search', 'Search', 'Accessibility');
		pll_register_string('Footer', 'Footer', 'Accessibility');
		pll_register_string('High contrast', 'High contrast', 'Accessibility');
		pll_register_string('Introduction', 'Introduction', 'Page Countries');
		pll_register_string('Statistic', 'Statistic', 'Page Countries');
		pll_register_string('Videos', 'Videos', 'Page Countries');
		pll_register_string('Depositions', 'Depositions', 'Page Countries');
		pll_register_string('Partners', 'Partners', 'Page Countries');
		pll_register_string('Social Networks', 'Social Networks', 'Page Countries');

		
	});
	//widgets - Home
	register_sidebar(array(
		'name'			=> 'Home Left',
		'id'			=> 'home_widget_left',
		'description'	=> 'Widgets Home Left',
		'class'			=> 'list-unstyled'
	));
	register_sidebar(array(
		'name'			=> 'Home Center',
		'id'			=> 'home_widget_center',
		'description'	=> 'Widgets Home Center',
		'class'			=> 'list-unstyled'
	));
	register_sidebar(array(
		'name'			=> 'Home Right',
		'id'			=> 'home_widget_right',
		'description'	=> 'Widgets Home Right',
		'class'			=> 'list-unstyled'
	));
	function add_favicon() {
echo '<link rel="shortcut icon" type="image/png" href="'.get_template_directory_uri().'/assets/favicon.png" />';
}

add_action('wp_head', 'add_favicon');

add_image_size('sizecard',576,300,true);
?>