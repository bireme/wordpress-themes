<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Pesquisar...', 'bvs-ecos' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php _ex( 'Pesquisar por:', 'bvs-ecos' ); ?>">
    </label>
    <input type="submit" class="search-submit btn btn-primary" value="<?php echo esc_attr_x( 'Pesquisar', 'bvs-ecos' ); ?>">
</form>



