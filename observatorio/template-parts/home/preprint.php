<?php
/**
 * Home pre-print section.
 *
 * @package Observatorio
 */

$preprint_description = function_exists( 'get_field' ) ? get_field( 'preprint_description', 'option' ) : '';
$preprint_image       = function_exists( 'get_field' ) ? (int) get_field( 'preprint_image', 'option' ) : 0;

if ( ! $preprint_description && ! $preprint_image ) {
	return;
}
?>
<section id="preprint" class="preprint-section section-space">
	<div class="container">
		<div class="row g-4 g-lg-5 align-items-center">
			<div class="col-lg-6">
				<div class="preprint-content">
					<span class="section-kicker"><?php esc_html_e( 'Sobre', 'observatorio' ); ?></span>
					<h2><?php esc_html_e( 'Pre-print', 'observatorio' ); ?></h2>

					<?php if ( $preprint_description ) : ?>
						<div class="preprint-description">
							<?php echo wp_kses_post( $preprint_description ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $preprint_image ) : ?>
				<div class="col-lg-6">
					<div class="preprint-image">
						<?php
						echo wp_get_attachment_image(
							$preprint_image,
							'large',
							false,
							array(
								'class'   => 'img-fluid',
								'loading' => 'lazy',
							)
						);
						?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
