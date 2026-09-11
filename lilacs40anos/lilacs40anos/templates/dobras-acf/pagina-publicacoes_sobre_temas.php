<?php
/**
 * DOBRA: pagina-publicacoes_sobre_temas
 * Layout: publicacoes_sobre_temas (ACF)
 * - Título + descrição centralizados
 * - Carrossel com cards (imagem + faixa azul + título)
 * - Setas centralizadas abaixo
 */

if ( ! defined('ABSPATH') ) exit;

// =====================
// CAMPOS (ACF)
// =====================
$titulo    = get_sub_field('titulo');
$descricao = get_sub_field('descricao');

// repeater: publicacoes
$items = [];
if ( have_rows('publicacoes') ) {
  while ( have_rows('publicacoes') ) { the_row();
    $items[] = [
      'title' => (string) get_sub_field('titulo_da_publicacao'),
      'link'  => (string) get_sub_field('link_da_publicacao'),
      'img'   => (string) get_sub_field('imagem_da_publicacao'), // return_format url
    ];
  }
}

if ( empty($items) ) {
  return;
}

// id único para suportar múltiplos carrosseis na mesma página
$uid = 'lilacs-pub-' . wp_generate_uuid4();
?>

<section class="lilacs-pub" id="<?php echo esc_attr($uid); ?>">
  <div class="lilacs-pub__container">

    <?php if ( ! empty($titulo) ) : ?>
      <h2 class="lilacs-pub__title"><?php echo esc_html($titulo); ?></h2>
    <?php endif; ?>

    <?php if ( ! empty($descricao) ) : ?>
      <p class="lilacs-pub__desc"><?php echo esc_html($descricao); ?></p>
    <?php endif; ?>

    <div class="lilacs-pub__carousel" data-carousel>
      <div class="lilacs-pub__viewport" data-viewport>
        <div class="lilacs-pub__track" data-track>
          <?php foreach ( $items as $it ) :
            $card_title = trim($it['title'] ?? '');
            $card_link  = trim($it['link'] ?? '');
            $card_img   = trim($it['img'] ?? '');

            // se não tiver título, não rende (para manter consistência visual)
            if ( $card_title === '' ) continue;

            $tag = $card_link ? 'a' : 'div';
            $href = $card_link ? ' href="' . esc_url($card_link) . '" target="_blank" rel="noopener noreferrer"' : '';
          ?>
            <<?php echo $tag; ?> class="lilacs-pub__card" <?php echo $href; ?>>
              <div class="lilacs-pub__card-media">
                <?php if ( $card_img ) : ?>
                  <img src="<?php echo esc_url($card_img); ?>" alt="<?php echo esc_attr($card_title); ?>">
                <?php else : ?>
                  <div class="lilacs-pub__card-media--placeholder" aria-hidden="true"></div>
                <?php endif; ?>
              </div>
              <div class="lilacs-pub__card-footer">
                <span class="lilacs-pub__card-title"><?php echo esc_html($card_title); ?></span>
              </div>
            </<?php echo $tag; ?>>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="lilacs-pub__nav" aria-label="Navegação do carrossel">
        <button class="lilacs-pub__btn" type="button" data-prev aria-label="Anterior">
          ‹
        </button>
        <button class="lilacs-pub__btn lilacs-pub__btn--primary" type="button" data-next aria-label="Próximo">
          ›
        </button>
      </div>
    </div>

  </div>
</section>

<style>
/* ====== Wrapper ====== */
.lilacs-pub{
  width:100%;
  background:#fff;
  padding:48px 0 56px;
}

.lilacs-pub__container{
  width:min(1200px, calc(100% - 48px));
  margin:0 auto;
}

.lilacs-pub__title{
  margin:0;
  text-align:center;
  font-size:20px;
  font-weight:600;
  color:#111827;
}

.lilacs-pub__desc{
  margin:12px auto 0;
  text-align:center;
  max-width:980px;
  font-size:14px;
  line-height:1.6;
  color:#374151;
}

/* ====== Carousel ====== */
.lilacs-pub__carousel{
  margin-top:26px;
}

.lilacs-pub__viewport{
  overflow:hidden;
  border-radius:16px;
}

/* Track com gap igual ao layout */
.lilacs-pub__track{
  display:flex;
  gap:18px;
  will-change:transform;
  transform:translateX(0);
  transition:transform .35s ease;
  padding:6px 6px;
}

/* Card */
.lilacs-pub__card{
  flex:0 0 auto;
  width:260px;                /* base desktop, JS ajusta por view */
  border-radius:16px;
  overflow:hidden;
  background:#fff;
  box-shadow:0 10px 26px rgba(17,24,39,.10);
  text-decoration:none;
  color:inherit;
  display:flex;
  flex-direction:column;
}

