<?php
/**
 * DOBRA: pagina-grid_2_box_por_linha
 * Layout ACF: grid_2_box_por_linha
 * - Grid com no máximo 2 boxes por linha
 * - Box roxo estilo referência (imagem topo, título, descrição, botões pill)
 */

if ( ! defined('ABSPATH') ) exit;

if ( ! have_rows('box') ) {
  return;
}

$uid = 'lilacs-grid2-' . wp_generate_uuid4();
?>

<section class="lilacs-grid2" id="<?php echo esc_attr($uid); ?>">
  <div class="lilacs-grid2__container">

    <div class="lilacs-grid2__grid">
      <?php while ( have_rows('box') ) : the_row();

        $img   = get_sub_field('imagem_do_box'); // array
        $title = (string) get_sub_field('titulo_do_box');
        $desc  = get_sub_field('descricao_do_box'); // wysiwyg

        $img_url = '';
        $img_alt = '';
        if ( is_array($img) ) {
          $img_url = $img['url'] ?? '';
          $img_alt = $img['alt'] ?? '';
        }

        // fallback alt
        if ( empty($img_alt) && ! empty($title) ) $img_alt = $title;
      ?>
        <article class="lilacs-grid2__card">

          <?php if ( ! empty($img_url) ) : ?>
            <div class="lilacs-grid2__media">
              <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>">
            </div>
          <?php endif; ?>

          <div class="lilacs-grid2__content">
            <?php if ( ! empty($title) ) : ?>
              <h3 class="lilacs-grid2__title"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>

            <?php if ( ! empty($desc) ) : ?>
              <div class="lilacs-grid2__desc">
                <?php echo wp_kses_post( wpautop($desc) ); ?>
              </div>
            <?php endif; ?>

            <?php if ( have_rows('botoes_e_links') ) : ?>
              <div class="lilacs-grid2__actions">
                <?php while ( have_rows('botoes_e_links') ) : the_row();
                  $bt  = (string) get_sub_field('texto_do_botao');
                  $lnk = (string) get_sub_field('link_do_botao');
                  if ( empty($bt) || empty($lnk) ) continue;
                ?>
                  <a class="lilacs-grid2__btn"
                     href="<?php echo esc_url($lnk); ?>"
                     target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html($bt); ?>
                  </a>
                <?php endwhile; ?>
              </div>
            <?php endif; ?>

          </div>
        </article>
      <?php endwhile; ?>
    </div>

  </div>
</section>

<style>
/* ===== wrapper ===== */
#<?php echo esc_attr($uid); ?>.lilacs-grid2{
  width:100%;
  padding:38px 0;
  background:#fff; /* conforme referência */
}

#<?php echo esc_attr($uid); ?> .lilacs-grid2__container{
  width:min(1200px, calc(100% - 48px));
  margin:0 auto;
}

/* ===== grid 2 por linha ===== */
#<?php echo esc_attr($uid); ?> .lilacs-grid2__grid{
  display:grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap:26px;
}

/* ===== card ===== */
#<?php echo esc_attr($uid); ?> .lilacs-grid2__card{
  border-radius:18px;
  overflow:hidden;
  /* roxo com leve variação/gradiente */
  background: radial-gradient(140% 120% at 100% 0%, rgba(255,255,255,.12) 0%, rgba(255,255,255,0) 42%),
              linear-gradient(180deg, #7b61ff 0%, #6a56e8 100%);
  box-shadow:0 18px 40px rgba(17,24,39,.10);
  min-height: 420px;
  display:flex;
  flex-direction:column;
}

/* mídia topo */
#<?php echo esc_attr($uid); ?> .lilacs-grid2__media{
  padding:18px 18px 0 18px;
}

#<?php echo esc_attr($uid); ?> .lilacs-grid2__media img{
  width:100%;
  height:auto;
  display:block;
  border-radius:14px;
  background:rgba(255,255,255,.12);
}

/* conteúdo */
#<?php echo esc_attr($uid); ?> .lilacs-grid2__content{
  padding:18px 22px 22px 22px;
  display:flex;
  flex-direction:column;
  gap:12px;
  flex:1 1 auto;
}

#<?php echo esc_attr($uid); ?> .lilacs-grid2__title{
  margin:0;
  color:#fff;
  font-size:22px;
  line-height:1.2;
  font-weight:800;
  letter-spacing:-0.2px;
}

#<?php echo esc_attr($uid); ?> .lilacs-grid2__desc{
  color:rgba(255,255,255,.92);
  font-size:13px;
  line-height:1.6;
}

#<?php echo esc_attr($uid); ?> .lilacs-grid2__desc p{
  margin:0 0 10px 0;
}
#<?php echo esc_attr($uid); ?> .lilacs-grid2__desc p:last-child{
  margin-bottom:0;
}

/* botões pill */
#<?php echo esc_attr($uid); ?> .lilacs-grid2__actions{
  margin-top:auto; /* empurra botões pro “rodapé” do card */
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  padding-top:8px;
}

#<?php echo esc_attr($uid); ?> .lilacs-grid2__btn{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  padding:10px 14px;
  border-radius:999px;
  background:#fff;
  color:#5b49d6;
  font-weight:700;
  font-size:12px;
  text-decoration:none;
  line-height:1;
  box-shadow:0 10px 18px rgba(17,24,39,.10);
  transition:transform .12s ease, opacity .12s ease;
}

#<?php echo esc_attr($uid); ?> .lilacs-grid2__btn:hover{
  transform:translateY(-1px);
  opacity:.96;
}

/* ===== responsivo ===== */
@media (max-width: 980px){
  #<?php echo esc_attr($uid); ?> .lilacs-grid2__grid{
    grid-template-columns: 1fr; /* 1 por linha no mobile/tablet */
  }
  #<?php echo esc_attr($uid); ?> .lilacs-grid2__card{
    min-height: auto;
  }
}

@media (max-width: 520px){
  #<?php echo esc_attr($uid); ?> .lilacs-grid2__container{
    width:calc(100% - 32px);
  }
  #<?php echo esc_attr($uid); ?> .lilacs-grid2__title{
    font-size:20px;
  }
}
</style>
