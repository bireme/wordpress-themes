<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="assistive-text" for="s"><?php _e( 'Search', 'panamazonica' ); ?></label>
	<?php if ( is_search() ) { ?>
		<input type="search" value="<?php the_search_query(); ?>" name="s" id="s" />
	<?php } else { ?>
		<input type="search" placeholder="<?php esc_attr_e( 'Search','panamazonica' ); ?>" name="s" id="s" />
	<?php } ?>
	<button type="submit" id="searchsubmit"><span aria-hidden="true" data-icon="&#x1F50D;"></span><span class="assistive-text"><?php esc_attr_e( 'Search','panamazonica' ); ?></span></button>
</form>
