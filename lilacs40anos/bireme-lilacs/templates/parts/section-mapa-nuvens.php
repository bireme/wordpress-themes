<?php
// --- garantir o ID da página atual
global $post;
$post_id = get_queried_object_id();
if ( ! $post_id && $post instanceof WP_Post ) {
    $post_id = (int) $post->ID;
}
$post_id = (int) $post_id;

/* ================== HELPERS ================== */

// monta JSON de palavras a partir de uma meta (CSV ou quebra de linha)
function lilacs_build_words_json( $post_id, $meta_key, $fallback_words = [] ){
    $raw = $post_id ? get_post_meta( $post_id, $meta_key, true ) : '';
    if ($raw){
        $parts = preg_split('/[\r\n,]+/', $raw);
        $words_list = array_filter(array_map('trim', $parts));
    } else {
        $words_list = $fallback_words;
    }
    // normaliza em {text, frequency} com variação determinística
    $words_js = [];
    $base = 60; $i = 0;
    foreach($words_list as $w){
        if ($w === '') continue;
        $freq = $base + ($i % 10) * 3;
        $words_js[] = ['text'=>$w, 'frequency'=>intval($freq)];
        $i++;
    }
    return wp_json_encode($words_js, JSON_UNESCAPED_UNICODE);
}

// renderiza 1 bloco de nuvem com as classes do layout de referência
function lilacs_render_cloud_section( $args ){
    $defaults = [
        'id'                 => '',
        'title_meta'         => '',
        'desc_meta'          => '',
        'words_meta'         => '',
        'bg_meta'            => '',
        'space_top_meta'     => '',
        'space_bottom_meta'  => '',
        'title_default'      => '',
        'desc_default'       => '',
        'fallback_words'     => [],
        'post_id'            => 0,
    ];
    $a = wp_parse_args($args, $defaults);

    $title = $a['post_id'] ? get_post_meta($a['post_id'], $a['title_meta'], true) : '';
    $desc  = $a['post_id'] ? get_post_meta($a['post_id'], $a['desc_meta'],  true) : '';

    if (!$title) $title = $a['title_default'];
    if (!$desc)  $desc  = $a['desc_default'];

    $bg   = $a['post_id'] ? get_post_meta($a['post_id'], $a['bg_meta'], true) : '';
    $mt   = $a['post_id'] ? intval(get_post_meta($a['post_id'], $a['space_top_meta'], true)) : 0;
    $mb   = $a['post_id'] ? intval(get_post_meta($a['post_id'], $a['space_bottom_meta'], true)) : 0;

    $style = '';
    if ($mt || $mb) $style .= "margin-top:{$mt}px; margin-bottom:{$mb}px;";
    if ($bg)        $style .= " background-color:".esc_attr($bg).";";

    $words_json = lilacs_build_words_json(
        $a['post_id'],
        $a['words_meta'],
        $a['fallback_words']
    );
    ?>

    <!-- BLOCO: NUVEM DE PALAVRAS (layout referência) -->
    <section id="<?php echo esc_attr($a['id']); ?>" class="indexed-journals" style="<?php echo esc_attr($style); ?>">
        <div class="container">
            <?php if ($title): ?>
                <h2><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($desc): ?>
                <p><?php echo wp_kses_post( wpautop($desc) ); ?></p>
            <?php endif; ?>

            <div class="cloud-container">
                <div class="word-cloud lilacs-cloud" data-words='<?php echo $words_json; ?>'>
                    <!-- as palavras serão geradas por JS como <span class="word small|medium|large"> -->
                </div>
            </div>
        </div>
    </section>
    <?php
}

/* ================== 3 SEÇÕES ================== */

lilacs_render_cloud_section([
    'id'                => 'redes-tematicas',
    'title_meta'        => '_lilacs_redes_title',
    'desc_meta'         => '_lilacs_redes_desc',
    'words_meta'        => '_lilacs_redes_words',
    'bg_meta'           => '_lilacs_bg_redes',
    'space_top_meta'    => '_lilacs_redes_spacing_top',
    'space_bottom_meta' => '_lilacs_redes_spacing_bottom',
    'title_default'     => 'Redes Nacionais e Temáticas da LILACS',
    'desc_default'      => 'A LILACS é fortalecida por redes nacionais e temáticas que integram países e comunidades de prática na gestão e disseminação da informação científica em saúde.',
    'fallback_words'    => ['rede','países','cooperação','gestão','disseminação','comunidades de prática','bibliotecas','centros cooperantes','equidade','interoperabilidade'],
    'post_id'           => $post_id,
]);

lilacs_render_cloud_section([
    'id'                => 'lilacs-plus',
    'title_meta'        => '_lilacs_plus_title',
    'desc_meta'         => '_lilacs_plus_desc',
    'words_meta'        => '_lilacs_plus_words',
    'bg_meta'           => '_lilacs_bg_plus',
    'space_top_meta'    => '_lilacs_plus_spacing_top',
    'space_bottom_meta' => '_lilacs_plus_spacing_bottom',
    'title_default'     => 'O que é a LILACS Plus?',
    'desc_default'      => 'A LILACS Plus amplia o alcance da LILACS, conectando bases de dados, revistas e idiomas, promovendo a interoperabilidade global da ciência latino-americana.',
    'fallback_words'    => ['bases de dados','revistas','idiomas','interoperabilidade','alcance','integração','indexação','acesso aberto','qualidade','metadados'],
    'post_id'           => $post_id,
]);

