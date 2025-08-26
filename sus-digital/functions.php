<?php
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'twentytwentyfive-style',
        get_template_directory_uri() . '/style.css'
    );
});

if ( function_exists('get_field') ) {
    add_action('rest_api_init', function () {
      register_rest_route('acf/v3', '/options', [
        'methods' => 'GET',
        'callback' => 'get_acf_options',
        'permission_callback' => '__return_true',
    ]);
  });

    function get_acf_options() {
      return get_fields('option');
  }
}
// Menus
add_action('init', 'action_init');
function action_init()
{
    register_nav_menu('main-nav', 'Main Menu (top)');
}