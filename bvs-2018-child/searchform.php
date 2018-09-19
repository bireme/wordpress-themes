<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <input type="search" class="search-field form-control" placeholder="<?php _e('Buscar', 'bvs_lang'); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php _e('Buscar por:', 'bvs_lang'); ?>">
    </label>
    <input type="submit" class="search-submit btn btn-primary" value="<?php _e('Buscar', 'bvs_lang'); ?>">
</form>