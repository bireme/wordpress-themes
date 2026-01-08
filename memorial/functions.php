<?php
//Title - tag <title> 
add_theme_support( 'title-tag' );
// Posta Thumbnails
add_theme_support( 'post-thumbnails' );

add_action('wp_enqueue_scripts','style_top');
function style_top(){
//Add Styles Top
	wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
	 wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/bootstrap-icons-1.10.5/font/bootstrap-icons.css');
	 wp_enqueue_style('slick',get_stylesheet_directory_uri().'/css/slick.css');
    wp_enqueue_style('theme-slick',get_stylesheet_directory_uri().'/css/slick-theme.css');
	wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
	wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.7.1.min.js');
	wp_enqueue_script('popper',get_stylesheet_directory_uri().'/js/popper.min.js');
	wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
	wp_enqueue_script('slick',get_stylesheet_directory_uri().'/js/slick.min.js');
	wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
}
//Add Excerpt
add_action('init', function () {
    add_post_type_support('page', 'excerpt');
});
//Menus Topo
add_action('init', 'action_init');
function action_init()
{
	register_nav_menu('main-nav', 'Main Menu (top)');
}
//Excerpt
add_filter('excerpt_length', 'custom_excerpt_length');
function custom_excerpt_length($length) {
    return 20;
}
//RSS Produção
function http_request_local( $args, $url ) {
   if ( preg_match('/xml|rss|feed/', $url) ){
      $args['reject_unsafe_urls'] = false;
   }
   return $args;
}
add_filter( 'http_request_args', 'http_request_local', 5, 2 );
// Widget
register_sidebar([
	'name'			=> 'Footer 1',
	'id'			=> 'footer1',
	'description'	=> 'Footer 1',
	'before_title'	=> '<h5>',
	'after_title'	=> '</h5>'
]);
register_sidebar([
	'name'			=> 'Footer 2',
	'id'			=> 'footer2',
	'description'	=> 'Footer 2',
	'before_title'	=> '<h5>',
	'after_title'	=> '</h5>'
]);
register_sidebar([
	'name'			=> 'Footer 3',
	'id'			=> 'footer3',
	'description'	=> 'Footer 3',
	'before_title'	=> '<h5>',
	'after_title'	=> '</h5>'
]);





