<?php 
	// Adicionar Logo
	// add_theme_support('custom-logo', [
	// 	'height'	=> 50,
	// 	'width'		=> 150,
	// 	'flex-width'=> true
	// ]);
	// Title - tag <title>
	add_theme_support('title-tag');
	// Adicionar script e stule no header
	add_action('wp_enqueue_scripts', 'add_script_cabecalho');
	function add_script_cabecalho(){
		//Adicionar estilos
		wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.css');
		wp_enqueue_style('style', get_stylesheet_directory_uri() . '/css/style.css');
		wp_enqueue_style('acessibilidade',get_stylesheet_directory_uri().'/css/accessibility.css');
		wp_enqueue_style('aos',get_stylesheet_directory_uri().'/css/aos.css');
		wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css' );

		$idioma = pll_current_language();
		if ($idioma == 'ar') {
			wp_enqueue_style('styleRtl', get_stylesheet_directory_uri() . '/css/styleRtl.css');
		}
	}
	// Adicionar script e stule no footer
	add_action('wp_footer', 'add_script_rodape');
	function add_script_rodape(){
		wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.3.1.min.js');
		wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
		wp_enqueue_script('aos', get_stylesheet_directory_uri().'/js/aos.js', array('jquery'));
		wp_enqueue_script('main', get_stylesheet_directory_uri().'/js/main.js', array('jquery'));
		wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
		wp_enqueue_script('accessibility',get_stylesheet_directory_uri().'/js/accessibility.js');
	}

	// Menus Top e Rodape
	add_action('init', 'action_init');
	function action_init()
	{
		register_nav_menu('principal', 'Menu principal (cabeçalho)');
		register_nav_menu('rodape', 'Menu Rodapé');
		register_nav_menu('linguagem', 'Idioma/Language');

		// Ativar Custom Post Tupe (Banners e Bibliotecas)
		registrar_custom_post_type();
	}
	//widgets 1
	register_sidebar(array(
		'name'			=> 'Column 1',
		'id'			=> 'gim_widgets1',
		'description'	=> 'Blue Area 1',
		'class'			=> 'margin1B',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	));
	//widgets 2
	register_sidebar(array(
		'name'			=> 'Column 2',
		'id'			=> 'gim_widgets2',
		'description'	=> 'Blue Area 2',
		'class'			=> 'margin1B',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	));

	//widgets 3
	register_sidebar(array(
		'name'			=> 'Column 3',
		'id'			=> 'gim_widgets3',
		'description'	=> 'Blue Area 3',
		'class'			=> 'margin1B',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	));

	//widgets 4
	register_sidebar(array(
		'name'			=> 'Column 4',
		'id'			=> 'gim_widgets4',
		'description'	=> 'Blue Area 4',
		'class'			=> 'margin1B',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	));
	//widgets 5
	register_sidebar(array(
		'name'			=> 'Column 5',
		'id'			=> 'gim_widgets5',
		'description'	=> 'Blue Area 5',
		'class'			=> 'margin1B',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	));

	//widgets 6
	register_sidebar(array(
		'name'			=> 'Column 6',
		'id'			=> 'gim_widgets6',
		'description'	=> 'Blue Area 6',
		'class'			=> 'margin1B',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	));
	//Footer Left
	register_sidebar(array(
		'name'			=> 'Footer Left',
		'id'			=> 'footer_left',
		'description'	=> 'Footer Left',
		'class'			=> 'margin1B',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	));
	//Footer Right
	register_sidebar(array(
		'name'			=> 'Footer Right',
		'id'			=> 'footer_right',
		'description'	=> 'Footer Right',
		'class'			=> 'margin1B',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	));
	// Excerpt Pages
	add_post_type_support( 'page', 'excerpt');

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
			'labels' => $descritivosBanner,  //Insere o Array de labels dentro do argumento de labels
			'public' => true,  //Se o Custom Type pode ser adicionado aos menus e exibidos em buscas
			'hierarchical' => false,  //Se o Custom Post pode ser hierarquico como as páginas
			'menu_position' => 11,  //Posição do menu que será exibido
			'supports' => array('title','thumbnail') //Quais recursos serão usados (metabox)
	    );
		register_post_type( 'banners' , $argsBanner );
		
		// Bibliotecas
		$descritivos = array(
			'name' => 'Library',
			'singular_name' => 'Library',
			'add_new' => 'Add New Library',
			'add_new_item' => 'Add Library',
			'edit_item' => 'Edit Library',
			'new_item' => 'New Library',
			'view_item' => 'View Library',
			'search_items' => 'Search Library',
			'not_found' =>  'No Library Found',
			'not_found_in_trash' => 'No Library in Trash',
			'parent_item_colon' => '',
			'menu_name' => 'Library'
		);
		$args = array(
			'labels' => $descritivos,  //Insere o Array de labels dentro do argumento de labels
			'public' => true,  //Se o Custom Type pode ser adicionado aos menus e exibidos em buscas
			'hierarchical' => false,  //Se o Custom Post pode ser hierarquico como as páginas
			'menu_position' => 12,  //Posição do menu que será exibido
			'supports' => array('title','editor','thumbnail', 'custom-fields', 'revisions', 'excerpt') //Quais recursos serão usados (metabox)
	    );
		register_post_type( 'biblioteca' , $args );
	}

	// Feed
	add_action('wp_feed_options', 'force_feed', 10, 1); 
	function force_feed($feed) {
	    $feed->force_feed(true);
	}

	//Adiciona suporte a miniaturas (imagem destacada)
	add_theme_support('post-thumbnails');

	//Adicionar tamanhos de imagem no Wordpress
	add_image_size('Bibliotecas', 500, 350, true);
	add_image_size('banners', 1600, 400, true);
	add_image_size('bannerMobile',576,300,true);


	// Tradução Polylang
	add_action('init', function() {
        pll_register_string('Título Home', 'Índices Regionais', 'Plugin');
        pll_register_string('Título Bibliotecas', 'Outros Índices', 'Plugin');
        pll_register_string('Endereço Footer', 'World Health Organization', 'Plugin');
        pll_register_string('Endereço Footer Bireme', 'Bireme', 'Plugin');
       	// Form
        pll_register_string('Formulário', 'Título', 'Formulário');
        pll_register_string('Formulário', 'Autor', 'Formulário');
        pll_register_string('Formulário', 'Assunto', 'Formulário');
        pll_register_string('Formulário', 'Todos os Índices', 'Formulário');
        pll_register_string('Formulário', 'Todas as Fontes', 'Formulário');
        pll_register_string('Formulário', 'Digite o que você procura', 'Formulário');
        pll_register_string('Formulário', 'Pesquisar', 'Formulário');
        pll_register_string('Formulário', 'Pesquisa via descritores', 'Formulário'); 
        pll_register_string('Formulário', 'Saiba Mais', 'Formulário'); 
        pll_register_string('Formulário', 'Ativar entrada de texto por voz', 'Formulário'); 
         // Temo de Uso
        pll_register_string('Temo de Uso', 'enviar um comentário /comunicar um erro', 'Temo de Uso'); 
        pll_register_string('Temo de Uso', 'Termos e condições de uso', 'Temo de Uso'); 
        pll_register_string('Temo de Uso', 'Política de privacidade', 'Temo de Uso');
         // Acessibilidade
        pll_register_string('Main content', 'Main content', 'Accessibility');
		pll_register_string('Menu', 'Menu', 'Accessibility');
		pll_register_string('Search', 'Search', 'Accessibility');
		pll_register_string('Footer', 'Footer', 'Accessibility');
		pll_register_string('High contrast', 'High contrast', 'Accessibility'); 
		// Diversos
		pll_register_string('Veja como é fácil pesquisar no GIM', 'Veja como é fácil pesquisar no GIM', 'Geral');
		pll_register_string('Clique para baixar o guia rápido de pesquisa GIM', 'Clique para baixar o guia rápido de pesquisa GIM', 'Geral');
    });

    function http_request_local( $args, $url ) {
   if ( preg_match('/xml|rss|feed/', $url) ){
      $args['reject_unsafe_urls'] = false;
   }
	   return $args;
	}
	add_filter( 'http_request_args', 'http_request_local', 5, 2 );
?>