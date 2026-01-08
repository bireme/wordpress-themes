<?php
/**
 * functions.php - Memorial (Site Pai)
 */

// Title - tag <title>
add_theme_support('title-tag');

// Post Thumbnails
add_theme_support('post-thumbnails');

/**
 * Enqueue styles (top)
 */
add_action('wp_enqueue_scripts', 'style_top');
function style_top()
{
    wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('fontawesome', get_stylesheet_directory_uri() . '/css/bootstrap-icons-1.10.5/font/bootstrap-icons.css');
    wp_enqueue_style('slick', get_stylesheet_directory_uri() . '/css/slick.css');
    wp_enqueue_style('theme-slick', get_stylesheet_directory_uri() . '/css/slick-theme.css');
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/css/style.css');
}

/**
 * Enqueue scripts (footer)
 */
add_action('wp_footer', 'scripts_footer');
function scripts_footer()
{
    wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/js/jquery-3.7.1.min.js');
    wp_enqueue_script('popper', get_stylesheet_directory_uri() . '/js/popper.min.js');
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script('slick', get_stylesheet_directory_uri() . '/js/slick.min.js');
    wp_enqueue_script('main', get_stylesheet_directory_uri() . '/js/main.js');
}

/**
 * Add excerpt to Pages
 */
add_action('init', function () {
    add_post_type_support('page', 'excerpt');
});

/**
 * Menus
 */
add_action('init', 'action_init');
function action_init()
{
    register_nav_menu('main-nav', 'Main Menu (top)');
}

/**
 * Excerpt length
 */
add_filter('excerpt_length', 'custom_excerpt_length');
function custom_excerpt_length($length)
{
    return 20;
}

/**
 * RSS Produção
 */
function http_request_local($args, $url)
{
    if (preg_match('/xml|rss|feed/', $url)) {
        $args['reject_unsafe_urls'] = false;
    }
    return $args;
}
add_filter('http_request_args', 'http_request_local', 5, 2);

/**
 * Widgets
 */
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

/**
 * ============================================================
 * CPT "Coleções" + MetaBox + Integração Tainacan + Debug
 * ============================================================
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ============================================================
 * 1) CPT: COLEÇÕES
 * ============================================================
 */
add_action('init', 'memorial_register_cpt_colecoes');

function memorial_register_cpt_colecoes(): void
{
    $labels = [
        'name'                  => 'Coleções',
        'singular_name'         => 'Coleção',
        'menu_name'             => 'Coleções',
        'name_admin_bar'        => 'Coleção',
        'add_new'               => 'Adicionar nova',
        'add_new_item'          => 'Adicionar nova coleção',
        'new_item'              => 'Nova coleção',
        'edit_item'             => 'Editar coleção',
        'view_item'             => 'Ver coleção',
        'all_items'             => 'Todas as coleções',
        'search_items'          => 'Pesquisar coleções',
        'not_found'             => 'Nenhuma coleção encontrada.',
        'not_found_in_trash'    => 'Nenhuma coleção encontrada na lixeira.',
        'featured_image'        => 'Imagem destacada',
        'set_featured_image'    => 'Definir imagem destacada',
        'remove_featured_image' => 'Remover imagem destacada',
        'use_featured_image'    => 'Usar como imagem destacada',
        'archives'              => 'Arquivos de coleções',
        'items_list'            => 'Lista de coleções',
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],

        'rewrite'            => [
            'slug'       => 'colecoes',
            'with_front' => false,
        ],

        'has_archive'        => true,
        'hierarchical'       => false,
        'show_in_rest'       => true,

        'publicly_queryable' => true,
        'exclude_from_search'=> false,
        'query_var'          => true,

        'capability_type'    => 'post',
        'map_meta_cap'       => true,
    ];

    register_post_type('colecoes', $args);
}

/**
 * ============================================================
 * 2) META BOX: CONFIGURAÇÕES DO TAINACAN
 * ============================================================
 */
