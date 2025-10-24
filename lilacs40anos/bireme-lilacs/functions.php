<?php
wp_enqueue_style(
    'bireme-style',
    get_stylesheet_uri(),
    array(),
    '1.47312312.9' 
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

  // Slick Carousel CSS
  wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/assets/css/slick.min.css' );
  wp_enqueue_style( 'slick-theme-css', get_template_directory_uri() . '/assets/css/slick-theme.min.css' ); // Opcional, se quiser o tema padrão do slick

  // Slick Carousel JS
  wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/assets/js/slick.min.js', array('jquery'), '1.8.1', true );

  // Seu script para inicializar o carrossel
  wp_enqueue_script( 'lilacs-carousel-init', get_template_directory_uri() . '/assets/js/carousel-init.js', array('jquery', 'slick-js'), '1.0', true );
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
        'count'  => 10000,
        'start'  => 0,
        'format' => 'json',
    ];

    $request_url = add_query_arg( $params, $url  );
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
/**
 * GET /wp-json/test/v1/bvs/journal/{id}
 * Retorna um periódico específico da BVS pelo journalId (ex.: 1890)
 */
function bvs_get_journal_by_id( WP_REST_Request $request ) {
    $journal_id = isset($request['id']) ? sanitize_text_field($request['id']) : '';

    // validação simples (número ou alfa-num com hífen/underscore, caso a API aceite)
    if (empty($journal_id) || !preg_match('/^[A-Za-z0-9\-_]+$/', $journal_id)) {
        return wp_send_json_error(['message' => 'Parâmetro {id} inválido.'], 400);
    }

    // parâmetros opcionais
    $format = sanitize_text_field($request->get_param('format') ?: 'json');

    $url  = sprintf('https://api.bvsalud.org/title/v1/%s/', rawurlencode($journal_id));
    $url  = add_query_arg(['format' => $format], $url);

    $args = [
        'headers' => [
            'apikey' => 'bec15fb66a094aef16439c0169d42710',
            'Accept' => 'application/json',
        ],
        'timeout' => 30,
    ];

    $response = wp_remote_get($url, $args);

    if (is_wp_error($response)) {
        return wp_send_json_error(['message' => $response->get_error_message()], 500);
    }

    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);

    if ($code !== 200) {
        // tenta repassar o corpo de erro da BVS para facilitar o debug
        return wp_send_json_error(['status' => $code, 'body' => $body], $code);
    }

    $data = json_decode($body, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        // fallback caso venha algo não-JSON por algum motivo
        return wp_send_json_success(['raw' => $body, '_note' => 'Resposta não era JSON parseável.']);
    }

    return wp_send_json_success($data);
}

// Registra a rota /wp-json/test/v1/bvs/journal/{id}
add_action('rest_api_init', function () {
    register_rest_route('test/v1', '/bvs/journal/(?P<id>[A-Za-z0-9\-_]+)', [
        'methods'             => 'GET',
        'callback'            => 'bvs_get_journal_by_id',
        'permission_callback' => '__return_true',
        'args'                => [
            'id' => [
                'description' => 'Identificador único do periódico (journalId). Ex.: 1890',
                'type'        => 'string',
                'required'    => true,
            ],
            'format' => [
                'description' => 'Formato do retorno (padrão: json)',
                'type'        => 'string',
                'required'    => false,
                'default'     => 'json',
                'enum'        => ['json'],
            ],
        ],
    ]);
});


/**
 * GET /wp-json/test/v1/bvs/journals/search
 * Busca periódicos por expressão (q) e/ou por thematic_area.
 */
function bvs_search_journals_by_thematic_area( WP_REST_Request $request ) {
    $base_url = 'https://api.bvsalud.org/title/v1/search/';

    // --- params de entrada ---
    $q      = trim( (string) $request->get_param('q') );
    if ($q === '') $q = '*';

    $format = sanitize_text_field( $request->get_param('format') ?: 'json' );
    $count  = (int) ($request->get_param('count') ?? 10);
    $start  = (int) ($request->get_param('start') ?? 0);
    $sort   = sanitize_text_field( $request->get_param('sort') ?? '' );

    // thematic_area pode vir como "area1,area2" ou array
    $ta_param = $request->get_param('thematic_area');
    $ta_list  = [];

    if (is_array($ta_param)) {
        $ta_list = array_filter(array_map('sanitize_text_field', $ta_param));
    } elseif (is_string($ta_param) && $ta_param !== '') {
        $ta_list = array_filter(array_map('sanitize_text_field', array_map('trim', explode(',', $ta_param))));
    }

    // monta fq (sempre força LILACS)
    $fq_parts = ['indexed_database:"LILACS"'];

    if (!empty($ta_list)) {
        // ex.: (thematic_area:"Saúde Pública" OR thematic_area:"Atenção Primária")
        $quoted = array_map(function($v){
            // escapa aspas internas
            $v = str_replace('"', '\"', $v);
            return sprintf('thematic_area:"%s"', $v);
        }, $ta_list);

        $fq_parts[] = '(' . implode(' OR ', $quoted) . ')';
    }

    // permite complementar com fq extra (opcional)
    $extra_fq = trim((string) $request->get_param('fq'));
    if ($extra_fq !== '') {
        $fq_parts[] = $extra_fq;
    }

    $params = [
        'q'      => $q,
        'fq'     => implode(' AND ', $fq_parts),
        'count'  => max(1, min(10000, $count)), // limite seguro
        'start'  => max(0, $start),
        'format' => $format,
    ];
    if ($sort !== '') $params['sort'] = $sort;

    $url = add_query_arg($params, $base_url);

    $args = [
        'headers' => [
            'apikey' => 'bec15fb66a094aef16439c0169d42710',
            'Accept' => 'application/json',
        ],
        'timeout' => 30,
    ];

    $response = wp_remote_get($url, $args);

    if (is_wp_error($response)) {
        return wp_send_json_error(['message' => $response->get_error_message()], 500);
    }

    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);

    if ($code !== 200) {
        return wp_send_json_error(['status' => $code, 'body' => $body], $code);
    }

    $data = json_decode($body, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return wp_send_json_success(['raw' => $body, '_note' => 'Resposta não era JSON parseável.']);
    }

    return wp_send_json_success($data);
}

add_action('rest_api_init', function () {
    register_rest_route('test/v1', '/bvs/journals/search', [
        'methods'             => 'GET',
        'callback'            => 'bvs_search_journals_by_thematic_area',
        'permission_callback' => '__return_true',
        'args' => [
            'q' => [
                'description' => 'Expressão de busca (boolean OK). Padrão: *',
                'type' => 'string',
                'required' => false,
            ],
            'thematic_area' => [
                'description' => 'Uma ou mais áreas temáticas (string única ou lista separada por vírgulas).',
                'type' => 'string',
                'required' => false,
            ],
            'fq' => [
                'description' => 'Filtro adicional em Solr syntax (opcional).',
                'type' => 'string',
                'required' => false,
            ],
            'count' => [
                'description' => 'Quantidade por página (1–10000).',
                'type' => 'integer',
                'required' => false,
                'default' => 10,
            ],
            'start' => [
                'description' => 'Offset inicial (>=0).',
                'type' => 'integer',
                'required' => false,
                'default' => 0,
            ],
            'sort' => [
                'description' => 'Ordenação (ex.: created_date DESC).',
                'type' => 'string',
                'required' => false,
            ],
            'format' => [
                'description' => 'Formato de saída (json).',
                'type' => 'string',
                'required' => false,
                'default' => 'json',
                'enum' => ['json'],
            ],
        ],
    ]);
});
