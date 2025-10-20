<?php
wp_enqueue_style(
    'bireme-style',
    get_stylesheet_uri(),
    array(),
    '1.2.9' 
);

require_once get_template_directory() . '/inc/admin/meta-loader.php';


// --- Theme setup básico ---
add_action('after_setup_theme', function() {
    // Title tag handled by WP
    add_theme_support('title-tag');

    // Suporte a logo customizável
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 240,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Outros supports úteis
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form','comment-form','gallery','caption'));

    // Registrar localização de menu
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'bireme-lilacs'),
    ));
});


add_action('wp_enqueue_scripts', function(){
  wp_enqueue_script('theme-header', get_template_directory_uri() . '/assets/js/header.js', array(), '1.0', true);
});



function bvs_journals_lilacs_test() {
    $url = 'https://api.bvsalud.org/title/v1/search/';
    $args = [
        'headers' => [
            'apikey' => 'bec15fb66a094aef16439c0169d42710',
            'Accept' => 'application/json',
        ],
        'timeout' => 30,
    ];

    $params = [
        'q'      => '*', // ou sua expressão
        'fq'     => 'indexed_database:"LILACS"',
        'count'  => 10,
        'start'  => 0,
        'format' => 'json',
    ];

    $request_url = add_query_arg( $params, $url );
    $response = wp_remote_get( $request_url, $args );

    if (is_wp_error($response)) {
        return wp_send_json_error($response->get_error_message(), 500);
    }

    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);

    if ($code !== 200) {
        return wp_send_json_error(['status' => $code, 'body' => $body], $code);
    }

    $data = json_decode($body, true);
    return wp_send_json_success($data);
}

// /wp-json/test/bvs
add_action('rest_api_init', function() {
    register_rest_route('test/v1', '/bvs', [
        'methods'  => 'GET',
        'callback' => 'bvs_journals_lilacs_test',
        'permission_callback' => '__return_true',
    ]);
});

