<?php
/**
 * Section: O que oferecemos + Cursos em Destaque
 * Consome metas:
 *  - _cap_oferecemos: [ [icon_id, title, text], ... ]
 *  - _cap_cursos:     [ [icon_id, title, excerpt, button, link], ... ]
 */

if (!defined('ABSPATH')) exit;

$post_id = get_queried_object_id() ?: get_the_ID();

// metas
$oferecemos = get_post_meta($post_id, '_cap_oferecemos', true);
$cursos     = get_post_meta($post_id, '_cap_cursos', true);
$oferecemos = is_array($oferecemos) ? $oferecemos : [];
$cursos     = is_array($cursos)     ? $cursos     : [];

// tiny fallback svg (ícone de livro) — usado quando não há imagem
$svg_book = '<svg width="64" height="64" viewBox="0 0 24 24" fill="#0B3563" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M3 4.75A2.75 2.75 0 0 1 5.75 2h11.5A2.75 2.75 0 0 1 20 4.75V19a1 1 0 0 1-1.447.894L12 17.118l-6.553 2.776A1 1 0 0 1 4 19V4.75ZM6 4h12v13.382l-5.553-2.353a1 1 0 0 0-.894 0L6 17.382V4Z"/></svg>';
?>

<style>
/* ===== O QUE OFERECEMOS ===== */
.lilacs-oferecemos{padding:24px 0;background:#F5F7FA}
.lilacs-oferecemos .of-title{max-width:1200px;margin:0 auto 12px;padding:0 16px;color:#0B3563;font-size:28px;font-weight:700}
.lilacs-oferecemos .of-grid{
  max-width:1200px;margin:0 auto;padding:8px 16px 32px;
  display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:18px;
}
.lilacs-oferecemos .of-card{
  background:#EDF2F7;border-radius:10px;padding:22px;text-align:left;
  box-shadow:0 0 0 1px rgba(0,0,0,0.03) inset;
}
.lilacs-oferecemos .of-icon{height:48px;width:48px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:8px}
.lilacs-oferecemos .of-icon img{max-width:48px;max-height:48px;object-fit:contain;display:block}
.lilacs-oferecemos .of-card h4{color:#0B3563;font-size:14px;font-weight:700;margin:6px 0 8px}
.lilacs-oferecemos .of-card p{color:#0B3563;font-size:13px;line-height:1.45;margin:0}

/* ===== CURSOS EM DESTAQUE ===== */
.lilacs-cursos{padding:28px 0;background:#FFFFFF}
.lilacs-cursos .cu-title{max-width:1200px;margin:0 auto 16px;padding:0 16px;color:#0B3563;font-size:28px;font-weight:700}
.lilacs-cursos .cu-grid{
  max-width:1200px;margin:0 auto;padding:8px 16px 20px;
  display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px;
}
.lilacs-cursos .cu-card{
  background:#EDF2F7;border-radius:10px;padding:22px;display:flex;flex-direction:column;min-height:100%;
  box-shadow:0 0 0 1px rgba(0,0,0,0.03) inset;
}
.lilacs-cursos .cu-icon{height:64px;width:64px;margin:0 auto 6px;display:flex;align-items:center;justify-content:center}
.lilacs-cursos .cu-icon img{max-width:64px;max-height:64px;object-fit:contain;display:block}
.lilacs-cursos .cu-card h5{color:#0B3563;font-size:14px;font-weight:700;line-height:1.3;margin:12px 0}
.lilacs-cursos .cu-card p{color:#0B3563;font-size:13px;line-height:1.55;margin:0 0 16px}
.lilacs-cursos .cu-actions{margin-top:auto;display:flex;justify-content:center}
.lilacs-cursos .cu-btn{
  display:inline-block;background:#0B3563;color:#fff;text-decoration:none;border:none;border-radius:999px;
  padding:10px 22px;font-size:13px;font-weight:600;line-height:1;cursor:pointer;
}
@media (max-width: 1100px){
  .lilacs-oferecemos .of-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
  .lilacs-cursos .cu-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
}
@media (max-width: 680px){
  .lilacs-oferecemos .of-grid{grid-template-columns:1fr}
  .lilacs-cursos .cu-grid{grid-template-columns:1fr}
}
</style>

<?php if (!empty($oferecemos)): ?>
<section class="lilacs-oferecemos" aria-label="<?php esc_attr_e('O que oferecemos','bireme'); ?>">
  <h2 class="of-title"><?php echo esc_html__('O que oferecemos', 'bireme'); ?></h2>
  <div class="of-grid">
    <?php foreach ($oferecemos as $it):
      $icon_id = isset($it['icon_id']) ? (int)$it['icon_id'] : 0;
      $title   = isset($it['title'])   ? $it['title']   : '';
      $text    = isset($it['text'])    ? $it['text']    : '';
      $icon    = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
      ?>
      <article class="of-card">
        <div class="of-icon" aria-hidden="true">
          <?php if ($icon): ?>
            <img src="<?php echo esc_url($icon); ?>" alt="">
          <?php else: ?>
            <?php echo $svg_book; // fallback visual ?>
          <?php endif; ?>
        </div>
        <?php if ($title): ?><h4><?php echo esc_html($title); ?></h4><?php endif; ?>
        <?php if ($text):  ?><p><?php echo esc_html($text); ?></p><?php endif; ?>
      </article>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($cursos)): ?>
<section class="lilacs-cursos" aria-label="<?php esc_attr_e('Cursos em Destaque','bireme'); ?>">
  <h2 class="cu-title"><?php echo esc_html__('Cursos em Destaque', 'bireme'); ?></h2>

  <div class="cu-grid">
    <?php foreach ($cursos as $it):
      $icon_id = isset($it['icon_id']) ? (int)$it['icon_id'] : 0;
      $title   = isset($it['title'])   ? $it['title']   : '';
      $excerpt = isset($it['excerpt']) ? $it['excerpt'] : '';
      $button  = isset($it['button'])  ? $it['button']  : __('Ver mais','bireme');
      $link    = isset($it['link'])    ? $it['link']    : '';
      $icon    = $icon_id ? wp_get_attachment_image_url($icon_id, 'medium') : '';
      ?>
      <article class="cu-card">
        <div class="cu-icon" aria-hidden="true">
          <?php if ($icon): ?>
            <img src="<?php echo esc_url($icon); ?>" alt="">
          <?php else: ?>
            <?php echo $svg_book; // fallback visual ?>
          <?php endif; ?>
        </div>

        <?php if ($title):   ?><h5><?php echo esc_html($title); ?></h5><?php endif; ?>
        <?php if ($excerpt): ?><p><?php echo esc_html($excerpt); ?></p><?php endif; ?>

        <?php if ($link): ?>
          <div class="cu-actions">
            <a class="cu-btn" href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener">
              <?php echo esc_html($button ?: __('Ver mais','bireme')); ?>
            </a>
          </div>
        <?php endif; ?>
      </article>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>
