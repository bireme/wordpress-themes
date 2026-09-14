<?php
/**
 * Dobra: Hero Sobre LILACS
 * Arquivo: templates/dobras-acf/pagina-hero_sobre.php
 *
 * Campos ACF (sub_fields do flexible content):
 *   - titulo         (text)
 *   - descricao      (textarea)
 *   - texto_numeros  (text)   — ex: "A LILACS em números:"
 *   - imagem_fundo   (image, return_format: url)
 *   - cor_fundo      (color_picker) — sobrepõe o gradiente padrão
 *   - estatisticas   (repeater)
 *       - numero     (text)
 *       - rotulo     (text)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$titulo        = get_sub_field( 'titulo' );
$descricao     = get_sub_field( 'descricao' );
$texto_numeros = get_sub_field( 'texto_numeros' );
$imagem_fundo  = get_sub_field( 'imagem_fundo' );
$cor_fundo     = get_sub_field( 'cor_fundo' );
$estatisticas  = get_sub_field( 'estatisticas' );

// fallbacks
if ( ! $titulo )    $titulo    = 'LILACS: 40 anos de ciência com identidade latino-americana';
if ( ! $descricao ) $descricao = 'A maior base de dados da produção científica em saúde da região.';

// defaults de estatísticas
$stats_default = [
    [ 'numero' => '+1.140 M', 'rotulo' => 'Registros' ],
    [ 'numero' => '+722M',    'rotulo' => 'Textos completos' ],
    [ 'numero' => '+2.600',   'rotulo' => 'Revistas' ],
    [ 'numero' => '30',       'rotulo' => 'Países' ],
    [ 'numero' => '9',        'rotulo' => 'Idiomas' ],
];
if ( empty( $estatisticas ) ) {
    $estatisticas = $stats_default;
}

// estilos inline
$bg_style = '';
if ( $imagem_fundo ) {
    $bg_style .= "--hero-sobre-img: url('" . esc_url( $imagem_fundo ) . "');";
}
if ( $cor_fundo ) {
    $bg_style .= " background-color: " . esc_attr( $cor_fundo ) . ";";
}

$uid = 'hero-sobre-' . get_the_ID() . '-' . get_row_index();
?>

<style>
#<?php echo esc_attr( $uid ); ?> {
    position: relative;
    background: linear-gradient(135deg, #0b2a4f 0%, #1a3a5c 25%, #2d1b4e 50%, #4a1a5c 75%, #2d1b4e 100%);
    overflow: hidden;
    padding: 60px 20px;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}
#<?php echo esc_attr( $uid ); ?>::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        var(--hero-sobre-img, none),
        radial-gradient(circle at 20% 50%, rgba(100,200,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(150,100,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 0%,  rgba(100,150,255,0.05) 0%, transparent 40%);
    background-size: cover;
    background-position: center right;
    background-repeat: no-repeat;
    pointer-events: none;
    z-index: 1;
}
#<?php echo esc_attr( $uid ); ?> .hs-decoration {
    position: absolute;
    right: -100px;
    top: 50%;
    transform: translateY(-50%);
    width: 400px;
    height: 400px;
    opacity: 0.15;
    z-index: 0;
}
#<?php echo esc_attr( $uid ); ?> .hs-inner {
    position: relative;
    z-index: 2;
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
}
#<?php echo esc_attr( $uid ); ?> .hs-content {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
#<?php echo esc_attr( $uid ); ?> .hs-title {
    width: 65%;
    font-size: clamp(28px, 5vw, 48px);
    font-weight: 700;
    color: #ffffff;
    line-height: 1.2;
    margin: 0 0 16px;
    letter-spacing: -0.5px;
}
#<?php echo esc_attr( $uid ); ?> .hs-desc {
    width: 65%;
    font-size: clamp(16px, 2vw, 22px);
    color: rgba(255,255,255,.9);
    line-height: 1.6;
    margin: 0;
}
#<?php echo esc_attr( $uid ); ?> .hs-texto-numeros {
    width: 65%;
    font-size: clamp(14px, 1.5vw, 18px);
    color: rgba(255,255,255,.75);
    margin: 8px 0 0;
}
#<?php echo esc_attr( $uid ); ?> .hs-stats {
    display: flex;
    justify-content: space-between;
    gap: 30px;
    margin-top: 40px;
}
#<?php echo esc_attr( $uid ); ?> .hs-stat-number {
    font-size: clamp(24px, 4vw, 42px);
    font-weight: 700;
    color: #ffffff;
    line-height: 1;
    margin-bottom: 8px;
}
#<?php echo esc_attr( $uid ); ?> .hs-stat-label {
    font-size: clamp(12px, 1.5vw, 14px);
    color: rgba(255,255,255,.85);
    font-weight: 500;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}

@media (max-width: 768px) {
    #<?php echo esc_attr( $uid ); ?> { padding: 40px 20px; min-height: auto; }
    #<?php echo esc_attr( $uid ); ?> .hs-title,
    #<?php echo esc_attr( $uid ); ?> .hs-desc,
    #<?php echo esc_attr( $uid ); ?> .hs-texto-numeros { width: 100%; }
    #<?php echo esc_attr( $uid ); ?> .hs-stats { flex-wrap: wrap; gap: 20px; margin-top: 30px; }
    #<?php echo esc_attr( $uid ); ?> .hs-decoration { display: none; }
}
@media (max-width: 480px) {
    #<?php echo esc_attr( $uid ); ?> { padding: 30px 15px; }
    #<?php echo esc_attr( $uid ); ?> .hs-stats { gap: 15px; }
}
</style>

<section id="<?php echo esc_attr( $uid ); ?>"<?php if ( $bg_style ) : ?> style="<?php echo esc_attr( $bg_style ); ?>"<?php endif; ?>>

    <div class="hs-decoration" aria-hidden="true">
        <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
            <g stroke="rgba(255,255,255,0.3)" stroke-width="1" fill="none">
                <polygon points="100,50 200,0 300,50 250,150 200,200 100,150"/>
                <polygon points="200,100 280,130 300,210 220,240 140,210 160,130"/>
                <circle cx="200" cy="150" r="80"/>
                <line x1="50" y1="200" x2="350" y2="200"/>
                <line x1="200" y1="50" x2="200" y2="350"/>
                <polygon points="150,300 200,250 250,300 230,350 170,350"/>
            </g>
        </svg>
    </div>

    <div class="hs-inner">
        <div class="hs-content">

            <div>
                <h1 class="hs-title"><?php echo esc_html( $titulo ); ?></h1>

                <?php if ( $descricao ) : ?>
                    <p class="hs-desc"><?php echo esc_html( $descricao ); ?></p>
                <?php endif; ?>

                <?php if ( $texto_numeros ) : ?>
                    <p class="hs-texto-numeros"><?php echo esc_html( $texto_numeros ); ?></p>
                <?php endif; ?>
            </div>

            <?php if ( ! empty( $estatisticas ) ) : ?>
                <div class="hs-stats">
                    <?php foreach ( $estatisticas as $stat ) :
                        $numero = isset( $stat['numero'] ) ? $stat['numero'] : '';
                        $rotulo = isset( $stat['rotulo'] ) ? $stat['rotulo'] : '';
                        if ( ! $numero && ! $rotulo ) continue;
                    ?>
                        <div class="hs-stat-item">
                            <div class="hs-stat-number"><?php echo esc_html( $numero ); ?></div>
                            <div class="hs-stat-label"><?php echo esc_html( $rotulo ); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
