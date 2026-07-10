<?php
/**
 * Dobra: 40 Anos – GALERIA DE FOTOS
 * Slug ACF: l40_galeria
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'l40_esc_text' ) ) { function l40_esc_text( $v ) { return esc_html( (string) $v ); } }
if ( ! function_exists( 'l40_esc_attr' ) ) { function l40_esc_attr( $v ) { return esc_attr( (string) $v ); } }
if ( ! function_exists( 'l40_esc_url'  ) ) { function l40_esc_url( $v )  { return esc_url( (string) $v );  } }

$slider_id     = 'l40-gal-' . get_the_ID() . '-' . get_row_index();
$gallery_title = get_sub_field( 'l40_gallery_title' )     ?: 'Galeria de fotos';
$gallery_sub   = get_sub_field( 'l40_gallery_subtitle' )  ?: '';
$gallery_items = get_sub_field( 'l40_gallery_items' );
$cta_label     = get_sub_field( 'l40_gallery_cta_label' ) ?: 'Ver agenda de eventos';
$cta_url       = get_sub_field( 'l40_gallery_cta_url' )   ?: '#agenda';

$slides = [];
if ( is_array( $gallery_items ) ) {
    foreach ( $gallery_items as $g ) {
        $img = isset( $g['image'] ) ? trim( (string) $g['image'] ) : '';
        if ( empty( $img ) ) continue;
        $slides[] = [
            'img'  => $img,
            'link' => isset( $g['link'] ) ? trim( (string) $g['link'] ) : '',
            'alt'  => isset( $g['alt'] )  ? trim( (string) $g['alt'] )  : '',
        ];
    }
}
if ( empty( $slides ) ) {
    $slides[] = [ 'img' => 'https://via.placeholder.com/1600x700', 'link' => '', 'alt' => 'Evento LILACS 40 anos' ];
}
?>

<section id="galeria" class="l40-gallery" aria-label="Galeria de fotos dos eventos LILACS 40 anos">
  <div class="l40-container">

    <div class="l40-gallery__header">
      <h2 class="l40-gallery__title"><?php echo l40_esc_text( $gallery_title ); ?></h2>
      <?php if ( ! empty( $gallery_sub ) ) : ?>
        <p class="l40-gallery__subtitle"><?php echo wp_kses_post( wpautop( $gallery_sub ) ); ?></p>
      <?php endif; ?>
    </div>

    <div class="l40-banner" id="<?php echo esc_attr( $slider_id ); ?>">
      <div class="l40-banner__track">
        <?php foreach ( $slides as $idx => $s ) :
          $href = ! empty( $s['link'] ) ? $s['link'] : $s['img'];
        ?>
          <a class="l40-banner__slide"
             href="<?php echo l40_esc_url( $href ); ?>"
             target="_blank" rel="noopener"
             aria-label="<?php echo l40_esc_attr( ( $s['alt'] ?: 'Foto do evento' ) . ' (abre em nova aba)' ); ?>">
            <img src="<?php echo l40_esc_url( $s['img'] ); ?>"
                 alt="<?php echo l40_esc_attr( $s['alt'] ); ?>"
                 loading="<?php echo ( $idx === 0 ) ? 'eager' : 'lazy'; ?>">
          </a>
        <?php endforeach; ?>
      </div>

      <?php if ( count( $slides ) > 1 ) : ?>
        <button class="l40-banner__nav l40-banner__prev" type="button" aria-label="Foto anterior"></button>
        <button class="l40-banner__nav l40-banner__next" type="button" aria-label="Próxima foto"></button>
        <div class="l40-banner__dots" role="tablist" aria-label="Navegação da galeria">
          <?php for ( $i = 0; $i < count( $slides ); $i++ ) : ?>
            <button type="button"
                    class="l40-banner__dot <?php echo ( $i === 0 ) ? 'is-active' : ''; ?>"
                    aria-label="Ir para foto <?php echo (int) ( $i + 1 ); ?>"
                    data-dot="<?php echo (int) $i; ?>"></button>
          <?php endfor; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="l40-gallery__footer">
      <a class="l40-gallery__cta" href="<?php echo l40_esc_attr( $cta_url ); ?>">
        <?php echo l40_esc_text( $cta_label ); ?>
      </a>
    </div>

  </div>
</section>

<style>
.l40-container{max-width:1180px;margin:0 auto;padding:0 20px;box-sizing:border-box;}
.l40-gallery{padding:44px 0;background:#fff;border-top:1px solid rgba(12,67,128,.08);}
.l40-gallery__header{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;margin-bottom:18px;}
.l40-gallery__title{font-family:"Noto Sans",system-ui,sans-serif;margin:0;font-size:1.85rem;line-height:1.15;color:#0f172a;}
.l40-gallery__subtitle{margin:0;font-family:"Noto Sans",system-ui,sans-serif;color:#475569;max-width:70ch;}
.l40-gallery__subtitle p{margin:0;}
.l40-gallery__footer{display:flex;justify-content:flex-end;margin-top:16px;}
.l40-gallery__cta{display:inline-flex;align-items:center;gap:10px;padding:12px 20px;border-radius:30px;text-decoration:none;font-family:"Noto Sans",system-ui,sans-serif;font-weight:600;color:#fff;background:linear-gradient(90deg,#0C4380,#0b3a70);box-shadow:0 12px 22px rgba(12,67,128,.18);}
.l40-gallery__cta:hover{filter:brightness(.98);transform:translateY(-1px);}
/* Slider */
.l40-banner{position:relative;width:100%;border-radius:16px;overflow:hidden;border:1px solid rgba(12,67,128,.10);box-shadow:0 16px 40px rgba(2,23,55,.10);background:#e9eef5;}
.l40-banner__track{display:flex;width:100%;transition:transform .45s ease;will-change:transform;}
.l40-banner__slide{flex:0 0 100%;width:100%;display:block;position:relative;min-height:360px;background:#e9eef5;}
.l40-banner__slide img{width:100%;height:100%;min-height:360px;object-fit:cover;display:block;}
.l40-banner__slide::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(12,67,128,0) 45%,rgba(12,67,128,.22));pointer-events:none;}
.l40-banner__nav{position:absolute;top:50%;transform:translateY(-50%);width:44px;height:44px;border-radius:999px;border:1px solid rgba(255,255,255,.35);background:rgba(12,67,128,.35);backdrop-filter:blur(6px);cursor:pointer;z-index:2;box-shadow:0 12px 22px rgba(0,0,0,.18);}
.l40-banner__nav:hover{filter:brightness(1.05);}
.l40-banner__prev{left:12px;}
.l40-banner__next{right:12px;}
.l40-banner__nav::before{content:"";position:absolute;inset:0;margin:auto;width:10px;height:10px;border-right:2px solid #fff;border-bottom:2px solid #fff;transform:rotate(135deg);}
.l40-banner__next::before{transform:rotate(-45deg);}
.l40-banner__dots{position:absolute;left:12px;right:12px;bottom:12px;display:flex;gap:8px;justify-content:center;z-index:2;}
.l40-banner__dot{width:10px;height:10px;border-radius:999px;border:1px solid rgba(255,255,255,.65);background:rgba(255,255,255,.25);cursor:pointer;}
.l40-banner__dot.is-active{background:rgba(255,255,255,.95);}
@media(max-width:980px){
  .l40-gallery__header{flex-direction:column;align-items:flex-start;}
  .l40-banner__slide,.l40-banner__slide img{min-height:320px;}
}
@media(max-width:640px){
  .l40-gallery{padding:34px 0;}
  .l40-gallery__footer{justify-content:stretch;}
  .l40-gallery__cta{width:100%;justify-content:center;}
  .l40-banner__nav{display:none;}
  .l40-banner__slide,.l40-banner__slide img{min-height:260px;}
}
</style>

<script>
(function(){
  var bannerId = '<?php echo esc_js( $slider_id ); ?>';
  var root = document.getElementById(bannerId);
  if (!root) return;

  var track  = root.querySelector('.l40-banner__track');
  var slides = root.querySelectorAll('.l40-banner__slide');
  if (!track || slides.length <= 1) return;

  var btnPrev = root.querySelector('.l40-banner__prev');
  var btnNext = root.querySelector('.l40-banner__next');
  var dots    = root.querySelectorAll('[data-dot]');
  var index   = 0, startX = 0, currentX = 0, isDown = false, autoTimer = null;

  function clamp(n,a,b){ return Math.max(a,Math.min(b,n)); }
  function setDots(i){ dots.forEach(function(d,di){ d.classList.toggle('is-active',di===i); }); }
  function goTo(i){ index=clamp(i,0,slides.length-1); track.style.transform='translateX('+(-index*100)+'%)'; setDots(index); }
  function next(){ goTo(index+1>=slides.length?0:index+1); }
  function prev(){ goTo(index-1<0?slides.length-1:index-1); }
  function stopAuto(){ if(autoTimer){clearInterval(autoTimer);autoTimer=null;} }
  function startAuto(){ stopAuto(); autoTimer=setInterval(next,6000); }

  if(btnNext) btnNext.addEventListener('click',function(){ stopAuto();next();startAuto(); });
  if(btnPrev) btnPrev.addEventListener('click',function(){ stopAuto();prev();startAuto(); });
  dots.forEach(function(d){ d.addEventListener('click',function(){ stopAuto();goTo(parseInt(d.getAttribute('data-dot')||'0',10));startAuto(); }); });

  function onDown(x){ isDown=true;startX=x;currentX=x;track.style.transition='none';stopAuto(); }
  function onMove(x){ if(!isDown)return;currentX=x;track.style.transform='translateX('+(-index*100+((x-startX)/Math.max(1,root.clientWidth))*100)+'%)'; }
  function onUp(){ if(!isDown)return;isDown=false;track.style.transition='';var dx=currentX-startX,th=root.clientWidth*.18;if(dx>th)prev();else if(dx<-th)next();else goTo(index);startAuto(); }

  root.addEventListener('touchstart',function(e){ if(e.touches&&e.touches[0])onDown(e.touches[0].clientX); },{passive:true});
  root.addEventListener('touchmove', function(e){ if(e.touches&&e.touches[0])onMove(e.touches[0].clientX); },{passive:true});
  root.addEventListener('touchend', onUp);
  root.addEventListener('mousedown',function(e){ onDown(e.clientX); });
  window.addEventListener('mousemove',function(e){ onMove(e.clientX); });
  window.addEventListener('mouseup', onUp);

  goTo(0); startAuto();
})();
</script>
