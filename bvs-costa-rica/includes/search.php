<?php
    $site_language = strtolower(get_bloginfo('language'));
    $lang = substr($site_language,0,2);
?>

<section id="search" class="padding1" style="margin-bottom:30px;">
    <div class="container">
        <form id="formHome" method="get" action="https://pesquisa.bvsalud.org/costarica">
            <div class="row g-3">
                <div class="col-10 col-md-8 offset-md-2">
                    <input name="lang" type="hidden" value="<?php echo $lang; ?>">
                    <input name="home_url" type="hidden" value="<?php echo home_url('/'); ?>" />
                    <input name="home_text" type="hidden" value="<?php echo get_bloginfo('name'); ?>" />
                    <input name="filter[collection_costarica][]" type="hidden" id="input-filter" value="SaludCR">
                    <label for="fieldSearch" style="display: none;"><?php _e('Search', 'vhl-costa-rica'); ?></label>
                    <input type="text" id="fieldSearch" class="form-control" placeholder="<?php _e('Search', 'vhl-costa-rica'); ?>" autocomplete="off" name="q" value="<?php echo get_search_query(); ?>">
                    <div id="formText">
                        <input type="radio" name="engine" class="form-check-input" checked="checked" value="op1">
                        <label for="search-op1"> <?php _e('All databases', 'vhl-costa-rica'); ?></label>
                        <input type="radio" name="engine" class="form-check-input" value="op2">
                        <label for="search-op2"><?php _e('SaludCR - Costa Rica Health Database', 'vhl-costa-rica'); ?></label>
                    </div>
                </div>
                <div class="col-1 float-end">
                    <button type="submit" id="submitHome" class="btn btn-primary search-submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>