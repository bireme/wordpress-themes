<?php
/**
 * Home events section.
 *
 * @package Observatorio
 */

$current_date = current_time( 'Ymd' );

$future_events = get_posts(
	array(
		'post_type'      => 'evento',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'meta_key'       => 'event_start_date',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'     => 'event_start_date',
				'value'   => $current_date,
				'compare' => '>=',
				'type'    => 'NUMERIC',
			),
		),
	)
);

$events = $future_events;

if ( count( $events ) < 3 ) {
	$remaining = 3 - count( $events );

	$past_events = get_posts(
		array(
			'post_type'      => 'evento',
			'post_status'    => 'publish',
			'posts_per_page' => $remaining,
			'meta_key'       => 'event_start_date',
			'orderby'        => 'meta_value_num',
			'order'          => 'DESC',
			'meta_query'     => array(
				array(
					'key'     => 'event_start_date',
					'value'   => $current_date,
					'compare' => '<',
					'type'    => 'NUMERIC',
				),
			),
		)
	);

	$events = array_merge( $events, $past_events );
}

$events = array_values( array_unique( $events, SORT_REGULAR ) );

$events_archive_url = get_post_type_archive_link( 'evento' );
$accent_classes     = array( 'event-accent-teal', 'event-accent-yellow', 'event-accent-coral' );
?>

<section id="events" class="events-section section-space">
	<div class="container">
		<div class="row g-4 g-xl-5 align-items-stretch">
			<div class="col-lg-4">
				<div class="events-intro h-100 d-flex flex-column justify-content-center">
					<h2><?php echo esc_html( observatorio_home_copy( 'events', 'title', 'Agenda' ) ); ?></h2>
					<p><?php esc_html_e( 'Encontros, seminários e atividades para promover diálogo, intercâmbio de experiências e disseminação de conhecimento sobre políticas, sistemas e inovação em saúde.', 'observatorio' ); ?></p>

					<?php if ( $events_archive_url ) : ?>
						<a href="<?php echo esc_url( $events_archive_url ); ?>" class="btn btn-primary align-self-start mt-2">
							<?php esc_html_e( 'Ver agenda', 'observatorio' ); ?><svg class="action-arrow-icon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16m-7-7 7 7-7 7"/></svg>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<div class="col-lg-8">
				<?php if ( $events ) : ?>
					<div class="row g-3 h-100">
						<?php
						$event_index = 0;

						foreach ( $events as $event_post ) :

							$start_date = get_field( 'event_start_date', $event_post->ID );
							$event_time = get_field( 'event_time', $event_post->ID );
							$event_mode = get_field( 'event_mode', $event_post->ID );
							$format     = get_field( 'event_format', $event_post->ID );
							$date       = $start_date ? DateTime::createFromFormat( 'Ymd', $start_date ) : false;
							$accent     = $accent_classes[ $event_index % count( $accent_classes ) ];
							$meta_parts = array_filter( array( $event_time, $event_mode ) );
							$is_past    = $start_date && (int) $start_date < (int) $current_date;
							?>
							<div class="col-md-4">
								<article class="event-card <?php echo esc_attr( $accent ); ?><?php echo $is_past ? ' is-past-event' : ''; ?> h-100">
									<?php if ( $date ) : ?>
										<div class="event-date">
											<strong><?php echo esc_html( $date->format( 'd' ) ); ?></strong>
											<span><?php echo esc_html( wp_date( 'M', $date->getTimestamp() ) ); ?></span>
										</div>
									<?php endif; ?>

									<div class="event-body">
										<?php if ( $format ) : ?>
											<span class="event-format"><?php echo esc_html( $format ); ?></span>
										<?php endif; ?>

										<h3><?php echo esc_html( get_the_title( $event_post->ID ) ); ?></h3>

										<?php if ( $meta_parts ) : ?>
											<p><?php echo esc_html( implode( ' · ', $meta_parts ) ); ?></p>
										<?php endif; ?>

										<a href="<?php echo esc_url( get_permalink( $event_post->ID ) ); ?>" class="event-link stretched-link" aria-label="<?php echo esc_attr( sprintf( __( 'Ver evento %s', 'observatorio' ), get_the_title( $event_post->ID ) ) ); ?>"><svg class="action-arrow-icon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16m-7-7 7 7-7 7"/></svg></a>
									</div>
								</article>
							</div>
							<?php
							$event_index++;
						endforeach;
						?>
					</div>
				<?php else : ?>
					<div class="events-empty d-flex align-items-center justify-content-center h-100">
						<p class="mb-0"><?php esc_html_e( 'Nenhum evento disponível no momento.', 'observatorio' ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php wp_reset_postdata(); ?>