add_action('add_meta_boxes_colecoes', 'memorial_colecoes_add_metabox_tainacan');

function memorial_colecoes_add_metabox_tainacan(): void
{
    add_meta_box(
        'memorial_colecoes_tainacan',
        'Configurações da Coleção (Tainacan)',
        'memorial_colecoes_render_metabox_tainacan',
        'colecoes',
        'normal',
        'high'
    );
}

function memorial_colecoes_render_metabox_tainacan(WP_Post $post): void
{
    wp_nonce_field('memorial_colecoes_save_metabox_tainacan', 'memorial_colecoes_nonce');

    $url_colecao      = get_post_meta($post->ID, '_memorial_tainacan_collection_url', true);
    $slug_colecao     = get_post_meta($post->ID, '_memorial_tainacan_collection_slug', true);
    $destaque_home    = get_post_meta($post->ID, '_memorial_destaque_home', true);
    $ordem_destaque   = get_post_meta($post->ID, '_memorial_ordem_destaque', true);
    $itens_por_pagina = get_post_meta($post->ID, '_memorial_itens_por_pagina', true);

    if ($itens_por_pagina === '') {
        $itens_por_pagina = 6;
    }
?>
    <style>
        .memorial-metabox-grid {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 12px 16px;
            align-items: center;
            max-width: 920px;
        }
        .memorial-metabox-grid label { font-weight: 600; }
        .memorial-metabox-grid input[type="text"],
        .memorial-metabox-grid input[type="url"],
        .memorial-metabox-grid input[type="number"]{
            width: 100%;
            max-width: 720px;
        }
        .memorial-metabox-help {
            grid-column: 2 / -1;
            color: #555;
            font-size: 12px;
            margin-top: -6px;
        }
        .memorial-metabox-divider {
            grid-column: 1 / -1;
            border-top: 1px solid #e2e2e2;
            margin: 10px 0;
        }
    </style>

    <div class="memorial-metabox-grid">

        <label for="memorial_tainacan_collection_url">URL da coleção no Tainacan</label>
        <input
            type="url"
            id="memorial_tainacan_collection_url"
            name="memorial_tainacan_collection_url"
            value="<?php echo esc_attr($url_colecao); ?>"
            placeholder="https://memorialpandemia.teste.bvs.br/tainacan/fala-parente/"
        />
        <div class="memorial-metabox-help">
            Usado para o botão “Ver todos” (leva para a listagem completa no Tainacan).
        </div>

        <label for="memorial_tainacan_collection_slug">Slug da coleção no Tainacan</label>
        <input
            type="text"
            id="memorial_tainacan_collection_slug"
            name="memorial_tainacan_collection_slug"
            value="<?php echo esc_attr($slug_colecao); ?>"
            placeholder="fala-parente"
        />
        <div class="memorial-metabox-help">
            Usado para consultas na API do Tainacan (normalmente é o slug da URL).
        </div>

        <div class="memorial-metabox-divider"></div>

        <label for="memorial_destaque_home">Destaque na Home</label>
        <label style="display:flex; align-items:center; gap:8px;">
            <input
                type="checkbox"
                id="memorial_destaque_home"
                name="memorial_destaque_home"
                value="1"
                <?php checked($destaque_home, '1'); ?>
            />
            Mostrar no carrossel/blocos da Home
        </label>
        <div class="memorial-metabox-help">
            Marca as coleções que podem aparecer em destaques na Home.
        </div>

        <label for="memorial_ordem_destaque">Ordem do destaque</label>
        <input
            type="number"
            id="memorial_ordem_destaque"
            name="memorial_ordem_destaque"
            value="<?php echo esc_attr($ordem_destaque); ?>"
            min="0"
            step="1"
            placeholder="1"
        />
        <div class="memorial-metabox-help">
            Menor número aparece primeiro (1, 2, 3...).
        </div>

        <label for="memorial_itens_por_pagina">Itens no single (amostra)</label>
        <input
            type="number"
            id="memorial_itens_por_pagina"
            name="memorial_itens_por_pagina"
            value="<?php echo esc_attr($itens_por_pagina); ?>"
            min="1"
            max="24"
            step="1"
        />
        <div class="memorial-metabox-help">
            Quantidade de itens do Tainacan para mostrar na página da coleção.
        </div>

    </div>
<?php
}

