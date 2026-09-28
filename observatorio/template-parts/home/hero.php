<?php
/**
 * Home hero carousel.
 *
 * @package Observatorio
 */

$banner_query = new WP_Query(
	array(
		'post_type'      => 'banner',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
	)
);

if ( ! $banner_query->have_posts() ) {
	return;
}

$banner_count = (int) $banner_query->post_count;
?>
<section id="hero" class="hero-section">
	<div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6500">

		<?php if ( $banner_count > 1 ) : ?>
			<div class="carousel-indicators">
				<?php for ( $indicator_index = 0; $indicator_index < $banner_count; $indicator_index++ ) : ?>
					<button
						type="button"
						data-bs-target="#hero-carousel"
						data-bs-slide-to="<?php echo esc_attr( $indicator_index ); ?>"
						<?php echo 0 === $indicator_index ? 'class="active" aria-current="true"' : ''; ?>
						aria-label="<?php echo esc_attr( sprintf( __( 'Destaque %d', 'observatorio' ), $indicator_index + 1 ) ); ?>"
					></button>
				<?php endfor; ?>
			</div>
		<?php endif; ?>

		<div class="carousel-inner">
			<?php
			$banner_index = 0;

			while ( $banner_query->have_posts() ) :
				$banner_query->the_post();

				$banner_kicker      = function_exists( 'get_field' ) ? get_field( 'banner_kicker' ) : get_post_meta( get_the_ID(), 'banner_kicker', true );
				$banner_description = function_exists( 'get_field' ) ? get_field( 'banner_description' ) : get_post_meta( get_the_ID(), 'banner_description', true );
				$banner_image_id    = function_exists( 'get_field' ) ? get_field( 'banner_image' ) : get_post_meta( get_the_ID(), 'banner_image', true );
				$banner_button      = function_exists( 'get_field' ) ? get_field( 'banner_button' ) : array();
				$banner_image_url   = $banner_image_id ? wp_get_attachment_image_url( (int) $banner_image_id, 'full' ) : '';
				$heading_tag        = 0 === $banner_index ? 'h1' : 'h2';

				$slide_style = $banner_image_url
					? sprintf( '--hero-image: url(%s);', esc_url( $banner_image_url ) )
					: '';
				?>

				<div class="carousel-item<?php echo 0 === $banner_index ? ' active' : ''; ?>">
					<div class="hero-slide d-flex align-items-center"<?php echo $slide_style ? ' style="' . esc_attr( $slide_style ) . '"' : ''; ?>>
						<div class="container position-relative">
							<div class="row">
								<div class="col-lg-7">
									<?php if ( $banner_kicker ) : ?>
										<span class="section-kicker text-white"><?php echo esc_html( $banner_kicker ); ?></span>
									<?php endif; ?>

									<<?php echo esc_attr( $heading_tag ); ?> class="display-4 fw-bold text-white mt-2">
										<?php the_title(); ?>
									</<?php echo esc_attr( $heading_tag ); ?>>

									<?php if ( $banner_description ) : ?>
										<p class="lead text-white-50 mt-3 mb-4"><?php echo esc_html( $banner_description ); ?></p>
									<?php endif; ?>

									<?php if ( ! empty( $banner_button['url'] ) && ! empty( $banner_button['title'] ) ) : ?>
										<a
											href="<?php echo esc_url( $banner_button['url'] ); ?>"
											class="btn btn-light btn-lg"
											target="<?php echo esc_attr( ! empty( $banner_button['target'] ) ? $banner_button['target'] : '_self' ); ?>"
											<?php echo '_blank' === ( $banner_button['target'] ?? '' ) ? 'rel="noopener noreferrer"' : ''; ?>
										>
											<?php echo esc_html( $banner_button['title'] ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php
				$banner_index++;
			endwhile;
			?>
		</div>

		<?php if ( $banner_count > 1 ) : ?>
			<button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden"><?php esc_html_e( 'Anterior', 'observatorio' ); ?></span>
			</button>

			<button class="carousel-control-next" type="button" data-bs-target="#hero-carousel" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden"><?php esc_html_e( 'Próximo', 'observatorio' ); ?></span>
			</button>
		<?php endif; ?>
	</div>
</section>
<?php
wp_reset_postdata();
