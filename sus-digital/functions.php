<?php
/**
 * Funções do tema
 */

// ------------------------------
// CSS do tema
// ------------------------------
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'twentytwentyfive-style',
        get_template_directory_uri() . '/style.css'
    );
});


// ------------------------------
// Endpoint ACF Options: /wp-json/acf/v3/options
// ------------------------------
if ( function_exists( 'get_field' ) ) {

    add_action( 'rest_api_init', function () {
        register_rest_route( 'acf/v3', '/options', [
            'methods'             => 'GET',
            'callback'            => 'get_acf_options',
            'permission_callback' => '__return_true',
        ] );
    } );

    function get_acf_options() {
        return get_fields( 'option' );
    }
}

// ------------------------------
// Garante SUporte a menus no tema
// ------------------------------
//
add_action( 'after_setup_theme', function () {
    add_theme_support( 'menus' );
} );

// ------------------------------
// Registrar locations de menu do tema
// ------------------------------
//
// Ajuste ou adicione mais locations conforme necessidade.
add_action( 'after_setup_theme', function () {
    register_nav_menus( [
        'main-nav'    => 'Main Menu (top)',
        'footer-nav'  => 'Footer Menu',
        'utility-nav' => 'Utility Menu',
    ] );
} );


// ------------------------------
// REST API: Menus headless
// ------------------------------

add_action( 'rest_api_init', function () {

    // 1) Todos os menus do site atual
    register_rest_route( 'menus/v1', '/all', [
        'methods'             => 'GET',
        'callback'            => 'rest_get_all_menus',
        'permission_callback' => '__return_true',
    ] );

    // 2) Menu por location (ex: main-nav, footer-nav)
    register_rest_route( 'menus/v1', '/(?P<location>[a-zA-Z0-9_-]+)', [
        'methods'             => 'GET',
        'callback'            => 'rest_get_menu_by_location',
        'permission_callback' => '__return_true',
    ] );

    // 3) (Opcional) Todos os menus de TODOS os sites da rede (multisite)
    if ( is_multisite() ) {
        register_rest_route( 'menus/v1', '/network', [
            'methods'             => 'GET',
            'callback'            => 'rest_get_network_menus',
            'permission_callback' => '__return_true',
        ] );
    }
} );

// ------------------------------
// REST API: filtro por campo ACF "br_region" no CPT "project"
// GET /wp-json/wp/v2/project?br_region=Nordeste
// ------------------------------
add_filter( 'rest_project_query', 'susdigital_rest_filter_project_by_br_region_meta', 10, 2 );

function susdigital_rest_filter_project_by_br_region_meta( $args, $request ) {
    // Lê o parâmetro da URL: ?br_region=...
    $param = $request->get_param( 'br_region' );

    // Se não vier parâmetro, não mexe na query
    if ( empty( $param ) ) {
        return $args;
    }

    // Garante que já exista (ou não) um meta_query
    $meta_query = isset( $args['meta_query'] ) ? (array) $args['meta_query'] : [];

    /**
     * Aqui assumimos que:
     * - o "Field Name" no ACF é exatamente "br_region"
     * - o valor salvo é algo como "Nordeste" (ou o slug/nome que você definiu)
     *
     * Se o campo for um select simples / texto, '=' resolve.
     * Se for checkbox ou select múltiplo, talvez seja melhor usar 'LIKE'.
     */
    $meta_query[] = [
        'key'     => 'br_region',   // nome do campo ACF
        'value'   => $param,
        'compare' => '='            // troque para 'LIKE' se for campo múltiplo
    ];

    $args['meta_query'] = $meta_query;

    return $args;
}


// ------------------------------
// REST API: DeCS Terms
// GET /wp-json/wp/v2/project/{id}/decs_term_terms
// Retorna os termos de decs_term associados ao projeto
// ------------------------------
add_action('rest_api_init', function () {
    // Termos de decs_term
    register_rest_field('project', 'decs_term_terms', [
        'get_callback' => function ($object) {
            if (empty($object['decs_term'])) {
                return [];
            }

            $terms = get_terms([
                'taxonomy'   => 'decs_term',
                'include'    => $object['decs_term'],
                'hide_empty' => false,
            ]);

            if (is_wp_error($terms) || empty($terms)) {
                return [];
            }

            return array_map(function ($term) {
                return [
                    'id'   => $term->term_id,
                    'name' => $term->name,
                    'slug' => $term->slug,
                ];
            }, $terms);
        },
        'schema' => null,
    ]);
});


