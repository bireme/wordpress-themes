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
	wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/fontawesome/css/all.css');
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
	wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.6.0.min.js');
	wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
	wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
}
//menu
add_action('init', 'action_init');
function action_init()
{
	register_nav_menu('Primary Menu', 'primary');
	register_nav_menu('Language', 'Language');
}
//widgets - Home
register_sidebar(array(
	'name'			=> 'Notícias Home',
	'id'			=> 'home_widget',
	'description'	=> 'Widgets Home',
	'class'			=> 'list-unstyled',
	'before_title'	=> '<h5>',
	'after_title'	=> '</h5>'
));
//Polylang
add_action('init', function() {
//Default
	pll_register_string('Terms and conditions of use', 'Terms and conditions of use','Default');
	pll_register_string('Privacy policy', 'Privacy policy', 'Default');
	pll_register_string('View more', 'View more', 'Default');
	pll_register_string('Scientific Comittee', 'Scientific Comittee', 'Default');
	pll_register_string('Advisory Committee', 'Advisory Committee', 'Default');
});
//Custom Post Type
add_action('init', 'custon_posts');
function custon_posts(){
	registrar_custom_post_type();
}
function registrar_custom_post_type() {
// Comité Científico
	$descritivosCientifico = array(
		'name' 				=> 'Cientifico',
		'singular_name' 	=> 'Cientifico',
		'add_new' 			=> 'Add New Cientifico',
		'add_new_item' 		=> 'Add Cientifico',
		'edit_item' 		=> 'Edit Cientifico',
		'new_item' 			=> 'New Cientifico',
		'view_item' 		=> 'View Cientifico',
		'search_items' 		=> 'Search Cientifico',
		'not_found' 		=>  'No Cientifico Found',
		'not_found_in_trash'=> 'No Cientifico in Trash',
		'parent_item_colon' => '',
		'menu_name' 		=> 'Comite Cientifico'
	);
	$argsCientifico = array(
		'labels' 			=> $descritivosCientifico,
		'public' 			=> true,
		'hierarchical' 		=> false,
		'menu_position' 	=> 11,
		'supports' 			=> array('title','editor','excerpt'),
		'menu_icon'         => 'dashicons-media-spreadsheet'
	);
	register_post_type( 'cientifico' , $argsCientifico );
	// Comité Acessor
	$descritivosAcessor = array(
		'name' 				=> 'Acessor',
		'singular_name' 	=> 'Acessor',
		'add_new' 			=> 'Add New Acessor',
		'add_new_item' 		=> 'Add Acessor',
		'edit_item' 		=> 'Edit Acessor',
		'new_item' 			=> 'New Acessor',
		'view_item' 		=> 'View Acessor',
		'search_items' 		=> 'Search Acessor',
		'not_found' 		=>  'No Acessor Found',
		'not_found_in_trash'=> 'No Acessor in Trash',
		'parent_item_colon' => '',
		'menu_name' 		=> 'Comite Acessor'
	);
	$argsAcessor = array(
		'labels' 			=> $descritivosAcessor,
		'public' 			=> true,
		'hierarchical' 		=> false,
		'menu_position' 	=> 11,
		'supports' 			=> array('title','editor','excerpt'),
		'menu_icon'         => 'dashicons-media-spreadsheet'
	);
	register_post_type( 'acessor' , $argsAcessor );
	flush_rewrite_rules();
}

function http_request_local( $args, $url ) {
   if ( preg_match('/xml|rss|feed/', $url) ){
      $args['reject_unsafe_urls'] = false;
   }
   return $args;
}
add_filter( 'http_request_args', 'http_request_local', 5, 2 );

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