//Custom pos Type - Coleções
if (!defined('ABSPATH')) {
    exit;
}
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
        'parent_item_colon'     => 'Coleção mãe:',
        'not_found'             => 'Nenhuma coleção encontrada.',
        'not_found_in_trash'    => 'Nenhuma coleção encontrada na lixeira.',
        'featured_image'        => 'Imagem destacada',
        'set_featured_image'    => 'Definir imagem destacada',
        'remove_featured_image' => 'Remover imagem destacada',
        'use_featured_image'    => 'Usar como imagem destacada',
        'archives'              => 'Arquivos de coleções',
        'insert_into_item'      => 'Inserir na coleção',
        'uploaded_to_this_item' => 'Enviado para esta coleção',
        'filter_items_list'     => 'Filtrar lista de coleções',
        'items_list_navigation' => 'Navegação da lista de coleções',
        'items_list'            => 'Lista de coleções',
    ];
    $args = [
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_admin_bar'  => true,
        'show_in_nav_menus'  => true,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
        // URL: /colecoes/slug
        'rewrite'            => [
            'slug'       => 'colecoes',
            'with_front' => false,
        ],
        'has_archive'        => true, // /colecoes
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

// Meta Box par ao custom post type coleções
add_action('add_meta_boxes', 'memorial_colecoes_add_metabox_tainacan');
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
    // Segurança
    wp_nonce_field('memorial_colecoes_save_metabox_tainacan', 'memorial_colecoes_nonce');

    // Valores atuais
    $url_colecao      = get_post_meta($post->ID, '_memorial_tainacan_collection_url', true);
    $slug_colecao     = get_post_meta($post->ID, '_memorial_tainacan_collection_slug', true);
    $destaque_home    = get_post_meta($post->ID, '_memorial_destaque_home', true);
    $ordem_destaque   = get_post_meta($post->ID, '_memorial_ordem_destaque', true);
    $itens_por_pagina = get_post_meta($post->ID, '_memorial_itens_por_pagina', true);

    // Defaults
    if ($itens_por_pagina === '') {
        $itens_por_pagina = 6;
    }

    ?>
    <style>
        .memorial-metabox-grid {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 12px 16px;
            align-items: center;
            max-width: 900px;
        }
        .memorial-metabox-grid label {
            font-weight: 600;
        }
        .memorial-metabox-grid input[type="text"],
        .memorial-metabox-grid input[type="url"],
        .memorial-metabox-grid input[type="number"]{
            width: 100%;
            max-width: 700px;
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
            margin: 8px 0;
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
            Usado para o botão “Ver todos” (leva o usuário para a listagem completa no Tainacan).
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
            Usado para montar as requisições na API do Tainacan. Normalmente é o mesmo slug da URL.
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
            Mostrar esta coleção no carrossel / destaques da Home
        </label>
        <div class="memorial-metabox-help">
            Permite selecionar quais coleções aparecem em blocos da Home.
        </div>

        <label for="memorial_ordem_destaque">Ordem do destaque</label>
        <input
            type="number"
            id="memorial_ordem_destaque"
            name="memorial_ordem_destaque"
            value="<?php echo esc_attr($ordem_destaque); ?>"
            min="0"
            step="1"
            placeholder="10"
        />
        <div class="memorial-metabox-help">
            Quanto menor o número, mais cedo aparece na Home (ex.: 1, 2, 3...).
        </div>

        <label for="memorial_itens_por_pagina">Itens para exibir no single</label>
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
            Quantidade de itens do Tainacan a serem mostrados na página da coleção (ex.: 6 ou 8).
        </div>
    </div>
    <?php
}

add_action('save_post_colecoes', 'memorial_colecoes_save_metabox_tainacan');
function memorial_colecoes_save_metabox_tainacan(int $post_id): void
{
    // Evita autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Nonce
    if (!isset($_POST['memorial_colecoes_nonce']) || !wp_verify_nonce($_POST['memorial_colecoes_nonce'], 'memorial_colecoes_save_metabox_tainacan')) {
        return;
    }

    // Permissão
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // URL da coleção
    if (isset($_POST['memorial_tainacan_collection_url'])) {
        $url = esc_url_raw(trim((string) $_POST['memorial_tainacan_collection_url']));
        if ($url === '') {
            delete_post_meta($post_id, '_memorial_tainacan_collection_url');
        } else {
            update_post_meta($post_id, '_memorial_tainacan_collection_url', $url);
        }
    }

    // Slug da coleção (sanitizado como slug)
    if (isset($_POST['memorial_tainacan_collection_slug'])) {
        $slug = sanitize_title((string) $_POST['memorial_tainacan_collection_slug']);
        if ($slug === '') {
            delete_post_meta($post_id, '_memorial_tainacan_collection_slug');
        } else {
            update_post_meta($post_id, '_memorial_tainacan_collection_slug', $slug);
        }
    }

    // Destaque na home
    $destaque = isset($_POST['memorial_destaque_home']) ? '1' : '0';
    update_post_meta($post_id, '_memorial_destaque_home', $destaque);

    // Ordem de destaque
    if (isset($_POST['memorial_ordem_destaque'])) {
        $ordem = (int) $_POST['memorial_ordem_destaque'];
        update_post_meta($post_id, '_memorial_ordem_destaque', $ordem);
    }

    // Itens por página no single
    if (isset($_POST['memorial_itens_por_pagina'])) {
        $perpage = (int) $_POST['memorial_itens_por_pagina'];
        if ($perpage < 1) $perpage = 1;
        if ($perpage > 24) $perpage = 24;
        update_post_meta($post_id, '_memorial_itens_por_pagina', $perpage);
    }
}





/**
 * Integração Memorial (Pai) -> Tainacan (Filho)
 * Funções para buscar coleção, itens e total via API, com cache.
 */

/**
 * 1) CONFIGURAÇÕES
 * Ajuste essa constante se mudar a pasta do Tainacan.
 */
define('MEMORIAL_TAINACAN_BASE_URL', 'https://memorialpandemia.teste.bvs.br/tainacan');

/**
 * Timeout e cache defaults (em segundos)
 */
define('MEMORIAL_TAINACAN_HTTP_TIMEOUT', 15);
define('MEMORIAL_TAINACAN_CACHE_TTL_ITEMS', 10 * MINUTE_IN_SECONDS);
define('MEMORIAL_TAINACAN_CACHE_TTL_COLLECTION', 6 * HOUR_IN_SECONDS);

/**
 * Helper: faz GET em uma URL e retorna array (JSON) ou WP_Error.
 */
function memorial_tainacan_http_get_json(string $url, array $args = [])
{
    $defaults = [
        'timeout' => MEMORIAL_TAINACAN_HTTP_TIMEOUT,
        'headers' => [
            'Accept' => 'application/json',
        ],
    ];

    $response = wp_remote_get($url, array_merge($defaults, $args));

    if (is_wp_error($response)) {
        return $response;
    }

    $code = (int) wp_remote_retrieve_response_code($response);
    $body = (string) wp_remote_retrieve_body($response);

    if ($code < 200 || $code >= 300) {
        return new WP_Error(
            'memorial_tainacan_http_error',
            'Erro ao consultar API do Tainacan.',
            [
                'url' => $url,
                'code' => $code,
                'body' => $body,
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
                'body' => $body,
            ]
        );
    }

    return $json;
}

/**
 * Helper: monta URL da API do Tainacan (filho) a partir de um path (sem barra inicial).
 */
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
 * 2) RESOLVER COLEÇÃO PELO SLUG
 *
 * Retorna informações da coleção (id, name, url, slug) com cache.
 *
 * Observação:
 * - Tainacan costuma expor coleções em /tainacan/v2/collections
 * - Pode variar conforme versão, então criamos um "fallback".
 */