lilacs_render_cloud_section([
    'id'                => 'ecossistema-lilacs',
    'title_meta'        => '_lilacs_ecos_title',
    'desc_meta'         => '_lilacs_ecos_desc',
    'words_meta'        => '_lilacs_ecos_words',
    'bg_meta'           => '_lilacs_bg_ecos',
    'space_top_meta'    => '_lilacs_ecos_spacing_top',
    'space_bottom_meta' => '_lilacs_ecos_spacing_bottom',
    'title_default'     => 'O Ecossistema LILACS',
    'desc_default'      => 'Formado por bases de dados, metodologias, ferramentas e redes de cooperação que sustentam a gestão e disseminação da informação científica em saúde na América Latina e Caribe.',
    'fallback_words'    => ['metodologias','DeCS','ferramentas','curadoria','qualificação','governança','padrões','Global Index Medicus','Cochrane','BIREME/OPAS/OMS'],
    'post_id'           => $post_id,
]);

?>
<!-- ================== CSS (layout de referência) ================== -->
<style>
/* container geral igual ao exemplo */
.lilacs-wordcloud .container,
.container { max-width: 1200px; margin: 0 auto; }

/* Seção: Revistas Indexadas (título/descrição) */
.indexed-journals { padding: 60px 0; }
.indexed-journals h2 {
    font-size: 2rem; color: #003d7a; margin-bottom: 15px; font-weight: 700;
}
.indexed-journals > p {
    font-size: 1rem; color: #555; margin-bottom: 40px; text-align: justify;
}

/* Word Cloud — mesmas classes do exemplo */
.cloud-container {
    background-color: #fff;
    padding: 60px 40px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
    min-height: 300px;
    display: flex; align-items: center; justify-content: center;
}
.word-cloud {
    width: 100%;
    display: flex; flex-wrap: wrap;
    gap: 15px; justify-content: center; align-items: center;
}
.word {
    padding: 8px 16px;
    background-color: #f0f0f0;
    color: #003d7a;
    border-radius: 20px;
    font-size: .9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all .3s ease;
}
.word:hover { background-color: #003d7a; color:#fff; transform: scale(1.1); }
.word.large  { font-size: 1.3rem; font-weight: 700; }
.word.medium { font-size: 1.1rem; font-weight: 600; }
.word.small  { font-size: .85rem; font-weight: 400; }

/* Responsivo como no exemplo */
@media (max-width: 768px){
  .indexed-journals { padding: 40px 0; }
  .indexed-journals h2 { font-size: 1.5rem; }
  .cloud-container { padding: 40px 20px; min-height: 250px; }
  .word-cloud { gap: 10px; }
  .word { padding: 6px 12px; font-size: .85rem; }
  .word.large  { font-size: 1.1rem; }
  .word.medium { font-size: .95rem; }
  .word.small  { font-size: .75rem; }
}
@media (max-width: 480px){
  .container { padding: 0 15px; }
  .indexed-journals h2 { font-size: 1.2rem; margin-bottom: 10px; }
  .indexed-journals > p { font-size: .9rem; margin-bottom: 30px; }
  .cloud-container { padding: 30px 15px; }
  .word { padding: 5px 10px; font-size: .8rem; }
}
</style>

<!-- ================== JS (gera as tags com classes small/medium/large) ================== -->
<script>
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.lilacs-cloud').forEach(function(el){
    let words = [];
    try { words = JSON.parse(el.getAttribute('data-words') || '[]'); }
    catch(e){ words = []; }

    if (!Array.isArray(words) || words.length === 0){
      el.innerHTML = '';
      return;
    }

    // min/max para normalizar
    const freqs = words.map(w => Number(w.frequency)||0);
    const fmin  = Math.min(...freqs);
    const fmax  = Math.max(...freqs);

    // embaralhar para visual “orgânico”
    words = [...words].sort(() => Math.random() - 0.5);

    // desenhar com classes small/medium/large
    el.innerHTML = '';
    words.forEach(function(w){
      const freq = Number(w.frequency)||0;
      const n = (freq - fmin) / ((fmax - fmin) || 1);
      const sizeClass = n >= .66 ? 'large' : (n >= .33 ? 'medium' : 'small');

      const tag = document.createElement('span');
      tag.className = 'word ' + sizeClass;
      tag.textContent = w.text;
      tag.setAttribute('data-frequency', freq);

      // opcional: tooltip simples com frequência
      tag.addEventListener('mouseenter', function(){
        const tt = document.createElement('div');
        tt.className = 'wc-tooltip';
        tt.textContent = 'Frequência: ' + freq;
        Object.assign(tt.style, {
          position:'absolute', background:'#003d7a', color:'#fff', padding:'5px 10px',
          borderRadius:'4px', fontSize:'.8rem', pointerEvents:'none', zIndex:'1000',
          whiteSpace:'nowrap'
        });
        document.body.appendChild(tt);
        const r = tag.getBoundingClientRect();
        tt.style.left = (r.left + r.width/2 - tt.offsetWidth/2) + 'px';
        tt.style.top  = (r.top - (tt.offsetHeight + 10)) + 'px';
        tag.addEventListener('mouseleave', ()=> tt.remove(), { once:true });
      });

      el.appendChild(tag);
    });
  });
});
</script>
