<?php
/**
 * Event archive template.
 *
 * @package Observatorio
 */

get_header();
?>

<main id="main-content" class="site-main events-archive">
	<header class="page-hero section-space">
		<div class="container">
			<span class="section-kicker"><?php esc_html_e( 'Agenda', 'observatorio' ); ?></span>
			<h1><?php post_type_archive_title(); ?></h1>
			<p class="lead"><?php esc_html_e( 'Acompanhe encontros, seminários e outras atividades do Observatório.', 'observatorio' ); ?></p>
		</div>
	</header>

	<section class="section-space pt-0">
		<div class="container">
			<?php if ( have_posts() ) : ?>
				<div class="row g-4">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php
						$start_date = get_field( 'event_start_date' );
						$event_time = get_field( 'event_time' );
						$event_mode = get_field( 'event_mode' );
						$format     = get_field( 'event_format' );
						$date       = $start_date ? DateTime::createFromFormat( 'Ymd', $start_date ) : false;
						?>
						<div class="col-md-6 col-xl-4">
							<article <?php post_class( 'event-card event-accent-teal h-100' ); ?>>
								<?php if ( $date ) : ?>
									<div class="event-date"><strong><?php echo esc_html( $date->format( 'd' ) ); ?></strong><span><?php echo esc_html( wp_date( 'M', $date->getTimestamp() ) ); ?></span></div>
								<?php endif; ?>
								<div class="event-body">
									<?php if ( $format ) : ?><span class="event-format"><?php echo esc_html( $format ); ?></span><?php endif; ?>
									<h2 class="h5"><?php the_title(); ?></h2>
									<?php if ( $event_time || $event_mode ) : ?><p><?php echo esc_html( implode( ' · ', array_filter( array( $event_time, $event_mode ) ) ) ); ?></p><?php endif; ?>
									<a href="<?php the_permalink(); ?>" class="event-link stretched-link" aria-label="<?php echo esc_attr( sprintf( __( 'Ver evento %s', 'observatorio' ), get_the_title() ) ); ?>">→</a>
								</div>
							</article>
						</div>
					<?php endwhile; ?>
				</div>

				<div class="archive-pagination mt-5">
					<?php the_posts_pagination(); ?>
				</div>
			<?php else : ?>
				<p><?php esc_html_e( 'Nenhum evento encontrado.', 'observatorio' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
