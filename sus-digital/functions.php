<?php
/**
 * functions.php — Tema filho do SUS Digital
 *
 * Índice de funcionalidades:
 * 1.  Enqueue do CSS do tema pai
 * 2.  Suporte a menus e registro de locations
 * 3.  REST API › Menus headless (todos / por location / rede multisite)
 * 4.  REST API › Lista de sites do multisite          GET /wp-json/susdigi/v1/sites
 * 5.  REST API › Filtros por CPT e taxonomia          GET /wp-json/susdigi/v1/filters?post_type=
 * 6.  REST API › Options do ACF                       GET /wp-json/acf/v3/options
 * 7.  REST API › Cache das Options Pages do ACF       (flush automático ao salvar)
 * 8.  REST API › Filtro por taxonomia "program"       GET /wp-json/wp/v2/{cpt}?program_slug=
 * 9.  REST API › Filtro por meta "br_region"          GET /wp-json/wp/v2/project?br_region=
 * 10. REST API › Campo extra "decs_term_terms"        GET /wp-json/wp/v2/project/{id}
 * 11. Helper › build_menu_tree()
 */


// =============================================================================
// 1. CSS DO TEMA PAI
// =============================================================================
// Carrega o style.css do tema Twenty Twenty-Five (pai).
// Se o tema pai mudar, ajuste get_template_directory_uri().
// =============================================================================

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'twentytwentyfive-style',
        get_template_directory_uri() . '/style.css'
    );
} );


// =============================================================================
// 2. SUPORTE A MENUS E REGISTRO DE LOCATIONS
// =============================================================================
// Declara as três áreas de menu utilizadas pelo front-end React headless.
// Adicione ou remova locations conforme a necessidade do projeto.
// =============================================================================

add_action( 'after_setup_theme', function () {
    add_theme_support( 'menus' );

    register_nav_menus( [
        'main-nav'    => 'Main Menu (top)',
        'footer-nav'  => 'Footer Menu',
        'utility-nav' => 'Utility Menu',
    ] );
} );


// =============================================================================
// 3. REST API › MENUS HEADLESS
// =============================================================================
// Expõe três endpoints para consumo dos menus pelo front-end React:
//
//   GET /wp-json/menus/v1/all
//       → Todos os menus do site atual com itens em árvore hierárquica.
//
//   GET /wp-json/menus/v1/{location}
//       → Menu de uma location específica.
//       ex: /wp-json/menus/v1/main-nav
//           /wp-json/menus/v1/footer-nav
//
//   GET /wp-json/menus/v1/network          (somente multisite)
//       → Menus de TODOS os subsites da rede.
// =============================================================================

add_action( 'rest_api_init', function () {

    register_rest_route( 'menus/v1', '/all', [
        'methods'             => 'GET',
        'callback'            => 'rest_get_all_menus',
        'permission_callback' => '__return_true',
    ] );

    register_rest_route( 'menus/v1', '/(?P<location>[a-zA-Z0-9_-]+)', [
        'methods'             => 'GET',
        'callback'            => 'rest_get_menu_by_location',
        'permission_callback' => '__return_true',
    ] );

    if ( is_multisite() ) {
        register_rest_route( 'menus/v1', '/network', [
            'methods'             => 'GET',
            'callback'            => 'rest_get_network_menus',
            'permission_callback' => '__return_true',
        ] );
    }
} );

// Retorna todos os menus do site atual com itens em árvore hierárquica.
function rest_get_all_menus() {
    $menus     = [];
    $wp_menus  = wp_get_nav_menus();
    $locations = get_nav_menu_locations();

    foreach ( $wp_menus as $menu_obj ) {
        $menu_id    = (int) $menu_obj->term_id;
        $menu_items = wp_get_nav_menu_items( $menu_id );

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
            'locations' => $menu_locations,
            'items'     => build_menu_tree( $menu_items ),
        ];
    }

    return rest_ensure_response( $menus );
}

// Retorna o menu de uma location específica.
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

