<section id="lilacs-audiences" aria-label="Acesso rápido por público">
    
    
    <?php 
        $post_id = get_queried_object_id() ?: get_the_ID();
    
    $titulo  = get_post_meta( $post_id, "_bireme_aud_title", true );  ?>
    
    
<header class="aud-header">
  <h2 class="aud-section-title"><?=$titulo?></h2>
</header>


  <style>
  /* ===== Título da seção ===== */
#lilacs-audiences .aud-header{
  max-width: 1280px;
  margin: 0 auto 40px;
  text-align: left;
}

#lilacs-audiences .aud-section-title{
    font-family: 'Noto Sans', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    font-size: 36px;
    font-weight: 700;
    line-height: 1.15;
    color: #fff;
    margin: 0;
}

/* Responsivo */
@media (max-width: 880px){
  #lilacs-audiences .aud-section-title{
    font-size: 30px;
  }
}

    /* ===== Fundo e container ===== */
    #lilacs-audiences{
      position: relative;
      padding: 105px 20px 105px;
      background-image:url(https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/Mask-group.png);
       overflow: hidden;
    }
    /* texturas/geometrias leves no fundo */
    #lilacs-audiences::before, #lilacs-audiences::after{
      content:"";
      position:absolute; inset:auto auto -18% -18%;
      width: 60vw; height: 60vw; border-radius: 50%;
      background: radial-gradient(closest-side, rgba(255,255,255,.06), transparent 70%);
      transform: rotate(-12deg);
      pointer-events: none;
    }
    #lilacs-audiences::after{
      inset: -22% -22% auto auto;
      transform: rotate(18deg);
    }

    #lilacs-audiences .aud-wrap{
      max-width: 1280px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }

    /* ===== Card ===== */
    #lilacs-audiences .aud-card{
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 12px 28px rgba(3,10,24,.20);
      padding: 18px 18px 16px;
      display: grid;
      grid-template-rows: auto auto 0.7fr auto;
      min-height: 220px;
      transition: transform .18s ease, box-shadow .18s ease;
    }
    #lilacs-audiences .aud-card:hover{
      transform: translateY(-2px);
      box-shadow: 0 16px 34px rgba(3,10,24,.25);
    }

    /* Ícone topo */
    #lilacs-audiences .aud-icon{
      width: 44px; height: 8px;
      margin-bottom: 10px;
      color: #072a53; /* azul escuro */
      flex: 0 0 auto;
    }
    #lilacs-audiences .aud-icon svg{
      width: 100%; height: 100%; display: block;
    }

    /* Títulos */
    #lilacs-audiences .aud-kicker{
      font: 700 14px/1 "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      color: #0a5fa1; /* azul mais claro */
      margin-bottom: 2px;
      line-height:0;
    }
      #lilacs-audiences .aud-title{
        color: #00205C;
        font-family: 'Noto Sans';
        font-size: 32px;
        font-weight: 700;
        line-height: 32px;
        margin: 0 !important;
    }
    #lilacs-audiences .aud-kicker{
          color: #F96A1E;
    font-family: 'Noto Sans';
    font-weight: 700;
    font-size: 18px;
    }

    /* Lista com “triangulinhos” */
    #lilacs-audiences .aud-list{
      list-style: none;
      margin: 0 0 8px;
      padding: 0;
      color: #1c2b3d;
      font: 500 14px/1.55 "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }
    #lilacs-audiences .aud-list li{
