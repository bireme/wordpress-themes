<?php
/**
 *
 * DEfinições específicas para BIREME
 *
 */
 /* Load up our theme options page and related code. */
if ( is_admin() ) require_once( TEMPLATEPATH . '/bireme_archives/admin_settings.php' );

$settings = get_option( "wp_bvs_theme_settings" );
$layout = $settings['layout'];
$total_columns = $layout['total'];
$top_sidebar = $layout['top-sidebar'];
$footer_sidebar = $layout['footer-sidebar'];

// sidebars do template
register_sidebar( array(
    'name' => 'Header',
    'id' => 'header',
    'description' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<strong class="widget-title">',
    'after_title' => '</strong>',
) );

//SideBar Auxiliar Top só aparece se ativado
if ($top_sidebar == true){
    register_sidebar( array(
        'name' => 'SideBar Auxiliar Top',
        'id' => 'top_sidebar',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );
}

// gerando as sidebars dinamicamente
for($i=1; $i <= $total_columns; $i++) {

    register_sidebar( array(
        'name' => 'Coluna ' . $i,
        'id' => 'column-' . $i,
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );

}
//SideBar Auxiliar Footer só aparece se ativado
if ($footer_sidebar == true){
    register_sidebar( array(
        'name' => 'SideBar Auxiliar Footer',
        'id' => 'footer_sidebar',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );
}

register_sidebar( array(
    'name' => 'Footer',
    'id' => 'footer',
    'description' => '',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<strong class="widget-title">',
    'after_title' => '</strong>',
) );

register_sidebar( array(
    'name' => 'Level2',
    'id' => 'level2',
    'description' => 'Widgets que aparecerão em segundo nível',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<strong class="widget-title">',
    'after_title' => '</strong>',
) );

$custom_header_file = TEMPLATEPATH . '/bireme_archives/custom/custom-header.php';

if(file_exists($custom_header_file)) {
    add_action('wp_head', 'add_custom_header');
}

function add_custom_header(){
    include_once(TEMPLATEPATH . '/bireme_archives/custom/custom-header.php');
}

$custom_include_file = TEMPLATEPATH . '/bireme_archives/custom/include.php';
if(file_exists($custom_include_file)) {
    require_once($custom_include_file);
}
?>
