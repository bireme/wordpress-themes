<?php

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

add_theme_support( 'post-thumbnails' );
// add_filter( 'pre_option_link_manager_enabled', '__return_true' );

if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    add_image_size('enfermeria-highlights', 260, 150, true);
}

// config parameters
$top_sidebar = true;
$footer_sidebar = true;
$mlf_activate = false;
$total_columns = 2;

// languages
$mlf_options = get_option('mlf_config');
$current_language = strtolower(get_bloginfo('language'));
$site_lang = substr($current_language, 0,2);

if ($current_language != ''){
   $current_language = '_' . $current_language;
}

if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
    $mlf_activate = true;
}
$variables_mlf = array (
            'header' => "header",
            'top_sidebar' => "top_sidebar",
            'footer_sidebar' => "footer_sidebar",
            'footer' => "footer",
            'level2' => "level2",
        );
if($mlf_activate) {
    foreach ($variables_mlf as $vmlf) {
        $variables_mlf [$vmlf] = $vmlf . $current_language;
    }
}

register_nav_menu( 'menu', 'Menu' );

// sidebars do template
register_sidebar( array(
    'name' => __('Header','vhl'),
    //'id' => 'header' . $current_language,
    'id' => $variables_mlf['header'],
    'description' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<strong class="widget-title">',
    'after_title' => '</strong>',
) );

// SIDEBARS
//SideBar Auxiliar Top só aparece se ativado
if ($top_sidebar == true){
    register_sidebar( array(
    'name' => __('Top Auxiliary SideBar','vhl'),
    //'id' => 'top_sidebar' . $current_language,
    'id' => $variables_mlf['top_sidebar'],
    'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );
}
// gerando as sidebars dinamicamente
for($i=1; $i <= $total_columns; $i++) {
    $column = "column-" . $i;
    if($mlf_activate) {
      $column .= $current_language;
    }
    register_sidebar( array(
    'name' => __('Column', 'vhl') . ' ' . $i,
    //'id' => 'column-' . $i . $current_language,
    'id' => $column,
    'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );

}
//SideBar Auxiliar Footer só aparece se ativado
if ($footer_sidebar == true){
    register_sidebar( array(
    'name' => __('Footer Auxiliary SideBar','vhl'),
    //'id' => 'footer_sidebar' . $current_language,
    'id' => $variables_mlf['footer_sidebar'],
    'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );
}

register_sidebar( array(
    'name' => __('Footer','vhl'),
    //'id' => 'footer' . $current_language,
    'id' => $variables_mlf['footer'],
    'description' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<strong class="widget-title">',
    'after_title' => '</strong>',
) );

register_sidebar( array(
    'name' => __('Level 2','vhl'),
    //'id' => 'level2' . $current_language,
    'id' => $variables_mlf['level2'],
    'description' => 'Widgets que aparecerão em segundo nível',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<strong class="widget-title">',
    'after_title' => '</strong>',
) );

// if ( is_admin() ) 
require_once( TEMPLATEPATH . '/admin/admin_settings.php' );

// arquivo com os shortcuts de funções
require_once(dirname(__FILE__) . "/admin/admin_shortcuts.php");