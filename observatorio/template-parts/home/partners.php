<?php
/**
 * Home partners section.
 *
 * @package Observatorio
 */

$partners = function_exists( 'get_field' ) ? get_field( 'partners', 'option' ) : array();

if ( empty( $partners ) || ! is_array( $partners ) ) {
	return;
}
?>
<section id="partners" class="partners-section section-space">
	<div class="container">
		<div class="section-heading text-center mb-4">
			<span class="section-kicker"><?php esc_html_e( 'Rede de colaboração', 'observatorio' ); ?></span>
			<h2><?php esc_html_e( 'Parceiros', 'observatorio' ); ?></h2>
		</div>

		<div class="partners-grid" aria-label="<?php esc_attr_e( 'Instituições parceiras', 'observatorio' ); ?>">
			<?php foreach ( $partners as $partner ) : ?>
				<?php
				$partner_name = ! empty( $partner['partner_name'] ) ? $partner['partner_name'] : '';
				$partner_logo = ! empty( $partner['partner_logo'] ) ? (int) $partner['partner_logo'] : 0;
				$partner_link = ! empty( $partner['partner_link'] ) && is_array( $partner['partner_link'] ) ? $partner['partner_link'] : array();

				if ( ! $partner_logo ) {
					continue;
				}

				$link_url    = ! empty( $partner_link['url'] ) ? $partner_link['url'] : '';
				$link_target = ! empty( $partner_link['target'] ) ? $partner_link['target'] : '_self';
				$link_title  = ! empty( $partner_link['title'] ) ? $partner_link['title'] : $partner_name;
				?>

				<?php if ( $link_url ) : ?>
					<a href="<?php echo esc_url( $link_url ); ?>" class="partner-logo" target="<?php echo esc_attr( $link_target ); ?>"<?php echo '_blank' === $link_target ? ' rel="noopener noreferrer"' : ''; ?> aria-label="<?php echo esc_attr( $link_title ); ?>">
						<?php echo wp_get_attachment_image( $partner_logo, 'medium', false, array( 'class' => 'img-fluid', 'alt' => $partner_name ) ); ?>
					</a>
				<?php else : ?>
					<div class="partner-logo" aria-label="<?php echo esc_attr( $partner_name ); ?>">
						<?php echo wp_get_attachment_image( $partner_logo, 'medium', false, array( 'class' => 'img-fluid', 'alt' => $partner_name ) ); ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
