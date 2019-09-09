<?php 
	// Adicionar styles - header
	add_action('wp_enqueue_scripts', 'add_script_cabecalho');
	function add_script_cabecalho(){
		require get_template_directory() . '/bootstrap-navwalker.php';
		wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
		wp_enqueue_style('style', get_stylesheet_directory_uri() . '/css/style.css');
	}
	//Adicionar scripts - Footer
	add_action('wp_footer', 'add_script_rodape');
	function add_script_rodape(){
		wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.4.1.min.js');
		wp_enqueue_script('popper', get_stylesheet_directory_uri().'/js/popper.min.js');
		wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', ['jquery']);
		wp_enqueue_script('main', get_stylesheet_directory_uri().'/js/main.js', ['jquery']);
	}
	//Adicionar imagem destacada
	add_theme_support('post-thumbnails');
	//Adicionar tamanho de imagens
	add_image_size('banners',1120,350,true);
	add_image_size('bannerMobile',576,300,true);
	//Tradução Polylang
	add_action('init',function(){
		pll_register_string('Títulos','Listas Anotadas de Medicamentos e Dispositivos','Home');
		pll_register_string('Títulos','Estatisticas','Home');
		pll_register_string('Títulos','Sumários de evidência','Home');
		pll_register_string('Títulos','Comparar Listas por Países','Home');
		pll_register_string('Títulos','Medicamentos por Países','Home');
		pll_register_string('Botões','Buscar','Botões');
		pll_register_string('Botões','Saiba Mais','Botões');
		pll_register_string('Botões','Ver Sumários','Botões');
		pll_register_string('Botões','Comparar Listas','Botões');
		pll_register_string('Formutário','Entre com sua pesquisa','Formutário');
		pll_register_string('Contador','Medicamentos','Contador');
		pll_register_string('Contador','Sumários de Evidências','Contador');
		pll_register_string('Contador','Dispositivos Médicos','Contador');
	});
	// Menu
	add_action('init','action_init');
	function action_init(){
		register_nav_menu('linguagem','Idioma/Language');
		register_nav_menu('menu','Menu/NAV');
		registrar_custom_post_type();
	}
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
			//Banners
			$banner = array(
				'name' 				=> 'Banner',
				'singular_name' 	=> 'Banner',
				'add_new' 			=> 'Adicionar Novo Banner',
				'add_new_item' 		=> 'Adicionar Banner',
				'edit_item' 		=> 'Editar Banner',
				'new_item' 			=> 'Novo Banner',
				'view_item' 		=> 'Ver Banner',
				'search_items' 		=> 'Procurar Banner',
				'not_found' 		=>  'Nenhum Banner encontrado',
				'not_found_in_trash'=> 'Nenhum Banner na Lixeira',
				'parent_item_colon' => '',
				'menu_name' 		=> 'Banner'
			);
			$argsBanner = array(
				'labels' 		=> $banner,
				'public' 		=> true,
				'hierarchical' 	=> false,
				'menu_position' => 11,
				'supports' 		=> array('title'),
				'menu_icon'		=> 'dashicons-feedback'
			);
			register_post_type( 'banners' , $argsBanner );
			//Grupo de Listas
			$lista = array(
				'name' 				=> 'Grupo de Listas',
				'singular_name' 	=> 'Grupo de Listas',
				'add_new' 			=> 'Adicionar Novo Grupo de Listas',
				'add_new_item' 		=> 'Adicionar Grupo de Listas',
				'edit_item' 		=> 'Editar Grupo de Listas',
				'new_item' 			=> 'Novo Grupo de Listas',
				'view_item' 		=> 'Ver Grupo de Listas',
				'search_items' 		=> 'Procurar Grupo de Listas',
				'not_found' 		=>  'Nenhum Grupo de Listas encontrado',
				'not_found_in_trash'=> 'Nenhum Grupo de Listas na Lixeira',
				'parent_item_colon' => '',
				'menu_name' 		=> 'Grupo de Listas'
				
			);
			$argsListas = array(
				'labels' 		=> $lista,
				'public' 		=> true,
				'hierarchical' 	=> false,
				'menu_position' => 12,
				'supports' 		=> array('title'),
				'menu_icon'		=> 'dashicons-media-spreadsheet'
			);
			register_post_type( 'listas' , $argsListas );
		//widgets 1
		register_sidebar(array(
			'name'			=> 'Column Left',
			'id'			=> 'widgets1',
			'description'	=> 'Column Left',
			'class'			=> 'margin1B',
			'before_title'	=> '<h5>',
			'after_title'	=> '</h5>'
		));
		//widgets 2
		register_sidebar(array(
			'name'			=> 'Column Center',
			'id'			=> 'widgets2',
			'description'	=> 'Column Center',
			'class'			=> 'margin1B',
			'before_title'	=> '<h5>',
			'after_title'	=> '</h5>'
		));
		//widgets 3
		register_sidebar(array(
			'name'			=> 'Column Right',
			'id'			=> 'widgets3',
			'description'	=> 'Column Right',
			'class'			=> 'margin1B',
			'before_title'	=> '<h5>',
			'after_title'	=> '</h5>'
		));
	}
?>