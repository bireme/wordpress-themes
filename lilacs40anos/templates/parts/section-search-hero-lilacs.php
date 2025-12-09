<?php $camposBanner = bireme_get_lilacs_hero_meta(get_the_ID());?>
<!-- LILACS HERO -->
<section class="lilacs-hero" aria-label="Busca Lilacs" style="background-image:url('<?=$camposBanner['img_url']?>')">
  <div class="lilacs-hero__overlay" aria-hidden="true"></div>

  <div class="lilacs-hero__inner container">
    <div class="lilacs-hero__content">
      <h1 class="lilacs-hero__title"><?=$camposBanner['title'];?></h1>
      <p class="lilacs-hero__subtitle"><?=$camposBanner['desc'];?></p>

      <form class="lilacs-search" role="search" method="get" action="https://pesquisa.bvsalud.org/portal/">
        <label class="screen-reader-text" for="lilacs-search-input">Pesquisar</label>
        <input type="hidden" name="home_url" value="http://lilacs.bvsalud.org">

        <?php
        // Campo de idioma dinâmico para o formulário de busca (compatível com Polylang)
        $pll_lang = function_exists('pll_current_language') ? pll_current_language() : '';
        // Mapear variações possíveis para códigos esperados pelo sistema de busca
        $lang_map = [
          'pt' => 'pt', 'pt-br' => 'pt', 'pt_br' => 'pt',
          'en' => 'en', 'en-us' => 'en', 'en_us' => 'en',
          'es' => 'es', 'es-es' => 'es', 'es_es' => 'es'
        ];
        $lang_field = 'es'; // fallback padrão
        if ($pll_lang) {
          $pll_key = strtolower($pll_lang);
          $lang_field = isset($lang_map[$pll_key]) ? $lang_map[$pll_key] : substr($pll_key, 0, 2);
        }
        ?>
        <input type="hidden" name="lang" value="<?php echo esc_attr($lang_field); ?>">

        <div class="lilacs-search__row">
          <input id="lilacs-search-input"
                 class="lilacs-search__input"
                 name="q"
                 type="search"
                 placeholder="Insira sua pesquisa aqui"
                 aria-label="Pesquisar"
                 autocomplete="off">

          <button type="button" class="lilacs-search__mic" title="Ativar ditado" aria-label="Ativar ditado">
            <span class="sr-only">microfone</span>
            <!-- SVG mic icon -->
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 14a3 3 0 0 0 3-3V5a3 3 0 0 0-6 0v6a3 3 0 0 0 3 3z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 11v1a7 7 0 0 1-14 0v-1" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 21v-3" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>

           <button type="submit" class="lilacs-search__btn" aria-label="Buscar">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/lupa.png" alt="Ícone de lupa para busca">
           </button>
        </div>

    <div class="lilacs-search__actions">
      <div class="lilacs-search_cts">
        <?php
          $l1 = $camposBanner['links'][0] ?? ['text'=>'Busca avançada','url'=>'#busca-avancada'];
          $l2 = $camposBanner['links'][1] ?? ['text'=>'Busca com DeCS / MeSH','url'=>'#decs'];
        ?>
        <a href="<?php echo esc_url($l1['url']); ?>" class="btn-pill"><?php echo esc_html($l1['text']); ?></a>
        <a href="<?php echo esc_url($l2['url']); ?>" class="btn-pill"><?php echo esc_html($l2['text']); ?></a>
      </div>
       <div class="lilacs-help">
      <?php $l3 = $camposBanner['links'][2] ?? ['text'=>'Como pesquisar','url'=>'#como-pesquisar']; ?>
      <a href="<?php echo esc_url($l3['url']); ?>" class="btn-pill"><?php echo esc_html($l3['text']); ?></a>
</div>
    </div>
      </form>
    </div>
  </div>
</section>