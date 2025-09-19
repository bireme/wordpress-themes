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


/**
* Expose WordPress menus in REST API with nested structure.
* Drop into functions.php or a custom plugin.
*/

add_action( 'rest_api_init', function () {
    register_rest_route( 'menus/v1', '/all', array(
        'methods'  => 'GET',
        'callback' => 'get_all_menus',
        'permission_callback' => '__return_true',
    ));
    
    register_rest_route( 'menus/v1', '/(?P<location>[a-zA-Z0-9_-]+)', array(
        'methods'  => 'GET',
        'callback' => 'get_menu_by_location',
        'permission_callback' => '__return_true',
    ));
});

function get_all_menus() {
    $locations = get_nav_menu_locations();
    $menus = [];
    
    foreach ( $locations as $location => $menu_id ) {
        $wp_menu   = wp_get_nav_menu_object( $menu_id );
        $menu_items = wp_get_nav_menu_items( $menu_id );
        
        $menus[$location] = [
            'location' => $location,
            'menu_id'  => (int) $menu_id,
            'name'     => $wp_menu ? $wp_menu->name : '',
            'slug'     => $wp_menu ? $wp_menu->slug : '',
            'items'    => build_menu_tree( $menu_items ),
        ];
    }
    
    return rest_ensure_response( $menus );
}

/**
* Return single menu by location
*/
function get_menu_by_location( $request ) {
    $location = $request['location'];
    $locations = get_nav_menu_locations();
    
    if ( ! isset( $locations[$location] ) ) {
        return new WP_Error( 'no_menu', 'No menu registered at this location', array( 'status' => 404 ) );
    }
    
    $menu_items = wp_get_nav_menu_items( $locations[$location] );
    return rest_ensure_response( build_menu_tree( $menu_items ) );
}

/**
* Build hierarchical tree from flat menu items
*/
function build_menu_tree( $menu_items ) {
    if ( empty( $menu_items ) ) {
        return [];
    }
    
    // Ensure consistent order (like in WP admin)
    usort( $menu_items, function( $a, $b ) {
        return (int) $a->menu_order <=> (int) $b->menu_order;
    });
    
    $tree   = [];
    $lookup = [];
    
    // Index by ID with a React-friendly shape
    foreach ( $menu_items as $item ) {
        // WordPress sets description from post_content in wp_setup_nav_menu_item
        $description = isset( $item->description ) ? $item->description : '';
        
        $lookup[ (int) $item->ID ] = [
            'id'           => (int) $item->ID,
            'title'        => $item->title,
            'url'          => $item->url,
            'parent'       => (int) $item->menu_item_parent,
            'description'  => $description,                     // ✅ here it is
            'target'       => isset($item->target) ? $item->target : '',
            'rel'          => isset($item->xfn) ? $item->xfn : '',
            'attr_title'   => isset($item->attr_title) ? $item->attr_title : '',
            'classes'      => isset($item->classes) && is_array($item->classes) ? array_values(array_filter($item->classes)) : [],
            'object_id'    => isset($item->object_id) ? (int) $item->object_id : 0,
            'object'       => isset($item->object) ? $item->object : '',
            'type'         => isset($item->type) ? $item->type : '',
            'type_label'   => isset($item->type_label) ? $item->type_label : '',
            'children'     => [],
        ];
    }
    
    // Build hierarchy
    foreach ( $lookup as $id => &$node ) {
        if ( $node['parent'] && isset( $lookup[ $node['parent'] ] ) ) {
            $lookup[ $node['parent'] ]['children'][] =& $node;
        } else {
            $tree[] =& $node;
        }
    }
    
    return $tree;
}