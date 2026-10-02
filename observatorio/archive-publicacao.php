<?php
/**
 * Publication archive template.
 *
 * @package Observatorio
 */

get_header();
?>

<main id="main-content" class="site-main publications-archive">
	<header class="page-hero section-space">
		<div class="container">
			<span class="section-kicker"><?php esc_html_e( 'Conhecimento', 'observatorio' ); ?></span>
			<h1><?php post_type_archive_title(); ?></h1>
			<p class="lead"><?php esc_html_e( 'Acesse publicações, materiais técnicos e conteúdos produzidos ou selecionados pelo Observatório.', 'observatorio' ); ?></p>
		</div>
	</header>

	<section class="section-space pt-0">
		<div class="container">
			<?php if ( have_posts() ) : ?>
				<div class="row g-4">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php $publication_type = get_field( 'publication_type' ); ?>
						<div class="col-lg-6">
							<article <?php post_class( 'publication-card publication-accent-teal h-100' ); ?>>
								<div class="row g-0 h-100">
									<div class="col-sm-4">
										<?php if ( has_post_thumbnail() ) : ?>
											<div class="publication-cover has-background-image" style="--publication-cover-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ) ); ?>');"></div>
										<?php else : ?>
											<div class="publication-cover"></div>
										<?php endif; ?>
									</div>
									<div class="col-sm-8">
										<div class="p-4 d-flex flex-column h-100">
											<?php if ( $publication_type ) : ?><span class="publication-type"><?php echo esc_html( $publication_type ); ?></span><?php endif; ?>
											<h2 class="h4 mt-2"><?php the_title(); ?></h2>
											<?php if ( has_excerpt() ) : ?><p class="text-secondary"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
											<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary mt-auto align-self-start"><?php esc_html_e( 'Ver publicação', 'observatorio' ); ?></a>
										</div>
									</div>
								</div>
							</article>
						</div>
					<?php endwhile; ?>
				</div>

				<div class="archive-pagination mt-5">
					<?php the_posts_pagination(); ?>
				</div>
			<?php else : ?>
				<p><?php esc_html_e( 'Nenhuma publicação encontrada.', 'observatorio' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
