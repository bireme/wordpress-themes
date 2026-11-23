<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    register_nav_menus( array(
        'institutional' => __( 'Navegação institucional', 'vitrines' ),
        'primary' => __( 'Navegação da vitrine', 'vitrines' ),
    ) );
} );

add_action( 'wp_enqueue_scripts', function () {
    $version = wp_get_theme()->get( 'Version' );
    wp_enqueue_style( 'vitrines-bootstrap-grid', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap-grid.min.css', array(), '4.6.2' );
    wp_enqueue_style( 'vitrines-main', get_theme_file_uri( 'assets/css/main.css' ), array( 'vitrines-bootstrap-grid' ), $version );

    // O bundle inclui Popper; reutiliza o jQuery registrado pelo WordPress.
    wp_enqueue_script( 'vitrines-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), '4.6.2', true );
    wp_enqueue_script( 'vitrines-main', get_theme_file_uri( 'assets/js/main.js' ), array( 'vitrines-bootstrap' ), $version, true );
} );

add_action( 'widgets_init', function () {
    foreach ( array(
        'header' => __( 'Cabeçalho', 'vitrines' ),
        'footer' => __( 'Rodapé (compatibilidade)', 'vitrines' ),
        'sidebar-footer' => __( 'Rodapé institucional', 'vitrines' ),
        'footer_sidebar' => __( 'Rodapé auxiliar', 'vitrines' ),
        'level2' => __( 'Barra lateral das páginas internas', 'vitrines' ),
    ) as $id => $name ) {
        register_sidebar( array(
            'id' => $id,
            'name' => $name,
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ) );
    }
} );

/** Usa o idioma da página com Polylang e a localidade do site com WordPress puro. */
function vitrines_locale() {
    $locale = function_exists( 'pll_current_language' ) ? pll_current_language( 'locale' ) : '';
    $language = strtolower( substr( $locale ?: get_locale(), 0, 2 ) );

    return in_array( $language, array( 'pt', 'es', 'en' ), true ) ? $language : 'pt';
}

function vitrines_copy() {
    $copy = require __DIR__ . '/institutional.php';
    return $copy[ vitrines_locale() ];
}

add_action( 'customize_register', function ( WP_Customize_Manager $customizer ) {
    $customizer->add_section( 'vitrines_branding', array(
        'title' => __( 'Identidade da vitrine por idioma', 'vitrines' ),
    ) );

    foreach ( array( 'pt' => 'Português', 'es' => 'Español', 'en' => 'English' ) as $language => $label ) {
        $title = "vitrines_title_{$language}";
        $logo = "vitrines_logo_{$language}";

        $customizer->add_setting( $title, array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $customizer->add_control( $title, array(
            'section' => 'vitrines_branding',
            'label' => sprintf( __( 'Título (%s)', 'vitrines' ), $label ),
        ) );

        $landing = "vitrines_landing_{$language}";
        $customizer->add_setting( $landing, array( 'sanitize_callback' => 'esc_url_raw' ) );
        $customizer->add_control( $landing, array(
            'section' => 'vitrines_branding',
            'label' => sprintf( __( 'Endereço da vitrine (%s)', 'vitrines' ), $label ),
            'type' => 'url',
        ) );

        $customizer->add_setting( $logo, array( 'sanitize_callback' => 'absint' ) );
        $customizer->add_control( new WP_Customize_Media_Control( $customizer, $logo, array(
            'section' => 'vitrines_branding',
            'label' => sprintf( __( 'Logotipo (%s)', 'vitrines' ), $label ),
            'mime_type' => 'image',
        ) ) );
    }
} );