function memorial_tainacan_get_collection_by_slug(string $collection_slug)
{
    $collection_slug = sanitize_title($collection_slug);
    if ($collection_slug === '') {
        return new WP_Error('memorial_tainacan_invalid_slug', 'Slug da coleção inválido.');
    }

    $cache_key = 'memorial_tainacan_collection_' . md5($collection_slug);
    $cached = get_transient($cache_key);

    if ($cached !== false) {
        return $cached;
    }

    // Tentativa 1 (padrão comum do Tainacan v2)
    // GET /wp-json/tainacan/v2/collections?slug={slug}
    $url = memorial_tainacan_api_url('tainacan/v2/collections', [
        'slug' => $collection_slug,
        'perpage' => 1,
    ]);

    $json = memorial_tainacan_http_get_json($url);

    if (!is_wp_error($json) && is_array($json)) {
        // Em algumas versões retorna uma lista
        $first = null;
        if (isset($json[0]) && is_array($json[0])) {
            $first = $json[0];
        } elseif (isset($json['items'][0])) {
            $first = $json['items'][0];
        }

        if (is_array($first)) {
            $collection = [
                'id'   => $first['id'] ?? ($first['ID'] ?? null),
                'name' => $first['name'] ?? ($first['title'] ?? ''),
                'slug' => $collection_slug,
                'url'  => $first['url'] ?? $first['link'] ?? (MEMORIAL_TAINACAN_BASE_URL . '/' . $collection_slug . '/'),
                'raw'  => $first,
            ];

            set_transient($cache_key, $collection, MEMORIAL_TAINACAN_CACHE_TTL_COLLECTION);
            return $collection;
        }
    }

    // Fallback: se a rota acima falhar, não vamos travar o site.
    // Retornamos uma estrutura mínima, que ainda permite “Ver todos”.
    $fallback = [
        'id'   => null,
        'name' => '',
        'slug' => $collection_slug,
        'url'  => MEMORIAL_TAINACAN_BASE_URL . '/' . $collection_slug . '/',
        'raw'  => null,
        'warning' => is_wp_error($json) ? $json->get_error_message() : 'Não foi possível resolver o ID da coleção via API.',
    ];

    set_transient($cache_key, $fallback, 30 * MINUTE_IN_SECONDS);
    return $fallback;
}

/**
 * 3) BUSCAR ITENS DA COLEÇÃO (CARDS)
 *
 * Retorna:
 * [
 *   'items' => [ ... ],
 *   'total' => (int|null),
 *   'page'  => (int),
 *   'perpage' => (int),
 *   'error' => (string|null),
 * ]
 *
 * Estratégia:
 * - Se conseguir o collection_id, tenta /collection/{id}/items (padrão comum).
 * - Se não conseguir, tenta query genérica com collection=... (fallback, pode variar).
 */
