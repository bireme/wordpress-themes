<?php
// inserido: carregar dados dinâmicos a partir das metas definidas no page-lilacs-sobre-fields.php
$post_id = get_queried_object_id() ?: ( isset($post->ID) ? $post->ID : 0 );
$voices_title = $post_id ? get_post_meta( $post_id, '_lilacs_voices_title', true ) : '';
$voices_items = [];
for ( $v = 1; $v <= 6; $v++ ) {
    $name   = get_post_meta( $post_id, "_lilacs_voice_{$v}_name", true );
    $role   = get_post_meta( $post_id, "_lilacs_voice_{$v}_role", true );
    $text   = get_post_meta( $post_id, "_lilacs_voice_{$v}_text", true );
    $avatar = get_post_meta( $post_id, "_lilacs_voice_{$v}_avatar", true );
    // only add if there's some meaningful content
    if ( $name || $role || $text || $avatar ) {
        $voices_items[] = [
            'name' => $name,
            'role' => $role,
            'text' => $text,
            'avatar_url' => $avatar,
        ];
    }
}
// fallback: if no metas and $dp['items'] exists, preserve previous behavior
if ( empty( $voices_items ) && isset( $dp['items'] ) && is_array( $dp['items'] ) ) {
    $voices_items = $dp['items'];
}
if ( ! $voices_title ) {
    $voices_title = 'Vozes da Rede LILACS';
}

// --- NOVO: cor de fundo (Vozes) ---
$bg_voices = $post_id ? get_post_meta( $post_id, '_lilacs_bg_voices', true ) : '';
$section_style = '';
if ( $bg_voices ) {
    $section_style = 'background-color:#00205C;';
}
?>
<section id="lilacs-dep" aria-label="Vozes da Rede LILACS" <?php if ( $section_style ) : ?> style="<?php echo esc_attr( $section_style ); ?>"<?php endif; ?>>
  <style>
  <?php echo <<<'CSS'
  #lilacs-dep{
    /* Fundo escuro conforme a imagem. */
    padding: 65px 20px 65px;
    background-color: #00205C; /* Cor azul-marinho escura */
  }
  #lilacs-dep .dep-wrap{max-width:1280px;margin:0 auto}
  
  /* Ajuste no título: Fonte, tamanho, cor branca para o fundo escuro */
  #lilacs-dep .dep-title{
    font-family: 'Noto Sans';
    font-size: 32px; /* Ligeiramente menor que o original, mais próximo da imagem */
    font-weight: 700;
    color: #fff;
    line-height: 100%;
    margin-bottom: 30px; /* Adiciona um espaço abaixo do título */
  }

  /* Mudança crucial: 3 colunas para a grade de depoimentos */
  #lilacs-dep .dep-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px}
  
  /* Media Query para telas menores */
  @media (max-width:1200px){#lilacs-dep .dep-grid{grid-template-columns:1fr 1fr}} /* 2 colunas em tablets */
  @media (max-width:680px){#lilacs-dep .dep-grid{grid-template-columns:1fr}} /* 1 coluna em mobiles */

  /* Cartão de Depoimento - O estilo de gradiente está perfeito para a imagem */
  #lilacs-dep .dep-card{
    position: relative;
    border-radius: 8px; /* Ligeiramente menos arredondado */
    padding: 24px; /* Mais espaço interno */
    color: #fff;
    /* Gradiente roxo/azul igual ao da imagem */
    background: linear-gradient(135deg, #9453BD 0%, #085695 100%); 
    box-shadow: none; /* Remove a sombra para ficar mais flat como na imagem */
    min-height: 240px; /* Ajuste a altura se necessário, ou remova para auto */
  }
  
  /* Estilo da Cabeça (Avatar + Nome/Profissão) */
  #lilacs-dep .dep-head{display:flex;align-items:center;gap:12px;margin-bottom:20px}
  #lilacs-dep .dep-avatar{
    /* A imagem é um círculo branco simples */
    width: 60px;
    height: 60px;
    border-radius:999px;
    overflow:hidden;
    background:rgba(255,255,255,.85);
    flex-shrink: 0;
  }
  #lilacs-dep .dep-avatar img{width:100%;height:100%;object-fit:cover;display:block}
  
  /* Estilos do Nome */
  #lilacs-dep .dep-name{
    margin: 0;
    font-family: 'Noto Sans';
    font-size: 20px;
    font-weight: 700;
  }
  
  /* Estilos da Profissão */
  #lilacs-dep .dep-role{
    margin: 0;
    font-family: 'Noto Sans';
    font-size: 16px; /* Ajuste de tamanho */
    font-weight: 400;
    opacity: 0.9;
  }
  
  /* Estilos do Texto do Depoimento */
  #lilacs-dep .dep-text{
    margin: 0; /* Remove a margem superior desnecessária */
    font-size: 14px;
    font-weight: 400;
    font-family: 'Noto Sans';
    line-height: 150%;
    padding-left: 0; /* Remove o padding da frente */
  }
  CSS; ?>
  </style>

  <div class="dep-wrap">
    <h2 class="dep-title"><?php echo esc_html( $voices_title ); ?></h2>

    <div class="dep-grid">
      <?php foreach( $voices_items as $it ):
        $name = trim( $it['name'] ?? '' ); if ( $name === '' ) continue;
        $role = trim( $it['role'] ?? '' );
        $text = trim( $it['text'] ?? '' );
        $img  = esc_url( $it['avatar_url'] ?? '' );
      ?>
        <article class="dep-card">
          <div class="dep-head">
            <span class="dep-avatar"><?php if($img): ?><img src="<?php echo $img; ?>" alt="<?php echo esc_attr($name); ?>"><?php endif; ?></span>
            <div>
              <p class="dep-name"><?php echo esc_html($name); ?></p>
              <?php if($role!==''): ?><p class="dep-role"><?php echo esc_html($role); ?></p><?php endif; ?>
            </div>
          </div>
          <?php if($text!==''): ?><p class="dep-text"><?php echo esc_html($text); ?></p><?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

