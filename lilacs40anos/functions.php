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
        '1.923.3' // altera a cada modificação
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
/**
 * Retorna o código de idioma normalizado (pt, en, es)
 */
function bireme_lilacs_get_lang_slug() {
    $current_lang = 'pt';

    if ( function_exists('pll_current_language') ) {
        // slug do Polylang (pt, en, es, pt-br, en-us...)
        $current_lang = pll_current_language();
    }

    $lang_map = array(
        'pt'    => 'pt',
        'pt-br' => 'pt',
        'en'    => 'en',
        'en-us' => 'en',
        'es'    => 'es',
        'es-es' => 'es',
    );

    return isset($lang_map[$current_lang]) ? $lang_map[$current_lang] : 'pt';
}

/**
 * Logo LILACS por idioma (já existia – só usei o helper acima)
 */
function bireme_lilacs_get_logo() {
    $logo_lang = bireme_lilacs_get_lang_slug();

    $logo_path = '/assets/images/logos/' . $logo_lang . '/logo-color.jpg';
    $logo_file = get_template_directory() . $logo_path;

    if ( file_exists($logo_file) ) {
        return get_template_directory_uri() . $logo_path;
    }

    // Fallback PT
    $fallback_path = '/assets/images/logos/pt/logo-color.jpg';
    $fallback_file = get_template_directory() . $fallback_path;

    if ( file_exists($fallback_file) ) {
        return get_template_directory_uri() . $fallback_path;
    }

    // Fallback final
    $default_logo = get_template_directory() . '/assets/images/logo-lilacs.png';
    if ( file_exists($default_logo) ) {
        return get_template_directory_uri() . '/assets/images/logo-lilacs.png';
    }

    return '';
}

/**
 * Logo BVS por idioma
 * Estrutura esperada:
 * /assets/images/logos/{lang}/logo-bvs.svg
 * Ex: /assets/images/logos/pt/logo-bvs.svg
 */
function bireme_bvs_get_logo() {
    $logo_lang = bireme_lilacs_get_lang_slug();

    $logo_path = '/assets/images/logos/' . $logo_lang . '/logo-bvs.svg';
    $logo_file = get_template_directory() . $logo_path;

    if ( file_exists($logo_file) ) {
        return get_template_directory_uri() . $logo_path;
    }

    // Fallback PT
    $fallback_path = '/assets/images/logos/pt/logo-bvs.svg';
    $fallback_file = get_template_directory() . $fallback_path;

    if ( file_exists($fallback_file) ) {
        return get_template_directory_uri() . $fallback_path;
    }

    // Fallback antigo
    $legacy = get_template_directory() . '/assets/images/logo-bvs.svg';
    if ( file_exists($legacy) ) {
        return get_template_directory_uri() . '/assets/images/logo-bvs.svg';
    }

    return '';
}

/**
 * Logo da REDE BVS por idioma
 * Estrutura sugerida:
 * /assets/images/logos/{lang}/logo-rede.svg
 */
function bireme_rede_get_logo() {
    $logo_lang = bireme_lilacs_get_lang_slug();

    $logo_path = '/assets/images/logos/' . $logo_lang . '/logo-rede.svg';
    $logo_file = get_template_directory() . $logo_path;

    if ( file_exists($logo_file) ) {
        return get_template_directory_uri() . $logo_path;
    }

    // Fallback PT
    $fallback_path = '/assets/images/logos/pt/logo-rede.svg';
    $fallback_file = get_template_directory() . $fallback_path;

    if ( file_exists($fallback_file) ) {
        return get_template_directory_uri() . $fallback_path;
    }

    return '';
}

/**
 * URL da REDE por idioma
 */
function bireme_rede_get_url() {
    $logo_lang = bireme_lilacs_get_lang_slug();

    switch ( $logo_lang ) {
        case 'es':
            return 'https://bvsalud.org/es/ ';
        case 'en':
            return 'https://bvsalud.org/en/';
        case 'pt':
        default:
            return 'https://bvsalud.org/';
    }
}

/**
 * Home URL no idioma atual (Polylang) com fallback
 */
