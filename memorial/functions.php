<?php
// Title - tag <title>
add_theme_support('title-tag');
// Post Thumbnails
add_theme_support('post-thumbnails');
//Add Styles Top
add_action('wp_enqueue_scripts','style_top');
function style_top(){
    wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
    wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css', [], filemtime(get_stylesheet_directory().'/css/style.css'));
    wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/fontawesome/css/all.css');
    wp_enqueue_style('slick',get_stylesheet_directory_uri().'/css/slick.css');
    wp_enqueue_style('theme-slick',get_stylesheet_directory_uri().'/css/slick-theme.css');
}

// Load styles in Gutenberg editor
add_action('enqueue_block_editor_assets', 'memorial_editor_styles');
function memorial_editor_styles(){
    wp_enqueue_style('bootstrap-editor', get_stylesheet_directory_uri().'/css/bootstrap.min.css');
    wp_enqueue_style('style-editor', get_stylesheet_directory_uri().'/css/style.css', array('bootstrap-editor'));
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
    wp_enqueue_script('popper',get_stylesheet_directory_uri().'/js/popper.min.js');
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script('slick',get_stylesheet_directory_uri().'/js/slick.min.js');
    wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');

    $tainacan_url = rtrim(get_option('memorial_tainacan_base_url', 'https://teste.memorialdigitalcovid19.org.br/tainacan'), '/');
    $bvs_url      = rtrim(get_option('memorial_bvs_base_url', 'https://pesquisa.bvsalud.org/memorialcovid'), '/');
    $colecao_params = get_option('memorial_tainacan_colecao_params', 'perpage=12&order=ASC&orderby=date&fetch_only_meta=&paged=1&fetch_only=thumbnail%2Ccreation_date%2Ctitle%2Cdescription&view_mode=cards');
    wp_localize_script('main', 'memorialURLs', [
        'tainacan'        => esc_url($tainacan_url),
        'bvs'             => esc_url($bvs_url),
        'colecao_params'  => sanitize_text_field($colecao_params),
    ]);
}

//Add excerpt to Pages
add_action('init', function () {
    add_post_type_support('page', 'excerpt');
});

//Menus
add_action('init', 'action_init');
function action_init(){
    register_nav_menu('main-nav', 'Main Menu (top)');
    register_nav_menu('Language', 'Language');
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
//custom post type
require_once get_template_directory() . '/includes/functions-colecoes.php';
require_once get_template_directory() . '/includes/functions-aspas.php';

//Custom functions and shortcodes
require_once get_template_directory() . '/includes/functions-shortcodes.php';

//polylang
add_action('init', function() {
    // thema
    pll_register_string('Footer', 'Todos os direitos são reservados', 'Tema'); 
    pll_register_string('Search', 'Pesquisar', 'Tema');
    pll_register_string('Learn more', 'Saiba mais', 'Tema');
    pll_register_string('See all', 'Ver todas', 'Tema');
    pll_register_string('Collections', 'Coleções', 'Tema');
    pll_register_string('Publications', 'Publicações', 'Tema');

    pll_register_string('News', 'Novidades', 'Home');
    pll_register_string('Memories and voices', 'Memórias e vozes', 'Home');
    pll_register_string('Browse through the collections and discover stories and experiences that marked the COVID-19 pandemic.', 'Navegue pelas coleções e conheça histórias e vivências que marcaram a pandemia de COVID-19', 'Home');
});