add_action('save_post_colecoes', 'memorial_colecoes_save_metabox_tainacan');

function memorial_colecoes_save_metabox_tainacan(int $post_id): void
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!isset($_POST['memorial_colecoes_nonce']) || !wp_verify_nonce($_POST['memorial_colecoes_nonce'], 'memorial_colecoes_save_metabox_tainacan')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['memorial_tainacan_collection_url'])) {
        $url = esc_url_raw(trim((string) $_POST['memorial_tainacan_collection_url']));
        if ($url === '') {
            delete_post_meta($post_id, '_memorial_tainacan_collection_url');
        } else {
            update_post_meta($post_id, '_memorial_tainacan_collection_url', $url);
        }
    }

    if (isset($_POST['memorial_tainacan_collection_slug'])) {
        $slug = sanitize_title((string) $_POST['memorial_tainacan_collection_slug']);
        if ($slug === '') {
            delete_post_meta($post_id, '_memorial_tainacan_collection_slug');
        } else {
            update_post_meta($post_id, '_memorial_tainacan_collection_slug', $slug);
        }
    }

    $destaque = isset($_POST['memorial_destaque_home']) ? '1' : '0';
    update_post_meta($post_id, '_memorial_destaque_home', $destaque);

    $ordem = isset($_POST['memorial_ordem_destaque']) ? (int) $_POST['memorial_ordem_destaque'] : 0;
    update_post_meta($post_id, '_memorial_ordem_destaque', $ordem);

    $perpage = isset($_POST['memorial_itens_por_pagina']) ? (int) $_POST['memorial_itens_por_pagina'] : 6;
    $perpage = max(1, min(24, $perpage));
    update_post_meta($post_id, '_memorial_itens_por_pagina', $perpage);
}

/**
 * ============================================================
 * 3) INTEGRAÇÃO TAINACAN (API) - FILTRO CERTO POR COLEÇÃO
 * ============================================================
 */

define('MEMORIAL_TAINACAN_BASE_URL', 'https://memorialpandemia.teste.bvs.br/tainacan');

define('MEMORIAL_TAINACAN_HTTP_TIMEOUT', 15);
define('MEMORIAL_TAINACAN_CACHE_TTL_COLLECTION', 6 * HOUR_IN_SECONDS);
define('MEMORIAL_TAINACAN_CACHE_TTL_ITEMS', 10 * MINUTE_IN_SECONDS);

function memorial_tainacan_api_url(string $path, array $query = []): string
{
    $base = rtrim(MEMORIAL_TAINACAN_BASE_URL, '/');
    $url  = $base . '/wp-json/' . ltrim($path, '/');

    if (!empty($query)) {
        $url = add_query_arg($query, $url);
    }

    return $url;
}

/**
 * GET JSON com headers (User-Agent para evitar bloqueios)
 */
