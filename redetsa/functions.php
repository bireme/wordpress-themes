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
//menu
add_action('init', 'action_init');
function action_init()
{
  register_nav_menu('Primary Menu', 'primary');
  register_nav_menu('Language', 'Language');
}
//Custom Post Type
add_action('init', 'custom_posts');
function custom_posts(){
  registrar_custom_post_type();
}
//Quantidade de caracteres do excerpt
add_filter('excerpt_length', 'custom_excerpt_length');
function custom_excerpt_length($length) {
return 15;
}
function registrar_custom_post_type() {
// Banners
  $home = array(
    'name' => 'Home'
  );
  $argsHome = array(
    'labels'        => $home,
    'public'        => true,
    'hierarchical'  => false,
    'menu_position' => 10,
    'supports'      => array('title'),
    'menu_icon'     => 'dashicons-admin-home'
  );
  register_post_type( 'home' , $argsHome );
// Banners
  $descritivosBanner = array(
    'name'               => 'Banner',
    'singular_name'      => 'Banner',
    'add_new'            => 'Agregar nuevo banner',
    'add_new_item'       => 'Agregar banner',
    'edit_item'          => 'Editar banner',
    'new_item'           => 'Nuevo banner',
    'view_item'          => 'Ver banner',
    'search_items'       => 'Buscar banner',
    'not_found'          => 'No se encontraron banner encontrado',
    'not_found_in_trash' => 'No se encontraron banner en la papelera',
    'parent_item_colon'  => '',
    'menu_name'          => 'Banner'
  );
  $argsBanner = array(
    'labels'            => $descritivosBanner,
    'public'            => true,
    'hierarchical'      => false,
    'menu_position'     => 11,
    'supports'          => array('title'),
    'menu_icon'         => 'dashicons-format-gallery'
  );
  register_post_type( 'banners' , $argsBanner );
// Covid Brisa
  $covidBrisa = array(
    'name'               => 'Covid-Brisa',
    'singular_name'      => 'Covid-Brisa',
    'add_new'            => 'Agregar nueva estratégia Covid-19 Brisa',
    'add_new_item'       => 'Agregar estratégia Covid-19 Brisa',
    'edit_item'          => 'Editar estratégia Covid-19 Brisa',
    'new_item'           => 'Nueva estratégia Covid-19 Brisa',
    'view_item'          => 'Ver estratégia Covid-19 Brisa',
    'search_items'       => 'Buscar estratégia Covid-19 Brisa',
    'not_found'          => 'No se encontraron estratégia Covid-19 Brisa encontrada',
    'not_found_in_trash' => 'No se encontraron estratégia Covid-19 Brisa en la papelera',
    'parent_item_colon'  => '',
    'menu_name'          => 'Estratégia Covid-19'
  );
  $argsCovidBrisa = array(
    'labels'            => $covidBrisa,
    'public'            => true,
    'hierarchical'      => false,
    'menu_position'     => 11,
    'supports'          => array('title', 'editor', 'thumbnail'),
    'menu_icon'         => 'dashicons-rest-api'
  );
  register_post_type( 'covid-brisa' , $argsCovidBrisa );
// Estratégias
  $estrategias = array(
    'name'               => 'Estratégias',
    'singular_name'      => 'Estratégia',
    'add_new'            => 'Agregar nueva Estratégia Brisa',
    'add_new_item'       => 'Agregar Estratégia Brisa',
    'edit_item'          => 'Editar Estratégia Brisa',
    'new_item'           => 'Nueva Estratégia Brisa',
    'view_item'          => 'Ver Estratégias Brisa',
    'search_items'       => 'Buscar Estratégias Brisa',
    'not_found'          => 'No se encontraron Estratégia Brisa encontrada',
    'not_found_in_trash' => 'No se encontraron Estratégia Brisa en la papelera',
    'parent_item_colon'  => '',
    'menu_name'          => 'Estratégia Brisa'
  );
  $argsOutrasEstrategias = array(
    'labels'            => $estrategias,
    'public'            => true,
    'hierarchical'      => false,
    'menu_position'     => 11,
    'supports'          => array('title', 'editor', 'thumbnail'),
    'menu_icon'         => 'dashicons-editor-kitchensink'
  );
  register_post_type( 'estrategia-brisa' , $argsOutrasEstrategias );
  // Estratégias Rebrats
  $rebrats = array(
    'name'               => 'Estratégias Rebrats',
    'singular_name'      => 'Estratégia Rebrats',
    'add_new'            => 'Agregar nueva Estratégia Rebrats',
    'add_new_item'       => 'Agregar Estratégia Rebrats',
    'edit_item'          => 'Editar Estratégia Rebrats',
    'new_item'           => 'Nueva Estratégia Rebrats',
    'view_item'          => 'Ver Estratégias Rebrats',
    'search_items'       => 'Buscar Estratégias Rebrats',
    'not_found'          => 'No se encontraron Estratégia Rebrats encontrada',
    'not_found_in_trash' => 'No se encontraron Estratégia Rebrats en la papelera',
    'parent_item_colon'  => '',
    'menu_name'          => 'Estratégia Rebrats'
  );
  $argsRebrats = array(
    'labels'            => $rebrats,
    'public'            => true,
    'hierarchical'      => false,
    'menu_position'     => 11,
    'supports'          => array('title', 'editor', 'thumbnail'),
    'menu_icon'         => 'dashicons-clipboard'
  );
  register_post_type( 'estrategia-rebrats' , $argsRebrats );
  // Eventos
  $eventos = array(
    'name'               => 'Eventos',
    'singular_name'      => 'Evento',
    'add_new'            => 'Agregar nuevo evento',
    'add_new_item'       => 'Agregar evento',
    'edit_item'          => 'Editar evento',
    'new_item'           => 'Nuevo evento',
    'view_item'          => 'Ver evento',
    'search_items'       => 'Buscar eventos',
    'not_found'          => 'No se encontraron eventos',
    'not_found_in_trash' => 'No se encontraron eventos en la papelera',
    'parent_item_colon'  => '',
    'menu_name'          => 'Eventos'
  );
  $argsEventos = array(
    'labels'            => $eventos,
    'public'            => true,
    'hierarchical'      => false,
    'menu_position'     => 11,
    'supports'          => array('title', 'editor', 'thumbnail'),
    'menu_icon'         => 'dashicons-media-document'
  );
  register_post_type( 'eventos' , $argsEventos );
  flush_rewrite_rules();
}
// WIDGETS
register_sidebar([
  'name'			=> 'Sidebar',
  'id'			=> 'sidebar-1',
  'description'	=> 'Sidebar',
  'before_widget' => '<aside>',
  'after_widget'  => '</aside>',
  'before_title'  => '<h2 class="widget-title">',
  'after_title'   => '</h2>'
]);
register_sidebar([
  'name'           => 'RSS Home',
  'id'             => 'rss_home',
  'description'    => 'RSS Home',
  'before_widget'  => '<aside>',
  'after_widget'   => '</aside>',
  'before_title'   => '<h3 class="title1">',
  'after_title'    => '</h3>'
]);