// Retorna os menus de todos os subsites da rede (somente multisite).
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


// =============================================================================
// 4. REST API › LISTA DE SITES DO MULTISITE
// =============================================================================
// Retorna os subsites públicos da rede com id, slug, nome, URL e idioma.
//
//   GET /wp-json/susdigi/v1/sites
// =============================================================================

add_action( 'rest_api_init', function () {
    register_rest_route( 'susdigi/v1', '/sites', [
        'methods'             => 'GET',
        'callback'            => 'susdigi_get_sites',
        'permission_callback' => '__return_true',
    ] );
} );

function susdigi_get_sites() {
    $sites = get_sites( [
        'public'   => 1,
        'archived' => 0,
        'deleted'  => 0,
        'fields'   => 'ids',
    ] );

    $data = [];
    foreach ( $sites as $site_id ) {
        $details = get_blog_details( $site_id );
        $data[]  = [
            'id'          => $site_id,
            'slug'        => $details->path,
            'name'        => $details->blogname,
            'url'         => $details->siteurl,
            'description' => $details->blogdescription,
            'lang'        => get_blog_option( $site_id, 'WPLANG', 'pt_BR' ),
        ];
    }

    return rest_ensure_response( $data );
}


// =============================================================================
// 5. REST API › FILTROS POR CPT + TAXONOMIAS (faceted search)
// =============================================================================
// Recebe um post_type e devolve todas as taxonomias associadas com seus
// termos e respectivas contagens de posts publicados.
// Ideal para renderizar painéis de filtro dinamicamente no React.
//
//   GET /wp-json/susdigi/v1/filters?post_type=post
//   GET /wp-json/susdigi/v1/filters?post_type=project
//   GET /wp-json/susdigi/v1/filters?post_type=stories
//   GET /wp-json/susdigi/v1/filters?post_type=event
//   GET /wp-json/susdigi/v1/filters?post_type=testimonials
//
// Resposta:
// {
//   "post_type": "event",
//   "filters": [
//     {
//       "taxonomy": "program",
//       "label": "Programas",
//       "items": [
//         { "id": 12, "slug": "petsaude", "name": "PET-Saúde", "count": 5 }
//       ]
//     }
//   ]
// }
// =============================================================================

add_action( 'rest_api_init', function () {
    register_rest_route( 'susdigi/v1', '/filters', [
        'methods'             => 'GET',
        'callback'            => 'susdigi_get_filters',
        'permission_callback' => '__return_true',
        'args'                => [
            'post_type' => [
                'sanitize_callback' => 'sanitize_key',
                'default'           => '',
            ],
        ],
    ] );
} );

function susdigi_get_filters( WP_REST_Request $request ) {
    $post_type = $request->get_param( 'post_type' );

    // Whitelist de CPTs permitidos (segurança: evita exposição de post types internos)
    $allowed_post_types = [ 'post', 'event', 'project', 'stories', 'testimonials' ];

    if ( empty( $post_type ) || ! in_array( $post_type, $allowed_post_types, true ) ) {
        return new WP_Error(
            'invalid_post_type',
            'post_type ausente ou não permitido. Valores aceitos: ' . implode( ', ', $allowed_post_types ),
            [ 'status' => 400 ]
        );
    }

    $taxonomies = get_object_taxonomies( $post_type, 'objects' );
    $filters    = [];

    foreach ( $taxonomies as $tax_slug => $tax_obj ) {
        $terms = get_terms( [
            'taxonomy'    => $tax_slug,
            'hide_empty'  => true,           // só exibe termos com posts publicados
            'orderby'     => 'count',
            'order'       => 'DESC',
            'object_type' => [ $post_type ], // conta apenas posts deste CPT
        ] );

        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            continue;
        }

        $items = array_map( function ( $term ) {
            return [
                'id'    => $term->term_id,
                'slug'  => $term->slug,
                'name'  => $term->name,
                'count' => (int) $term->count,
            ];
        }, $terms );

        $filters[] = [
            'taxonomy' => $tax_slug,
            'label'    => $tax_obj->label,
            'items'    => $items,
        ];
    }

    return rest_ensure_response( [
        'post_type' => $post_type,
        'filters'   => $filters,
    ] );
}