function memorial_tainacan_http_get_json_with_headers(string $url, array $args = [])
{
    $defaults = [
        'timeout' => MEMORIAL_TAINACAN_HTTP_TIMEOUT,
        'redirection' => 3,
        'sslverify' => true,
        'headers' => [
            'Accept' => 'application/json',
            'Accept-Language' => 'pt-BR,pt;q=0.9,en;q=0.8',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120 Safari/537.36',
            'Referer' => home_url('/'),
        ],
    ];

    $response = wp_remote_get($url, array_replace_recursive($defaults, $args));

    if (is_wp_error($response)) {
        return $response;
    }

    $code    = (int) wp_remote_retrieve_response_code($response);
    $body    = (string) wp_remote_retrieve_body($response);
    $headers = wp_remote_retrieve_headers($response);

    if ($code < 200 || $code >= 300) {
        return new WP_Error(
            'memorial_tainacan_http_error',
            'Erro ao consultar API do Tainacan.',
            [
                'url' => $url,
                'code' => $code,
                'body_excerpt' => mb_substr(wp_strip_all_tags($body), 0, 500),
            ]
        );
    }

    $json = json_decode($body, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return new WP_Error(
            'memorial_tainacan_json_error',
            'Resposta da API não é um JSON válido.',
            [
                'url' => $url,
                'error' => json_last_error_msg(),
                'body_excerpt' => mb_substr($body, 0, 500),
            ]
        );
    }

    return [
        'code' => $code,
        'json' => $json,
        'headers' => $headers,
        'url' => $url,
    ];
}

/**
 * Resolver o ID da coleção pelo slug
 * - Aqui está o ponto que garante o filtro correto.
 */
function memorial_tainacan_get_collection_id_by_slug(string $collection_slug): ?int
{
    $collection_slug = sanitize_title($collection_slug);
    if ($collection_slug === '') {
        return null;
    }

    $cache_key = 'memorial_tainacan_collection_id_' . md5($collection_slug);
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return is_numeric($cached) ? (int) $cached : null;
    }

    // Busca lista de coleções e encontra manualmente o slug
    $url = memorial_tainacan_api_url('tainacan/v2/collections', [
        'perpage' => 100,
    ]);

    $resp = memorial_tainacan_http_get_json_with_headers($url);
    if (is_wp_error($resp)) {
        set_transient($cache_key, 'null', 10 * MINUTE_IN_SECONDS);
        return null;
    }

    $json = $resp['json'];

    $collections = [];
    if (isset($json['items']) && is_array($json['items'])) {
        $collections = $json['items'];
    } elseif (is_array($json)) {
        $collections = $json;
    }

    foreach ($collections as $col) {
        if (!is_array($col)) continue;

        $col_slug = $col['slug'] ?? ($col['name'] ?? null);
        $col_slug = is_string($col_slug) ? sanitize_title($col_slug) : '';

        if ($col_slug === $collection_slug) {
            $id = $col['id'] ?? ($col['ID'] ?? null);

            if (!empty($id) && is_numeric($id)) {
                set_transient($cache_key, (int) $id, MEMORIAL_TAINACAN_CACHE_TTL_COLLECTION);
                return (int) $id;
            }
        }
    }

    set_transient($cache_key, 'null', 10 * MINUTE_IN_SECONDS);
    return null;
}

/**
 * Buscar itens da coleção (filtro 100% correto usando collection_id)
 */