.lilacs-pub__card-media{
  height:170px;
  background:#f3f4f6;
}

.lilacs-pub__card-media img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
}

.lilacs-pub__card-media--placeholder{
  width:100%;
  height:100%;
  background:linear-gradient(135deg, #f3f4f6, #e5e7eb);
}

.lilacs-pub__card-footer{
  background:#0b2f6d; /* azul da faixa */
  padding:16px 16px;
  min-height:72px;
  display:flex;
  align-items:center;
  justify-content:center;
  text-align:center;
}

.lilacs-pub__card-title{
  color:#fff;
  font-weight:700;
  font-size:14px;
  line-height:1.25;
}

/* ====== Nav buttons (central) ====== */
.lilacs-pub__nav{
  margin-top:18px;
  display:flex;
  justify-content:center;
  gap:12px;
}

.lilacs-pub__btn{
  width:36px;
  height:36px;
  border-radius:999px;
  border:1px solid rgba(17,24,39,.25);
  background:#fff;
  color:#111827;
  cursor:pointer;
  font-size:20px;
  line-height:1;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  transition:transform .12s ease, opacity .12s ease;
}

.lilacs-pub__btn:hover{
  transform:translateY(-1px);
  opacity:.95;
}

.lilacs-pub__btn--primary{
  border-color:#0b2f6d;
  color:#0b2f6d;
}

/* ====== Responsivo ====== */
@media (max-width: 1100px){
  .lilacs-pub__card{ width:240px; }
}
@media (max-width: 820px){
  .lilacs-pub{ padding:36px 0 46px; }
  .lilacs-pub__container{ width:calc(100% - 32px); }
  .lilacs-pub__card{ width:220px; }
}
@media (max-width: 520px){
  .lilacs-pub__card{ width:78vw; } /* mobile: 1 por vez bem grande */
  .lilacs-pub__track{ gap:14px; }
}
</style>

<script>
(function(){
  const root = document.getElementById(<?php echo json_encode($uid); ?>);
  if (!root) return;

  const viewport = root.querySelector('[data-viewport]');
  const track    = root.querySelector('[data-track]');
  const btnPrev  = root.querySelector('[data-prev]');
  const btnNext  = root.querySelector('[data-next]');
  const cards    = Array.from(root.querySelectorAll('.lilacs-pub__card'));

  if (!viewport || !track || cards.length === 0) return;

  let index = 0;       // "página" atual
  let perView = 4;     // quantos cards por view (desktop)
  let stepPx = 0;      // deslocamento por "página"

  function calcPerView(){
    const w = viewport.clientWidth;

    // Heurística simples baseada na referência (desktop ~ 5 cards visíveis)
    if (w >= 1200) perView = 5;
    else if (w >= 980) perView = 4;
    else if (w >= 720) perView = 3;
    else if (w >= 520) perView = 2;
    else perView = 1;
  }

  function calcStep(){
    // usa largura real do card + gap (pega do layout do track)
    const first = cards[0];
    const cardW = first.getBoundingClientRect().width;

    const styles = window.getComputedStyle(track);
    const gap = parseFloat(styles.columnGap || styles.gap || '0') || 0;

    stepPx = (cardW + gap) * perView;
  }

  function clampIndex(){
    const pages = Math.max(1, Math.ceil(cards.length / perView));
    if (index < 0) index = pages - 1;       // loop
    if (index > pages - 1) index = 0;       // loop
  }

  function render(){
    calcPerView();
    calcStep();
    clampIndex();

    const x = -(index * stepPx);
    track.style.transform = `translateX(${x}px)`;
  }

  function next(){
    index += 1;
    render();
  }

  function prev(){
    index -= 1;
    render();
  }

  btnNext && btnNext.addEventListener('click', next);
  btnPrev && btnPrev.addEventListener('click', prev);

  // swipe básico no mobile
  let startX = null;
  viewport.addEventListener('touchstart', (e) => {
    startX = e.touches && e.touches[0] ? e.touches[0].clientX : null;
  }, {passive:true});

  viewport.addEventListener('touchend', (e) => {
    if (startX === null) return;
    const endX = e.changedTouches && e.changedTouches[0] ? e.changedTouches[0].clientX : null;
    if (endX === null) return;

    const diff = endX - startX;
    if (Math.abs(diff) > 40){
      if (diff < 0) next();
      else prev();
    }
    startX = null;
  }, {passive:true});

  window.addEventListener('resize', () => {
    // mantém a página atual mais coerente ao recalcular
    render();
  });

  // init
  render();
})();
</script>
