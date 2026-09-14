<?php
/**
 * Dobra: Nuvem de Palavras
 * Arquivo: templates/dobras-acf/pagina-nuvem_de_palavras.php
 *
 * Campos ACF (sub_fields do flexible content):
 *   - titulo         (text)
 *   - descricao      (textarea)
 *   - palavras       (textarea) — uma por linha ou separadas por vírgula
 *   - cor_fundo      (color_picker)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$titulo    = get_sub_field( 'titulo' );
$descricao = get_sub_field( 'descricao' );
$palavras  = get_sub_field( 'palavras' );
$cor_fundo = get_sub_field( 'cor_fundo' );

// fallback de palavras
$fallback = [
    'rede', 'países', 'cooperação', 'gestão', 'disseminação',
    'comunidades de prática', 'bibliotecas', 'centros cooperantes',
    'equidade', 'interoperabilidade', 'DeCS', 'acesso aberto',
    'qualidade', 'metadados', 'América Latina', 'Caribe', 'saúde',
    'indexação', 'BIREME', 'Global Index Medicus',
];

// normaliza palavras
if ( $palavras ) {
    $partes = preg_split( '/[\r\n,]+/', $palavras );
    $lista  = array_values( array_filter( array_map( 'trim', $partes ) ) );
} else {
    $lista = $fallback;
}

// monta JSON {text, frequency}
$words_js = [];
$base = 60;
foreach ( $lista as $i => $w ) {
    $freq       = $base + ( $i % 10 ) * 3;
    $words_js[] = [ 'text' => $w, 'frequency' => $freq ];
}
$words_json = wp_json_encode( $words_js, JSON_UNESCAPED_UNICODE );

$uid       = 'nuvem-' . get_the_ID() . '-' . get_row_index();
$bg_style  = $cor_fundo ? 'background-color:' . esc_attr( $cor_fundo ) . ';' : '';
?>

<style>
#<?php echo esc_attr( $uid ); ?> {
    padding: 60px 16px;
    <?php echo $bg_style; ?>
}
#<?php echo esc_attr( $uid ); ?> .nuvem-inner {
    max-width: 1200px;
    margin: 0 auto;
}
#<?php echo esc_attr( $uid ); ?> .nuvem-title {
    font-family: 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    font-size: 2rem;
    font-weight: 700;
    color: #003d7a;
    margin: 0 0 16px;
}
#<?php echo esc_attr( $uid ); ?> .nuvem-desc {
    font-family: 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    font-size: 1rem;
    color: #555;
    line-height: 1.7;
    margin: 0 0 40px;
    text-align: justify;
}
#<?php echo esc_attr( $uid ); ?> .nuvem-cloud-wrap {
    background: #ffffff;
    padding: 56px 40px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    min-height: 260px;
    display: flex;
    align-items: center;
    justify-content: center;
}
#<?php echo esc_attr( $uid ); ?> .nuvem-cloud {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    justify-content: center;
    align-items: center;
}
#<?php echo esc_attr( $uid ); ?> .nuvem-word {
    padding: 8px 18px;
    background: #f0f0f0;
    color: #003d7a;
    border-radius: 20px;
    font-family: 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    font-size: .9rem;
    font-weight: 500;
    cursor: default;
    transition: background .2s ease, color .2s ease, transform .15s ease;
    line-height: 1.3;
}
#<?php echo esc_attr( $uid ); ?> .nuvem-word:hover {
    background: #003d7a;
    color: #fff;
    transform: scale(1.08);
}
#<?php echo esc_attr( $uid ); ?> .nuvem-word.large  { font-size: 1.3rem; font-weight: 700; }
#<?php echo esc_attr( $uid ); ?> .nuvem-word.medium { font-size: 1.1rem; font-weight: 600; }
#<?php echo esc_attr( $uid ); ?> .nuvem-word.small  { font-size: .85rem; font-weight: 400; }

@media (max-width: 768px) {
    #<?php echo esc_attr( $uid ); ?> { padding: 40px 16px; }
    #<?php echo esc_attr( $uid ); ?> .nuvem-title { font-size: 1.5rem; }
    #<?php echo esc_attr( $uid ); ?> .nuvem-cloud-wrap { padding: 40px 20px; }
    #<?php echo esc_attr( $uid ); ?> .nuvem-cloud { gap: 10px; }
}
@media (max-width: 480px) {
    #<?php echo esc_attr( $uid ); ?> .nuvem-title { font-size: 1.2rem; }
    #<?php echo esc_attr( $uid ); ?> .nuvem-cloud-wrap { padding: 30px 15px; }
}
</style>

<section id="<?php echo esc_attr( $uid ); ?>">
    <div class="nuvem-inner">

        <?php if ( $titulo ) : ?>
            <h2 class="nuvem-title"><?php echo esc_html( $titulo ); ?></h2>
        <?php endif; ?>

        <?php if ( $descricao ) : ?>
            <p class="nuvem-desc"><?php echo esc_html( $descricao ); ?></p>
        <?php endif; ?>

        <div class="nuvem-cloud-wrap">
            <div class="nuvem-cloud" data-words="<?php echo esc_attr( $words_json ); ?>">
                <!-- tags geradas por JS -->
            </div>
        </div>

    </div>
</section>

<script>
(function(){
    var el = document.getElementById(<?php echo wp_json_encode( $uid ); ?>);
    if (!el) return;
    var cloud = el.querySelector('.nuvem-cloud');
    if (!cloud) return;

    var words = [];
    try { words = JSON.parse(cloud.getAttribute('data-words') || '[]'); }
    catch(e){ words = []; }

    if (!words.length) return;

    var freqs = words.map(function(w){ return Number(w.frequency)||0; });
    var fmin  = Math.min.apply(null, freqs);
    var fmax  = Math.max.apply(null, freqs);

    // embaralha para visual orgânico
    words = words.slice().sort(function(){ return Math.random() - 0.5; });

    cloud.innerHTML = '';
    words.forEach(function(w){
        var freq = Number(w.frequency)||0;
        var n    = (freq - fmin) / ((fmax - fmin) || 1);
        var cls  = n >= .66 ? 'large' : (n >= .33 ? 'medium' : 'small');

        var span = document.createElement('span');
        span.className = 'nuvem-word ' + cls;
        span.textContent = w.text;
        cloud.appendChild(span);
    });
})();
</script>
