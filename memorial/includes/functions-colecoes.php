<?php
/**
 * Memorial - CPT Coleções + MetaBox + Integração Tainacan + Debug
 */

if (!defined('ABSPATH')) {
    exit;
}


/**
 * ============================================================
 * 0) CONFIG / CONSTANTES (protege contra inclusão dupla)
 * ============================================================
 */

if (!defined('MEMORIAL_TAINACAN_BASE_URL')) {
    // SEM barra no final
    define('MEMORIAL_TAINACAN_BASE_URL', 'https://teste.memorialdigitalcovid19.org.br/tainacan');
}

if (!defined('MEMORIAL_TAINACAN_HTTP_TIMEOUT')) {
    define('MEMORIAL_TAINACAN_HTTP_TIMEOUT', 15);
}

if (!defined('MEMORIAL_TAINACAN_CACHE_TTL_COLLECTION')) {
    define('MEMORIAL_TAINACAN_CACHE_TTL_COLLECTION', 6 * HOUR_IN_SECONDS);
}

if (!defined('MEMORIAL_TAINACAN_CACHE_TTL_ITEMS')) {
    define('MEMORIAL_TAINACAN_CACHE_TTL_ITEMS', 10 * MINUTE_IN_SECONDS);
}

if (!defined('MEMORIAL_TAINACAN_CACHE_TTL_NULL')) {
    define('MEMORIAL_TAINACAN_CACHE_TTL_NULL', 10 * MINUTE_IN_SECONDS);
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
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'],
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
            placeholder="<?php echo esc_attr(rtrim(MEMORIAL_TAINACAN_BASE_URL, '/') . '/fala-parente/'); ?>"
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
 * 3) HELPERS API
 * ============================================================
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

function memorial_tainacan_http_get_json_with_headers(string $url, array $args = [])
{
    $defaults = [
        'timeout' => MEMORIAL_TAINACAN_HTTP_TIMEOUT,
        'redirection' => 5,
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
                'body_excerpt' => mb_substr(wp_strip_all_tags($body), 0, 800),
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
                'body_excerpt' => mb_substr((string) $body, 0, 800),
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
 * ============================================================
 * 4) RESOLVER COLLECTION_ID PELO SLUG (robusto)
 * ============================================================
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
        return ($cached === 'null') ? null : (int) $cached;
    }

    // 1) Busca a lista de coleções (não confia em ?slug= porque pode ser ignorado pelo endpoint)
    $url = memorial_tainacan_api_url('tainacan/v2/collections', [
        'perpage' => 100,
        'paged'   => 1,
        // opcional: alguns ambientes aceitam "search"
        // 'search'  => $collection_slug,
    ]);

    $resp = memorial_tainacan_http_get_json_with_headers($url);

    if (is_wp_error($resp)) {
        // cache curto pra evitar martelar a API quando está fora
        set_transient($cache_key, 'null', 2 * MINUTE_IN_SECONDS);
        return null;
    }

    $json = $resp['json'];

    // 2) Normaliza "lista de coleções" a partir de formatos comuns
    $collections = [];

    if (is_array($json)) {
        if (isset($json['items']) && is_array($json['items'])) {
            $collections = $json['items'];
        } elseif (isset($json['collections']) && is_array($json['collections'])) {
            $collections = $json['collections'];
        } elseif (array_is_list($json)) {
            // lista pura
            $collections = $json;
        }
    }

    if (empty($collections) || !is_array($collections)) {
        // Não veio no formato esperado -> não "chuta"
        set_transient($cache_key, 'null', 2 * MINUTE_IN_SECONDS);
        return null;
    }

    // 3) Procura o slug EXATO; não usa name como fallback
    foreach ($collections as $col) {
        if (!is_array($col)) continue;

        // slug pode vir em lugares diferentes dependendo da versão/serialização
        $col_slug_raw = $col['slug'] ?? $col['collection_slug'] ?? null;
        $col_slug = sanitize_title((string) $col_slug_raw);

        if ($col_slug !== '' && $col_slug === $collection_slug) {
            $id = $col['id'] ?? $col['ID'] ?? null;
            if (is_numeric($id)) {
                set_transient($cache_key, (string) ((int) $id), MEMORIAL_TAINACAN_CACHE_TTL_COLLECTION);
                return (int) $id;
            }
        }
    }

    // 4) Não achou: cacheia null
    set_transient($cache_key, 'null', MEMORIAL_TAINACAN_CACHE_TTL_NULL);
    return null;
}