position: relative;
    padding-left: 14px;
    margin: 6px 0;
    font-family: 'Noto Sans';
    font-size: 18px;
    font-weight: 500;
    }
    #lilacs-audiences .aud-list li::before{
      content:"";
      position:absolute; left:0; top:.58em;
      width: 0; height: 0;
      border-left: 6px solid #0e315b;   /* triângulo azul */
      border-top: 4px solid transparent;
      border-bottom: 4px solid transparent;
    }

    /* destaque para o último item da lista */
    #lilacs-audiences .aud-list li.is-last{
      color: #F96A1E;
    }
    #lilacs-audiences .aud-list li.is-last::before{
      border-left-color: #F96A1E;
    }

    /* Link “Outras informações” */
    #lilacs-audiences .aud-more{
      margin-top: 6px;
      font: 700 14px/1 "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      color: #f96a1e;                 /* laranja */
      text-decoration: none;
      display: inline-block;
      display:none;
    }
    #lilacs-audiences .aud-more:hover{ text-decoration: underline; }

    /* Responsivo */
    @media (max-width: 1024px){
      #lilacs-audiences .aud-wrap{ gap: 18px; }
    }
    @media (max-width: 880px){
      #lilacs-audiences .aud-wrap{ grid-template-columns: 1fr; }
    }
  </style>
    
  <div class="aud-wrap">


    <?php


    // Tenta ler os cards dinâmicos do painel (meta _bireme_aud_{i}_*)
    $cards = array();
    for ( $i = 1; $i <= 3; $i++ ) {
        $kicker    = get_post_meta( $post_id, "_bireme_aud_{$i}_kicker", true );
        $title     = get_post_meta( $post_id, "_bireme_aud_{$i}_title", true );
        $icon_id   = (int) get_post_meta( $post_id, "_bireme_aud_{$i}_icon_id", true );
        $items_raw = get_post_meta( $post_id, "_bireme_aud_{$i}_items", true );
        $more_text = get_post_meta( $post_id, "_bireme_aud_{$i}_more_text", true );
        $more_url  = get_post_meta( $post_id, "_bireme_aud_{$i}_more_url", true );

        // items podem estar salvos como array ou string (nova linha)
        $items = array();
        if ( is_array( $items_raw ) ) {
            $items = $items_raw;
        } elseif ( is_string( $items_raw ) && $items_raw !== '' ) {
            $maybe = json_decode( $items_raw, true );
            if ( is_array( $maybe ) ) {
                $items = $maybe;
            } else {
                $items = array_filter( array_map( 'trim', preg_split("/\r\n|\n|\r/", $items_raw ) ) );
            }
        }
    // Normaliza itens aceitando tanto strings quanto arrays ['label'=>..,'url'=>..]
    $normalized = array();
    foreach ((array) $items as $it) {
      if (is_array($it)) {
        // suporta ['label'=>...,'url'=>...] ou [0=>'label',1=>'url']
        $label = isset($it['label']) ? $it['label'] : (isset($it[0]) ? $it[0] : '');
        $url = isset($it['url']) ? $it['url'] : (isset($it[1]) ? $it[1] : '');
        $label = trim((string) $label);
        $url = trim((string) $url);
        if ($label !== '') {
          $normalized[] = array('label' => $label, 'url' => $url);
        }
      } else {
        $s = trim((string) $it);
        if ($s !== '') $normalized[] = $s;
      }
    }
    $items = array_values($normalized);

        // monta HTML do ícone: prefere attachment (id), senão tenta meta antiga icon_svg
        $icon_html = '';
        if ( $icon_id ) {
            $icon_html = wp_get_attachment_image( $icon_id, 'full', false, array( 'class' => 'aud-icon-img', 'alt' => '' ) );
        }
        if ( ! $icon_html ) {
            $old_svg = get_post_meta( $post_id, "lilacs_aud_card_{$i}_icon_svg", true );
            if ( $old_svg ) {
                $icon_html = wp_kses( $old_svg, array(
                    'svg'  => array( 'viewBox' => true, 'fill' => true, 'xmlns' => true ),
                    'path' => array( 'd' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true ),
                ) );
            }
        }

        // adiciona card apenas se houver algum conteúdo
        if ( $kicker || $title || ! empty( $items ) || $icon_html || $more_text || $more_url ) {
            $cards[] = array(
                'kicker'     => $kicker,
                'title'      => $title,
                'items'      => $items,
                'more_text'  => $more_text,
                'more_url'   => $more_url,
                'icon_html'  => $icon_html,
            );
        }
    }

    // Se nenhum card dinâmico, mantém conteúdo default (como antes)
    if ( empty( $cards ) ) {
        $cards = array(
            array(
                'kicker' => 'Para você',
                'title'  => 'Usuário',
                'items'  => array(
                    'Pesquise na LILACS',
                    'Use o DeCS para refinar sua busca',
                    'Acesse guias de pesquisas',
                    'Salve e compartilhe resultados',
                    'Explore recursos adicionais da BVS',
                ),
                'more_text' => 'Outras informações',
                'more_url'  => '#usuario-mais',
                'icon_html' => '<svg viewBox="0 0 24 24" fill="none"><path d="M4 19V5M10 19V9M16 19V3M22 19H2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
            ),
            array(
                'kicker' => 'Para sua',
                'title'  => 'Revista',
                'items'  => array(
                    'Indexe sua revista',
                    'Acompanhe o status de atualização',
                    'Consulte o seu código de editor',
                    'Acesse guias e orientações para editores',
                ),
                'more_text' => 'Outras informações',
                'more_url'  => '#revista-mais',
                'icon_html' => '<svg viewBox="0 0 24 24" fill="none"><path d="M4 20l4.5-1 10.5-10.5a2.12 2.12 0 0 0-3-3L5.5 16 4 20Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M13.5 6.5l3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
            ),
            array(
                'kicker' => 'Para sua',
                'title'  => 'Instituição',
                'items'  => array(
                    'Quero me tornar um Centro Cooperante',
                    'Estatísticas de contribuição da sua instituição',
                    'Atualização de dados cadastrais',
                    'Diretório da rede LILACS',
                ),
                'more_text' => 'Outras informações',
                'more_url'  => '#instituicao-mais',
                'icon_html' => '<svg viewBox="0 0 24 24" fill="none"><path d="M16 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2"/><path d="M8 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2"/><path d="M2 20a6 6 0 0 1 12 0M10 20a6 6 0 0 1 12 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
            ),
        );
    }

    // Renderiza os cards (até 3)
    $count = 0;
    foreach ( $cards as $card ) {
        if ( $count >= 3 ) break;
        $kicker     = isset( $card['kicker'] ) ? $card['kicker'] : '';
        $title      = isset( $card['title'] ) ? $card['title'] : '';
        $items      = isset( $card['items'] ) && is_array( $card['items'] ) ? $card['items'] : array();
        $more_label = isset( $card['more_label'] ) ? $card['more_label'] : 'Outras informações';
        $more_url   = isset( $card['more_url'] ) ? $card['more_url'] : '#';
        $icon_svg   = isset( $card['icon_svg'] ) ? $card['icon_svg'] : '';

        ?>
        <article class="aud-card">
          <div class="aud-icon" aria-hidden="true">
            <?php
            // icon_html pode ser <img> (attachment) ou inline SVG (from old meta). já sanitizado onde necessário.
            if ( ! empty( $card['icon_html'] ) ) {
                echo $card['icon_html'];
            }
            ?>
          </div>

          <?php if ( $kicker ) : ?>
            <div class="aud-kicker"><?php echo esc_html( $kicker ); ?></div>
          <?php endif; ?>

          <?php if ( $title ) : ?>
            <h3 class="aud-title"><?php echo esc_html( $title ); ?></h3>
          <?php endif; ?>

          <?php if ( ! empty( $items ) ) : ?>
            <ul class="aud-list">
              <?php
                $lastIndex = count( $items ) - 1;
                foreach ( $items as $idx => $li ) :
                  $cls = ( $idx === $lastIndex ) ? 'is-last' : '';
              ?>
        <?php
        // Suporta tanto string quanto ['label'=>..,'url'=>..]
        if ( is_array( $li ) ) {
          $label = isset( $li['label'] ) ? $li['label'] : (isset($li[0]) ? $li[0] : '');
          $url   = isset( $li['url'] ) ? $li['url'] : (isset($li[1]) ? $li[1] : '');
          if ( $url ) {
            echo '<li class="' . esc_attr( $cls ) . '"><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
          } else {
            echo '<li class="' . esc_attr( $cls ) . '">' . esc_html( $label ) . '</li>';
          }
        } else {
          echo '<li class="' . esc_attr( $cls ) . '">' . esc_html( $li ) . '</li>';
        }
        ?>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <a class="aud-more" href="<?php echo esc_url( $more_url ); ?>" aria-label="<?php echo esc_attr( $more_label ); ?>"><?php echo esc_html( $more_label ); ?></a>
        </article>
        <?php
        $count++;
    }
    ?>
  </div>
</section>
