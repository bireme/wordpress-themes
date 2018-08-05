<?php
/**
 * The template part for displaying navigation.
 *
 */
if( is_archive() || is_home() || is_search() || is_page() ) {
	/**
	 * Checking WP-PageNaviplugin exist
	 */
	if ( function_exists('wp_pagenavi' ) ) :
		wp_pagenavi();

	else: ?>
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 pagination-grid text-center">
				<?php wordpress_pagination(); ?>
			</div>
		</div>
	<?php
	endif;
}

if ( is_single() ) {
	if( is_attachment() ) { ?>
		<ul class="default-wp-page clearfix">
			<li class="previous"><?php previous_image_link( false, __( '&larr; Anterior', 'bvs_lang' ) ); ?></li>
			<li class="next"><?php next_image_link( false, __( 'Próximo &rarr;', 'bvs_lang' ) ); ?></li>
		</ul>
	<?php
	}
	else { ?>
		<ul class="default-wp-page clearfix">
			<li class="previous">
				<?php previous_post_link( '%link', '<span class="fas fa-chevron-circle-left"></span> <span>'. __('Anterior', 'bvs_lang') .'</span>', false ); ?>
			</li>
			<li class="next">
				<?php next_post_link( '%link', '<span>'. __('Próximo', 'bvs_lang') .'</span> <span class="fas fa-chevron-circle-right"></span>', false ); ?>
			</li>
		</ul>
	<?php
	}
}

?>
