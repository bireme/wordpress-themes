<?php
//Register Custom Navigation Walker 
require_once get_template_directory().'/class-wp-bootstrap-navwalker.php';
//thumb, title
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );
add_theme_support( 'align-wide' );

add_action('wp_enqueue_scripts','style_top');
function style_top(){
//Add Styles Top
	wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
	wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
	wp_enqueue_style('acessibilidade',get_stylesheet_directory_uri().'/css/accessibility.css');
	wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/fontawesome/css/all.css');
	wp_enqueue_style('fonts','https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto:ital,wght@0,100;0,900;1,400&display=swap');
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
	wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.6.0.min.js');
	wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
	wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
	wp_enqueue_script('accessibility',get_stylesheet_directory_uri().'/js/accessibility.js');
}
//menu
add_action('init', 'action_init');
function action_init()
{
	register_nav_menu('Primary Menu', 'primary');
	register_nav_menu('Language', 'Language');
}
//Custom Post Type
add_action('init', 'custon_posts');
function custon_posts(){
	registrar_custom_post_type();
}
function registrar_custom_post_type() {
	// Áreas Temáticas
	$descritivosTematica = array(
		'name'               => 'Área Temática',
		'singular_name'      => 'Área Temática',
		'add_new'            => 'Adicionar novo área temática',
		'add_new_item'       => 'Adicionar área temática',
		'edit_item'          => 'Editar área temática',
		'new_item'           => 'Novo área temática',
		'view_item'          => 'Visualizar área temática',
		'search_items'       => 'Pesquisar área temática',
		'not_found'          => 'Nenhum área temática encontrado',
		'not_found_in_trash' => 'Nenhum área temática na lixeira',
		'parent_item_colon'  => '',
		'menu_name'          => 'Áreas Temáticas'
	);
	$argsTematica = array(
		'labels'            => $descritivosTematica,
		'public'            => true,
		'hierarchical'      => false,
		'menu_position'     => 11,
		'supports'          => array('title'),
		'menu_icon'         => 'dashicons-format-gallery'
	);
	register_post_type( 'tematica' , $argsTematica );
	// Normas e diretrizes em comunicação científica
	$descritivosNormas = array(
		'name'               => 'Normas e diretrizes',
		'singular_name'      => 'Normas e diretrizes',
		'add_new'            => 'Adicionar novo normas e diretrizes',
		'add_new_item'       => 'Adicionar normas e diretrizes',
		'edit_item'          => 'Editar normas e diretrizes',
		'new_item'           => 'Novo normas e diretrizes',
		'view_item'          => 'Visualizar normas e diretrizes',
		'search_items'       => 'Pesquisar normas e diretrizes',
		'not_found'          => 'Nenhum normas e diretrizes encontrado',
		'not_found_in_trash' => 'Nenhum normas e diretrizes na lixeira',
		'parent_item_colon'  => '',
		'menu_name'          => 'Normas e diretrizes'
	);
	$argsNormas = array(
		'labels'            => $descritivosNormas,
		'public'            => true,
		'hierarchical'      => false,
		'menu_position'     => 12,
		'supports'          => array('title'),
		'menu_icon'         => 'dashicons-category'
	);
	register_post_type( 'normas' , $argsNormas );
	// Cursos e capacitações
	$descritivosCursos = array(
		'name'               => 'Cursos e capacitações',
		'singular_name'      => 'curso',
		'add_new'            => 'Adicionar novo cursos',
		'add_new_item'       => 'Adicionar cursos',
		'edit_item'          => 'Editar cursos',
		'new_item'           => 'Novo cursos',
		'view_item'          => 'Visualizar cursos',
		'search_items'       => 'Pesquisar cursos',
		'not_found'          => 'Nenhum cursos encontrado',
		'not_found_in_trash' => 'Nenhum cursos na lixeira',
		'parent_item_colon'  => '',
		'menu_name'          => 'Cursos e capacitações'
	);
	$argsCursos = array(
		'labels'            => $descritivosCursos,
		'public'            => true,
		'hierarchical'      => false,
		'menu_position'     => 13,
		'supports'          => array('title', 'thumbnail', 'editor', 'excerpt'),
		'menu_icon'         => 'dashicons-welcome-learn-more'
	);
	register_post_type( 'cursos' , $argsCursos );
  	// Critérios de seleção de periódicos em bases de dados
	$descritivosCriterios = array(
		'name'               => 'Critérios de seleção',
		'singular_name'      => 'Critérios de seleção',
		'add_new'            => 'Adicionar novo Critérios de seleção',
		'add_new_item'       => 'Adicionar Critérios de seleção',
		'edit_item'          => 'Editar Critérios de seleção',
		'new_item'           => 'Novo Critérios de seleção',
		'view_item'          => 'Visualizar Critérios de seleção',
		'search_items'       => 'Pesquisar Critérios de seleção',
		'not_found'          => 'Nenhum Critérios de seleção encontrado',
		'not_found_in_trash' => 'Nenhum Critérios de seleção na lixeira',
		'parent_item_colon'  => '',
		'menu_name'          => 'Critérios de seleção de periódicos de periódicos'
	);
	$argsCriterios = array(
		'labels'            => $descritivosCriterios,
		'public'            => true,
		'hierarchical'      => false,
		'menu_position'     => 14,
		'supports'          => array('title','thumbnail'),
		'menu_icon'         => 'dashicons-saved'
	);
	register_post_type( 'criterios' , $argsCriterios );
	flush_rewrite_rules();
}
add_action('init', function() {
  //Default
	pll_register_string('Terms and conditions of use', 'Terms and conditions of use','Default');
	pll_register_string('Privacy policy', 'Privacy policy', 'Default');

  //Accessibility
	pll_register_string('Main content', 'Main content', 'Accessibility');
	pll_register_string('Menu', 'Menu', 'Accessibility');
	pll_register_string('Search', 'Search', 'Accessibility');
	pll_register_string('Footer', 'Footer', 'Accessibility');
	pll_register_string('High contrast', 'High contrast', 'Accessibility'); 

	//HOME
	pll_register_string('Áreas Temáticas', 'Áreas Temáticas', 'Home');
	pll_register_string('Normas e diretrizes em comunicação científica', 'Normas e diretrizes em comunicação científica', 'Home');
	pll_register_string('Cursos e capacitações', 'Cursos e capacitações', 'Home');
	pll_register_string('Critérios de seleção de periódicos em bases de dados', 'Critérios de seleção de periódicos em bases de dados', 'Home');
	pll_register_string('Áreas Temáticas', 'Áreas Temáticas', 'Home');

});
//////////////////////////////////////////// Menu boostrap 5 ////////////////////////////////////////////////////////
class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu
{
	private $current_item;
	private $dropdown_menu_alignment_values = [
		'dropdown-menu-start',
		'dropdown-menu-end',
		'dropdown-menu-sm-start',
		'dropdown-menu-sm-end',
		'dropdown-menu-md-start',
		'dropdown-menu-md-end',
		'dropdown-menu-lg-start',
		'dropdown-menu-lg-end',
		'dropdown-menu-xl-start',
		'dropdown-menu-xl-end',
		'dropdown-menu-xxl-start',
		'dropdown-menu-xxl-end'
	];

	function start_lvl(&$output, $depth = 0, $args = array())
	{
		$dropdown_menu_class[] = '';
		foreach($this->current_item->classes as $class) {
			if(in_array($class, $this->dropdown_menu_alignment_values)) {
				$dropdown_menu_class[] = $class;
			}
		}
		$indent = str_repeat("\t", $depth);
		$submenu = ($depth > 0) ? ' sub-menu' : '';
		$output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
	{
		$this->current_item = $item;
		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		$li_attributes = '';
		$class_names = $value = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = ($args->walker->has_children) ? 'dropdown' : '';
		$classes[] = 'nav-item';
		$classes[] = 'nav-item-' . $item->ID;
		if ($depth && $args->walker->has_children) {
			$classes[] = 'dropdown-menu dropdown-menu-end';
		}
		$class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = ' class="' . esc_attr($class_names) . '"';
		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
		$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';
		$output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';
		$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
		$active_class = ($item->current || $item->current_item_ancestor) ? 'active' : '';
		$attributes .= ($args->walker->has_children) ? ' class="nav-link ' . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="nav-link ' . $active_class . '"';
		$item_output = $args->before;
		$item_output .= ($depth > 0) ? '<a class="dropdown-item"' . $attributes . '>' : '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}

?>