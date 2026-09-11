<?php
if (!defined('ABSPATH')) exit;

$post_id = get_queried_object_id();
if (!$post_id && isset($post->ID)) $post_id = (int)$post->ID;

/* ========= LEITURA DOS METAS ========= */

/* 4 Cards (links rápidos) */
$quick = [];
for ($i=1; $i<=4; $i++){
  $img_id = (int) get_post_meta($post_id, "_lilacs_quick_{$i}_bg_img_id", true);   // NOVO (1..3 usam)
  $quick[$i] = [
    'title' => get_post_meta($post_id, "_lilacs_quick_{$i}_title", true),
    'url'   => get_post_meta($post_id, "_lilacs_quick_{$i}_url",   true),
    'icon'  => get_post_meta($post_id, "_lilacs_quick_{$i}_icon",  true),
    'bgimg' => $img_id ? wp_get_attachment_image_url($img_id, 'large') : '',
    'bgcol' => get_post_meta($post_id, "_lilacs_quick_{$i}_bg_color", true),        // ex: #0A3A74
  ];
}

/* Banner rotativo (3 slides) */
$slides = [];
for ($s=1; $s<=3; $s++){
  $img_id  = (int) get_post_meta($post_id, "_lilacs_banner_{$s}_img_id", true);
  $slides[$s] = [
    'title'   => get_post_meta($post_id, "_lilacs_banner_{$s}_title", true),
    'desc'    => get_post_meta($post_id, "_lilacs_banner_{$s}_desc",  true),
    'btn_txt' => get_post_meta($post_id, "_lilacs_banner_{$s}_btn_txt", true),
    'btn_url' => get_post_meta($post_id, "_lilacs_banner_{$s}_btn_url", true),
    'img'     => $img_id ? wp_get_attachment_image_url($img_id, 'full') : '',
  ];
}

/* 3 Boxes inferiores */
$boxes = [];
for ($b=1; $b<=3; $b++){
  $img_id = (int) get_post_meta($post_id, "_lilacs_box_{$b}_img_id", true);
  $boxes[$b] = [
    'title' => get_post_meta($post_id, "_lilacs_box_{$b}_title", true),
    'url'   => get_post_meta($post_id, "_lilacs_box_{$b}_url",   true),
    'img'   => $img_id ? wp_get_attachment_image_url($img_id, 'large') : '',
  ];
}
?>

