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
		wp_enqueue_style('acessibilidade',get_stylesheet_directory_uri().'/css/accessibility.css');
		wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/fontawesome/css/all.css');
	}
	//Add Scripts Footer
	add_action('wp_footer','scripts_footer');
	function scripts_footer(){
		wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.4.1.min.js');
		wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
		wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
		wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
		wp_enqueue_script('accessibility',get_stylesheet_directory_uri().'/js/accessibility.js');
	}
	// Menus Topo
	add_action('init', 'action_init');
	function action_init()
	{
		register_nav_menu('main-nav', 'Main Menu (top)');
	}
// WIDGETS
	//TV Clima
	register_sidebar([
		'name'			=> 'Clima',
		'id'			=> 'clima',
		'description'	=> 'Clima TV',
		'before_title'	=> '<h4>',
		'after_title'	=> '</h4>'
	]);
	//Categorias
	register_sidebar([
		'name'			=> 'Categorias',
		'id'			=> 'categorias',
		'description'	=> 'Categorias',
		'before_title'	=> '<h4>',
		'after_title'	=> '</h4>'
	]);
	//Enquete
	register_sidebar([
		'name'			=> 'Enquete',
		'id'			=> 'enquete',
		'description'	=> 'Enquete',
		'before_title'	=> '<h4>',
		'after_title'	=> '</h4>'
	]);
	//Adicionar tamanhos de imagem no Wordpress
	add_image_size('banners', 800, 400, true);
	add_image_size('tv',830,530,true);
?>