// ------------------------------
// Função: todos os menus do site atual
// GET /wp-json/menus/v1/all
// ------------------------------
function rest_get_all_menus() {
    $menus = [];

    // Todos os menus criados (mesmo sem estarem ligados a location)
    $wp_menus = wp_get_nav_menus();

    // Locations registradas no tema
    $locations = get_nav_menu_locations();

    foreach ( $wp_menus as $menu_obj ) {

        $menu_id    = (int) $menu_obj->term_id;
        $menu_items = wp_get_nav_menu_items( $menu_id );

        // Descobre em quais locations esse menu está em uso
        $menu_locations = [];
        foreach ( $locations as $loc_slug => $loc_menu_id ) {
            if ( (int) $loc_menu_id === $menu_id ) {
                $menu_locations[] = $loc_slug;
            }
        }

        $menus[] = [
            'menu_id'   => $menu_id,
            'name'      => $menu_obj->name,
            'slug'      => $menu_obj->slug,
            'locations' => $menu_locations,           // pode ter 0, 1 ou várias
            'items'     => build_menu_tree( $menu_items ),
        ];
    }

    return rest_ensure_response( $menus );
}


// ------------------------------
// Função: menu por location
// GET /wp-json/menus/v1/{location}
// ex: /wp-json/menus/v1/main-nav
// ------------------------------
function rest_get_menu_by_location( $request ) {
    $location  = sanitize_key( $request['location'] );
    $locations = get_nav_menu_locations();

    if ( ! isset( $locations[ $location ] ) ) {
        return new WP_Error(
            'no_menu',
            'No menu found for this location',
            [ 'status' => 404 ]
        );
    }

    $menu_id    = $locations[ $location ];
    $menu_items = wp_get_nav_menu_items( $menu_id );

    return rest_ensure_response( build_menu_tree( $menu_items ) );
}


// ------------------------------
// Função: menus de TODOS os sites (multisite)
// GET /wp-json/menus/v1/network (chame a partir do site raiz)
// ------------------------------
function rest_get_network_menus() {

    if ( ! function_exists( 'get_sites' ) ) {
        return new WP_Error(
            'not_multisite',
            'Multisite not enabled',
            [ 'status' => 400 ]
        );
    }

    $sites  = get_sites();
    $result = [];

    foreach ( $sites as $site ) {

        switch_to_blog( $site->blog_id );

        // Reaproveita a função de "todos os menus" do site atual
        $menus = rest_get_all_menus();

        if ( $menus instanceof WP_REST_Response ) {
            $menus = $menus->get_data();
        }

        $result[] = [
            'blog_id' => $site->blog_id,
            'domain'  => $site->domain,
            'path'    => $site->path,
            'menus'   => $menus,
        ];

        restore_current_blog();
    }

    return rest_ensure_response( $result );
}


// ------------------------------
// Helper: monta árvore hierárquica de menu
// ------------------------------
function build_menu_tree( $menu_items ) {

    if ( empty( $menu_items ) ) {
        return [];
    }

    // Ordena como no admin do WP
    usort( $menu_items, function ( $a, $b ) {
        return (int) $a->menu_order <=> (int) $b->menu_order;
    } );

    $tree   = [];
    $lookup = [];

    // Normaliza cada item para um formato amigável para React
    foreach ( $menu_items as $item ) {

        $lookup[ (int) $item->ID ] = [
            'id'          => (int) $item->ID,
            'title'       => $item->title,
            'url'         => $item->url,
            'parent'      => (int) $item->menu_item_parent,
            'description' => $item->description ?? '',
            'target'      => $item->target ?? '',
            'rel'         => $item->xfn ?? '',
            'attr_title'  => $item->attr_title ?? '',
            'classes'     => ( isset( $item->classes ) && is_array( $item->classes ) )
                ? array_values( array_filter( $item->classes ) )
                : [],
            'object_id'   => isset( $item->object_id ) ? (int) $item->object_id : 0,
            'object'      => $item->object ?? '',
            'type'        => $item->type ?? '',
            'type_label'  => $item->type_label ?? '',
            'children'    => [],
        ];
    }

    // Monta hierarquia (parent/children)
    foreach ( $lookup as $id => &$node ) {
        if ( $node['parent'] && isset( $lookup[ $node['parent'] ] ) ) {
            $lookup[ $node['parent'] ]['children'][] =& $node;
        } else {
            $tree[] =& $node;
        }
    }

    return $tree;
}