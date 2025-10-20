<?php $camposBanner = bireme_get_lilacs_hero_meta(get_the_ID());?>
<!-- LILACS HERO -->
<section class="lilacs-hero" aria-label="Busca Lilacs" style="background-image:url('<?=$camposBanner['img_url']?>')">
  <div class="lilacs-hero__overlay" aria-hidden="true"></div>

  <div class="lilacs-hero__inner container">
    <div class="lilacs-hero__content">
      <h1 class="lilacs-hero__title"><?=$camposBanner['title'];?></h1>
      <p class="lilacs-hero__subtitle"><?=$camposBanner['desc'];?></p>

      <form class="lilacs-search" role="search" method="get" action="<?php echo esc_url( home_url('/') ); ?>">
        <label class="screen-reader-text" for="lilacs-search-input">Pesquisar</label>

        <div class="lilacs-search__row">
          <input id="lilacs-search-input"
                 class="lilacs-search__input"
                 name="s"
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
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M21 21l-4.35-4.35" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/></svg>
          </button>
        </div>

        <div class="lilacs-search__actions">
          <a href="#busca-avancada" class="btn-pill">Busca avançada</a>
          <a href="#decs" class="btn-pill">Busca com DeCS / MeSH</a>
          <a href="#como-pesquisar" class="btn-pill">Como pesquisar</a>
        </div>
      </form>
    </div>
  </div>
</section>