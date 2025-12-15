<?php
/**
 * Single: indicador
 * Banner superior com título + conteúdo encaixotado
 */

if (!defined('ABSPATH')) exit;

get_header();

if (have_posts()) :
  while (have_posts()) : the_post();

    $title   = get_the_title();
    $content = get_the_content();

    // imagem destacada opcional para o banner
    $featured_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $banner_style = $featured_url
      ? 'background-image:url(' . esc_url($featured_url) . ');'
      : 'background: linear-gradient(135deg, #082A53 0%, #0b2f57 55%, #0a3a72 100%);';

    // breadcrumb: Home - Indicadores - Título
    $indicadores_url = get_post_type_archive_link('indicador');
    if (empty($indicadores_url)) $indicadores_url = home_url('/indicador/');

    $uid = 'lilacs-single-indicador-' . wp_generate_uuid4();
?>

<section id="<?php echo esc_attr($uid); ?>" class="lsi">

  <header class="lsi-hero" style="<?php echo esc_attr($banner_style); ?>">
    <div class="lsi-hero__overlay" aria-hidden="true"></div>

    <div class="lsi-container">
      <nav class="lsi-breadcrumb" aria-label="Breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span class="lsi-sep">-</span>
        <a href="<?php echo esc_url($indicadores_url); ?>">Indicadores</a>
        <span class="lsi-sep">-</span>
        <span class="lsi-current"><?php echo esc_html($title); ?></span>
      </nav>

      <h1 class="lsi-title"><?php echo esc_html($title); ?></h1>
    </div>
  </header>

  <main class="lsi-body">
    <div class="lsi-container">

      <article class="lsi-card">
        <div class="lsi-content">
          <?php
            // mantém blocos do Gutenberg bonitinhos
            echo apply_filters('the_content', $content);
          ?>
        </div>
      </article>

    </div>
  </main>

</section>

<style>
/* Font global */
#<?php echo esc_attr($uid); ?>,
#<?php echo esc_attr($uid); ?> *{
  font-family: "Noto Sans", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

/* container */
#<?php echo esc_attr($uid); ?> .lsi-container{
  width:min(1200px, calc(100% - 48px));
  margin:0 auto;
}

/* HERO */
#<?php echo esc_attr($uid); ?> .lsi-hero{
  position:relative;
  width:100%;
  min-height: 190px;
  padding: 28px 0 26px;
  background-size:cover;
  background-position:center;
  background-repeat:no-repeat;
  border-bottom: 2px solid rgba(8,42,83,.25);
}

#<?php echo esc_attr($uid); ?> .lsi-hero__overlay{
  position:absolute;
  inset:0;
  background: rgba(8,42,83,.72);
}

#<?php echo esc_attr($uid); ?> .lsi-hero .lsi-container{
  position:relative;
  z-index:2;
}

/* breadcrumb */
#<?php echo esc_attr($uid); ?> .lsi-breadcrumb{
  display:flex;
  flex-wrap:wrap;
  gap:8px;
  align-items:center;
  font-size:12px;
  color: rgba(255,255,255,.85);
  margin-bottom: 10px;
}
#<?php echo esc_attr($uid); ?> .lsi-breadcrumb a{
  color: rgba(255,255,255,.85);
  text-decoration:none;
}
#<?php echo esc_attr($uid); ?> .lsi-breadcrumb a:hover{
  text-decoration:underline;
}
#<?php echo esc_attr($uid); ?> .lsi-sep{ opacity:.85; }
#<?php echo esc_attr($uid); ?> .lsi-current{
  color:#fff;
  font-weight:800;
}

/* título */
#<?php echo esc_attr($uid); ?> .lsi-title{
  margin:0;
  color:#fff;
  font-size:28px;
  line-height:1.15;
  font-weight:900;
  letter-spacing:-.2px;
  max-width: 980px;
}

/* BODY */
#<?php echo esc_attr($uid); ?> .lsi-body{
  background:#fff;
  padding: 22px 0 48px;
}

/* card do conteúdo */
#<?php echo esc_attr($uid); ?> .lsi-card{
  border:1px solid #e6eef6;
  border-radius:14px;
  background:#fff;
  box-shadow: 0 14px 30px rgba(8,42,83,.06);
  padding: 18px 18px;
}

/* conteúdo */
#<?php echo esc_attr($uid); ?> .lsi-content{
  color:#0f172a;
  font-size:14px;
  line-height:1.7;
}
#<?php echo esc_attr($uid); ?> .lsi-content h2,
#<?php echo esc_attr($uid); ?> .lsi-content h3{
  color:#0b2f57;
}

/* Gutenberg: imagens e embeds responsivos */
#<?php echo esc_attr($uid); ?> .lsi-content img{
  max-width:100%;
  height:auto;
  border-radius:12px;
}
#<?php echo esc_attr($uid); ?> .lsi-content iframe,
#<?php echo esc_attr($uid); ?> .lsi-content video{
  max-width:100%;
}

/* responsivo */
@media (max-width: 920px){
  #<?php echo esc_attr($uid); ?> .lsi-hero{ min-height: 160px; padding: 22px 0; }
  #<?php echo esc_attr($uid); ?> .lsi-title{ font-size:22px; }
  #<?php echo esc_attr($uid); ?> .lsi-card{ padding: 14px; }
}
</style>

<?php
  endwhile;
endif;

get_footer();
