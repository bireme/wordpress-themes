<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Setup básico do tema
 */
function rede_bvs_theme_setup() {

    // Suporte a título dinâmico
    add_theme_support( 'title-tag' );

    // Logo personalizada
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 160,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Menus
    register_nav_menus( array(
        'primary' => __( 'Menu Principal', 'rede-bvs' ),
    ) );
}
add_action( 'after_setup_theme', 'rede_bvs_theme_setup' );

/**
 * Enqueue de estilos
 */
function rede_bvs_enqueue_assets() {
    wp_enqueue_style(
        'rede-bvs-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'rede_bvs_enqueue_assets' );

/**
 * Carrega automaticamente todos os arquivos da pasta /shortcodes
 */
function rede_bvs_load_shortcodes() {
    $shortcodes_dir = get_template_directory() . '/shortcodes';

    if ( is_dir( $shortcodes_dir ) ) {
        foreach ( glob( $shortcodes_dir . '/*.php' ) as $shortcode_file ) {
            require_once $shortcode_file;
        }
    }
}
add_action( 'init', 'rede_bvs_load_shortcodes' );

/**
 * Helper para carregar dobras de layout em /dobras
 */
function rede_bvs_dobra( $slug, $args = array() ) {
    get_template_part( 'dobras/' . $slug, null, $args );
}



if ( ! function_exists( 'rede_bvs_breadcrumb' ) ) {
    /**
     * Renderiza o breadcrumb da BVS.
     *
     * @param array $items Cada item: [ 'label' => 'Texto', 'url' => 'https://...' ]
     *                     O último item não precisa de URL (página atual).
     */
    function rede_bvs_breadcrumb( $items = array() ) {

        // Se não vier nada, tenta montar automaticamente a partir da hierarquia da página
        if ( empty( $items ) && is_singular() ) {
            $items = array();

            // Exemplo: Home
            $items[] = array(
                'label' => get_bloginfo( 'name' ),
                'url'   => home_url( '/' ),
            );

            // Pais da página
            $post    = get_post();
            $parents = get_post_ancestors( $post );

            if ( ! empty( $parents ) ) {
                $parents = array_reverse( $parents );
                foreach ( $parents as $parent_id ) {
                    $items[] = array(
                        'label' => get_the_title( $parent_id ),
                        'url'   => get_permalink( $parent_id ),
                    );
                }
            }

            // Página atual
            $items[] = array(
                'label' => get_the_title( $post ),
            );
        }

        if ( empty( $items ) ) {
            return;
        }

        ?>
        <nav class="bvs-breadcrumb" aria-label="Você está aqui:">
            <ol class="bvs-breadcrumb-list">
                <?php
                $total = count( $items );
                foreach ( $items as $index => $item ) :
                    $is_last = ( $index === $total - 1 );
                    $label   = isset( $item['label'] ) ? $item['label'] : '';
                    $url     = isset( $item['url'] ) ? $item['url'] : '';
                    ?>
                    <li class="bvs-breadcrumb-item <?php echo $index === 0 ? 'bvs-breadcrumb-item--root' : ''; ?>">
                        <?php if ( $is_last || empty( $url ) ) : ?>
                            <span class="bvs-breadcrumb-label" aria-current="page">
                                <?php echo esc_html( $label ); ?>
                            </span>
                        <?php else : ?>
                            <a class="bvs-breadcrumb-link" href="<?php echo esc_url( $url ); ?>">
                                <?php echo esc_html( $label ); ?>
                            </a>
                        <?php endif; ?>

                        <?php if ( ! $is_last ) : ?>
                            <span class="bvs-breadcrumb-sep">&gt;</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>
        <?php
    }
}


// Shortcode de busca BVS + Repositório
add_action( 'init', function() {
    add_shortcode( 'bvs_busca_repositorio', 'bvs_busca_repositorio_shortcode' );
});

function bvs_busca_repositorio_shortcode( $atts = [] ) {
    // idioma via Polylang (se existir)
    $lang = 'pt';
    if ( function_exists( 'pll_current_language' ) ) {
        $lang = pll_current_language( 'slug' );
    }

    // base da URL do repositório conforme idioma
    switch ( $lang ) {
        case 'es':
            $repo_base = 'https://pesquisa.bvsalud.org/repositoriobvs/?lang=es&home_url=http%3A%2F%2Fred.bvsalud.org%2F&home_text=Portal+Red+BVS&q=';
            break;
        case 'en':
            $repo_base = 'https://pesquisa.bvsalud.org/repositoriobvs/?lang=en&home_url=http%3A%2F%2Fred.bvsalud.org%2F&home_text=Portal+Red+BVS&q=';
            break;
        case 'pt':
        default:
            $repo_base = 'https://pesquisa.bvsalud.org/repositoriobvs/?lang=pt&home_url=http%3A%2Fred.bvsalud.org%2F&home_text=Portal+Red+BVS&q=';
            break;
    }

    // URL da página atual para busca local (?s=termo_digitado)
    $portal_url = '/';

    $uid = uniqid('bvs-search-');

    ob_start();
    ?>
    <div class="bvs-search-widget" id="<?php echo esc_attr( $uid ); ?>"
         data-repo-base-url="<?php echo esc_url( $repo_base ); ?>"
         data-portal-url="<?php echo esc_url( $portal_url ); ?>">

        <style>
        /* ---- ESTILOS DA BUSCA BVS / REPOSITÓRIO ---- */
        .bvs-search-widget {
            max-width: 620px;
            margin: 0;
            font-size: 14px;
        }

        .bvs-search-form {
          display: flex;
    flex-direction: column;
    gap: 8px;
    width: 441px;
        }

        .bvs-search-input-wrap {
            position: relative;
            display: flex;
            align-items: stretch;
        }

        .bvs-search-input {
            flex: 1;
            border-radius: 10px 0 0 10px;
            border: none;
            padding: 12px 44px 12px 18px;
            font-size: 16px;
            color: #111827;
            background: #ffffff;
            outline: none;
        }

        .bvs-search-input::placeholder {
            color: #9ca3af;
        }

        .bvs-search-mic {
            position: absolute;
            right: 54px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bvs-search-mic svg {
            width: 18px;
            height: 18px;
            fill: #9ca3af;
        }
        .bvs-search-submit img{
            max-width: 23px;
        }
        .bvs-search-submit {
            border: none;
            background: #9ca3af;
            border-radius: 0 12px 12px 0;
            min-width: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .bvs-search-submit svg {
            width: 20px;
            height: 20px;
            fill: #ffffff;
        }

        .bvs-search-targets {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            color: #e5e7eb;
        }

        .bvs-search-target-label {
            font-size: 13px;
            color: #e5e7eb;
        }

        .bvs-search-target {
            border-radius: 999px;
            border: 1px solid #ffffff;
            background: transparent;
            color: #ffffff;
            padding: 4px 14px;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
        }

        .bvs-search-target.is-active {
            background: #ffffff;
            color: #28367D;
            border-color: #ffffff;
            font-weight: 500;
        }

        @media (max-width: 480px) {
            .bvs-search-input {
                font-size: 14px;
                padding-left: 14px;
            }
        }
        </style>

        <form class="bvs-search-form" onsubmit="return false;">
            <div class="bvs-search-input-wrap">
                <input id="bvs-search-input" type="text"
                       class="bvs-search-input"
                       placeholder="Pesquisar"
                       autocomplete="off">
                <button type="button" class="bvs-search-mic" aria-label="Busca por voz (não implementada)">
              
                </button>
                <button type="submit" class="bvs-search-submit" aria-label="Buscar">
                    <!-- Ícone de lupa -->
                      <img 
                            src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/Frame.png' ); ?>"
                            alt="<?php esc_attr_e('Busca Portal da Rede BVS', 'rede-bvs'); ?>"
                        >
                </button>
            </div>

            <div class="bvs-search-targets">
                <span class="bvs-search-target-label">Buscar em:</span>
                <button type="button"
                        class="bvs-search-target is-active"
                        data-target="repositorio">
                    Repositório BVS
                </button>
                <button type="button"
                        class="bvs-search-target"
                        data-target="portal">
                    Neste portal
                </button>
            </div>
        </form>

        <script>
        (function() {
            var widget   = document.getElementById('<?php echo esc_js( $uid ); ?>');
            if (!widget) return;

            var input    = widget.querySelector('.bvs-search-input');
            var targets  = widget.querySelectorAll('.bvs-search-target');
            var form     = widget.querySelector('.bvs-search-form');

            var currentTarget = 'repositorio'; // default

            targets.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    targets.forEach(function(b) { b.classList.remove('is-active'); });
                    btn.classList.add('is-active');
                    currentTarget = btn.getAttribute('data-target');
                });
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                var term = (input.value || '').trim();
                if (!term) {
                    input.focus();
                    return false;
                }

                var repoBase  = widget.getAttribute('data-repo-base-url');
                var portalUrl = widget.getAttribute('data-portal-url');

                if (currentTarget === 'portal') {
                    // busca neste portal: página atual + ?s=termo
                    var url = portalUrl;
                    if (url.indexOf('?') === -1) {
                        url += '?s=' + encodeURIComponent(term);
                    } else {
                        url += '&s=' + encodeURIComponent(term);
                    }
                    window.location.href = url;
                } else {
                    // busca no repositório BVS
                    window.location.href = repoBase + encodeURIComponent(term);
                }

                return false;
            });
        })();
        </script>
    </div>
    <?php
    return ob_get_clean();
}


