<?php
/**
 * Dobra ACF: guias_faq
 * Layout: Botões dos Guias (esquerda) + Caixa de ferramentas (direita)
 * Chamado via lilacs_bvs_dobra('pagina-guias_faq') dentro de the_row()
 *
 * Sub_fields esperados (ACF):
 *   - guias (repeater): label, link, icone (image url), grande (true_false)
 *   - caixa_ferramentas (repeater): titulo, texto, botao_texto, botao_link
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$guias = get_sub_field( 'guias' );
if ( ! is_array( $guias ) ) $guias = [];

$ferramentas = get_sub_field( 'caixa_ferramentas' );
if ( ! is_array( $ferramentas ) ) $ferramentas = [];

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
if ( empty( $ferramentas ) ) {
    $ferramentas = [
        [
            'titulo'      => 'FI-Admin',
            'texto'       => 'Acesse o sistema FI-Admin para começar a contribuir.',
            'botao_texto' => 'Acessar',
            'botao_link'  => 'https://fi-admin.bvsalud.org/',
        ],
    ];
}
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

  /* Caixa de ferramentas */
  .toolbox-column {
    background: #085695;
    border-radius: 10px;
    padding: 28px 24px;
    color: #fff;
    min-height: 85%;
    display: flex;
    flex-direction: column;
    gap: 0;
  }
  .toolbox-header { display: flex; justify-content: center; margin-bottom: 16px; }
  .toolbox-icon { font-size: 32px; line-height: 1; }
  .toolbox-list { display: flex; flex-direction: column; gap: 0; }
  .toolbox-item {
    padding: 16px 0;
    border-bottom: 1px solid rgba(255,255,255,.15);
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .toolbox-item:first-child { padding-top: 0; }
  .toolbox-item:last-child { border-bottom: none; padding-bottom: 0; }
  .toolbox-title {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    line-height: 1.25;
    color: #fff;
  }
  .toolbox-text {
    margin: 0;
    font-size: 13px;
    line-height: 1.55;
    color: rgba(255,255,255,.9);
  }
  .toolbox-text p { margin: 0 0 6px; }
  .toolbox-text p:last-child { margin-bottom: 0; }
  .toolbox-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 18px;
    border-radius: 999px;
    background: #fff;
    color: #085695;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: transform .15s ease, box-shadow .15s ease;
    align-self: flex-start;
  }
  .toolbox-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 18px rgba(0,0,0,.2);
    color: #085695;
  }

  @media (max-width: 768px) {
    .guides-faq-wrapper { grid-template-columns: 1fr; gap: 20px; }
    .guides-grid { grid-template-columns: 1fr; }
    .guides-column { width: 100%; }
    .toolbox-btn { width: 100%; }
  }
</style>

<?php
// Agrupa guias: itens "grande" ficam sozinhos; os demais são agrupados em pares
$groups = [];
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

    <!-- Lado Direito: Caixa de ferramentas -->
    <aside class="toolbox-column" aria-label="Caixa de ferramentas">
      <div class="toolbox-header">
        <span class="toolbox-icon" aria-hidden="true">⚙️</span>
      </div>

      <div class="toolbox-list">
        <?php foreach ( $ferramentas as $item ) :
          $titulo = trim( (string) ( $item['titulo'] ?? '' ) );
          $texto  = trim( (string) ( $item['texto'] ?? '' ) );
          $btn_t  = trim( (string) ( $item['botao_texto'] ?? '' ) );
          $btn_l  = trim( (string) ( $item['botao_link'] ?? '' ) );
          if ( $titulo === '' && $texto === '' ) continue;
        ?>
          <div class="toolbox-item">
            <?php if ( $titulo !== '' ) : ?>
              <h3 class="toolbox-title"><?php echo esc_html( $titulo ); ?></h3>
            <?php endif; ?>

            <?php if ( $texto !== '' ) : ?>
              <div class="toolbox-text"><?php echo wp_kses_post( wpautop( $texto ) ); ?></div>
            <?php endif; ?>

            <?php if ( $btn_t !== '' && $btn_l !== '' ) : ?>
              <a class="toolbox-btn"
                 href="<?php echo esc_url( $btn_l ); ?>"
                 target="_blank"
                 rel="noopener">
                <?php echo esc_html( $btn_t ); ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </aside>

  </div>
</section>

<script>
(function(){
  document.querySelectorAll('.guide-btn[data-link]').forEach(function(btn){
    btn.addEventListener('click', function(){
      var link = this.getAttribute('data-link');
      if (link && link !== '#') { window.open(link, '_blank'); }
    });
  });
})();
</script>
