<?php 
	// Adicionar Logo
	// add_theme_support('custom-logo', [
	// 	'height'	=> 50,
	// 	'width'		=> 150,
	// 	'flex-width'=> true
	// ]);
	
	// Adicionar script e style no header
	add_action('wp_enqueue_scripts', 'add_script_cabecalho');
	function add_script_cabecalho(){
		//Adicionar estilos
		wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.css');
		wp_enqueue_style('style', get_stylesheet_directory_uri() . '/css/style.css');
		wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css' );
	}
	// Adicionar script e stule no footer
	add_action('wp_footer', 'add_script_rodape');
	function add_script_rodape(){
		wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.3.1.min.js');
		wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', ['jquery']);
		wp_enqueue_script('main', get_stylesheet_directory_uri().'/js/main.js', ['jquery']);
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
	register_sidebar([
		'name'			=> 'Coluna 1',
		'id'			=> 'gim_widgets1',
		'description'	=> 'Aréa azul coluna 1',
		'class'			=> 'margin1B',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	]);
	//widgets 2
	register_sidebar([
		'name'			=> 'Coluna 2',
		'id'			=> 'gim_widgets2',
		'description'	=> 'Aréa azul coluna 2',
		'class'			=> 'margin1B',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	]);

	//widgets 3
	register_sidebar([
		'name'			=> 'Coluna 3',
		'id'			=> 'gim_widgets3',
		'description'	=> 'Aréa azul coluna 3',
		'class'			=> 'margin1B',
		'before_title'	=> '<h5>',
		'after_title'	=> '</h5>'
	]);
	//Custom Post Type
	function registrar_custom_post_type() {
		// Banners
		$descritivosBanner = array(
			'name' => 'Banner',
			'singular_name' => 'Banner',
			'add_new' => 'Adicionar Novo Banner',
			'add_new_item' => 'Adicionar Banner',
			'edit_item' => 'Editar Banner',
			'new_item' => 'Novo Banner',
			'view_item' => 'Ver Banner',
			'search_items' => 'Procurar Banner',
			'not_found' =>  'Nenhum Banner encontrado',
			'not_found_in_trash' => 'Nenhum Banner na Lixeira',
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
			'name' => 'Bibliotecas',
			'singular_name' => 'Biblioteca',
			'add_new' => 'Adicionar Nova Biblioteca',
			'add_new_item' => 'Adicionar Biblioteca',
			'edit_item' => 'Editar Biblioteca',
			'new_item' => 'Nova Biblioteca',
			'view_item' => 'Ver Bibliotecas',
			'search_items' => 'Procurar Biblioteca',
			'not_found' =>  'Nenhum Curso encontrado',
			'not_found_in_trash' => 'Nenhum Biblioteca na Lixeira',
			'parent_item_colon' => '',
			'menu_name' => 'Biblioteca'
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

	//Adiciona suporte a miniaturas (imagem destacada)
	add_theme_support('post-thumbnails');

	//Adicionar tamanhos de imagem no Wordpress
	add_image_size('Bibliotecas', 500, 350, true);
	add_image_size('banners', 1600, 400, true);


	// Tradução Polylang
	add_action('init', function() {
        pll_register_string('Título Home', 'Índices Regionais', 'Plugin');
        pll_register_string('Título Bibliotecas', 'Outros Índices', 'Plugin');
        pll_register_string('Endereço Footer', 'World Health Organization', 'Plugin');
       	// Form
        pll_register_string('Formulário', 'Título', 'Formulário');
        pll_register_string('Formulário', 'Autor', 'Formulário');
        pll_register_string('Formulário', 'Assunto', 'Formulário');
        pll_register_string('Formulário', 'Todos os Índices', 'Formulário');
        pll_register_string('Formulário', 'Todas as Fontes', 'Formulário');
        pll_register_string('Formulário', 'Digite o que você procura', 'Formulário');
        pll_register_string('Formulário', 'Pesquisar', 'Formulário');
        pll_register_string('Formulário', 'Pesquisa via descritores', 'Formulário');
    });
?>