/**
 * Registra submenu em Aparência para configurar menus + texto + imagem do rodapé
 */
add_action( 'admin_menu', 'rede_bvs_register_footer_menus_page' );
function rede_bvs_register_footer_menus_page() {
    add_theme_page(
        __( 'Menus do Rodapé BVS', 'rede-bvs' ),
        __( 'Menus do Rodapé BVS', 'rede-bvs' ),
        'manage_options',
        'rede-bvs-footer-menus',
        'rede_bvs_footer_menus_page_callback'
    );
}

/**
 * Idiomas fixos: ptbr, en, es
 */
function rede_bvs_get_footer_languages_fixed() {
    return array(
        'ptbr' => array(
            'slug'  => 'ptbr',
            'label' => 'Português (Brasil)',
        ),
        'en'   => array(
            'slug'  => 'en',
            'label' => 'English',
        ),
        'es'   => array(
            'slug'  => 'es',
            'label' => 'Español',
        ),
    );
}

/**
 * Página de configuração dos menus + texto + imagem do rodapé
 */
function rede_bvs_footer_menus_page_callback() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // ---------- SALVAR ----------
    if (
        isset( $_POST['rede_bvs_footer_menus_nonce'] ) &&
        wp_verify_nonce( $_POST['rede_bvs_footer_menus_nonce'], 'rede_bvs_footer_menus_save' )
    ) {
        $raw       = isset( $_POST['rede_bvs_footer_menus'] ) ? (array) $_POST['rede_bvs_footer_menus'] : array();
        $sanitized = array();

        $menu_keys = array(
            'col_rede_bvs',
            'col_produtos',
            'col_servicos',
            'col_modelo',
            'col_contato',
        );

        foreach ( $raw as $lang_slug => $cols ) {
            // esperamos: ptbr, en, es
            $lang_slug = sanitize_key( $lang_slug );

            if ( ! is_array( $cols ) ) {
                continue;
            }

            if ( ! isset( $sanitized[ $lang_slug ] ) ) {
                $sanitized[ $lang_slug ] = array();
            }

            foreach ( $cols as $key => $value ) {

                // Menus
                if ( in_array( $key, $menu_keys, true ) ) {
                    $sanitized[ $lang_slug ][ $key ] = (int) $value;
                    continue;
                }

                // Texto do rodapé
                if ( $key === 'footer_text' ) {
                    $sanitized[ $lang_slug ]['footer_text'] = wp_kses_post( $value );
                    continue;
                }

                // Imagem / logo (URL)
                if ( $key === 'footer_logo' ) {
                    $sanitized[ $lang_slug ]['footer_logo'] = esc_url_raw( $value );
                    continue;
                }
            }
        }

        update_option( 'rede_bvs_footer_menus', $sanitized );

        echo '<div class="notice notice-success is-dismissible"><p>'
            . esc_html__( 'Configurações salvas com sucesso.', 'rede-bvs' )
            . '</p></div>';
    }

    // ---------- FORM ----------
    $saved     = get_option( 'rede_bvs_footer_menus', array() );
    $languages = rede_bvs_get_footer_languages_fixed();
    $menus     = wp_get_nav_menus();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Menus do Rodapé BVS', 'rede-bvs' ); ?></h1>
        <p><?php esc_html_e( 'Defina, para cada idioma (ptbr, en, es), os menus das colunas do rodapé, o texto do rodapé e a imagem/box à esquerda.', 'rede-bvs' ); ?></p>

        <form method="post" action="">
            <?php wp_nonce_field( 'rede_bvs_footer_menus_save', 'rede_bvs_footer_menus_nonce' ); ?>

            <table class="form-table">
                <tbody>
                <?php foreach ( $languages as $lang_slug => $lang_data ) :

                    $lang_saved = isset( $saved[ $lang_slug ] ) ? (array) $saved[ $lang_slug ] : array();

                    $col_rede_bvs = isset( $lang_saved['col_rede_bvs'] ) ? (int) $lang_saved['col_rede_bvs'] : 0;
                    $col_produtos = isset( $lang_saved['col_produtos'] ) ? (int) $lang_saved['col_produtos'] : 0;
                    $col_servicos = isset( $lang_saved['col_servicos'] ) ? (int) $lang_saved['col_servicos'] : 0;
                    $col_modelo   = isset( $lang_saved['col_modelo'] )   ? (int) $lang_saved['col_modelo']   : 0;
                    $col_contato  = isset( $lang_saved['col_contato'] )  ? (int) $lang_saved['col_contato']  : 0;

                    $footer_text = isset( $lang_saved['footer_text'] ) ? $lang_saved['footer_text'] : '';
                    $footer_logo = isset( $lang_saved['footer_logo'] ) ? $lang_saved['footer_logo'] : '';
                    ?>
                    <tr>
                        <th colspan="2">
                            <h2 style="margin-bottom:0;"><?php echo esc_html( $lang_data['label'] ); ?></h2>
                            <p style="margin-top:4px; color:#555;">
                                <?php printf(
                                    esc_html__( 'Configurações para o idioma (chave): %s', 'rede-bvs' ),
                                    esc_html( $lang_slug )
                                ); ?>
                            </p>
                            <hr>
                        </th>
                    </tr>

                    <!-- Texto do rodapé -->
                    <tr>
                        <th scope="row">
                            <label for="footer-text-<?php echo esc_attr( $lang_slug ); ?>">
                                <?php esc_html_e( 'Texto do rodapé (parágrafo)', 'rede-bvs' ); ?>
                            </label>
                        </th>
                        <td>
                            <textarea
                                id="footer-text-<?php echo esc_attr( $lang_slug ); ?>"
                                name="rede_bvs_footer_menus[<?php echo esc_attr( $lang_slug ); ?>][footer_text]"
                                rows="4"
                                class="large-text"
                            ><?php echo esc_textarea( $footer_text ); ?></textarea>
                            <p class="description">
                                <?php esc_html_e( 'Texto que aparece ao lado direito da caixa, abaixo do box/imagem.', 'rede-bvs' ); ?>
                            </p>
                        </td>
                    </tr>

                    <!-- Imagem / box à esquerda -->
                    <tr>
                        <th scope="row">
                            <label for="footer-logo-<?php echo esc_attr( $lang_slug ); ?>">
                                <?php esc_html_e( 'Imagem da caixa à esquerda (URL)', 'rede-bvs' ); ?>
                            </label>
                        </th>
                        <td>
                            <input
                                type="text"
                                id="footer-logo-<?php echo esc_attr( $lang_slug ); ?>"
                                name="rede_bvs_footer_menus[<?php echo esc_attr( $lang_slug ); ?>][footer_logo]"
                                value="<?php echo esc_attr( $footer_logo ); ?>"
                                class="regular-text"
                            />
                            <p class="description">
                                <?php esc_html_e( 'Cole a URL da imagem (da biblioteca de mídia, por exemplo). Se vazio, aparece o texto padrão "Portal da Rede BVS".', 'rede-bvs' ); ?>
                            </p>
                        </td>
                    </tr>

                    <!-- Coluna: A Rede BVS -->
                    <tr>
                        <th scope="row">
                            <label><?php esc_html_e( 'Coluna "A Rede BVS"', 'rede-bvs' ); ?></label>
                        </th>
                        <td>
                            <select name="rede_bvs_footer_menus[<?php echo esc_attr( $lang_slug ); ?>][col_rede_bvs]">
                                <option value="0"><?php esc_html_e( '— Selecione um menu —', 'rede-bvs' ); ?></option>
                                <?php foreach ( $menus as $menu ) : ?>
                                    <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $col_rede_bvs, $menu->term_id ); ?>>
                                        <?php echo esc_html( $menu->name ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <!-- Coluna: Produtos -->
                    <tr>
                        <th scope="row">
                            <label><?php esc_html_e( 'Coluna "Produtos"', 'rede-bvs' ); ?></label>
                        </th>
                        <td>
                            <select name="rede_bvs_footer_menus[<?php echo esc_attr( $lang_slug ); ?>][col_produtos]">
                                <option value="0"><?php esc_html_e( '— Selecione um menu —', 'rede-bvs' ); ?></option>
                                <?php foreach ( $menus as $menu ) : ?>
                                    <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $col_produtos, $menu->term_id ); ?>>
                                        <?php echo esc_html( $menu->name ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <!-- Coluna: Serviços -->
                    <tr>
                        <th scope="row">
                            <label><?php esc_html_e( 'Coluna "Serviços"', 'rede-bvs' ); ?></label>
                        </th>
                        <td>
                            <select name="rede_bvs_footer_menus[<?php echo esc_attr( $lang_slug ); ?>][col_servicos]">
                                <option value="0"><?php esc_html_e( '— Selecione um menu —', 'rede-bvs' ); ?></option>
                                <?php foreach ( $menus as $menu ) : ?>
                                    <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $col_servicos, $menu->term_id ); ?>>
                                        <?php echo esc_html( $menu->name ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <!-- Coluna: Modelo BVS -->
                    <tr>
                        <th scope="row">
                            <label><?php esc_html_e( 'Coluna "Modelo BVS"', 'rede-bvs' ); ?></label>
                        </th>
                        <td>
                            <select name="rede_bvs_footer_menus[<?php echo esc_attr( $lang_slug ); ?>][col_modelo]">
                                <option value="0"><?php esc_html_e( '— Selecione um menu —', 'rede-bvs' ); ?></option>
                                <?php foreach ( $menus as $menu ) : ?>
                                    <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $col_modelo, $menu->term_id ); ?>>
                                        <?php echo esc_html( $menu->name ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <!-- Coluna: Contato -->
                    <tr>
                        <th scope="row">
                            <label><?php esc_html_e( 'Coluna "Contato"', 'rede-bvs' ); ?></label>
                        </th>
                        <td>
                            <select name="rede_bvs_footer_menus[<?php echo esc_attr( $lang_slug ); ?>][col_contato]">
                                <option value="0"><?php esc_html_e( '— Selecione um menu —', 'rede-bvs' ); ?></option>
                                <?php foreach ( $menus as $menu ) : ?>
                                    <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $col_contato, $menu->term_id ); ?>>
                                        <?php echo esc_html( $menu->name ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>
            </table>

            <?php submit_button( __( 'Salvar alterações', 'rede-bvs' ) ); ?>
        </form>
    </div>
    <?php
}

