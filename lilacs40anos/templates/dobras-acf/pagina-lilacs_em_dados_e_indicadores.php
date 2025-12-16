<?php
/**
 * DOBRA: pagina-lilacs_em_dados_e_indicadores
 * Layout ACF: lilacs_em_dados_e_indicadores
 * Render: título + descrição + grid de cards (2 colunas) com ícone/imagem opcional por indicador
 * Cor do botão: #082A53
 */

if ( ! defined('ABSPATH') ) exit;

$titulo    = (string) get_sub_field('titulo');
$descricao = (string) get_sub_field('descricao');

if ( empty($titulo) && empty($descricao) && ! have_rows('indicadores') ) {
  return;
}

$uid = 'lilacs-indicadores-' . wp_generate_uuid4();

/**
 * Ícone fallback (SVG) caso não tenha imagemicone
 */
function lilacs_indicadores_fallback_svg() {
  return '
  <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
    <path d="M4 19h16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M7 16V10" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M12 16V6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    <path d="M17 16v-8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>';
}
?>

<section class="lilacs-em-dados" id="<?php echo esc_attr($uid); ?>">
  <div class="lilacs-em-dados__container">

    <div class="lilacs-em-dados__header">
      <?php if ( ! empty($titulo) ) : ?>
        <h2 class="lilacs-em-dados__title"><?php echo esc_html($titulo); ?></h2>
      <?php endif; ?>

      <?php if ( ! empty($descricao) ) : ?>
        <p class="lilacs-em-dados__desc"><?php echo esc_html($descricao); ?></p>
      <?php endif; ?>
    </div>

    <?php if ( have_rows('indicadores') ) : ?>
      <div class="lilacs-em-dados__grid" role="list" aria-label="<?php echo esc_attr($titulo ?: 'Indicadores'); ?>">
        <?php while ( have_rows('indicadores') ) : the_row();

          $t    = (string) get_sub_field('titulo_do_indicador');
          $d    = (string) get_sub_field('descricao_do_indicador'); // wysiwyg
          $l    = (string) get_sub_field('link_do_indicador');
          $tags = (string) get_sub_field('tags_do_indicador'); // opcional

          // ✅ NOVO: imagem/ícone (url)
          $imgicon = (string) get_sub_field('imagemicone');

          if ( empty($t) && empty($d) && empty($l) && empty($imgicon) ) continue;

          // card clicável se tiver link
          $tag   = ! empty($l) ? 'a' : 'div';
          $attrs = ! empty($l)
            ? 'href="' . esc_url($l) . '" class="lilacs-em-dados__card is-link" target="_blank" rel="noopener noreferrer" role="listitem"'
            : 'class="lilacs-em-dados__card" role="listitem"';
        ?>
          <<?php echo $tag; ?> <?php echo $attrs; ?>>

            <div class="lilacs-em-dados__card-top">
              <span class="lilacs-em-dados__icon" aria-hidden="true">
                <?php if ( ! empty($imgicon) ) : ?>
                  <img src="<?php echo esc_url($imgicon); ?>" alt="" loading="lazy">
                <?php else : ?>
                  <?php echo lilacs_indicadores_fallback_svg(); ?>
                <?php endif; ?>
              </span>

              <?php if ( ! empty($t) ) : ?>
                <h3 class="lilacs-em-dados__card-title"><?php echo esc_html($t); ?></h3>
              <?php endif; ?>
            </div>

            <?php if ( ! empty($d) ) : ?>
              <div class="lilacs-em-dados__card-desc">
                <?php echo wp_kses_post( wpautop($d) ); ?>
              </div>
            <?php endif; ?>

            <div class="lilacs-em-dados__card-footer">
              <?php if ( ! empty($l) ) : ?>
                <span class="lilacs-em-dados__btn">Acessar</span>
              <?php endif; ?>
            </div>

          </<?php echo $tag; ?>>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<style>
/* ===== wrapper ===== */
#<?php echo esc_attr($uid); ?>.lilacs-em-dados{
  width:100%;
  padding:34px 0 28px;
  background:#fff;
}

/* ===== container (encaixotado) ===== */
#<?php echo esc_attr($uid); ?> .lilacs-em-dados__container{
  width:min(1200px, calc(100% - 48px));
  margin:0 auto;
}

/* ===== header ===== */
#<?php echo esc_attr($uid); ?> .lilacs-em-dados__header{
  margin-bottom:22px;
}

#<?php echo esc_attr($uid); ?> .lilacs-em-dados__title{
  margin:0 0 6px 0;
  font-size:26px;
  line-height:1.2;
  font-weight:800;
  color:#0b2f57;
}

#<?php echo esc_attr($uid); ?> .lilacs-em-dados__desc{
  margin:0;
  font-size:16px;
  line-height:1.6;
  color:#5b6b7a;
}

/* ===== grid 2 colunas ===== */
#<?php echo esc_attr($uid); ?> .lilacs-em-dados__grid{
  display:grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap:18px 18px;
}

/* ===== card ===== */
#<?php echo esc_attr($uid); ?> .lilacs-em-dados__card{
  background:#fff;
  border:1px solid #e6eef6;
  border-radius:10px;
  padding:16px 16px 14px;
  box-shadow:0 10px 24px rgba(8,42,83,.06);
  min-height:120px;
}

#<?php echo esc_attr($uid); ?> .lilacs-em-dados__card.is-link{
  text-decoration:none;
  color:inherit;
  transition:transform .12s ease, box-shadow .12s ease, border-color .12s ease;
  display:block;
}

#<?php echo esc_attr($uid); ?> .lilacs-em-dados__card.is-link:hover{
  transform:translateY(-1px);
  border-color:rgba(8,42,83,.28);
  box-shadow:0 14px 32px rgba(8,42,83,.10);
}

/* topo com ícone + título */
#<?php echo esc_attr($uid); ?> .lilacs-em-dados__card-top{
  display:flex;
  gap:10px;
  align-items:flex-start;
  align-items: center;
    margin-bottom: 8px;
    align-content: center;

}

#<?php echo esc_attr($uid); ?> .lilacs-em-dados__icon{
  width:60px;
  height:60px;
  border-radius:8px;
  background:#f2f6fb;
  color:#082A53;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  flex:0 0 60px;
  overflow:hidden;
}

#<?php echo esc_attr($uid); ?> .lilacs-em-dados__icon img{
  display:block;
  width:60px;
  height:60px;
  object-fit:contain;
}

#<?php echo esc_attr($uid); ?> .lilacs-em-dados__card-title{
  margin:0;
  font-size:18px;
  line-height:1.35;
  font-weight:800;
  color:#0b2f57;
}

/* descrição */
#<?php echo esc_attr($uid); ?> .lilacs-em-dados__card-desc{
  font-size:16px;
  line-height:1.55;
  color:#5b6b7a;
  margin:0 0 12px 0;
}

#<?php echo esc_attr($uid); ?> .lilacs-em-dados__card-desc p{
  margin:0;
}

/* footer + botão */
#<?php echo esc_attr($uid); ?> .lilacs-em-dados__card-footer{
  margin-top:auto;
}

#<?php echo esc_attr($uid); ?> .lilacs-em-dados__btn{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  padding:6px 10px;
  border-radius:6px;
  background:#f97316; /* ✅ cor solicitada */
  color:#fff;
  font-size:14px;
  font-weight:800;
  line-height:1;
}

/* responsivo */
@media (max-width: 900px){
  #<?php echo esc_attr($uid); ?> .lilacs-em-dados__grid{
    grid-template-columns: 1fr;
  }
}
</style>
