<?php
// Register Custom Navigation Walker 
require_once get_template_directory().'/includes/class-wp-bootstrap-navwalker.php';
// Title - tag <title>
add_theme_support('title-tag');
//Post Thmbnails
add_theme_support('post-thmbnails');
//Menus Top/Language
add_action('init', 'action_init');
function action_init()
{
	register_nav_menu('main-nav', 'Main Menu (top)');
	register_nav_menu('Language', 'Language');
}
//Add Styles Top
add_action('wp_enqueue_scripts','style_top');
function style_top(){
	wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
	wp_enqueue_style('bootstrap-icons',get_stylesheet_directory_uri().'/css/bootstrap-icons-1.10.5/font/bootstrap-icons.css');
	wp_enqueue_style('slick',get_stylesheet_directory_uri().'/css/slick.css');
	wp_enqueue_style('slick-theme',get_stylesheet_directory_uri().'/css/slick-theme.css');
	wp_enqueue_style('aos',get_stylesheet_directory_uri().'/css/aos.css');
	wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
	wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.6.4.min.js');
	wp_enqueue_script('popper',get_stylesheet_directory_uri().'/js/popper.min.js');
	wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js');
	wp_enqueue_script('slick', get_stylesheet_directory_uri().'/js/slick.min.js');
	wp_enqueue_script('aos', get_stylesheet_directory_uri().'/js/aos.js');
	wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
}
// WIDGETS
register_sidebar([
  'name'        => 'footer 1',
  'id'          => 'footer1',
  'description'   => 'Footer 1',
  'before_title'  => '<h5>',
  'after_title'   => '</h5>'
]);
register_sidebar([
  'name'        => 'footer 2',
  'id'          => 'footer2',
  'description'   => 'Footer 2',
  'before_title'  => '<h5>',
  'after_title'   => '</h5>'
]);
register_sidebar([
  'name'        => 'social',
  'id'          => 'social',
  'description'   => 'Social',
  'before_title'  => '<h5>',
  'after_title'   => '</h5>'
]);
//RSS Produção
function http_request_local( $args, $url ) {
   if ( preg_match('/xml|rss|feed/', $url) ){
      $args['reject_unsafe_urls'] = false;
   }
   return $args;
}
add_filter( 'http_request_args', 'http_request_local', 5, 2 );


// Custom post type
add_action('init', 'custom_posts');
function custom_posts(){
  register_custom_post_type();
}
function register_custom_post_type() {
  // Destaques
  $destaques = array(
    'name'                => 'Destaques',
    'singular_name'       => 'Destaque',
    'add_new'             => 'Adicionar destaque',
    'add_new_item'        => 'Adicionar destaque',
    'edit_item'           => 'Editar destaque',
    'new_item'            => 'Novo item',
    'view_item'           => 'Visualizar destaque',
    'search_items'        => 'Pesquisar destaques',
    'not_found'           => 'Nenhum destque encontrado',
    'not_found_in_trash'  => 'Nenhum destaque na lixeira',
    'parent_item_colon'   => '',
    'menu_name'           => 'Destaques'
  );
  $argsDestaques = array(
    'labels'              => $destaques,
    'public'              => true,
    'hierarchical'        => false,
    'menu_position'       => 13,
    'supports'            => array('title'),
    'menu_icon'           => 'dashicons-images-alt'
  );
  register_post_type( 'Destaques' , $argsDestaques );
}

add_action('init', function() {
  pll_register_string('Term', 'Terms and conditions of use', 'Text default'); 
  pll_register_string('Privacy policy', 'Privacy policy', 'Text default'); 
  pll_register_string('Access My VHL', 'Access My VHL', 'Text default'); 
  pll_register_string('All rights are reserved', 'All rights are reserved', 'Text default'); 
});

// https://wordpressbr.blogspot.com/2012/11/personalizar-o-menu-do-wpnavmenu.html
// bootstrap 5 wp_nav_menu walker
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

  function start_lvl(&$output, $depth = 0, $args = null)
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

  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
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

    $active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
    $nav_link_class = ( $depth > 0 ) ? 'dropdown-item ' : 'nav-link ';
    $attributes .= ( $args->walker->has_children ) ? ' class="'. $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="'. $nav_link_class . $active_class . '"';

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}

?>