function bireme_get_lang_home_url() {
    if ( function_exists('pll_home_url') ) {
        return pll_home_url();
    }
    return home_url('/');
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


/**
 * Helper para carregar dobras de layout em /dobras
 */
function lilacs_bvs_dobra( $slug, $args = array() ) {
    get_template_part( 'templates/dobras-acf/' . $slug, null, $args );
}


add_action('rest_api_init', function () {
    register_rest_route('debug/v1', '/bvs', [
        'methods'  => 'GET',
        'callback' => function () {
            $url = get_rest_url(null, 'test/v1/bvs');
            $response = wp_remote_get($url);

            echo "<pre>";
            print_r(json_decode(wp_remote_retrieve_body($response), true));
            echo "</pre>";
            die();
        }
    ]);
});


// Shortcode: Caixa de busca com estilo CTA moderno LILACS
add_shortcode('lilacs_busca_capacitacao', function() {

    $valor = isset($_GET['s']) ? esc_attr($_GET['s']) : '';

    ob_start();
    ?>

    <div class="lilacs-cta-search-wrapper">
        <form class="lilacs-cta-search-form" method="get" action="">
            
            <div class="lilacs-cta-search-label">
                Pesquise capacitações anteriores:
            </div>

            <div class="lilacs-cta-search-box">
                
                <input 
                    type="text"
                    id="busca-capacitacao"
                    name="s"
                    class="lilacs-cta-input"
                    placeholder="Digite um tema, título ou palavra-chave..."
                    value="<?php echo $valor; ?>"
                >

                <button type="submit" class="lilacs-cta-button">
                    🔍 Buscar
                </button>
            </div>

            <input type="hidden" name="post_type" value="capacitacao">

        </form>
    </div>

<style>
/* ----------------------------- */
/* WRAPPER PRINCIPAL             */
/* ----------------------------- */
.lilacs-cta-search-wrapper {
    max-width: 1180px;
    margin: 40px auto 60px;
    padding: 0 16px;
}

/* ----------------------------- */
/* TÍTULO / LABEL                */
/* ----------------------------- */
.lilacs-cta-search-label {
    font-size: 20px;
    font-weight: 700;
    color: #0b2c68;
    margin-bottom: 12px;
}

/* ----------------------------- */
/* CONTAINER DO INPUT + BOTÃO    */
/* ----------------------------- */
.lilacs-cta-search-box {
    display: flex;
    align-items: center;
    gap: 0;
    background: #ffffff;
    border-radius: 50px;
    padding: 6px;
    border: 1px solid rgba(11, 44, 104, 0.20);
    box-shadow: 0 10px 30px rgba(11, 44, 104, 0.15);
    overflow: hidden;
}

/* ----------------------------- */
/* INPUT                         */
/* ----------------------------- */
.lilacs-cta-input {
    flex: 1;
    border: none;
    font-size: 16px;
    padding: 14px 18px;
    border-radius: 50px 0 0 50px;
    outline: none;
    color: #0b2c68;
}

.lilacs-cta-input::placeholder {
    color: #6b7a90;
}

/* ----------------------------- */
/* BOTÃO                         */
/* ----------------------------- */
.lilacs-cta-button {
    background: linear-gradient(90deg, #0b2c68, #0a6ad8);
    color: #fff;
    border: none;
    padding: 14px 26px;
    font-size: 15px;
    font-weight: 600;
    border-radius: 40px;
    cursor: pointer;
    transition: all .25s ease;
}

.lilacs-cta-button:hover {
    background: linear-gradient(90deg, #0a6ad8, #0b2c68);
    box-shadow: 0 8px 22px rgba(10, 106, 216, 0.35);
    transform: translateY(-2px);
}

/* ----------------------------- */
/* RESPONSIVO                    */
/* ----------------------------- */
@media (max-width: 700px) {

    .lilacs-cta-search-box {
        flex-direction: column;
        padding: 12px;
        border-radius: 20px;
        gap: 12px;
    }

    .lilacs-cta-input {
        width: 100%;
        border-radius: 12px;
        padding: 14px;
    }

    .lilacs-cta-button {
        width: 100%;
        border-radius: 12px;
    }
}
</style>

    <?php
    return ob_get_clean();
});

/**
 * Painel do Footer (LILACS) por idioma (Polylang)
 * - Logos por idioma
 * - Textos por idioma
 * - Seleção de menus por “bloco” (Home, Sobre, Rede, Revistas, Indicadores, Contato)
 * - Guilherme 2WP
 */

if (!defined('ABSPATH')) exit;

function lilacs_footer_get_langs() {
    if (function_exists('pll_languages_list')) {
        $langs = pll_languages_list(['fields' => 'slug']);
        return !empty($langs) ? $langs : ['default'];
    }
    return ['default'];
}

function lilacs_footer_option_name($lang) {
    return 'lilacs_footer_options_' . sanitize_key($lang);
}

function lilacs_footer_get_options($lang = null) {
    if ($lang === null) {
        $lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'default';
        if (!$lang) $lang = 'default';
    }
    $opts = get_option(lilacs_footer_option_name($lang), []);
    return is_array($opts) ? $opts : [];
}

function lilacs_footer_opt($key, $default = '', $lang = null) {
    $opts = lilacs_footer_get_options($lang);
    return isset($opts[$key]) && $opts[$key] !== '' ? $opts[$key] : $default;
}

/**
 * Admin page
 */
add_action('admin_menu', function () {
    add_theme_page(
        'Footer (LILACS)',
        'Footer (LILACS)',
        'manage_options',
        'lilacs-footer-settings',
        'lilacs_footer_settings_page_render'
    );
});

add_action('admin_init', function () {
    foreach (lilacs_footer_get_langs() as $lang) {
        register_setting(
            'lilacs_footer_settings_group_' . $lang,
            lilacs_footer_option_name($lang),
            [
                'type' => 'array',
                'sanitize_callback' => 'lilacs_footer_sanitize_options',
                'default' => [],
            ]
        );
    }
});

function lilacs_footer_sanitize_options($input) {
    $out = [];
    $fields_textarea = ['intro_text'];
    $fields_text = [
        'copyright_text',
        'logo_lilacs_url',
        'logo_opas_bireme_url',
        'powered_by_image_url',
    ];

    // textareas (permite HTML básico)
    foreach ($fields_textarea as $f) {
        if (isset($input[$f])) {
            $out[$f] = wp_kses_post($input[$f]);
        }
    }

    // textos simples / urls
    foreach ($fields_text as $f) {
        if (isset($input[$f])) {
            $val = $input[$f];
            if (str_contains($f, '_url')) $val = esc_url_raw($val);
            else $val = sanitize_text_field($val);
            $out[$f] = $val;
        }
    }

    // blocos -> menu IDs + títulos
    $blocks = lilacs_footer_blocks_schema();
    foreach ($blocks as $block_key => $block_label) {
        $title_key = 'block_title_' . $block_key;
        $menu_key  = 'block_menu_' . $block_key;

        if (isset($input[$title_key])) {
            $out[$title_key] = sanitize_text_field($input[$title_key]);
        }
        if (isset($input[$menu_key])) {
            $out[$menu_key] = absint($input[$menu_key]);
        }
    }

    return $out;
}

function lilacs_footer_blocks_schema() {
    // Seus “H3” atuais viram blocos configuráveis:
    return [
        'home'       => 'Bloco: Home',
        'sobre'      => 'Bloco: Sobre',
        'rede'       => 'Bloco: Rede LILACS',
        'revistas'   => 'Bloco: Revistas',
        'indicadores'=> 'Bloco: Indicadores',
        'contato'    => 'Bloco: Contato',
    ];
}

function lilacs_footer_settings_page_render() {
    if (!current_user_can('manage_options')) return;

    $langs = lilacs_footer_get_langs();
    $current_lang = isset($_GET['lilacs_lang']) ? sanitize_key($_GET['lilacs_lang']) : $langs[0];
    if (!in_array($current_lang, $langs, true)) $current_lang = $langs[0];

    $option_name = lilacs_footer_option_name($current_lang);
    $opts = get_option($option_name, []);

    $menus = wp_get_nav_menus();
    $blocks = lilacs_footer_blocks_schema();
    ?>
    <div class="wrap">
        <h1>Footer (LILACS)</h1>

        <?php if (function_exists('pll_languages_list')): ?>
            <p><strong>Idioma:</strong>
                <?php foreach ($langs as $slug): ?>
                    <?php
                    $url = add_query_arg(['page' => 'lilacs-footer-settings', 'lilacs_lang' => $slug], admin_url('themes.php'));
                    ?>
                    <a class="button <?php echo $slug === $current_lang ? 'button-primary' : ''; ?>" href="<?php echo esc_url($url); ?>">
                        <?php echo esc_html(strtoupper($slug)); ?>
                    </a>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>

        <form method="post" action="options.php">
            <?php
                settings_fields('lilacs_footer_settings_group_' . $current_lang);
            ?>

            <h2 class="title">Logos</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row">Logo LILACS (URL)</th>
                    <td>
                        <input type="url" name="<?php echo esc_attr($option_name); ?>[logo_lilacs_url]" value="<?php echo esc_attr($opts['logo_lilacs_url'] ?? ''); ?>" class="regular-text" />
                        <p class="description">Cole a URL da imagem (você pode pegar da Biblioteca de Mídia).</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Logo OPAS/BIREME (URL)</th>
                    <td>
                        <input type="url" name="<?php echo esc_attr($option_name); ?>[logo_opas_bireme_url]" value="<?php echo esc_attr($opts['logo_opas_bireme_url'] ?? ''); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Imagem “Powered by” (URL)</th>
                    <td>
                        <input type="url" name="<?php echo esc_attr($option_name); ?>[powered_by_image_url]" value="<?php echo esc_attr($opts['powered_by_image_url'] ?? ''); ?>" class="regular-text" />
                    </td>
                </tr>
            </table>

            <h2 class="title">Textos</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row">Texto introdutório</th>
                    <td>
                        <textarea name="<?php echo esc_attr($option_name); ?>[intro_text]" rows="6" class="large-text"><?php echo esc_textarea($opts['intro_text'] ?? ''); ?></textarea>
                        <p class="description">Aceita HTML básico (negrito, links, etc.).</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Copyright</th>
                    <td>
                        <input type="text" name="<?php echo esc_attr($option_name); ?>[copyright_text]" value="<?php echo esc_attr($opts['copyright_text'] ?? ''); ?>" class="regular-text" />
                        <p class="description">Ex: © Todos os direitos reservados</p>
                    </td>
                </tr>
            </table>

            <hr/>

            <h2 class="title">Menus por bloco (colunas)</h2>
            <p class="description">Crie menus em <strong>Aparência → Menus</strong> e selecione abaixo qual aparece em cada bloco deste idioma.</p>

            <table class="form-table" role="presentation">
                <?php foreach ($blocks as $key => $label): ?>
                    <?php
                        $title_key = 'block_title_' . $key;
                        $menu_key  = 'block_menu_' . $key;
                        $title_val = $opts[$title_key] ?? '';
                        $menu_val  = (int)($opts[$menu_key] ?? 0);
                    ?>
                    <tr>
                        <th scope="row"><?php echo esc_html($label); ?></th>
                        <td>
                            <p style="margin:0 0 8px;">
                                <label><strong>Título (H3)</strong></label><br/>
                                <input type="text" name="<?php echo esc_attr($option_name); ?>[<?php echo esc_attr($title_key); ?>]" value="<?php echo esc_attr($title_val); ?>" class="regular-text" />
                            </p>

                            <p style="margin:0;">
                                <label><strong>Menu</strong></label><br/>
                                <select name="<?php echo esc_attr($option_name); ?>[<?php echo esc_attr($menu_key); ?>]">
                                    <option value="0">— Nenhum —</option>
                                    <?php foreach ($menus as $m): ?>
                                        <option value="<?php echo (int)$m->term_id; ?>" <?php selected($menu_val, (int)$m->term_id); ?>>
                                            <?php echo esc_html($m->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <?php submit_button('Salvar Footer'); ?>
        </form>
    </div>
    <?php
}

/**
 * Walker pra aplicar classes iguais:
 * - UL raiz: lf-list
 * - Submenu: lf-list lf-list--sub
 */
class Lilacs_Footer_Menu_Walker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $class = ($depth === 0) ? 'lf-list lf-list--sub' : 'lf-list lf-list--sub';
        $output .= "\n{$indent}<ul class=\"" . esc_attr($class) . "\">\n";
    }
}