function memorial_tainacan_get_collection_items(string $collection_slug, int $page = 1, int $perpage = 6, array $options = []): array
{
    $collection_slug = sanitize_title($collection_slug);

    $page = max(1, (int) $page);
    $perpage = max(1, min(24, (int) $perpage));

    $orderby = $options['orderby'] ?? 'date';
    $order   = $options['order'] ?? 'DESC';
    $fetch_only = $options['fetch_only'] ?? 'thumbnail,creation_date,title,description';

    $cache_key = 'memorial_tainacan_items_' . md5($collection_slug . '|' . $page . '|' . $perpage . '|' . $orderby . '|' . $order);
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    $collection_id = memorial_tainacan_get_collection_id_by_slug($collection_slug);

    if (empty($collection_id)) {
        $result = [
            'items' => [],
            'total' => null,
            'page' => $page,
            'perpage' => $perpage,
            'error' => 'Não foi possível resolver o ID da coleção pelo slug. Verifique se o slug está correto no metabox.',
        ];
        set_transient($cache_key, $result, 2 * MINUTE_IN_SECONDS);
        return $result;
    }

    $query = [
        'perpage' => $perpage,
        'paged'   => $page,
        'orderby' => $orderby,
        'order'   => $order,
        'fetch_only' => $fetch_only,
    ];

    // Aqui é o endpoint correto (filtra de verdade)
    $url = memorial_tainacan_api_url('tainacan/v2/collection/' . (int) $collection_id . '/items', $query);

    $resp = memorial_tainacan_http_get_json_with_headers($url);
    if (is_wp_error($resp)) {
        $result = [
            'items' => [],
            'total' => null,
            'page' => $page,
            'perpage' => $perpage,
            'error' => $resp->get_error_message(),
        ];
        set_transient($cache_key, $result, 2 * MINUTE_IN_SECONDS);
        return $result;
    }

    $json = $resp['json'];

    $items = [];
    $total = null;

    if (isset($json['items']) && is_array($json['items'])) {
        $items = $json['items'];
        if (isset($json['total']) && is_numeric($json['total'])) {
            $total = (int) $json['total'];
        }
    } elseif (is_array($json)) {
        $items = $json;
    }

    $result = [
        'items' => $items,
        'total' => $total,
        'page' => $page,
        'perpage' => $perpage,
        'error' => null,
    ];

    set_transient($cache_key, $result, MEMORIAL_TAINACAN_CACHE_TTL_ITEMS);
    return $result;
}

/**
 * Normalizar item para card
 */
function memorial_tainacan_normalize_item_to_card(array $item): array
{
    $title = $item['title'] ?? ($item['name'] ?? '');
    if (is_array($title) && isset($title['rendered'])) {
        $title = $title['rendered'];
    }
    $title = wp_strip_all_tags((string) $title);

    $description = $item['description'] ?? '';
    if (is_array($description) && isset($description['rendered'])) {
        $description = $description['rendered'];
    }
    $description = wp_strip_all_tags((string) $description);

    $url = $item['url'] ?? ($item['link'] ?? '');
    $url = esc_url_raw((string) $url);

    $thumb = '';
    if (!empty($item['thumbnail']) && is_string($item['thumbnail'])) {
        $thumb = $item['thumbnail'];
    } elseif (!empty($item['thumbnail']['medium'][0])) {
        $thumb = $item['thumbnail']['medium'][0];
    } elseif (!empty($item['thumbnail']['full'][0])) {
        $thumb = $item['thumbnail']['full'][0];
    }
    $thumb = esc_url_raw((string) $thumb);

    return [
        'title' => $title,
        'description' => $description,
        'thumb' => $thumb,
        'url' => $url,
        'raw' => $item,
    ];
}

/**
 * ============================================================
 * DEBUG: Shortcode
 * ============================================================
 */
add_shortcode('memorial_debug_tainacan', function ($atts) {
    $atts = shortcode_atts([
        'slug' => '',
    ], $atts);

    $slug = sanitize_title($atts['slug']);
    if ($slug === '') {
        return '<pre>Informe slug: [memorial_debug_tainacan slug="fala-parente"]</pre>';
    }

    $resp  = memorial_tainacan_get_collection_items($slug, 1, 6);

    $out = [];
    $out[] = 'Slug: ' . $slug;
    $out[] = 'Erro: ' . ($resp['error'] ?? 'nenhum');
    $out[] = 'Itens: ' . count($resp['items'] ?? []);

    if (!empty($resp['items']) && is_array($resp['items'])) {
        $out[] = '';
        $out[] = 'Primeiros títulos:';
        $i = 0;
        foreach ($resp['items'] as $item) {
            $card = memorial_tainacan_normalize_item_to_card($item);
            $out[] = '- ' . $card['title'];
            $i++;
            if ($i >= 3) break;
        }
    }

    return '<pre>' . esc_html(implode("\n", $out)) . '</pre>';
});
