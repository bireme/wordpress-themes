<?php
/**
 * Single thematic area template.
 *
 * @package Observatorio
 */

get_header();
?>

<main id="primary-content" class="site-main">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$thematic_area_id = get_the_ID();
		$today            = current_time( 'Ymd' );

		$news_query = new WP_Query(
			array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => 3,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'meta_query'     => array(
					array(
						'key'     => 'news_thematic_area',
						'value'   => $thematic_area_id,
						'compare' => '=',
					),
				),
			)
		);

		$events_query = new WP_Query(
			array(
				'post_type'      => 'evento',
				'post_status'    => 'publish',
				'posts_per_page' => 3,
				'meta_key'       => 'event_start_date',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
				'meta_query'     => array(
					'relation' => 'AND',
					array(
						'key'     => 'event_thematic_area',
						'value'   => $thematic_area_id,
						'compare' => '=',
					),
					array(
						'key'     => 'event_start_date',
						'value'   => $today,
						'compare' => '>=',
						'type'    => 'NUMERIC',
					),
				),
			)
		);

		$publications_query = new WP_Query(
			array(
				'post_type'      => 'publicacao',
				'post_status'    => 'publish',
				'posts_per_page' => 3,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'meta_query'     => array(
					array(
						'key'     => 'publication_thematic_area',
						'value'   => $thematic_area_id,
						'compare' => '=',
					),
				),
			)
		);
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'thematic-area-single' ); ?>>
			<header class="page-hero unified-inner-hero section-space-sm">
				<div class="container">
					<p class="section-kicker"><?php esc_html_e( 'Área temática', 'observatorio' ); ?></p>
					<h1><?php the_title(); ?></h1>

					<?php if ( has_excerpt() ) : ?>
						<p class="page-intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php endif; ?>
				</div>
			</header>

            <?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="container thematic-area-featured-image">
					<?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid rounded-4' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="container section-space-sm">
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</div>

			<?php if ( $news_query->have_posts() ) : ?>
				<section class="thematic-related-section thematic-news-section section-space-sm" aria-labelledby="thematic-news-title">
					<div class="container">
						<div class="section-heading mb-4 d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3">
							<div>
								<p class="section-kicker"><?php esc_html_e( 'Atualizações', 'observatorio' ); ?></p>
								<h2 id="thematic-news-title"><?php esc_html_e( 'Notícias relacionadas', 'observatorio' ); ?></h2>
							</div>
						</div>

						<div class="row g-4">
							<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
								<div class="col-md-6 col-lg-4">
									<article class="related-content-card related-news-card h-100">
										<p class="related-content-meta"><?php echo esc_html( get_the_date() ); ?></p>
										<h3 class="h5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
										<a class="related-content-link" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Ler notícia %s', 'observatorio' ), get_the_title() ) ); ?>">&rarr;</a>
									</article>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				</section>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

			<?php if ( $events_query->have_posts() ) : ?>
				<section class="thematic-related-section thematic-events-section section-space-sm" aria-labelledby="thematic-events-title">
					<div class="container">
						<div class="section-heading mb-4">
							<p class="section-kicker"><?php esc_html_e( 'Agenda', 'observatorio' ); ?></p>
							<h2 id="thematic-events-title"><?php esc_html_e( 'Próximos eventos', 'observatorio' ); ?></h2>
						</div>

						<div class="row g-4">
							<?php while ( $events_query->have_posts() ) : $events_query->the_post(); ?>
								<?php
								$event_date = function_exists( 'get_field' ) ? get_field( 'event_start_date' ) : '';
								$event_time = function_exists( 'get_field' ) ? get_field( 'event_time' ) : '';
								?>
								<div class="col-md-6 col-lg-4">
									<article class="related-content-card related-event-card h-100">
										<?php if ( $event_date ) : ?>
											<p class="related-content-meta"><?php echo esc_html( wp_date( get_option( 'date_format' ), strtotime( $event_date ) ) ); ?></p>
										<?php endif; ?>
										<h3 class="h5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<?php if ( $event_time ) : ?>
											<p><?php echo esc_html( $event_time ); ?></p>
										<?php elseif ( has_excerpt() ) : ?>
											<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
										<?php endif; ?>
										<a class="related-content-link" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Ver evento %s', 'observatorio' ), get_the_title() ) ); ?>">&rarr;</a>
									</article>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				</section>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

			<?php if ( $publications_query->have_posts() ) : ?>
				<section class="thematic-related-section thematic-publications-section section-space-sm" aria-labelledby="thematic-publications-title">
					<div class="container">
						<div class="section-heading mb-4">
							<p class="section-kicker"><?php esc_html_e( 'Biblioteca', 'observatorio' ); ?></p>
							<h2 id="thematic-publications-title"><?php esc_html_e( 'Publicações relacionadas', 'observatorio' ); ?></h2>
						</div>

						<div class="thematic-publication-list">
							<?php while ( $publications_query->have_posts() ) : $publications_query->the_post(); ?>
								<?php get_template_part( 'template-parts/publications/publication-card' ); ?>
                            <?php endwhile; ?>
						</div>
                        <a class="btn btn-outline-primary mt-4" href="<?php echo esc_url( get_post_type_archive_link( 'publicacao' ) ); ?>"><?php esc_html_e( 'Ver todas as publicações', 'observatorio' ); ?> &rarr;</a>
					</div>
				</section>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
