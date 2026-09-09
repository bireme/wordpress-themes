<?php
/**
 * Dobra ACF: guias_faq
 * Layout: Botões dos Guias (esquerda) + Caixa de ferramentas (direita)
 * Chamado via lilacs_bvs_dobra('pagina-guias_faq') dentro de the_row()
 *
 * Sub_fields esperados (ACF):
 *   - guias (repeater): label, link, titulo, texto, botao_texto, icone (image url), grande (true_false)
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

  /* Caixas de chamada dos guias (título + descrição + botão) */
  .guides-cta-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 0;
  }
  .guide-cta {
    background: #f3f7fc;
    border: 1px solid #d7e4f2;
    border-radius: 10px;
    padding: 20px 18px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .guide-cta-title {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    line-height: 1.25;
    color: #00205C;
  }
  .guide-cta-text {
    margin: 0;
    font-size: 14px;
    line-height: 1.55;
    color: #334155;
  }
  .guide-cta-text p { margin: 0 0 6px; }
  .guide-cta-text p:last-child { margin-bottom: 0; }
  .guide-cta-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 18px;
    border-radius: 999px;
    background: #00205C;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: transform .15s ease, box-shadow .15s ease, background .15s ease;
    align-self: flex-start;
  }
  .guide-cta-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 18px rgba(0,32,92,.2);
    background: #085695;
    color: #fff;
  }

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
    .guides-column { width: 100%; }
    .toolbox-btn,
    .guide-cta-btn { width: 100%; }
  }
</style>

<section class="guides-faq-section">
  <div class="guides-faq-wrapper">

    <!-- Lado Esquerdo: chamadas dos guias (sem caixas azuis) -->
    <div class="guides-column">
      <?php
      $guias_com_caixa = array_filter( $guias, static function ( $g ) {
          $titulo = trim( (string) ( $g['titulo'] ?? '' ) );
          $texto  = trim( (string) ( $g['texto'] ?? '' ) );
          return $titulo !== '' || $texto !== '';
      } );
      ?>
      <?php if ( ! empty( $guias_com_caixa ) ) : ?>
        <div class="guides-cta-list" aria-label="Chamadas dos guias">
          <?php foreach ( $guias_com_caixa as $g ) :
            $titulo = trim( (string) ( $g['titulo'] ?? '' ) );
            $texto  = trim( (string) ( $g['texto'] ?? '' ) );
            $btn_t  = trim( (string) ( $g['botao_texto'] ?? '' ) );
            if ( $btn_t === '' ) $btn_t = 'Acessar';
            $btn_l  = trim( (string) ( $g['link'] ?? '' ) );
          ?>
            <article class="guide-cta">
              <?php if ( $titulo !== '' ) : ?>
                <h3 class="guide-cta-title"><?php echo esc_html( $titulo ); ?></h3>
              <?php endif; ?>

              <?php if ( $texto !== '' ) : ?>
                <div class="guide-cta-text"><?php echo wp_kses_post( wpautop( $texto ) ); ?></div>
              <?php endif; ?>

              <?php if ( $btn_t !== '' && $btn_l !== '' ) : ?>
                <a class="guide-cta-btn"
                   href="<?php echo esc_url( $btn_l ); ?>"
                   target="_blank"
                   rel="noopener">
                  <?php echo esc_html( $btn_t ); ?>
                </a>
              <?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
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
