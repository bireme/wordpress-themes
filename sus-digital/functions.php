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
// shows the menus in the REST API
add_action( 'rest_api_init', function () {
    register_rest_route( 'menus/v1', '/(?P<location>[a-zA-Z0-9_-]+)', array(
        'methods'  => 'GET',
        'callback' => 'get_menu_by_location',
    ));
});
 
function get_menu_by_location( $request ) {
    $location = $request['location'];
    $locations = get_nav_menu_locations();
 
    if ( ! isset( $locations[$location] ) ) {
        return new WP_Error( 'no_menu', 'No menu registered at this location', array( 'status' => 404 ) );
    }
 
    $menu = wp_get_nav_menu_items( $locations[$location] );
    return rest_ensure_response( $menu );
}