<?php
/**
 * Home thematic areas section.
 *
 * @package Observatorio
 */

$thematic_areas = new WP_Query(
	array(
		'post_type'      => 'area_tematica',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
		'order'          => 'ASC',
	)
);
?>

<section id="thematic-areas" class="thematic-section section-space">
	<div class="container">
		<div class="section-heading mb-4">
			<span class="section-kicker d-none"><?php echo esc_html( observatorio_home_copy( 'thematic_areas', 'title', 'Áreas temáticas' ) ); ?></span>
			<h2><?php esc_html_e( 'Áreas temáticas', 'observatorio' ); ?></h2>
			<p class="section-intro"><?php echo esc_html( observatorio_home_copy( 'thematic_areas', 'description', 'Acesse conteúdos organizados nos eixos temáticos do Observatório.' ) ); ?></p>
		</div>

		<?php if ( $thematic_areas->have_posts() ) : ?>
			<div class="row g-4">
				<?php while ( $thematic_areas->have_posts() ) : $thematic_areas->the_post(); ?>
					<?php
					$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
					$summary       = wp_html_excerpt( wp_strip_all_tags( get_the_excerpt() ), 180, '…' );
					?>
					<div class="col-lg-6">
						<a class="thematic-card thematic-card-link d-block" href="<?php the_permalink(); ?>">
							<?php if ( $thumbnail_url ) : ?>
								<div
									class="thematic-image"
									style="--thematic-image: url('<?php echo esc_url( $thumbnail_url ); ?>');"
									role="img"
									aria-label="<?php echo esc_attr( get_the_title() ); ?>"
								></div>
							<?php endif; ?>

							<div class="thematic-overlay"></div>

							<div class="thematic-content">
								<h3><?php the_title(); ?></h3>

								<?php if ( $summary ) : ?>
									<p><?php echo esc_html( $summary ); ?></p>
								<?php endif; ?>

								<span class="btn btn-outline-light">
									<?php esc_html_e( 'Acessar área temática', 'observatorio' ); ?><svg class="action-arrow-icon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16m-7-7 7 7-7 7"/></svg>
								</span>
							</div>
						</a>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
wp_reset_postdata();
