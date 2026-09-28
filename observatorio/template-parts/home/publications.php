<?php
/**
 * Home publications section.
 *
 * @package Observatorio
 */

$publications_query = new WP_Query(
	array(
		'post_type'      => 'publicacao',
		'post_status'    => 'publish',
		'posts_per_page' => 2,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

$publications_archive_url = get_post_type_archive_link( 'publicacao' );
$accent_classes           = array( 'publication-accent-teal', 'publication-accent-coral' );
?>

<section id="publications" class="publications-section section-space">
	<div class="container">
		<div class="section-heading mb-4 d-lg-flex justify-content-between align-items-end gap-4">
			<div>
				<span class="section-kicker"><?php esc_html_e( 'Conhecimento', 'observatorio' ); ?></span>
				<h2><?php esc_html_e( 'Publicações', 'observatorio' ); ?></h2>
				<p class="section-intro mb-0"><?php esc_html_e( 'Policy briefs e materiais técnicos para apoiar decisões e políticas públicas.', 'observatorio' ); ?></p>
			</div>

			<?php if ( $publications_archive_url ) : ?>
				<a href="<?php echo esc_url( $publications_archive_url ); ?>" class="btn btn-outline-primary mt-3 mt-lg-0 flex-shrink-0">
					<?php esc_html_e( 'Ver todas as publicações', 'observatorio' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<?php if ( $publications_query->have_posts() ) : ?>
			<div class="row g-4">
				<?php
				$publication_index = 0;

				while ( $publications_query->have_posts() ) :
					$publications_query->the_post();

					$publication_type = get_field( 'publication_type' );
					$accent_class     = $accent_classes[ $publication_index % count( $accent_classes ) ];
					$cover_style      = '';

					if ( has_post_thumbnail() ) {
						$cover_url = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
						$cover_style = $cover_url ? '--publication-cover-image: url(' . esc_url( $cover_url ) . ');' : '';
					}
					?>
					<div class="col-lg-6">
						<article <?php post_class( 'publication-card ' . $accent_class . ' h-100' ); ?>>
							<div class="row g-0 h-100">
								<div class="col-sm-4">
									<div class="publication-cover<?php echo $cover_style ? ' has-background-image' : ''; ?>"<?php echo $cover_style ? ' style="' . esc_attr( $cover_style ) . '"' : ''; ?>></div>
								</div>
								<div class="col-sm-8">
									<div class="p-4 d-flex flex-column h-100">
										<?php if ( $publication_type ) : ?>
											<span class="publication-type"><?php echo esc_html( $publication_type ); ?></span>
										<?php endif; ?>

										<h3 class="h4 mt-2"><?php the_title(); ?></h3>

										<?php if ( has_excerpt() ) : ?>
											<p class="text-secondary"><?php echo esc_html( get_the_excerpt() ); ?></p>
										<?php endif; ?>

										<a href="<?php the_permalink(); ?>" class="btn btn-outline-primary mt-auto align-self-start">
											<?php esc_html_e( 'Ver publicação', 'observatorio' ); ?>
										</a>
									</div>
								</div>
							</div>
						</article>
					</div>
					<?php
					$publication_index++;
				endwhile;
				?>
			</div>
		<?php else : ?>
			<div class="publications-empty">
				<p class="mb-0"><?php esc_html_e( 'Nenhuma publicação disponível no momento.', 'observatorio' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php wp_reset_postdata(); ?>
