<?php
/**
 * Home news section.
 *
 * @package Observatorio
 */

$news_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
	)
);

$posts_page_id = (int) get_option( 'page_for_posts' );
$news_page_url = $posts_page_id ? get_permalink( $posts_page_id ) : '';

if ( ! $news_page_url ) {
	$news_page = get_page_by_path( 'noticias' );
	if ( $news_page ) {
		$news_page_url = get_permalink( $news_page );
	}
}
?>

<?php if ( $news_query->have_posts() ) : ?>
	<section id="news" class="news-section section-space bg-body-tertiary">
		<div class="container">
			<div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-4">
				<div class="section-heading mb-0">
					<span class="section-kicker"><?php esc_html_e( 'Atualidades', 'observatorio' ); ?></span>
					<h2><?php esc_html_e( 'Notícias', 'observatorio' ); ?></h2>
				</div>

				<?php if ( $news_page_url ) : ?>
					<a href="<?php echo esc_url( $news_page_url ); ?>" class="btn btn-outline-primary mt-3 mt-md-0 flex-shrink-0">
						<?php esc_html_e( 'Ver todas as notícias', 'observatorio' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<div class="row g-4 news-grid">
				<?php
				$news_index = 0;

				while ( $news_query->have_posts() ) :
					$news_query->the_post();
					$news_index++;

					$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
					$excerpt       = get_the_excerpt();
					?>

					<?php if ( 1 === $news_index ) : ?>
						<div class="col-lg-7">
							<article <?php post_class( 'news-card news-card-featured' ); ?>>
								<div
									class="news-bg"
									<?php if ( $thumbnail_url ) : ?>
										style="--news-image: url('<?php echo esc_url( $thumbnail_url ); ?>');"
									<?php endif; ?>
								></div>
								<div class="news-shade"></div>
								<div class="news-content">
									<time class="news-date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
										<?php echo esc_html( get_the_date( 'd M Y' ) ); ?>
									</time>
									<h3><?php the_title(); ?></h3>

									<?php if ( $excerpt ) : ?>
										<p><?php echo esc_html( wp_trim_words( $excerpt, 34 ) ); ?></p>
									<?php endif; ?>

									<a href="<?php the_permalink(); ?>" class="news-arrow stretched-link" aria-label="<?php echo esc_attr( sprintf( __( 'Ler notícia: %s', 'observatorio' ), get_the_title() ) ); ?>">
										<span aria-hidden="true">→</span>
									</a>
								</div>
							</article>
						</div>

						<?php if ( $news_query->post_count > 1 ) : ?>
							<div class="col-lg-5">
								<div class="row g-4 h-100">
						<?php endif; ?>
					<?php else : ?>
						<div class="col-12">
							<article <?php post_class( 'news-card news-card-small' ); ?>>
								<div
									class="news-bg"
									<?php if ( $thumbnail_url ) : ?>
										style="--news-image: url('<?php echo esc_url( $thumbnail_url ); ?>');"
									<?php endif; ?>
								></div>
								<div class="news-shade"></div>
								<div class="news-content">
									<time class="news-date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
										<?php echo esc_html( get_the_date( 'd M Y' ) ); ?>
									</time>
									<h3><?php the_title(); ?></h3>
									<a href="<?php the_permalink(); ?>" class="news-arrow stretched-link" aria-label="<?php echo esc_attr( sprintf( __( 'Ler notícia: %s', 'observatorio' ), get_the_title() ) ); ?>">
										<span aria-hidden="true">→</span>
									</a>
								</div>
							</article>
						</div>
					<?php endif; ?>

				<?php endwhile; ?>

				<?php if ( $news_query->post_count > 1 ) : ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php wp_reset_postdata(); ?>
