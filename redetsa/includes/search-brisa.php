<?php $language = pll_current_language(); ?>
<section id="searchBrisa" class="padding2">
  <div class="container">
    <form name="searchForm" id="searchForm" action="https://pesquisa.bvsalud.org/brisa/" method="GET" id="formBusca" role="search">
      <div class="row g-3">
        <div class="col-9 offset-1" style="position:relative;">
          <input type="hidden" name="lang" value="<?php echo $language ?>"/>
          <input type="hidden" name="_charset_" value="utf-8"/>
          <input type="text" id="fieldSearch" class="form-control" autocomplete="off" placeholder="Buscar"  name="q" id="q" value="">
          <a id="speakBtn" href="#"><i class="fas fa-microphone-alt"></i></a>
        </div>
        <div class="col-1 float-end">
          <button type="submit" id="submitHome" class="btn btn-primary">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
</section>