<style>
  .guides-faq-section{padding:40px 20px}
  .guides-faq-wrapper{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:flex-start}
  .guides-column{width:770px;display:flex;flex-direction:column;gap:12px}
  .guides-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
  .guide-btn{display:flex;align-items:center;gap:12px;padding:20px 16px;background:#00205C;color:#fff;border:none;border-radius:10px;cursor:pointer;font-size:18px;font-weight:600;transition:all .2s ease;text-align:left;text-decoration:none}
  .guide-btn:hover{transform:translateY(-2px);box-shadow:0 6px 12px rgba(13,59,102,.25);background:linear-gradient(135deg,#1a5490 0%,#2563a8 100%)}
  .guide-btn-large{grid-column:1 / -1}
  .btn-icon{font-size:16px;flex-shrink:0;display:inline-flex;align-items:center;justify-content:center}
  .btn-icon img{width:28px;height:28px;object-fit:cover;border-radius:6px;display:block}
  .btn-label{flex:1;line-height:1.3}
  .btn-arrow{font-size:14px;opacity:.7;transition:opacity .2s ease;padding:7px 12px;border-radius:99px;background:rgba(255,255,255,.15)}
  .guide-btn:hover .btn-arrow{opacity:1}
  .faq-column{background:#085695;border-radius:10px;padding:24px;color:#fff;min-height:85%}
  .faq-header{display:flex;justify-content:center;margin-bottom:20px}
  .faq-icon{font-size:32px}
  .faq-list{display:flex;flex-direction:column;gap:0}
  .faq-item{border-bottom:1px solid rgba(255,255,255,.15)}
  .faq-item:last-child{border-bottom:none}
  .faq-btn{width:100%;display:flex;align-items:center;justify-content:space-between;padding:12px 0;background:none;border:none;color:#fff;cursor:pointer;font-size:18px;font-weight:600;text-align:left;transition:all .2s ease;gap:20px}
  .faq-btn:hover{opacity:.9}
  .faq-text{flex:1}
  .faq-caret{font-size:12px;opacity:.7;transition:transform .2s ease;margin-left:8px}
  .faq-content{max-height:0;overflow:hidden;opacity:0;transition:max-height .2s ease,opacity .2s ease,padding .2s ease;padding:0}
  .faq-content.active{max-height:200px;opacity:1;padding:0 0 12px 0}
  .faq-content p{margin:0;font-size:12px;line-height:1.5;color:rgba(255,255,255,.85)}
  .faq-btn.active .faq-caret{transform:rotate(90deg)}
  @media (max-width:768px){
    .guides-faq-wrapper{grid-template-columns:1fr;gap:20px}
    .guides-grid{grid-template-columns:1fr}
    .guide-btn-large{grid-column:1}
  }
</style>

<?php
// ==== DADOS (com fallbacks p/ manter o layout se faltar meta) ====
$post_id = get_queried_object_id() ?: get_the_ID();

// GUIAS: chave => [rótulo padrão, é grande?]
$__guides = [
  'gestao'        => ['Manual de gestão', true],
  'descricao'     => ['Manual de descrição', false],
  'indexacao'     => ['Manual de indexação', false],
  'filtros'       => ['Filtros de busca', false],
  'nota_tecnica'  => ['Nota técnica', false],
  'boas_praticas' => ['Guia de boas práticas editoriais LILACS', true],
];

// helper: render de um “botão” de guia (mantém classes/estilo)
function metod_render_guide_btn($post_id, $key, $label_default, $large=false){
  $label   = get_post_meta($post_id, "_metod_{$key}_label",   true);
  $link    = get_post_meta($post_id, "_metod_{$key}_link",    true);
  $icon_id = (int) get_post_meta($post_id, "_metod_{$key}_icon_id", true);

  $label   = $label ?: $label_default;
  $icon    = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
  $classes = 'guide-btn' . ($large ? ' guide-btn-large' : '');
  $data    = esc_attr($key);
  $dataLink= esc_url($link ?: '#');

  // botão visual igual; usamos data-link para navegação via JS
  echo '<button class="'.esc_attr($classes).'" data-guide="'.$data.'" data-link="'.$dataLink.'">';
  echo '  <span class="btn-icon">';
  if ($icon){
    echo '    <img src="'.esc_url($icon).'" alt="">';
  } else {
    // fallback visual (mantém layout): emojis originais mais usados
    $emoji = in_array($key, ['filtros']) ? '🔍' : (in_array($key,['nota_tecnica']) ? '✏️' : '📖');
    if ($key === 'boas_praticas') $emoji = '📚';
    echo esc_html($emoji);
  }
  echo '  </span>';
  echo '  <span class="btn-label">'.esc_html($label).'</span>';
  echo '  <span class="btn-arrow">❯</span>';
  echo '</button>';
}

// FAQ (4 itens) com fallbacks
$faqs = [];
for($i=1; $i<=4; $i++){
  $t = get_post_meta($post_id, "_metod_faq{$i}_title", true);
  $c = get_post_meta($post_id, "_metod_faq{$i}_text",  true);
  // textos de exemplo (mantêm o visual se faltar conteúdo)
  if (!$t){
    $t = ['FI-Admin','BIREME Accounts','Manual do FI-Admin','Compatibilização MARC - LILACS'][$i-1];
  }
  if (!$c){
    $defaults = [
      'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
      'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
      'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.',
      'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores.'
    ];
    $c = $defaults[$i-1];
  }
  $faqs[$i] = ['title'=>$t, 'text'=>$c];
}
?>

<section class="guides-faq-section">
  <div class="guides-faq-wrapper">
    <!-- Lado Esquerdo: Botões dos Guias -->
    <div class="guides-column">
      <?php
        // 1ª linha: grande (gestao)
        metod_render_guide_btn($post_id, 'gestao', $__guides['gestao'][0], $__guides['gestao'][1]);
      ?>

      <div class="guides-grid">
        <?php
          metod_render_guide_btn($post_id, 'descricao', $__guides['descricao'][0], $__guides['descricao'][1]);
          metod_render_guide_btn($post_id, 'indexacao', $__guides['indexacao'][0], $__guides['indexacao'][1]);
        ?>
      </div>

      <div class="guides-grid">
        <?php
          metod_render_guide_btn($post_id, 'filtros', $__guides['filtros'][0], $__guides['filtros'][1]);
          metod_render_guide_btn($post_id, 'nota_tecnica', $__guides['nota_tecnica'][0], $__guides['nota_tecnica'][1]);
        ?>
      </div>

      <?php
        // última linha: grande (boas_praticas)
        metod_render_guide_btn($post_id, 'boas_praticas', $__guides['boas_praticas'][0], $__guides['boas_praticas'][1]);
      ?>
    </div>

    <!-- Lado Direito: FAQ -->
    <div class="faq-column">
      <div class="faq-header">
        <span class="faq-icon">⚙️</span>
      </div>

      <div class="faq-list">
        <?php foreach($faqs as $idx => $faq): ?>
          <div class="faq-item">
            <button class="faq-btn" data-faq="<?php echo esc_attr($idx); ?>">
              <span class="faq-caret">❯</span>
              <span class="faq-text"><?php echo esc_html($faq['title']); ?></span>
            </button>
            <div class="faq-content" id="faq-<?php echo esc_attr($idx); ?>">
              <p><?php echo wp_kses_post( wpautop($faq['text']) ); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<script>
  // Botões dos guias: se houver data-link válido, navega
  document.querySelectorAll('.guide-btn[data-guide]').forEach(function(btn){
    btn.addEventListener('click', function(){
      var link = this.getAttribute('data-link');
      if (link && link !== '#') {
        window.open(link, '_blank'); // mantém UX atual e não quebra layout
      } else {
        // fallback: comportamento anterior (apenas log)
        console.log('Guia clicado:', this.getAttribute('data-guide'));
      }
    });
  });

  // FAQ: abre/fecha
  document.querySelectorAll('.faq-btn').forEach(function(button){
    button.addEventListener('click', function(){
      var faqId = this.getAttribute('data-faq');
      var content = document.getElementById('faq-' + faqId);

      // fecha outros
      document.querySelectorAll('.faq-content.active').forEach(function(openContent){
        if (openContent.id !== 'faq-' + faqId) {
          openContent.classList.remove('active');
          var otherBtn = document.querySelector('[data-faq="' + openContent.id.split('-')[1] + '"]');
          otherBtn && otherBtn.classList.remove('active');
        }
      });

      // toggle atual
      content.classList.toggle('active');
      this.classList.toggle('active');
    });
  });
</script>
