<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Exemplo de shortcode: [rede_bvs_exemplo]
 */
function rede_bvs_exemplo_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts(
        array(
            'titulo' => 'Exemplo REDE BVS',
        ),
        $atts,
        'rede_bvs_exemplo'
    );

    ob_start();
    ?>
    <div class="rede-bvs-exemplo-shortcode">
        <h2><?php echo esc_html( $atts['titulo'] ); ?></h2>
        <p><?php echo $content ? wp_kses_post( $content ) : 'Conteúdo de exemplo do shortcode.'; ?></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'rede_bvs_exemplo', 'rede_bvs_exemplo_shortcode' );