// =============================================================================
// 6. REST API › OPTIONS DO ACF
// =============================================================================
// Expõe os campos da Options Page do ACF Pro.
// Necessário porque o endpoint nativo do ACF (/acf/v3/options/options) exige
// autenticação em algumas configurações.
//
//   GET /wp-json/acf/v3/options
// =============================================================================

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


// =============================================================================
// 7. REST API › CACHE DAS OPTIONS PAGES DO ACF
// =============================================================================
// Garante que, ao salvar uma Options Page no painel WP, o cache da REST API
// seja limpo automaticamente — sem necessidade de acesso ao banco ou à infra.
//
// Cobre:
//   - Cache de objetos (Redis, Memcached ou cache nativo do WP)
//   - Transients da REST API
//   - Plugins de cache populares (WP Rocket, W3TC, LiteSpeed, WP Super Cache)
//   - Header Cache-Control nas rotas /acf/v3/options para evitar cache em CDN/proxy
// =============================================================================

// 7a. Flush automático ao salvar qualquer Options Page do ACF
add_action( 'acf/save_post', function ( $post_id ) {

    // Só age em páginas de opções (post_id é string, ex: 'options' ou slug da página)
    if ( ! is_string( $post_id ) ) {
        return;
    }

    // Cache de objetos nativo do WP (e Redis/Memcached se configurados)
    wp_cache_flush();

    // Transients gerados pela REST API
    global $wpdb;
    $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_rest_%'" );
    $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_rest_%'" );

    // Revalida cache de permalinks (sem gravar no .htaccess)
    flush_rewrite_rules( false );

    // WP Rocket
    if ( function_exists( 'rocket_clean_domain' ) ) {
        rocket_clean_domain();
    }

    // W3 Total Cache
    if ( function_exists( 'w3tc_flush_all' ) ) {
        w3tc_flush_all();
    }

    // LiteSpeed Cache
    if ( class_exists( 'LiteSpeed_Cache_API' ) ) {
        LiteSpeed_Cache_API::purge_all();
    }

    // WP Super Cache
    if ( function_exists( 'wp_cache_clear_cache' ) ) {
        wp_cache_clear_cache();
    }

}, 20 );

// 7b. Impede que proxies e CDNs armazenem respostas das rotas de options
add_filter( 'rest_post_dispatch', function ( $result, $server, $request ) {
    $route = $request->get_route();

    if ( strpos( $route, '/acf/v3/options' ) !== false ) {
        $result->header( 'Cache-Control', 'no-store, no-cache, must-revalidate' );
        $result->header( 'Pragma', 'no-cache' );
        $result->header( 'Surrogate-Control', 'no-store' );
    }

    return $result;
}, 10, 3 );


// =============================================================================
// 8. REST API › FILTRO POR TAXONOMIA "program"
// =============================================================================
// Permite filtrar posts e CPTs pelo slug de um termo da taxonomia "program"
// diretamente nos endpoints nativos do WP REST API.
//
// O parâmetro é "program_slug" (e não "program") para não conflitar com o
// parâmetro nativo do WP que espera ID inteiro.
//
//   GET /wp-json/wp/v2/posts?program_slug=telessaude
//   GET /wp-json/wp/v2/event?program_slug=petsaude
//   GET /wp-json/wp/v2/stories?program_slug=inovasus
//   GET /wp-json/wp/v2/project?program_slug=transforma-sus-digital
//   GET /wp-json/wp/v2/testimonials?program_slug=sus-digital
// =============================================================================

add_action( 'init', function () {
    $post_types = [ 'post', 'event', 'stories', 'project', 'testimonials' ];

    foreach ( $post_types as $pt ) {
        add_filter( "rest_{$pt}_query", 'susdigi_filter_by_program_slug', 10, 2 );
    }
} );

