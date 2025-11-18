<?php
if (!defined('ABSPATH')) exit;

// Registra suporte a menus
function bireme_lilacs_setup() {
    // Suporte a logo personalizado
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Suporte a título dinâmico
    add_theme_support('title-tag');

    // Suporte a imagens destacadas
    add_theme_support('post-thumbnails');

    // Registra menus de navegação
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'bireme-lilacs'),
    ));
}
add_action('after_setup_theme', 'bireme_lilacs_setup');

// Enfileira scripts e estilos
function bireme_lilacs_scripts() {
       wp_enqueue_style(
        'bireme-lilacs-style',
        get_stylesheet_uri(),
        array(),
        '1.44.3' // altera a cada modificação
    );

    
    // Scripts do tema
    if (file_exists(get_template_directory() . '/assets/js/header.js')) {
        wp_enqueue_script('bireme-lilacs-header', get_template_directory_uri() . '/assets/js/header.js', array(), '1.1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'bireme_lilacs_scripts');

// Suporte ao Polylang - registra menus por idioma
function bireme_lilacs_polylang_menus() {
    if (function_exists('pll_the_languages')) {
        $languages = pll_the_languages(array('raw' => 1));
        
        if ($languages) {
            $menu_locations = array();
            foreach ($languages as $lang) {
                $menu_locations['primary_' . $lang['slug']] = sprintf(__('Menu Principal - %s', 'bireme-lilacs'), $lang['name']);
            }
            
            // Registra os menus específicos por idioma
            register_nav_menus($menu_locations);
        }
    }
}
add_action('after_setup_theme', 'bireme_lilacs_polylang_menus', 20);

// Função para obter o menu correto baseado no idioma atual
function bireme_lilacs_get_menu_location() {
    if (function_exists('pll_current_language')) {
        $current_lang = pll_current_language();
        $menu_location = 'primary_' . $current_lang;
        
        // Verifica se existe um menu para o idioma atual
        $locations = get_nav_menu_locations();
        if (isset($locations[$menu_location]) && $locations[$menu_location]) {
            return $menu_location;
        }
    }
    
    // Fallback para o menu principal padrão
    return 'primary';
}

// Adiciona classes CSS específicas por idioma no body
function bireme_lilacs_body_classes($classes) {
    if (function_exists('pll_current_language')) {
        $current_lang = pll_current_language();
        $classes[] = 'lang-' . $current_lang;
    }
    return $classes;
}
add_filter('body_class', 'bireme_lilacs_body_classes');

// Filtro para modificar URLs no switcher de idiomas
function bireme_lilacs_language_switcher_urls($url, $lang) {
    // Permite personalização das URLs se necessário
    return $url;
}

// Hook específico para quando o Polylang estiver ativo
function bireme_lilacs_polylang_init() {
    if (function_exists('pll_register_string')) {
        // Registra strings para tradução
        pll_register_string('bireme-lilacs', 'Conteúdo Principal', 'Navigation');
        pll_register_string('bireme-lilacs', 'Menu', 'Navigation');
        pll_register_string('bireme-lilacs', 'Pesquisa', 'Navigation');
        pll_register_string('bireme-lilacs', 'Rodapé', 'Navigation');
        pll_register_string('bireme-lilacs', 'Alto Contraste', 'Accessibility');
        pll_register_string('bireme-lilacs', 'Abrir menu', 'Navigation');
        pll_register_string('bireme-lilacs', 'Fechar menu', 'Navigation');
        pll_register_string('bireme-lilacs', 'Abrir submenu', 'Navigation');
        pll_register_string('bireme-lilacs', 'LILACS', 'Site Name');
    }
}
add_action('init', 'bireme_lilacs_polylang_init');

// Função para debug dos logos (apenas para admins)
function bireme_lilacs_debug_logo_info() {
    if (!current_user_can('manage_options')) return;
    
    $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pt';
    $logo_url = bireme_lilacs_get_logo();
    $logo_path = str_replace(get_template_directory_uri(), get_template_directory(), $logo_url);
    
    echo '<!-- Logo Debug Info:';
    echo ' Current Lang: ' . $current_lang;
    echo ' | Logo URL: ' . $logo_url;
    echo ' | File Exists: ' . (file_exists($logo_path) ? 'Yes' : 'No');
    echo ' -->';
}
add_action('wp_head', 'bireme_lilacs_debug_logo_info');

// Função helper para traduzir strings
function bireme_lilacs_translate($string, $context = 'General') {
    if (function_exists('pll__')) {
        return pll__($string);
    }
    return __($string, 'bireme-lilacs');
}

// Função para obter o logo baseado no idioma atual
function bireme_lilacs_get_logo() {
    $current_lang = 'pt'; // fallback para português
    
    if (function_exists('pll_current_language')) {
        $current_lang = pll_current_language();
    }
    
    // Mapear idiomas para os códigos corretos
    $lang_map = array(
        'pt' => 'pt',
        'pt-br' => 'pt',
        'en' => 'en',
        'en-us' => 'en',
        'es' => 'es',
        'es-es' => 'es'
    );
    
    $logo_lang = isset($lang_map[$current_lang]) ? $lang_map[$current_lang] : 'pt';
    
    // Caminho do logo específico do idioma
    $logo_path = '/assets/images/logos/' . $logo_lang . '/logo-color.jpg';
    $logo_file = get_template_directory() . $logo_path;
    
    // Verifica se o arquivo existe
    if (file_exists($logo_file)) {
        return get_template_directory_uri() . $logo_path;
    }
    
    // Fallback: tenta o logo em português
    $fallback_path = '/assets/images/logos/pt/logo-color.jpg';
    $fallback_file = get_template_directory() . $fallback_path;
    
    if (file_exists($fallback_file)) {
        return get_template_directory_uri() . $fallback_path;
    }
    
    // Fallback final: logo padrão antigo
    $default_logo = get_template_directory() . '/assets/images/logo-lilacs.png';
    if (file_exists($default_logo)) {
        return get_template_directory_uri() . '/assets/images/logo-lilacs.png';
    }
    
    // Se nenhum logo for encontrado, retorna uma URL vazia
    return '';
}

// Adiciona suporte a campos personalizados traduzíveis
function bireme_lilacs_polylang_metaboxes() {
    if (function_exists('pll_is_translated_post_type')) {
        // Adiciona suporte para tradução de campos personalizados se necessário
    }
}
add_action('init', 'bireme_lilacs_polylang_metaboxes');

// Carrega o loader de metaboxes específicos do template no admin
if (is_admin()) {
    // Preferir child theme (get_stylesheet_directory) se existir, senão usar parent (get_template_directory)
    $admin_loader = trailingslashit(get_stylesheet_directory()) . 'inc/admin/meta-loader.php';
    if (!file_exists($admin_loader)) {
        $admin_loader = trailingslashit(get_template_directory()) . 'inc/admin/meta-loader.php';
    }
    if (file_exists($admin_loader)) {
        require_once $admin_loader;
    }
}




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