add_image_size('bannerDesktop', 1280, 350, true);
add_image_size('bannerMobile', 600, 350, true);


add_action('init', function() {
//Default
  pll_register_string('Terms and conditions of use', 'Terms and conditions of use','Default');
  pll_register_string('Privacy policy', 'Privacy policy', 'Default');
  pll_register_string('View more', 'View more', 'Default');

//Home
  pll_register_string('Latest news', 'Latest news','Home');
  pll_register_string('Know RedETSA', 'Know RedETSA', 'Home');

//Accessibility
  pll_register_string('Main content', 'Main content', 'Accessibility');
  pll_register_string('Menu', 'Menu', 'Accessibility');
  pll_register_string('Search', 'Search', 'Accessibility');
  pll_register_string('Footer', 'Footer', 'Accessibility');
  pll_register_string('High contrast', 'High contrast', 'Accessibility');

//Filters
  pll_register_string('all_cats', 'All Categories', 'Theme');
  pll_register_string('year_filter', 'Filter by year', 'Theme');
  pll_register_string('placeholder', 'Enter one or more words', 'Theme');
  pll_register_string('search', 'Search', 'Theme');
  pll_register_string('not_found', 'No results found', 'Theme');
  pll_register_string('filters', 'Filters', 'Theme');
  pll_register_string('ago', 'ago', 'Theme');
//Page Brisa
  pll_register_string('Advanced Search', 'Advanced Search', 'Page Brisa');
  pll_register_string('Explore the BRISA database by category', 'Explore the BRISA database by category', 'Page Brisa');
});


function custom_template_include( $template ) {
    global $wp;
    
    if ( !$wp->request && array_key_exists('category_name', $wp->query_vars) && empty($wp->query_vars['category_name']) ) {
        $template = locate_template( array( 'category.php' ) );
    }

    return $template;
}
// add_filter( 'template_include', 'custom_template_include' );

// Ajuste RSS
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
