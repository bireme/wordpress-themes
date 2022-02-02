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
  wp_enqueue_style('font','https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;700&display=swap');
  wp_enqueue_style('ficha',get_stylesheet_directory_uri().'/css/ficha.css');
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
  wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.5.1.min.js');
  wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
  wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
  wp_enqueue_script('accessibility',get_stylesheet_directory_uri().'/js/accessibility.js');
  wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
}
//menu
add_action('init', 'action_init');
function action_init()
{
  register_nav_menu('Primary Menu', 'primary');
  register_nav_menu('Secondary Menu', 'secondary');
  register_nav_menu('Language', 'Language');
}
//Custom Post Type
add_action('init', 'custon_posts');
function custon_posts(){
  registrar_custom_post_type();
}
function registrar_custom_post_type() {
// Fichas
  $descritivosFichas = array(
    'name'                => 'Fichas',
    'singular_name'      => 'Fichas',
    'add_new'            => 'Adicionar novo fichas',
    'add_new_item'       => 'Adicionar fichas',
    'edit_item'          => 'Editar fichas',
    'new_item'           => 'Novas fichas',
    'view_item'          => 'Visualizar fichas',
    'search_items'       => 'Pesquisar fichas',
    'not_found'          => 'Nenhum fichas encontrado',
    'not_found_in_trash' => 'Nenhum fichas na lixeira',
    'parent_item_colon'  => '',
    'menu_name'          => 'Fichas'
  );
  $argsFichas = array(
    'labels'            => $descritivosFichas,
    'public'            => true,
    'hierarchical'      => false,
    'menu_position'     => 11,
    'supports'          => array('title'),
    'menu_icon'         => 'dashicons-format-gallery'
  );
  register_post_type( 'fichas' , $argsFichas );
  // ToolKits
  /*$descritivosToolKit = array(
    'name'                => 'Toolkits',
    'singular_name'      => 'Toolkits',
    'add_new'            => 'Adicionar novo toolkit',
    'add_new_item'       => 'Adicionar toolkit',
    'edit_item'          => 'Editar toolkit',
    'new_item'           => 'Novas toolkit',
    'view_item'          => 'Visualizar toolkit',
    'search_items'       => 'Pesquisar toolkit',
    'not_found'          => 'Nenhum toolkit encontrado',
    'not_found_in_trash' => 'Nenhum toolkit na lixeira',
    'parent_item_colon'  => '',
    'menu_name'          => 'Toolkits'
  );
  $argsToolkit = array(
    'labels'            => $descritivosToolKit,
    'public'            => true,
    'hierarchical'      => false,
    'menu_position'     => 12,
    'supports'          => array('title','editor'),
    'menu_icon'         => 'dashicons-media-document'
  );
  register_post_type( 'toolkit' , $argsToolkit );*/
  flush_rewrite_rules();
}
add_image_size('flag', 30, 20, true);

add_action('init', function() {
    //Accessibility
    pll_register_string('Main content', 'Main content', 'Accessibility');
    pll_register_string('Menu', 'Menu', 'Accessibility');
    pll_register_string('Footer', 'Footer', 'Accessibility');
    pll_register_string('High contrast', 'High contrast', 'Accessibility'); 
    //Footer
    pll_register_string('Terms and conditions of use', 'Terms and conditions of use', 'Footer'); 
    pll_register_string('Privacy policy', 'Privacy policy', 'Footer');
    //Labels
    pll_register_string('Ficha técnica del país', 'Ficha técnica del país', 'Labels');
    pll_register_string('Seleccionar país', 'Seleccionar país', 'Labels');
    pll_register_string('Autorización de Mercado', 'Autorización de Mercado', 'Labels');
    pll_register_string('Priorización de TS a evaluar', 'Priorización de TS a evaluar', 'Labels');
    pll_register_string('Configuración institucional y Gobernanza', 'Configuración institucional y Gobernanza', 'Labels');
    pll_register_string('Marco legal y dependencia', 'Marco legal y dependencia', 'Labels');
    pll_register_string('Estructura y Recursos', 'Estructura y Recursos', 'Labels');
    pll_register_string('Redes y Colaboradores', 'Redes y Colaboradores', 'Labels');
    pll_register_string('Evaluación de Tecnologías de Salud', 'Evaluación de Tecnologías de Salud', 'Labels');
    pll_register_string('Aspectos metodológicos y procedimentales', 'Aspectos metodológicos y procedimentales', 'Labels');
    pll_register_string('Directrices y aspectos a evaluar', 'Directrices y aspectos a evaluar', 'Labels');
    pll_register_string('Producción y ejecución', 'Producción y ejecución', 'Labels');
    pll_register_string('Participación social', 'Participación social', 'Labels');
    pll_register_string('Productos de ETS', 'Productos de ETS', 'Labels');
    pll_register_string('Toma de decisiones en salud', 'Toma de decisiones en salud', 'Labels');
    pll_register_string('Mecanismos de incorporación de TS', 'Mecanismos de incorporación de TS', 'Labels');
    pll_register_string('Cobertura en salud', 'Cobertura en salud', 'Labels');
    pll_register_string('TS incorporadas', 'TS incorporadas', 'Labels');
    pll_register_string('Procesos de desinversión', 'Procesos de desinversión', 'Labels');
    pll_register_string('Uso de las Tecnologías de Salud', 'Uso de las Tecnologías de Salud', 'Labels');
    pll_register_string('Uso Racional', 'Uso Racional', 'Labels');
    pll_register_string('Guías de Práctica Clínica', 'Guías de Práctica Clínica', 'Labels');
    pll_register_string('Monitoreo', 'Monitoreo', 'Labels');
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