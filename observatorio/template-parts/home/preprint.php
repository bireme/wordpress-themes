<?php
/**
 * Home PrePrint section.
 *
 * @package Observatorio
 */

$preprint_description = function_exists( 'get_field' ) ? get_field( 'preprint_description', 'option' ) : '';
$preprint_image       = function_exists( 'get_field' ) ? (int) get_field( 'preprint_image', 'option' ) : 0;
$preprint_button      = function_exists( 'get_field' ) ? get_field( 'preprint_button', 'option' ) : array();

if ( ! $preprint_description && ! $preprint_image ) {
	return;
}

$preprint_background = $preprint_image ? wp_get_attachment_image_url( $preprint_image, 'full' ) : '';
$preprint_style      = $preprint_background ? '--preprint-image: url(\'' . esc_url( $preprint_background ) . '\');' : '';
?>
<section id="preprint" class="preprint-section"<?php echo $preprint_style ? ' style="' . esc_attr( $preprint_style ) . '"' : ''; ?>>
	<div class="container position-relative">
		<div class="preprint-content">
			<h2><?php esc_html_e( 'PrePrint', 'observatorio' ); ?></h2>

			<?php if ( $preprint_description ) : ?>
				<div class="preprint-description">
					<?php echo wp_kses_post( $preprint_description ); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $preprint_button['url'] ) && ! empty( $preprint_button['title'] ) ) : ?>
				<a
					href="<?php echo esc_url( $preprint_button['url'] ); ?>"
					class="btn btn-outline-light mt-3"
					<?php echo ! empty( $preprint_button['target'] ) ? ' target="' . esc_attr( $preprint_button['target'] ) . '" rel="noopener"' : ''; ?>
				>
					<?php echo esc_html( $preprint_button['title'] ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
