<?php
// Suporte para título
add_theme_support("title-tag");
// Suporte para thumbnail
add_theme_support("post-thumbnails");
// Suporte para menu
register_nav_menus(array(
    "primary" => "Menu Principal",
));
//Add Styles Top
add_action('wp_enqueue_scripts','style_top');
function style_top(){
    wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-icons',get_stylesheet_directory_uri().'/css/bootstrap-icons-1.10.5/font/bootstrap-icons.css');
    wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
    wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.7.1.min.js');
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js');
    wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
}
function custom_post_type_vagas_oportunidades() {
    $labels = array(
        'name'                  => 'Vagas e Oportunidades',
        'singular_name'         => 'Vaga ou Oportunidade',
        'menu_name'             => 'Vagas e Oportunidades',
        'name_admin_bar'        => 'Vaga ou Oportunidade',
        'add_new'               => 'Adicionar Nova',
        'add_new_item'          => 'Adicionar Nova Vaga ou Oportunidade',
        'new_item'              => 'Nova Vaga ou Oportunidade',
        'edit_item'             => 'Editar Vaga ou Oportunidade',
        'view_item'             => 'Ver Vaga ou Oportunidade',
        'all_items'             => 'Todas as Vagas e Oportunidades',
        'search_items'          => 'Buscar Vagas e Oportunidades',
        'parent_item_colon'     => 'Vagas e Oportunidades Pai:',
        'not_found'             => 'Nenhuma vaga ou oportunidade encontrada.',
        'not_found_in_trash'    => 'Nenhuma vaga ou oportunidade encontrada na lixeira.'
    );
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'show_in_rest'          => true,
        'rewrite'               => array( 'slug' => 'vagas-oportunidades' ),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => null,
        'supports'              => array( 'title', 'editor', 'excerpt')
    );

    register_post_type( 'vagas_oportunidades', $args );
}
add_action( 'init', 'custom_post_type_vagas_oportunidades' );
// Suporte para logo
add_theme_support("custom-logo", array(
    "height" => 100,
    "width" => 400,
    "flex-height" => true,
    "flex-width" => true,
));
// Área para widgets
function create_footer_widget_area() {
    register_sidebar([
        'name'          => 'BIREME',
        'id'            => 'bireme',
        'description'   => 'Descrição BIREME',
        'before_title'  => '<h5>',
        'after_title'   => '</h5>'
    ]);
    register_sidebar([
        'name'          => 'Rodape',
        'id'            => 'footer',
        'description'   => 'Footer',
        'before_title'  => '<h5>',
        'after_title'   => '</h5>'
    ]);
}
add_action("widgets_init", "create_footer_widget_area");
?>
