<?php
/**
 * Layout ACF: banner_copiar (layout_69a983a024e82)
 * Uso dentro do loop have_rows('layout'): the_row();
 */

$titulo        = (string) get_sub_field('titulo_banner');
$descricao     = (string) get_sub_field('descricao_banner');
$highlight     = (string) get_sub_field('texto_complementar_descricao_banner');
$pos_highlight = (string) get_sub_field('posicao_do_highlight'); // 'titulo' | 'descricao'
$bg            = (string) get_sub_field('fundo_banner'); // return_format = url
$no_overlay    = (string) get_sub_field('desativar_overlay'); // 'sim' | 'nao'
$cor_titulo    = (string) get_sub_field('cor_da_fonte_do_titulo');
$cor_desc      = (string) get_sub_field('cor_da_fonte_da_descricao');

// Grupos (cada um tem link_1 e texto_1)
$links_1 = (array) get_sub_field('links_rapidos');            // Busca avançada
$links_2 = (array) get_sub_field('links_rapidos_copiar');     // DeCS/MeSH
$links_3 = (array) get_sub_field('como_pesquisar');           // Como pesquisar

$href_1  = !empty($links_1['link_1'])  ? esc_url($links_1['link_1'])  : 'https://pesquisa.bvsalud.org/portal/advanced/';
$txt_1   = !empty($links_1['texto_1']) ? esc_html($links_1['texto_1']) : 'Busca avançada';

$href_2  = !empty($links_2['link_1'])  ? esc_url($links_2['link_1'])  : 'https://pesquisa.bvsalud.org/portal/decs-locator/?output=site&lang=pt&from=0&sort=&format=summary&count=20&fb=&page=1&tab=&range_year_start=&range_year_end=&skfp=&index=&q=';
$txt_2   = !empty($links_2['texto_1']) ? esc_html($links_2['texto_1']) : 'Busca com DeCS / MeSH';

$href_3  = !empty($links_3['link_1'])  ? esc_url($links_3['link_1'])  : '/como-pesquisar';
$txt_3   = !empty($links_3['texto_1']) ? esc_html($links_3['texto_1']) : 'Como pesquisar';

// Estilos inline (cores vindas do ACF)
$style_titulo = $cor_titulo ? 'style="color:' . esc_attr($cor_titulo) . ';"' : '';
$style_desc   = $cor_desc   ? 'style="color:' . esc_attr($cor_desc) . ';"'   : '';
$style_bg     = $bg ? 'style="background-image:url(' . esc_url($bg) . ');"' : '';
?>

<section class="lilacs-hero" <?php echo $style_bg; ?>>
  <?php if ($no_overlay !== 'sim') : ?>
    <div class="lilacs-hero__overlay" aria-hidden="true"></div>
  <?php endif; ?>

  <div class="lilacs-hero__inner">
    <header class="lilacs-hero__head">
      <?php if ($titulo) : ?>
        <h1 class="lilacs-hero__title" <?php echo $style_titulo; ?>>
          <?php echo esc_html($titulo); ?>
        </h1>
      <?php endif; ?>

      <?php if ($pos_highlight === 'titulo' && $highlight) : ?>
        <div class="lilacs-hero__highlight" <?php echo $style_desc; ?>>
          <?php echo esc_html($highlight); ?>
        </div>
      <?php endif; ?>

      <?php if ($descricao) : ?>
        <p class="lilacs-hero__subtitle" <?php echo $style_desc; ?>>
          <?php echo esc_html($descricao); ?>
        </p>
      <?php endif; ?>

      <?php if ($pos_highlight === 'descricao' && $highlight) : ?>
        <div class="lilacs-hero__highlight" <?php echo $style_desc; ?>>
          <?php echo esc_html($highlight); ?>
        </div>
      <?php endif; ?>
    </header>

    <!-- FORM (exatamente como você pediu) -->
    <form class="lilacs-search" role="search" method="get" action="https://pesquisa.bvsalud.org/portal/">
      <label class="screen-reader-text" for="lilacs-search-input">Pesquisar</label>
      <input type="hidden" name="home_url" value="http://lilacs.bvsalud.org">

      <input type="hidden" name="lang" value="pt">

      <div class="lilacs-search__row">
        <input id="lilacs-search-input" class="lilacs-search__input" name="q" type="search" placeholder="Insira sua pesquisa aqui" aria-label="Pesquisar" autocomplete="off">

        <button type="button" class="lilacs-search__mic" title="Ativar ditado" aria-label="Ativar ditado">
          <span class="sr-only">microfone</span>
          <!-- SVG mic icon -->
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 14a3 3 0 0 0 3-3V5a3 3 0 0 0-6 0v6a3 3 0 0 0 3 3z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M19 11v1a7 7 0 0 1-14 0v-1" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 21v-3" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </button>

        <button type="submit" class="lilacs-search__btn" aria-label="Buscar">
          <img src="https://lilacs.teste.bvsalud.org/wp-content/themes/bireme-lilacs/assets/images/lupa.png" alt="Ícone de lupa para busca">
        </button>
      </div>

      <div class="lilacs-search__actions">
        <div class="lilacs-search_cts">
          <a href="<?php echo $href_1; ?>" class="btn-pill"><?php echo $txt_1; ?></a>
          <a href="<?php echo $href_2; ?>" class="btn-pill"><?php echo $txt_2; ?></a>
        </div>
        <div class="lilacs-help">
          <a href="<?php echo $href_3; ?>" class="btn-pill"><?php echo $txt_3; ?></a>
        </div>
      </div>
    </form>
  </div>