function susdigi_filter_by_program_slug( $args, $request ) {
    $slug = $request->get_param( 'program_slug' );

    if ( empty( $slug ) ) {
        return $args;
    }

    $term = get_term_by( 'slug', sanitize_title( $slug ), 'program' );

    if ( ! $term || is_wp_error( $term ) ) {
        return $args;
    }

    $args['tax_query'] = [
        [
            'taxonomy' => 'program',
            'field'    => 'term_id',
            'terms'    => $term->term_id,
        ],
    ];

    return $args;
}


// =============================================================================
// 9. REST API › FILTRO POR META "br_region" NO CPT "project"
// =============================================================================
// Filtra projetos pelo campo ACF "br_region" (região do Brasil).
// O valor deve ser exato (compare '='). Se o campo for múltiplo, use 'LIKE'.
//
//   GET /wp-json/wp/v2/project?br_region=Nordeste
//   GET /wp-json/wp/v2/project?br_region=Sudeste
// =============================================================================

add_filter( 'rest_project_query', 'susdigital_rest_filter_project_by_br_region_meta', 10, 2 );

function susdigital_rest_filter_project_by_br_region_meta( $args, $request ) {
    $param = $request->get_param( 'br_region' );

    if ( empty( $param ) ) {
        return $args;
    }

    $meta_query   = isset( $args['meta_query'] ) ? (array) $args['meta_query'] : [];
    $meta_query[] = [
        'key'     => 'br_region',
        'value'   => $param,
        'compare' => '=',   // troque para 'LIKE' se for campo de seleção múltipla
    ];

    $args['meta_query'] = $meta_query;

    return $args;
}


// =============================================================================
// 10. REST API › CAMPO EXTRA "decs_term_terms" NO CPT "project"
// =============================================================================
// Adiciona o campo "decs_term_terms" na resposta do endpoint de projetos,
// retornando os termos da taxonomia "decs_term" com id, name e slug.
// Preparado para futura integração com a API do DeCS (BVS/BIREME).
//
//   GET /wp-json/wp/v2/project/{id}
//   → resposta inclui: "decs_term_terms": [ { "id": 1, "name": "...", "slug": "..." } ]
// =============================================================================

add_action( 'rest_api_init', function () {
    register_rest_field( 'project', 'decs_term_terms', [
        'get_callback' => function ( $object ) {
            if ( empty( $object['decs_term'] ) ) {
                return [];
            }

            $terms = get_terms( [
                'taxonomy'   => 'decs_term',
                'include'    => $object['decs_term'],
                'hide_empty' => false,
            ] );

            if ( is_wp_error( $terms ) || empty( $terms ) ) {
                return [];
            }

            return array_map( function ( $term ) {
                return [
                    'id'   => $term->term_id,
                    'name' => $term->name,
                    'slug' => $term->slug,
                ];
            }, $terms );
        },
        'schema' => null,
    ] );
} );


// =============================================================================
// 11. HELPER › BUILD_MENU_TREE()
// =============================================================================
// Converte a lista plana de itens retornada pelo WP em uma árvore hierárquica
// com suporte a filhos aninhados (children). Formato otimizado para React.
// =============================================================================

function build_menu_tree( $menu_items ) {
    if ( empty( $menu_items ) ) {
        return [];
    }

    // Mantém a ordem definida no admin do WP
    usort( $menu_items, function ( $a, $b ) {
        return (int) $a->menu_order <=> (int) $b->menu_order;
    } );

    $tree   = [];
    $lookup = [];

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

    // Monta hierarquia parent → children
    foreach ( $lookup as $id => &$node ) {
        if ( $node['parent'] && isset( $lookup[ $node['parent'] ] ) ) {
            $lookup[ $node['parent'] ]['children'][] = &$node;
        } else {
            $tree[] = &$node;
        }
    }

    return $tree;
}