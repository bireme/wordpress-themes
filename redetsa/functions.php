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
  register_nav_menu('Footer Menu', 'footer');
  register_nav_menu('Language', 'Language');
}
//Custom Post Type
add_action('init', 'custon_posts');
function custon_posts(){
  registrar_custom_post_type();
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
    'name'                => 'Banner',
    'singular_name'      => 'Banner',
    'add_new'            => 'Adicionar novo banner',
    'add_new_item'       => 'Adicionar banner',
    'edit_item'          => 'Editar banner',
    'new_item'           => 'Novo banner',
    'view_item'          => 'Visualizar banner',
    'search_items'       => 'Pesquisar banner',
    'not_found'          => 'Nenhum banner encontrado',
    'not_found_in_trash' => 'Nenhum banner na lixeira',
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
  'name'			=> 'Footer',
  'id'			=> 'footer',
  'description'	=> 'Footer',
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

add_image_size('bannerDesktop', 1280, 480, true);
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