/**
 * Mapeia o idioma atual (Polylang) para a chave fixa ptbr/en/es
 */
function rede_bvs_footer_get_current_lang_key() {
    $default = 'ptbr';

    if ( function_exists( 'pll_current_language' ) ) {
        $pll = pll_current_language( 'slug' ); // ex: pt, en, es, pt-br, es-mx etc.

        if ( strpos( $pll, 'pt' ) === 0 ) {
            return 'ptbr';
        }
        if ( strpos( $pll, 'en' ) === 0 ) {
            return 'en';
        }
        if ( strpos( $pll, 'es' ) === 0 ) {
            return 'es';
        }
    }

    return $default;
}

/**
 * Helper: ID do menu por coluna / idioma atual
 */
function rede_bvs_get_footer_menu_id( $column_key ) {
    $options    = get_option( 'rede_bvs_footer_menus', array() );
    $column_key = sanitize_key( $column_key );
    $lang_key   = rede_bvs_footer_get_current_lang_key();

    if ( isset( $options[ $lang_key ][ $column_key ] ) && $options[ $lang_key ][ $column_key ] ) {
        return (int) $options[ $lang_key ][ $column_key ];
    }

    return 0;
}

/**
 * Helper: texto do rodapé por idioma atual
 */
function rede_bvs_get_footer_text() {
    $options  = get_option( 'rede_bvs_footer_menus', array() );
    $lang_key = rede_bvs_footer_get_current_lang_key();

    if ( ! empty( $options[ $lang_key ]['footer_text'] ) ) {
        return $options[ $lang_key ]['footer_text'];
    }

    // fallback hardcoded
    return 'A BVS é um produto colaborativo, coordenado pela BIREME/OPAS/OMS. Como biblioteca, oferece acesso abrangente à informação científica e técnica em saúde. A BVS coleta, indexa e armazena citações de documentos publicados por diversas organizações. A inclusão de qualquer artigo, documento ou citação na coleção da BVS não implica endosso ou concordância da BIREME/OPAS/OMS com o seu conteúdo.';
}

/**
 * Helper: URL da imagem à esquerda (box) por idioma atual
 */
function rede_bvs_get_footer_logo_url() {
    $options  = get_option( 'rede_bvs_footer_menus', array() );
    $lang_key = rede_bvs_footer_get_current_lang_key();

    if ( ! empty( $options[ $lang_key ]['footer_logo'] ) ) {
        return $options[ $lang_key ]['footer_logo'];
    }

    return '';
}
