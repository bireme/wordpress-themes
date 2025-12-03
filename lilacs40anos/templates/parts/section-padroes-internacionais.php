<style>
/* ===== Padrões internacionais (barra de logos) ===== */
.padroes-inter-section{width:100%}
.padroes-inter-content{
  max-width:1200px;margin:0 auto;
  padding:60px 20px;
  display:flex;align-items:center;justify-content:space-between;gap:32px;
}
.padroes-inter-section .content-text{
  flex:0 0 320px; /* fixa área do título (aprox. 1/4) */
}
.padroes-inter-section .content-text h2{
  color:#00205C;font-size:24px;font-weight:600;line-height:1.4;margin:0;
}

/* faixa de logos */
.padroes-inter-section .content-logos{
  flex:1 1 auto;
  display:flex;align-items:center;justify-content:space-between;
  gap:48px; /* espaço uniforme entre logos */
  flex-wrap:nowrap;
  min-height:64px; /* dá respiro vertical como no print */
}

/* cada logo */
.padroes-inter-section .content-logos img{
  display:block;height:44px; /* altura uniforme dos logos */
  width:auto;object-fit:contain;
  filter:none;opacity:1;transition:transform .15s ease, opacity .15s ease;
}
.padroes-inter-section .content-logos img:hover{
  transform:translateY(-2px);
}

/* responsivo */
@media (max-width: 1100px){
  .padroes-inter-section .content-logos{flex-wrap:wrap;row-gap:24px;column-gap:36px;justify-content:flex-start}
}
@media (max-width: 768px){
  .padroes-inter-content{flex-direction:column;align-items:flex-start;gap:20px}
  .padroes-inter-section .content-text{flex:0 0 auto}
  .padroes-inter-section .content-logos{width:100%;justify-content:space-between}
}
</style>

<?php
// --- Obtém ID da página atual com fallback seguro
global $post;
$post_id = get_queried_object_id();
if (!$post_id && $post instanceof WP_Post) $post_id = (int) $post->ID;

// --- Título
$padroes_title = $post_id ? get_post_meta($post_id, '_metod_padroes_title', true) : '';
if (!$padroes_title) {
  $padroes_title = 'Padrões internacionais que são a base da Metodologia LILACS';
}

// --- Logos (até 8)
$logos = [];
for ($i=1; $i<=8; $i++){
  $id  = (int) get_post_meta($post_id, "_metod_padroes_logo_{$i}_id",  true);
  $url =        get_post_meta($post_id, "_metod_padroes_logo_{$i}_url", true);
  $alt =        get_post_meta($post_id, "_metod_padroes_logo_{$i}_alt", true);

  if ($id) {
    // pega uma variação leve; CSS já fixa a altura
    $src = wp_get_attachment_image_url($id, 'medium') ?: wp_get_attachment_image_url($id, 'full');
    if ($src) {
      $logos[] = [
        'src' => $src,
        'alt' => $alt ?: 'Logo',
        'url' => $url
      ];
    }
  }
}

// Não renderiza se não houver pelo menos 1 logo
if (!empty($logos)) : ?>
<section class="padroes-inter-section" aria-labelledby="padroes-inter-title">
  <div class="padroes-inter-content">
    <div class="content-text">
      <h2 id="padroes-inter-title"><?php echo esc_html($padroes_title); ?></h2>
    </div>

    <div class="content-logos" aria-label="<?php echo esc_attr($padroes_title); ?>">
      <?php foreach ($logos as $logo): ?>
        <?php if (!empty($logo['url'])): ?>
          <a href="<?php echo esc_url($logo['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($logo['alt']); ?>">
            <img src="<?php echo esc_url($logo['src']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
          </a>
        <?php else: ?>
          <img src="<?php echo esc_url($logo['src']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
