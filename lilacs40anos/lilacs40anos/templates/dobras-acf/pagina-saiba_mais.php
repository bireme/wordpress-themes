<?php
/**
 * DOBRA: Saiba mais
 * Slug esperado: pagina-saiba_mais
 * Arquivo: pagina-saiba_mais.php
 */
if ( ! defined('ABSPATH') ) exit;

$titulo   = get_sub_field('titulo_da_dobra');
$descricao = get_sub_field('descricao_da_dobra');
$itens    = get_sub_field('itens'); // repeater (array) OU usar have_rows('itens')
?>

<section class="lilacs-saibamais" aria-label="<?php echo esc_attr( $titulo ?: 'Saiba mais' ); ?>">
  <div class="lilacs-saibamais__inner">

    <?php if ( ! empty($titulo) ) : ?>
      <h2 class="lilacs-saibamais__title"><?php echo esc_html($titulo); ?></h2>
    <?php endif; ?>

    <?php if ( ! empty($descricao) ) : ?>
      <p class="lilacs-saibamais__desc"><?php echo esc_html($descricao); ?></p>
    <?php endif; ?>

    <?php if ( have_rows('itens') ) : ?>
      <div class="lilacs-saibamais__grid">
        <?php while ( have_rows('itens') ) : the_row();
          $item_titulo = get_sub_field('titulo');
          $item_link   = trim((string) get_sub_field('link'));

          // permite link sem esquema
          if ($item_link && !preg_match('#^https?://#i', $item_link) && strpos($item_link, '/') === 0) {
            $item_link = home_url($item_link);
          } elseif ($item_link && !preg_match('#^https?://#i', $item_link) && !preg_match('#^mailto:|^tel:#i', $item_link)) {
            $item_link = 'https://' . $item_link;
          }

          $tag = $item_link ? 'a' : 'div';
          $attrs = $item_link ? 'href="'.esc_url($item_link).'"' : '';
        ?>
          <<?php echo $tag; ?> class="lilacs-saibamais__card" <?php echo $attrs; ?> <?php echo $item_link ? 'target="_self" rel="noopener"' : ''; ?>>
            <span class="lilacs-saibamais__cardtxt">
              <?php echo esc_html($item_titulo); ?>
            </span>

            <span class="lilacs-saibamais__arrow" aria-hidden="true">
              <!-- setinha (igual ao print) -->
              <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                <path d="M9 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </<?php echo $tag; ?>>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<style>
/* ========= Dobra: Saiba mais (layout conforme imagem) ========= */
.lilacs-saibamais{
  background:#fff;
  padding: 18px 0 26px;
}

.lilacs-saibamais__inner{
  max-width: 1180px;
  margin: 0 auto;
  padding: 0 18px;
}

.lilacs-saibamais__title{
  margin: 0 0 12px;
  font-size: 32px;
  line-height: 1.2;
  font-weight: 800;
  color: #103A7A;
  letter-spacing: -0.2px;
}

.lilacs-saibamais__desc{
  margin: -6px 0 14px;
  font-size: 12px;
  line-height: 1.45;
  color: #6B7280;
}

/* cards */
.lilacs-saibamais__grid{
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
}

.lilacs-saibamais__card{
  background: #0B5AA6; /* azul do card */
  border-radius: 8px;
  padding: 16px 14px;
  min-height: 76px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  text-decoration: none;
  color: #fff;
  box-shadow: 0 0 0 1px rgba(255,255,255,0.08) inset;
  transition: transform .12s ease, filter .12s ease, box-shadow .12s ease;
}

.lilacs-saibamais__card:hover{
  transform: translateY(-1px);
  filter: brightness(1.02);
  box-shadow: 0 6px 18px rgba(16,58,122,0.18);
}

.lilacs-saibamais__card:focus{
  outline: none;
}

.lilacs-saibamais__card:focus-visible{
  outline: 3px solid rgba(11,90,166,.25);
  outline-offset: 3px;
}

.lilacs-saibamais__cardtxt{
font-size: 16px;
    line-height: 1.4;
    font-weight: 700;
    height: 160px;
    max-width: calc(100% - 34px);
    display: flex;
    align-content: center;
    align-items: center;
}

.lilacs-saibamais__arrow{
  width: 22px;
  height: 22px;
  display: grid;
  place-items: center;
  flex: 0 0 auto;
}

.lilacs-saibamais__arrow svg{
  width: 22px;
  height: 22px;
  color: rgba(255,255,255,.9);
}

/* responsivo */
@media (max-width: 900px){
  .lilacs-saibamais__grid{ grid-template-columns: 1fr; }
  .lilacs-saibamais__card{ min-height: 68px; }
}
</style>