function memorial_tainacan_get_collection_items(string $collection_slug, int $page = 1, int $perpage = 6, array $options = []): array
{
    $collection_slug = sanitize_title($collection_slug);

    $page = max(1, (int) $page);
    $perpage = max(1, min(24, (int) $perpage));

    $orderby = $options['orderby'] ?? 'date';
    $order   = $options['order'] ?? 'DESC';

    $cache_key = 'memorial_tainacan_items_' . md5($collection_slug . '|' . $page . '|' . $perpage . '|' . $orderby . '|' . $order);
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    $collection = memorial_tainacan_get_collection_by_slug($collection_slug);
    $collection_id = is_array($collection) ? ($collection['id'] ?? null) : null;

    // Campos mínimos para cards (ajuste depois)
    $fetch_only = $options['fetch_only'] ?? 'thumbnail,creation_date,title,description';

    $query = [
        'perpage' => $perpage,
        'paged'   => $page,
        'orderby' => $orderby,
        'order'   => $order,
        'fetch_only' => $fetch_only,
    ];

    $json = null;
    $error = null;

    // Tentativa 1: rota padrão por collection_id
    if (!empty($collection_id)) {
        // GET /wp-json/tainacan/v2/collection/{id}/items
        $url = memorial_tainacan_api_url('tainacan/v2/collection/' . (int) $collection_id . '/items', $query);
        $json = memorial_tainacan_http_get_json($url);
    }

    // Tentativa 2: fallback genérico
    if (empty($collection_id) || is_wp_error($json)) {
        // GET /wp-json/tainacan/v2/items?collection={slug}
        $url = memorial_tainacan_api_url('tainacan/v2/items', array_merge($query, [
            'collection' => $collection_slug,
        ]));
        $json = memorial_tainacan_http_get_json($url);
    }

    if (is_wp_error($json)) {
        $error = $json->get_error_message();
        $result = [
            'items' => [],
            'total' => null,
            'page' => $page,
            'perpage' => $perpage,
            'error' => $error,
        ];
        set_transient($cache_key, $result, 2 * MINUTE_IN_SECONDS);
        return $result;
    }

    // Normalização: diferentes versões podem retornar estruturas diferentes
    $items = [];
    $total = null;

    if (isset($json['items']) && is_array($json['items'])) {
        $items = $json['items'];
        $total = isset($json['total']) ? (int) $json['total'] : null;
    } elseif (is_array($json)) {
        // Pode ser uma lista simples de itens
        $items = $json;
        // Total pode não vir; usaremos count como fallback
        $total = isset($options['total_fallback']) && $options['total_fallback'] === true ? count($items) : null;
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
 * 4) BUSCAR TOTAL DE ITENS DA COLEÇÃO
 *
 * Se o endpoint retornar total (via payload), usamos.
 * Caso não retorne, fazemos um request leve com perpage=1 e extraímos o total.
 */
function memorial_tainacan_get_collection_total_items(string $collection_slug): ?int
{
    $collection_slug = sanitize_title($collection_slug);
    if ($collection_slug === '') {
        return null;
    }

    $cache_key = 'memorial_tainacan_total_' . md5($collection_slug);
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return is_numeric($cached) ? (int) $cached : null;
    }

    // Request leve
    $resp = memorial_tainacan_get_collection_items($collection_slug, 1, 1, [
        'fetch_only' => 'title',
    ]);

    if (!empty($resp['error'])) {
        set_transient($cache_key, 'null', 5 * MINUTE_IN_SECONDS);
        return null;
    }

    if (isset($resp['total']) && is_numeric($resp['total'])) {
        $total = (int) $resp['total'];
        set_transient($cache_key, $total, 30 * MINUTE_IN_SECONDS);
        return $total;
    }

    // Se não veio total, fallback:
    // retornamos null (para não mentir) — depois ajustamos conforme o endpoint certo do seu Tainacan.
    set_transient($cache_key, 'null', 10 * MINUTE_IN_SECONDS);
    return null;
}

/**
 * 5) NORMALIZAR ITEM DO TAINACAN PARA CARD
 *
 * Retorna estrutura padronizada:
 * [
 *   'title' => '...',
 *   'description' => '...',
 *   'thumb' => 'https://...',
 *   'url' => 'https://... (item no Tainacan)',
 *   'date' => '...',
 * ]
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

    // Link do item (pode variar)
    $url = $item['url'] ?? ($item['link'] ?? '');
    $url = esc_url_raw((string) $url);

    // Thumbnail (pode variar conforme retorno)
    $thumb = '';
    if (!empty($item['thumbnail']) && is_string($item['thumbnail'])) {
        $thumb = $item['thumbnail'];
    } elseif (!empty($item['thumbnail']['medium'][0])) {
        $thumb = $item['thumbnail']['medium'][0];
    } elseif (!empty($item['thumbnail']['full'][0])) {
        $thumb = $item['thumbnail']['full'][0];
    } elseif (!empty($item['_embedded']['wp:featuredmedia'][0]['source_url'])) {
        $thumb = $item['_embedded']['wp:featuredmedia'][0]['source_url'];
    }
    $thumb = esc_url_raw((string) $thumb);

    $date = $item['creation_date'] ?? ($item['date'] ?? null);

    return [
        'title' => $title,
        'description' => $description,
        'thumb' => $thumb,
        'url' => $url,
        'date' => $date,
        'raw' => $item,
    ];
}



//shortcode memorial
add_shortcode('memorial_debug_tainacan', function($atts) {
    $atts = shortcode_atts([
        'slug' => '',
    ], $atts);

    $slug = sanitize_title($atts['slug']);
    if ($slug === '') {
        return '<pre>Informe slug: [memorial_debug_tainacan slug="fala-parente"]</pre>';
    }

    $total = memorial_tainacan_get_collection_total_items($slug);
    $resp  = memorial_tainacan_get_collection_items($slug, 1, 6);

    $out = [];
    $out[] = 'Slug: ' . $slug;
    $out[] = 'Total: ' . (is_null($total) ? 'null' : $total);
    $out[] = 'Erro: ' . ($resp['error'] ?? 'nenhum');
    $out[] = 'Itens: ' . count($resp['items'] ?? []);

    // Mostrar títulos (primeiros 3)
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