/**
 * ============================================================
 * 5) ITENS DA COLEÇÃO (endpoint correto)
 * ============================================================
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
            'error' => 'Não foi possível resolver o ID da coleção pelo slug. Verifique se o slug está correto no metabox ou se a API /collections está acessível.',
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

    $url = memorial_tainacan_api_url('tainacan/v2/collection/' . (int) $collection_id . '/items', $query);

    $resp = memorial_tainacan_http_get_json_with_headers($url);
    if (is_wp_error($resp)) {
        $result = [
            'items' => [],
            'total' => null,
            'page' => $page,
            'perpage' => $perpage,
            'error' => $resp->get_error_message(),
            'debug' => $resp->get_error_data(),
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
 * ============================================================
 * 6) NORMALIZAR ITEM PARA CARD
 * ============================================================
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
 * 7) DEBUG (shortcode)
 * ============================================================
 *
 * Uso: [memorial_debug_tainacan slug="fala-parente"]
 */
add_shortcode('memorial_debug_tainacan', function ($atts) {
    $atts = shortcode_atts(['slug' => ''], $atts);

    $slug = sanitize_title($atts['slug']);
    if ($slug === '') {
        return '<pre>Informe slug: [memorial_debug_tainacan slug="fala-parente"]</pre>';
    }

    $out = [];
    $out[] = 'Base: ' . rtrim(MEMORIAL_TAINACAN_BASE_URL, '/');
    $out[] = 'Slug: ' . $slug;

    // Teste collections por slug
    $test_url = memorial_tainacan_api_url('tainacan/v2/collections', [
        'slug' => $slug,
        'perpage' => 1,
    ]);
    $out[] = 'Collections URL: ' . $test_url;

    $test = memorial_tainacan_http_get_json_with_headers($test_url);
    if (is_wp_error($test)) {
        $out[] = 'Collections ERROR: ' . $test->get_error_message();
        $data = $test->get_error_data();
        if (is_array($data)) {
            $out[] = 'HTTP code: ' . ($data['code'] ?? '');
            $out[] = 'Body excerpt: ' . ($data['body_excerpt'] ?? '');
        }
        return '<pre>' . esc_html(implode("\n", $out)) . '</pre>';
    }

    $json_preview = wp_json_encode($test['json']);
    $out[] = 'Collections OK (HTTP ' . ($test['code'] ?? '') . ')';
    $out[] = 'Collections JSON preview: ' . mb_substr($json_preview, 0, 500) . '...';

    // Agora tenta resolver ID e itens
    $collection_id = memorial_tainacan_get_collection_id_by_slug($slug);
    $out[] = 'Resolved collection_id: ' . (is_null($collection_id) ? 'null' : (string) $collection_id);

    $resp = memorial_tainacan_get_collection_items($slug, 1, 6);
    $out[] = 'Items error: ' . ($resp['error'] ?? 'nenhum');
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

/**
 * ============================================================
 * 8) (OPCIONAL) Limpar cache via URL (somente admin)
 * ============================================================
 * Acesse: /?memorial_flush_tainacan_cache=1
 * Remova este bloco se não quiser essa सुविधा.
 */
add_action('init', function () {
    if (!is_user_logged_in() || !current_user_can('manage_options')) {
        return;
    }
    if (!isset($_GET['memorial_flush_tainacan_cache'])) {
        return;
    }

    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_memorial_tainacan_%' OR option_name LIKE '_transient_timeout_memorial_tainacan_%'");

    // Redireciona para limpar a querystring
    wp_safe_redirect(remove_query_arg('memorial_flush_tainacan_cache'));
    exit;
});


add_shortcode('memorial_debug_item_keys', function ($atts) {
    $atts = shortcode_atts([
        'slug' => '',
    ], $atts);

    $slug = sanitize_title($atts['slug']);
    if ($slug === '') {
        return '<pre>Use: [memorial_debug_item_keys slug="fala-parente"]</pre>';
    }

    // tenta buscar itens do jeito que seu sistema já faz
    if (!function_exists('memorial_tainacan_get_collection_items')) {
        return '<pre>Função memorial_tainacan_get_collection_items não existe.</pre>';
    }

    $resp = memorial_tainacan_get_collection_items($slug, 1, 6);

    $out = [];
    $out[] = 'Slug: ' . $slug;
    $out[] = 'Erro: ' . ($resp['error'] ?? 'nenhum');
    $out[] = 'Qtd itens: ' . count($resp['items'] ?? []);

    if (!empty($resp['items'][0]) && is_array($resp['items'][0])) {
        $first = $resp['items'][0];
        $out[] = '';
        $out[] = 'Chaves do 1º item:';
        $out[] = implode(', ', array_keys($first));

        $out[] = '';
        $out[] = 'Preview 1º item (cortado):';
        $json = wp_json_encode($first, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $out[] = mb_substr($json, 0, 1500) . '...';
    }

    return '<pre>' . esc_html(implode("\n", $out)) . '</pre>';
});
