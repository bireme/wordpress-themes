<?php 
//Theme Settings
require_once(get_template_directory().'/settings.php');
//Register Custom Navigation Walker 
require_once get_template_directory().'/class-wp-bootstrap-navwalker.php';
// Title - tag <title> 
add_theme_support( 'title-tag' );
// Posta Thumbnails
add_theme_support( 'post-thumbnails' ); 
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
}
//Quantidade de caracteres do excerpt
add_filter('excerpt_length', 'custom_excerpt_length');
function custom_excerpt_length($length) {
  return 25;
}

function bvs_aps_admin_menu() {
    add_submenu_page( 'options-general.php', __('VHL APS Theme Settings', 'bvs-aps'), __('VHL APS', 'bvs-aps'), 'manage_options', 'bvs-aps', 'bvs_aps_page_admin');
    // call register settings function
    add_action( 'admin_init', 'bvs_aps_register_settings' );
}
add_action( 'admin_menu', 'bvs_aps_admin_menu' );

function bvs_aps_register_settings() {
    register_setting('bvs-aps-settings-group', 'bvs_aps_config');
}

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