<style>
.lilacs-rbc{--c1:#085695; --c2:#05244a; --bg:#eef2f7}
.lilacs-rbc{padding:24px 0;background:var(--bg)}
.lilacs-rbc .container{max-width:1200px;margin:0 auto;padding:0 16px}

/* utilitário full-bleed */
.full-bleed{width:100vw; margin-left:calc(50% - 50vw); margin-right:calc(50% - 50vw)}

/* 4 cards */
.rbc-quick{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
.rbc-quick .item{
  position:relative; display:flex; justify-content:space-between;
  background:var(--c1); color:#fff; border-radius:12px; padding:22px 18px; text-decoration:none;
  box-shadow:0 2px 8px rgba(0,0,0,.1); overflow:hidden; height: 150px;
}
.rbc-quick .item .txt{font-weight:600;line-height:1.2;position:relative;z-index:2}
.rbc-quick .item .ico{margin-left:12px;display:inline-flex;align-items:flex-end;position:relative;z-index:2;background: #0b2f5f; border-radius: 99px; padding: 25px 13px 8px 15px; margin-top: 50%;}
.rbc-quick .item:hover{background:var(--c2)}
/* fundo próprio dos 3 primeiros cards */
.rbc-quick .item.has-bg::before{
  content:""; position:absolute; inset:0; background-size:cover; background-position:center; opacity:.25; z-index:1;
}
.rbc-quick .item.has-color{background:var(--c1)} /* cor será aplicada inline */

/* slider full-bleed */
.rbc-slider{position:relative; overflow:hidden; margin:0 0 24px; background:#ddd; border-radius:0} /* sem radius para ponta-a-ponta */
.rbc-slide{position:relative; min-height:360px; display:none}
.rbc-slide.is-active{display:block}
.rbc-slide .bg{position:absolute; inset:0; background-size:cover; background-position:center; filter:saturate(.96)}
.rbc-slide .shade{position:absolute; inset:0; /*background:linear-gradient(90deg,rgba(5,36,74,.85) 0%, rgba(5,36,74,.35) 55%, rgba(5,36,74,0) 100%)*/}
.rbc-slide .content{position:relative; padding:36px 16px; max-width:1200px; margin:0 auto; color:#fff; height: 250px; display: flex; flex-direction: column; justify-content: center; }
.rbc-slide h3{font-size:1.8rem;margin:0 0 8px; color: #0b2f5f;}
.rbc-slide p{margin:0 0 45px;opacity:.95; color: #0b2f5f; font-weight: 500; font-size: 18px; width: 58%;}
.rbc-btn{display:inline-flex;align-items:center;justify-content: space-between;background:#0b2f5f;border:0;color:#fff;padding:12px 18px;border-radius:999px;cursor:pointer;text-decoration:none;width: 30%; font-family: 'Noto Sans';}
.rbc-btn:hover{background:#0f2e6b}
.rbc-nav{position:absolute;inset:0;pointer-events:none}
.rbc-prev,.rbc-next{position:absolute;top:50%;transform:translateY(-50%);pointer-events:auto;border:none;background:rgba(255,255,255,.9);
  width:38px;height:38px;border-radius:999px;display:flex;align-items:center;justify-content:center;cursor:pointer}
.rbc-prev{left:16px} .rbc-next{right:16px}

/* 3 boxes */
.rbc-boxes{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.rbc-box{background:#0b2f5f;border-radius:14px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.08)}
.rbc-box .img{aspect-ratio:16/9;background:#ccc;background-size:cover;background-position:center}
.rbc-box a{display:block;text-decoration:none;color:#fff;padding:14px 16px;font-weight:700;font-family: 'Noto Sans';}

/* responsive */
@media (max-width:992px){
  .rbc-quick{grid-template-columns:repeat(2,1fr)}
  .rbc-slide{min-height:280px}
  .rbc-boxes{grid-template-columns:1fr}
}
@media (max-width:520px){
  .rbc-quick{grid-template-columns:1fr}
}
</style>

<section class="lilacs-rbc">
  <div class="container">

    <!-- 4 CARDS -->
    <div class="rbc-quick">
      <?php foreach($quick as $idx=>$q): if(!$q['title']) continue;
        // aplica fundo próprio apenas nos 3 primeiros
        $classes = 'item';
        $style   = '';
        if ($idx <= 3) {
          if (!empty($q['bgimg'])) { $classes .= ' has-bg'; $style = "background-image:url('".esc_url($q['bgimg'])."')"; }
          if (!empty($q['bgcol'])) { $classes .= ' has-color'; /* cor inline no container */ }
        }
      ?>
        <a class="<?php echo esc_attr($classes); ?>"
           href="<?php echo esc_url($q['url'] ?: '#'); ?>"
           <?php echo $style ? 'style="--bgimg:url('.esc_url($q['bgimg']).'); background-color:'.esc_attr($q['bgcol'] ?: 'transparent').'"' : ( $q['bgcol'] ? 'style="background-color:'.esc_attr($q['bgcol']).'"' : '' ); ?>>
          <?php
            // se tiver imagem, injeta no ::before via style (fallback para inline):
            if ($idx <= 3 && !empty($q['bgimg'])) {
              echo '<style>.rbc-quick .item.has-bg[style*="'.esc_attr($q['bgimg']).'"]::before{background-image:url("'.esc_url($q['bgimg']).'")}</style>';
            }
          ?>
          <span class="txt"><?php echo esc_html($q['title']); ?></span>
          <span class="ico" aria-hidden="true">›</span>
        </a>
      <?php endforeach; ?>
    </div>

  </div>

  <!-- SLIDER FULL-BLEED (100% viewport) -->
  <?php if (array_filter(array_column($slides,'img'))) : ?>
  <div class="rbc-slider full-bleed" id="rbcSlider">
    <?php foreach($slides as $idx=>$sl): if(!$sl['img']) continue; ?>
      <div class="rbc-slide <?php echo $idx===1?'is-active':''; ?>">
        <div class="bg" style="background-image:url('<?php echo esc_url($sl['img']); ?>')"></div>
        <div class="shade"></div>
        <div class="content">
          <?php if($sl['title']): ?><h3><?php echo esc_html($sl['title']); ?></h3><?php endif; ?>
          <?php if($sl['desc']):  ?><p><?php echo esc_html($sl['desc']); ?></p><?php endif; ?>
          <?php if($sl['btn_url']): ?>
            <a class="rbc-btn" href="<?php echo esc_url($sl['btn_url']); ?>">
              <?php echo esc_html($sl['btn_txt'] ?: 'Saiba mais'); ?> <span aria-hidden="true">›</span>
            </a>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
    <div class="rbc-nav">
      <button class="rbc-prev" type="button" aria-label="Anterior">‹</button>
      <button class="rbc-next" type="button" aria-label="Próximo">›</button>
    </div>
  </div>
  <?php endif; ?>

  <div class="container">
    <!-- 3 BOXES -->
    <div class="rbc-boxes">
      <?php foreach($boxes as $bx): if(!$bx['title']) continue; ?>
        <div class="rbc-box">
          <div class="img" style="background-image:url('<?php echo esc_url($bx['img']); ?>')"></div>
          <a href="<?php echo esc_url($bx['url'] ?: '#'); ?>"><?php echo esc_html($bx['title']); ?></a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
(function(){
  const root = document.getElementById('rbcSlider');
  if(!root) return;
  const slides = Array.from(root.querySelectorAll('.rbc-slide'));
  if(slides.length < 2) return;

  let i = 0, timer;
  const show = idx => { slides.forEach((s,k)=>s.classList.toggle('is-active', k===idx)); i = idx; };
  const next = () => show((i+1)%slides.length);
  const prev = () => show((i-1+slides.length)%slides.length);

  root.querySelector('.rbc-next').addEventListener('click', ()=>{ next(); restart(); });
  root.querySelector('.rbc-prev').addEventListener('click', ()=>{ prev(); restart(); });

  const start = ()=> timer = setInterval(next, 6000);
  const stop  = ()=> clearInterval(timer);
  const restart = ()=>{ stop(); start(); };

  root.addEventListener('mouseenter', stop);
  root.addEventListener('mouseleave', start);
  start();
})();
</script>
