<?php
/**
 * Site footer.
 *
 * @package Observatorio
 */

$footer_description = function_exists( 'get_field' ) ? get_field( 'footer_description', 'option' ) : '';
$footer_sus_logo     = function_exists( 'get_field' ) ? (int) get_field( 'footer_sus_logo', 'option' ) : 0;
$footer_bireme_logo  = function_exists( 'get_field' ) ? (int) get_field( 'footer_bireme_logo', 'option' ) : 0;

if ( ! $footer_description ) {
	$footer_description = __( 'Informação, evidência e conhecimento para apoiar decisões em saúde.', 'observatorio' );
}
?>
<footer id="site-footer" class="site-footer">
	<div class="container py-5">
		<div class="row g-4 align-items-start">
			<div class="col-lg-7">
				<h2 class="h5 footer-site-name">
					<?php esc_html_e( 'Observatório', 'observatorio' ); ?><br>
					<small><?php esc_html_e( 'de Políticas, Sistemas e Inovação em Saúde', 'observatorio' ); ?></small>
				</h2>
				<p class="mb-0"><?php echo wp_kses_post( $footer_description ); ?></p>
			</div>

			<div class="col-lg-5 text-lg-end">
				<h2 class="h6 text-uppercase"><?php esc_html_e( 'Navegação', 'observatorio' ); ?></h2>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'list-unstyled footer-links footer-links-inline mb-0',
						'fallback_cb'    => false,
						'depth'          => 1,
					)
				);
				?>
			</div>
		</div>

		<div class="text-center">
			<hr>
			<?php if ( $footer_sus_logo ) : ?>
				<?php echo wp_get_attachment_image( $footer_sus_logo, 'medium', false, array( 'class' => 'footer-sus-logo', 'alt' => __( 'Sistema Único de Saúde', 'observatorio' ) ) ); ?>
			<?php else : ?>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-sus.png' ); ?>" alt="<?php esc_attr_e( 'Sistema Único de Saúde', 'observatorio' ); ?>" class="footer-sus-logo">
			<?php endif; ?>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="text-center">
			<?php if ( $footer_bireme_logo ) : ?>
				<?php echo wp_get_attachment_image( $footer_bireme_logo, 'medium', false, array( 'class' => 'footer-bireme-logo', 'alt' => __( 'BIREME', 'observatorio' ) ) ); ?>
			<?php else : ?>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/powered.png' ); ?>" alt="<?php esc_attr_e( 'BIREME', 'observatorio' ); ?>" class="footer-bireme-logo">
			<?php endif; ?>
			<br>
			<?php esc_html_e( 'Todos os direitos são reservados', 'observatorio' ); ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
