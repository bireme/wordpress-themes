<?php
// Title - tag <title>
add_theme_support('title-tag');
// Post Thumbnails
add_theme_support('post-thumbnails');
//Add Styles Top
add_action('wp_enqueue_scripts','style_top');
function style_top(){
    wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
    wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
    wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/fontawesome/css/all.css');
    wp_enqueue_style('slick',get_stylesheet_directory_uri().'/css/slick.css');
    wp_enqueue_style('theme-slick',get_stylesheet_directory_uri().'/css/slick-theme.css');
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
    wp_enqueue_script('popper',get_stylesheet_directory_uri().'/js/popper.min.js');
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script('slick',get_stylesheet_directory_uri().'/js/slick.min.js');
    wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
}

//Add excerpt to Pages
add_action('init', function () {
    add_post_type_support('page', 'excerpt');
});

//Menus
add_action('init', 'action_init');
function action_init(){
    register_nav_menu('main-nav', 'Main Menu (top)');
    register_nav_menu('main-nav-home', 'Main Menu (Home)');
}

//Excerpt length
add_filter('excerpt_length', 'custom_excerpt_length');
function custom_excerpt_length($length){
    return 20;
}

//RSS Produção
function http_request_local($args, $url){
    if (preg_match('/xml|rss|feed/', $url)) {
        $args['reject_unsafe_urls'] = false;
    }
    return $args;
}
add_filter('http_request_args', 'http_request_local', 5, 2);

//Widgets
register_sidebar([
    'name'          => 'Footer 1',
    'id'            => 'footer1',
    'description'   => 'Footer 1',
    'before_title'  => '<h5>',
    'after_title'   => '</h5>'
]);
register_sidebar([
    'name'          => 'Footer 2',
    'id'            => 'footer2',
    'description'   => 'Footer 2',
    'before_title'  => '<h5>',
    'after_title'   => '</h5>'
]);
register_sidebar([
    'name'          => 'Footer 3',
    'id'            => 'footer3',
    'description'   => 'Footer 3',
    'before_title'  => '<h5>',
    'after_title'   => '</h5>'
]);
register_sidebar([
    'name'          => 'Nova Home',
    'id'            => 'nova-home',
    'description'   => 'Nova Home',
    'before_title'  => '<h5>',
    'after_title'   => '</h5>'
]);
//custom post type
require_once get_template_directory() . '/includes/functions-colecoes.php';