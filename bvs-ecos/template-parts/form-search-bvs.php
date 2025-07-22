<?php $lang = get_current_language(); ?>
<form id="form-search-bvs" method="GET" action="https://pesquisa.bvsalud.org/economia/">
    <input type="hidden" name="lang" value="<?php echo $lang; ?>">
    <input type="hidden" name="home_url" value="<?php echo esc_url( home_url( '/' )); ?>">
    <input type="hidden" name="home_text" value="<?php esc_url(bloginfo('name')); ?>">
    <input type="hidden" id="filter_db" name="filter[db][]" value="ECOS">
    <input type="hidden" name="inputval" class="vhl-search-submit" value="<?php _e("Pesquisar", "bvs-ecos"); ?>">

    <div class="d-flex justify-content-center">
        <input class="form-control me-2" type="text" name="q" placeholder="<?php _e("O que você está procurando hoje?", "bvs-ecos"); ?>" aria-label="Search" />
        <button class="btn btn-primary" type="submit"><?php _e("Pesquisar", "bvs-ecos"); ?></button>
    </div>
    <div class="grid-field-bellow">
        <div class="form-checks">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="engine" id="ecos-bases-check" value="ECOS" checked="checked"/>
                <label class="form-check-label" for="ecos-bases-check"><?php _e("Base Ecos", "bvs-ecos"); ?></label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="engine" id="all-bases-check" value=""/>
                <label class="form-check-label" for="all-bases-check"><?php _e("Todas as Bases de dados", "bvs-ecos"); ?></label>
            </div>            
        </div>

        <?php $advanced_search_link = esc_attr(get_option($lang . '_section_2_link_advanced_search')); ?>
        <a target="_blank" href="<?php echo $advanced_search_link; ?>" class="btn-link"><?php _e("Pesquisa Avançada", "bvs-ecos"); ?></a>
    </div>
</form>