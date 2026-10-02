<?php
/**
 * Main fallback template.
 *
 * @package Observatorio
 */

get_header();
?>

<main id="main-content" class="site-main section-space">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-5' ); ?>>
					<h1 class="h2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nenhum conteúdo encontrado.', 'observatorio' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
