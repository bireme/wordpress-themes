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

// O editor informa a quantidade junto do nome. Vale para as duas nuvens:
// LILACS Plus usa "MEDLINE (972833)"; o ecossistema usa "BDENF\t84016"
// ou "BBO - Brasil 59235". O número só define o tamanho da fonte.
$words_js = [];
foreach ( $lista as $w ) {
    $name   = $w;
    $count  = null;
    $w_norm = str_replace( array( "\xc2\xa0", "\t" ), ' ', $w );
    $w_norm = trim( $w_norm );

    if ( preg_match( '/^(.*)\((\d+)\)\s*$/u', $w_norm, $m ) && trim( $m[1] ) !== '' ) {
        $name  = trim( $m[1] );
        $count = (int) $m[2];
    } elseif ( preg_match( '/^(.*\S)\s+(\d+)\s*$/u', $w_norm, $m ) ) {
        $name  = trim( $m[1] );
        $count = (int) $m[2];
        // Ecossistema: "LILACS - ALyC 1241545" e "ColecionaSUS - Brasil 41599"
        // exibem só a sigla. A coleção Plus usa parênteses e mantém o nome completo.
        if ( preg_match( '/^(.+?)\s+-\s+.+$/u', $name, $short ) ) {
            $name = trim( $short[1] );
        }
    }

    $name = trim( $name );
    if ( $name === '' || preg_match( '/^\d+$/', $name ) ) {
        continue;
    }

    $words_js[] = [
        'text'      => $name,
        'frequency' => $count ? $count : 1,
    ];
}
$words_json = wp_json_encode( $words_js, JSON_UNESCAPED_UNICODE );

$uid       = 'nuvem-' . get_the_ID() . '-' . get_row_index();
$bg_style  = $cor_fundo ? 'background-color:' . esc_attr( $cor_fundo ) . ';' : '';

$show_plus_logo = $titulo && preg_match( '/lilacs\s*plus/i', wp_strip_all_tags( (string) $titulo ) );
$plus_logo_src  = '';
if ( $show_plus_logo ) {
    $plus_logo_lang = 'pt';
    if ( function_exists( 'pll_current_language' ) ) {
        $lang_slug = pll_current_language( 'slug' );
        if ( in_array( $lang_slug, array( 'pt', 'en', 'es' ), true ) ) {
            $plus_logo_lang = $lang_slug;
        }
    }
    $plus_logo_file = 'assets/images/logos/lilacs_color_' . $plus_logo_lang . '.svg';
    if ( file_exists( get_template_directory() . '/' . $plus_logo_file ) ) {
        $plus_logo_src = get_template_directory_uri() . '/' . $plus_logo_file;
    }
}
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
#<?php echo esc_attr( $uid ); ?> .nuvem-lead {
    display: flex;
    align-items: flex-start;
    gap: 18px;
    margin: 0 0 40px;
}
#<?php echo esc_attr( $uid ); ?> .nuvem-logo {
    flex: 0 0 auto;
    width: auto;
    height: 52px;
    margin-top: 4px;
}
#<?php echo esc_attr( $uid ); ?> .nuvem-desc {
    font-family: 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    font-size: 18px;
    color: #555;
    line-height: 1.7;
    margin: 0;
    flex: 1 1 auto;
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
    white-space: nowrap;
    transition: background .2s ease, color .2s ease, transform .15s ease;
    line-height: 1.3;
}
#<?php echo esc_attr( $uid ); ?> .nuvem-word:hover {
    background: #003d7a;
    color: #fff;
    transform: scale(1.08);
}

@media (max-width: 768px) {
    #<?php echo esc_attr( $uid ); ?> { padding: 40px 16px; }
    #<?php echo esc_attr( $uid ); ?> .nuvem-title { font-size: 1.5rem; }
    #<?php echo esc_attr( $uid ); ?> .nuvem-logo { height: 44px; }
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

        <?php if ( $descricao || $plus_logo_src ) : ?>
            <div class="nuvem-lead">
                <?php if ( $plus_logo_src ) : ?>
                    <img class="nuvem-logo" src="<?php echo esc_url( $plus_logo_src ); ?>" alt="<?php echo esc_attr__( 'LILACS', 'rede-bvs' ); ?>">
                <?php endif; ?>
                <?php if ( $descricao ) : ?>
                    <p class="nuvem-desc"><?php echo esc_html( $descricao ); ?></p>
                <?php endif; ?>
            </div>
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

    function readWord(w) {
        var text = String(w && w.text || '').replace(/\u00a0/g, ' ').trim();
        var freq = Math.max(1, Number(w && w.frequency) || 1);
        var m = text.match(/^(.*)\((\d+)\)\s*$/);
        if (m && m[1].trim()) {
            text = m[1].trim();
            freq = parseInt(m[2], 10) || freq;
        } else if ((m = text.match(/^(.*\S)\s+(\d+)\s*$/))) {
            text = m[1].trim();
            freq = parseInt(m[2], 10) || freq;
            var shortName = text.match(/^(.+?)\s+-\s+.+$/);
            if (shortName) text = shortName[1].trim();
        }
        return { text: text, frequency: Math.max(1, freq) };
    }

    words = words.map(readWord).filter(function(w){ return w.text && !/^\d+$/.test(w.text); });
    if (!words.length) return;

    // Escala logarítmica: a diferença entre dezenas e mais de um milhão
    // de registros continua legível, e bases maiores ficam claramente maiores.
    var logs = words.map(function(w){ return Math.log(w.frequency); });
    var lmin = Math.min.apply(null, logs);
    var lmax = Math.max.apply(null, logs);
    var span = (lmax - lmin) || 1;

    words = words.slice().sort(function(){ return Math.random() - 0.5; });

    cloud.innerHTML = '';
    words.forEach(function(w){
        var n    = (Math.log(w.frequency) - lmin) / span;
        var size = 16 + n * 18;

        var elWord = document.createElement('span');
        elWord.className = 'nuvem-word';
        elWord.textContent = w.text;
        elWord.style.fontSize = size.toFixed(2) + 'px';
        elWord.style.fontWeight = n >= 0.66 ? '700' : (n >= 0.33 ? '600' : '500');
        cloud.appendChild(elWord);
    });
})();
</script>
