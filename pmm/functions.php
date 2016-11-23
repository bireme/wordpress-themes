<?php
function theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function home_breadcrumb_title($title, $type, $id)
{
    if( in_array( 'home', $type ) && !$id )
        $title = 'HOME';
    return $title;
}
add_filter('bcn_breadcrumb_title', 'home_breadcrumb_title', 3, 10);

function home_breadcrumb_url($url, $type, $id)
{
    if( defined( 'POLYLANG_VERSION' ) && in_array( 'home', $type ) && !$id ) {
    	$dl = pll_default_language(); // default language
    	$cl = pll_current_language(); // current language
    	if ( $dl != $cl )
        	$url = pll_home_url();
    }
    return $url;
}
add_filter('bcn_breadcrumb_url', 'home_breadcrumb_url', 3, 10);
