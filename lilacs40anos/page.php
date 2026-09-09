<?php
/**
 * Template padrão de página.
 * Renderiza as dobras ACF (campo "layout") quando existirem;
 * caso contrário, exibe o conteúdo padrão da página.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main>
	<section class="lilacs-pagina-layout">
		<div class="lilacs-pagina-layout-inner">
			<?php
			if ( function_exists( 'have_rows' ) && have_rows( 'layout' ) ) :
				while ( have_rows( 'layout' ) ) :
					the_row();
					$layout = get_row_layout();
					if ( ! $layout ) {
						continue;
					}
					lilacs_bvs_dobra( 'pagina-' . $layout );
				endwhile;
			else :
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'lilacs-gutenberg-content' ); ?>>
							<div class="lilacs-content-entry">
								<?php the_content(); ?>
							</div>
						</article>
						<?php
					endwhile;
				endif;
			endif;
			?>
		</div>
	</section>
</main>

<?php
get_footer();
