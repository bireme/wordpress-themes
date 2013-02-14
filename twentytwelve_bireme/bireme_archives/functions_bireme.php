<?php
/**
 * 
 * DEfinições específicas para BIREME
 * 
 */
 /* Load up our theme options page and related code. */
if ( is_admin() ) require_once( TEMPLATEPATH . '/bireme_archives/admin_settings.php' );

$settings = get_option( "wp_bvs_theme_settings" );
$total_columns = $settings['layout']['total'];
$top_sidebar = $settings['layout']['top-sidebar'];
$footer_sidebar = $settings['layout']['footer-sidebar'];

// sidebars do template
register_sidebar( array(
	'name' => 'Header',
	'id' => 'header',
	'description' => '',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );

//SideBar Auxiliar Top só aparece se ativado
if ($top_sidebar == true){
	register_sidebar( array(
		'name' => 'SideBar Auxiliar Top',
		'id' => 'top_sidebar',
		'description' => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
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
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
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
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

register_sidebar( array(
	'name' => 'Footer',
	'id' => 'footer',
	'description' => '',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );



?>
