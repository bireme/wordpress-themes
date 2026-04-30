<?php
/**
 * Dobra ACF: guias_faq
 * Layout: Botões dos Guias (esquerda) + Accordion FAQ (direita)
 * Chamado via lilacs_bvs_dobra('pagina-guias_faq') dentro de the_row()
 *
 * Sub_fields esperados (ACF):
 *   - guias (repeater): label, link, icone (image url), grande (true_false)
 *   - faq   (repeater): titulo, texto
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$guias = get_sub_field( 'guias' );
$faqs  = get_sub_field( 'faq' );
if ( ! is_array( $guias ) ) $guias = [];
if ( ! is_array( $faqs ) )  $faqs  = [];

// Fallbacks para manter o layout visual se não houver conteúdo ainda
if ( empty( $guias ) ) {
    $guias = [
        [ 'label' => 'Manual de gestão',                          'link' => '#', 'icone' => '', 'grande' => true  ],
        [ 'label' => 'Manual de descrição',                       'link' => '#', 'icone' => '', 'grande' => false ],
        [ 'label' => 'Manual de indexação',                       'link' => '#', 'icone' => '', 'grande' => false ],
        [ 'label' => 'Filtros de busca',                          'link' => '#', 'icone' => '', 'grande' => false ],
        [ 'label' => 'Nota técnica',                              'link' => '#', 'icone' => '', 'grande' => false ],
        [ 'label' => 'Guia de boas práticas editoriais LILACS',   'link' => '#', 'icone' => '', 'grande' => true  ],
    ];
}
if ( empty( $faqs ) ) {
    $faqs = [
        [ 'titulo' => 'FI-Admin',                              'texto' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' ],
        [ 'titulo' => 'BIREME Accounts',                       'texto' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.' ],
        [ 'titulo' => 'Manual do FI-Admin',                    'texto' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.' ],
        [ 'titulo' => 'Compatibilização MARC - LILACS',        'texto' => 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores.' ],
    ];
}

// Separa guias "grandes" (largura total) dos normais para montar o grid preservando a lógica original
// O primeiro "grande" vai sozinho, depois vêm pares em grid, o último "grande" fecha
// Novo comportamento: a flag `grande` de cada item controla isso dinamicamente.
?>

<style>
  .guides-faq-section { padding: 40px 20px; }
  .guides-faq-wrapper { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr; gap: 20px; align-items: flex-start; }
  .guides-column { display: flex; flex-direction: column; gap: 12px; }
  .guides-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .guide-btn { display: flex; align-items: center; gap: 12px; padding: 20px 16px; background: #00205C; color: #fff; border: none; border-radius: 10px; cursor: pointer; font-size: 18px; font-weight: 600; transition: all .2s ease; text-align: left; text-decoration: none; width: 100%; box-sizing: border-box; }
  .guide-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 12px rgba(13,59,102,.25); background: linear-gradient(135deg,#1a5490 0%,#2563a8 100%); }
  .guide-btn-large { width: 100%; }
  .btn-icon { font-size: 16px; flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center; }
  .btn-icon img { width: 28px; height: 28px; object-fit: cover; border-radius: 6px; display: block; }
  .btn-label { flex: 1; line-height: 1.3; }
  .btn-arrow { font-size: 14px; opacity: .7; transition: opacity .2s ease; padding: 7px 12px; border-radius: 99px; background: rgba(255,255,255,.15); }
  .guide-btn:hover .btn-arrow { opacity: 1; }
  .faq-column { background: #085695; border-radius: 10px; padding: 24px; color: #fff; min-height: 85%; }
  .faq-header { display: flex; justify-content: center; margin-bottom: 20px; }
  .faq-icon { font-size: 32px; }
  .faq-list { display: flex; flex-direction: column; gap: 0; }
  .faq-item { border-bottom: 1px solid rgba(255,255,255,.15); }
  .faq-item:last-child { border-bottom: none; }
  .faq-btn { width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 12px 0; background: none; border: none; color: #fff; cursor: pointer; font-size: 18px; font-weight: 600; text-align: left; transition: all .2s ease; gap: 20px; }
  .faq-btn:hover { opacity: .9; }
  .faq-text { flex: 1; }
  .faq-caret { font-size: 12px; opacity: .7; transition: transform .2s ease; margin-left: 8px; }
  .faq-content { max-height: 0; overflow: hidden; opacity: 0; transition: max-height .2s ease, opacity .2s ease, padding .2s ease; padding: 0; }
  .faq-content.active { max-height: 200px; opacity: 1; padding: 0 0 12px 0; }
  .faq-content p { margin: 0; font-size: 12px; line-height: 1.5; color: rgba(255,255,255,.85); }
  .faq-btn.active .faq-caret { transform: rotate(90deg); }
  @media (max-width: 768px) {
    .guides-faq-wrapper { grid-template-columns: 1fr; gap: 20px; }
    .guides-grid { grid-template-columns: 1fr; }
    .guides-column { width: 100%; }
  }
</style>

<?php
// Agrupa guias: itens "grande" ficam sozinhos; os demais são agrupados em pares
$groups = []; // cada entry: [ 'large' => bool, 'items' => [...] ]
$pair_buffer = [];

foreach ( $guias as $g ) {
    $is_large = ! empty( $g['grande'] );
    if ( $is_large ) {
        if ( ! empty( $pair_buffer ) ) {
            $groups[] = [ 'large' => false, 'items' => $pair_buffer ];
            $pair_buffer = [];
        }
        $groups[] = [ 'large' => true, 'items' => [ $g ] ];
    } else {
        $pair_buffer[] = $g;
        if ( count( $pair_buffer ) === 2 ) {
            $groups[] = [ 'large' => false, 'items' => $pair_buffer ];
            $pair_buffer = [];
        }
    }
}
if ( ! empty( $pair_buffer ) ) {
    $groups[] = [ 'large' => false, 'items' => $pair_buffer ];
}

$uid = 'gfaq-' . wp_unique_id();
?>

<section class="guides-faq-section">
  <div class="guides-faq-wrapper">

    <!-- Lado Esquerdo: Botões dos Guias -->
    <div class="guides-column">
      <?php foreach ( $groups as $group ) :
        if ( $group['large'] ) :
          $g     = $group['items'][0];
          $label = esc_html( (string) ( $g['label'] ?? '' ) );
          $link  = esc_url( (string) ( $g['link']  ?? '#' ) );
          $icon  = (string) ( $g['icone'] ?? '' );
        ?>
          <button class="guide-btn guide-btn-large" data-link="<?php echo $link; ?>">
            <span class="btn-icon">
              <?php if ( $icon ) : ?><img src="<?php echo esc_url( $icon ); ?>" alt=""><?php else : ?>📖<?php endif; ?>
            </span>
            <span class="btn-label"><?php echo $label; ?></span>
            <span class="btn-arrow">❯</span>
          </button>
        <?php else : ?>
          <div class="guides-grid">
            <?php foreach ( $group['items'] as $g ) :
              $label = esc_html( (string) ( $g['label'] ?? '' ) );
              $link  = esc_url( (string) ( $g['link']  ?? '#' ) );
              $icon  = (string) ( $g['icone'] ?? '' );
            ?>
              <button class="guide-btn" data-link="<?php echo $link; ?>">
                <span class="btn-icon">
                  <?php if ( $icon ) : ?><img src="<?php echo esc_url( $icon ); ?>" alt=""><?php else : ?>📖<?php endif; ?>
                </span>
                <span class="btn-label"><?php echo $label; ?></span>
                <span class="btn-arrow">❯</span>
              </button>
            <?php endforeach; ?>
          </div>
        <?php endif;
      endforeach; ?>
    </div>

    <!-- Lado Direito: FAQ -->
    <div class="faq-column">
      <div class="faq-header">
        <span class="faq-icon">⚙️</span>
      </div>
      <div class="faq-list">
        <?php foreach ( $faqs as $idx => $faq ) :
          $faq_id    = esc_attr( $uid . '-' . $idx );
          $faq_title = (string) ( $faq['titulo'] ?? '' );
          $faq_text  = (string) ( $faq['texto']  ?? '' );
        ?>
          <div class="faq-item">
            <button class="faq-btn" data-faq="<?php echo $faq_id; ?>">
              <span class="faq-caret">❯</span>
              <span class="faq-text"><?php echo esc_html( $faq_title ); ?></span>
            </button>
            <div class="faq-content" id="faq-<?php echo $faq_id; ?>">
              <p><?php echo wp_kses_post( wpautop( $faq_text ) ); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</section>

<script>
(function(){
  // Botões dos guias: navega ao clicar
  document.querySelectorAll('.guide-btn[data-link]').forEach(function(btn){
    btn.addEventListener('click', function(){
      var link = this.getAttribute('data-link');
      if (link && link !== '#') { window.open(link, '_blank'); }
    });
  });

  // FAQ accordion
  document.querySelectorAll('.faq-btn').forEach(function(button){
    button.addEventListener('click', function(){
      var faqId  = this.getAttribute('data-faq');
      var content = document.getElementById('faq-' + faqId);
      if (!content) return;

      // fecha outros da mesma seção
      var section = this.closest('.faq-list');
      if (section) {
        section.querySelectorAll('.faq-content.active').forEach(function(el){
          if (el.id !== 'faq-' + faqId) {
            el.classList.remove('active');
            var otherBtn = section.querySelector('[data-faq="' + el.id.replace('faq-','') + '"]');
            if (otherBtn) otherBtn.classList.remove('active');
          }
        });
      }

      content.classList.toggle('active');
      button.classList.toggle('active');
    });
  });
})();
</script>