</section>

<style>
    /* HERO (banner) */
.lilacs-hero{
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  overflow: hidden;
}
.lilacs-hero__overlay{
  position:absolute; inset:0;
  background: linear-gradient(90deg, rgba(23,37,84,.68), rgba(30,64,175,.45), rgba(88,28,135,.45));
  pointer-events:none;
}
.lilacs-hero__inner{
  position: relative;
  width: min(1180px, calc(100% - 48px));
  padding: 56px 0 54px;
  text-align: center;
  display: flex;
 flex-direction:column;

}
.lilacs-search__actions .btn-pill{
    font-family: 'Noto Sans';
    display: flex;
    padding: 10px 18px;
    border-radius: 22px;
    background: #072a53;
    color: #fff;
    text-decoration: none;
    font-weight: 400;
    font-size: 20px;
    box-shadow: inset 0 -2px 0 rgba(0, 0, 0, 0.08);
    margin-right: 10px;
    width: fit-content;
    padding-right: 45px;
    padding-left: 45px;
}
.lilacs-hero__title{
  margin: 0 auto 14px;
  font-weight: 700;
  font-size: clamp(28px, 3.2vw, 36px);
  line-height: 1.15;
  color: #fff;
}
.lilacs-hero__subtitle{
  margin: 0 auto 26px;
  font-size: clamp(14px, 1.4vw, 24px);
  line-height: 1.55;
  color: rgba(255,255,255,.92);
}
.lilacs-hero__highlight{
  margin: 0 auto 16px;
  max-width: 980px;
  font-size: 16px;
  font-weight: 600;
  color: rgba(255,255,255,.95);
}

/* FORM */
.lilacs-search{
  margin: 0 auto;
  width: 100%;
}
.lilacs-search__row{
  display:flex;
  align-items: stretch;
  border-radius: 6px;
  overflow: hidden;
  box-shadow: 0 18px 40px rgba(0,0,0,.18);
  background:#fff;
}
.lilacs-search__input{
  flex:1;
  border:0;
  padding: 18px 18px;
  font-size: 16px;
  outline:none;
}
.lilacs-search__mic{
  width: 68px;
  border:0;
  background:transparent;
  display:flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
}
.lilacs-search__btn{
  width: 70px;
  border:0;
  background:#f97316;
  display:flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
}
.lilacs-search__btn img{ width: 22px; height: 22px; }

.lilacs-search__actions{
display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    margin-top: 16px;
    flex-direction: row;
}
.lilacs-search_cts{ 
        display: flex;
    gap: 14px;
    flex-wrap: wrap;
    justify-content: flex-start;
    flex-direction: row;
    align-items: center;

}
.lilacs-help{ display:flex; justify-content:center; width:26%;}

.btn-pill{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  padding: 12px 22px;
  border-radius: 999px;
  text-decoration:none;
  font-weight: 600;
  color:#fff;
  background: rgba(2, 18, 43, .72);
  border: 1px solid rgba(255,255,255,.15);
  backdrop-filter: blur(6px);
}
.btn-pill:hover{ background: rgba(2, 18, 43, .85); }

@media (max-width: 820px){
  .lilacs-hero{ min-height: 560px; }
  .lilacs-search__actions{
    flex-direction: column;
    align-items: center;
  }
}
</style>