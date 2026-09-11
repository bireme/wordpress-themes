<?php
/**
 * DOBRA: pagina-normas_e_diretrizes_em_comunicacao_cientifica
 * Layout ACF: normas_e_diretrizes_em_comunicacao_cientifica
 * Render: título à esquerda + faixa de logos (com links) à direita
 */

if ( ! defined('ABSPATH') ) exit;

$titulo = (string) get_sub_field('titulo');

if ( empty($titulo) && ! have_rows('links') ) {
    return;
}

$uid = 'lilacs-normas-' . wp_generate_uuid4();
?>

<section class="lilacs-normas" id="<?php echo esc_attr($uid); ?>">
  <div class="lilacs-normas__container">

    <?php if ( ! empty($titulo) ) : ?>
      <h3 class="lilacs-normas__title">
        <?php echo esc_html($titulo); ?>
      </h3>
    <?php endif; ?>

    <?php if ( have_rows('links') ) : ?>
      <div class="lilacs-normas__logos" aria-label="Normas e diretrizes">
        <?php while ( have_rows('links') ) : the_row();

          $img  = get_sub_field('imagem');          // image (url)
          $link = get_sub_field('link_da_imagem');  // url

          if ( empty($img) ) continue;

          $tag   = ! empty($link) ? 'a' : 'span';
          $attrs = ! empty($link)
            ? 'href="' . esc_url($link) . '" target="_blank" rel="noopener noreferrer"'
            : '';
        ?>
          <<?php echo $tag; ?> class="lilacs-normas__logo" <?php echo $attrs; ?>>
            <img src="<?php echo esc_url($img); ?>" alt="" loading="lazy">
          </<?php echo $tag; ?>>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<style>
/* wrapper */
#<?php echo esc_attr($uid); ?>.lilacs-normas{
    width: 100%;
    padding: 22px 0;
    background: #fff;
    height: 169px;
    display: flex;
    border-top: 2px solid #082a53;
}

/* container */
#<?php echo esc_attr($uid); ?> .lilacs-normas__container{
  width:min(1200px, calc(100% - 48px));
  margin:0 auto;
  display:flex;
  align-items:center;
  gap:28px;
}

/* título à esquerda */
#<?php echo esc_attr($uid); ?> .lilacs-normas__title{
  margin:0;
  font-size:26px;
  line-height:1.2;
  font-weight:800;
  color:#0b2f57;
  max-width:340px;
}

/* logos à direita */
#<?php echo esc_attr($uid); ?> .lilacs-normas__logos{
  flex:1 1 auto;
  display:flex;
  align-items:center;
  gap:26px;

  /* ✅ scroll horizontal suave no desktop */
  overflow-x:auto;
  overflow-y:hidden;
  white-space:nowrap;
  scroll-behavior:smooth;
  -webkit-overflow-scrolling:touch;
  padding-bottom: 6px; /* espaço p/ não "cortar" a sombra/hover */
  scrollbar-gutter: stable both-edges;
}

/* barra de rolagem (discreta) */
#<?php echo esc_attr($uid); ?> .lilacs-normas__logos::-webkit-scrollbar{
  height: 8px;
}
#<?php echo esc_attr($uid); ?> .lilacs-normas__logos::-webkit-scrollbar-track{
  background: rgba(0,0,0,.06);
  border-radius: 999px;
}
#<?php echo esc_attr($uid); ?> .lilacs-normas__logos::-webkit-scrollbar-thumb{
  background: rgba(8,42,83,.28);
  border-radius: 999px;
}
#<?php echo esc_attr($uid); ?> .lilacs-normas__logos::-webkit-scrollbar-thumb:hover{
  background: rgba(8,42,83,.42);
}

/* item */
#<?php echo esc_attr($uid); ?> .lilacs-normas__logo{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  padding:8px 10px;
  border-radius:10px;
  text-decoration:none;
  transition:transform .12s ease, opacity .12s ease;

  /* ✅ garante que os itens não "quebrem" e não encolham */
  flex: 0 0 auto;
}

#<?php echo esc_attr($uid); ?> .lilacs-normas__logo:hover{
  transform:translateY(-1px);
  opacity:.95;
}

#<?php echo esc_attr($uid); ?> .lilacs-normas__logo img{
  display:block;
  height:55px;
  width:auto;
  object-fit:contain;
}

/* responsivo */
@media (max-width: 980px){
  #<?php echo esc_attr($uid); ?> .lilacs-normas__container{
    flex-direction:column;
    align-items:flex-start;
    gap:14px;
  }

  /* no mobile mantém como wrap (como você já tinha) */
  #<?php echo esc_attr($uid); ?> .lilacs-normas__logos{
    overflow-x: visible;
    white-space: normal;
    flex-wrap:wrap;
    gap:14px 18px;
    padding-bottom: 0;
  }

  #<?php echo esc_attr($uid); ?> .lilacs-normas__logo img{
    height:32px;
  }
}
</style>
