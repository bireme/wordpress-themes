<?php
/**
 * Single event template.
 *
 * @package Observatorio
 */

get_header();
?>

<main id="main-content" class="site-main single-event">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$start_date    = get_field( 'event_start_date' );
		$end_date      = get_field( 'event_end_date' );
		$event_time    = get_field( 'event_time' );
		$event_format  = get_field( 'event_format' );
		$event_mode    = get_field( 'event_mode' );
		$event_location = get_field( 'event_location' );
		$external_link = get_field( 'event_external_link' );
		$thematic_area = get_field( 'event_thematic_area' );
		?>

		<article <?php post_class( 'event-detail' ); ?>>
			<header class="page-hero section-space">
				<div class="container">
					<?php if ( $event_format ) : ?>
						<span class="section-kicker"><?php echo esc_html( $event_format ); ?></span>
					<?php else : ?>
						<span class="section-kicker"><?php esc_html_e( 'Evento', 'observatorio' ); ?></span>
					<?php endif; ?>

					<h1><?php the_title(); ?></h1>

					<?php if ( has_excerpt() ) : ?>
						<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php endif; ?>
				</div>
			</header>

			<div class="container section-space pt-0">
				<div class="row g-5">
					<div class="col-lg-8">
						<?php if ( has_post_thumbnail() ) : ?>
							<figure class="event-featured-image mb-4">
								<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded-4' ) ); ?>
							</figure>
						<?php endif; ?>

						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</div>

					<aside class="col-lg-4">
						<div class="event-info-card">
							<h2 class="h4"><?php esc_html_e( 'Informações do evento', 'observatorio' ); ?></h2>

							<?php if ( $start_date ) : ?>
								<p><strong><?php esc_html_e( 'Data:', 'observatorio' ); ?></strong><br><?php echo esc_html( DateTime::createFromFormat( 'Ymd', $start_date )->format( 'd/m/Y' ) ); ?><?php echo $end_date ? ' – ' . esc_html( DateTime::createFromFormat( 'Ymd', $end_date )->format( 'd/m/Y' ) ) : ''; ?></p>
							<?php endif; ?>

							<?php if ( $event_time ) : ?>
								<p><strong><?php esc_html_e( 'Horário:', 'observatorio' ); ?></strong><br><?php echo esc_html( $event_time ); ?></p>
							<?php endif; ?>

							<?php if ( $event_mode ) : ?>
								<p><strong><?php esc_html_e( 'Modalidade:', 'observatorio' ); ?></strong><br><?php echo esc_html( $event_mode ); ?></p>
							<?php endif; ?>

							<?php if ( $event_location ) : ?>
								<p><strong><?php esc_html_e( 'Local:', 'observatorio' ); ?></strong><br><?php echo esc_html( $event_location ); ?></p>
							<?php endif; ?>

							<?php if ( $thematic_area ) : ?>
								<p><strong><?php esc_html_e( 'Área Temática:', 'observatorio' ); ?></strong><br><a href="<?php echo esc_url( get_permalink( $thematic_area ) ); ?>"><?php echo esc_html( get_the_title( $thematic_area ) ); ?></a></p>
							<?php endif; ?>

							<?php if ( $external_link && ! empty( $external_link['url'] ) ) : ?>
								<a class="btn btn-primary w-100" href="<?php echo esc_url( $external_link['url'] ); ?>"<?php echo ! empty( $external_link['target'] ) ? ' target="' . esc_attr( $external_link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>>
									<?php echo esc_html( $external_link['title'] ?: __( 'Acessar evento', 'observatorio' ) ); ?>
								</a>
							<?php endif; ?>
						</div>
					</aside>
				</div>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
