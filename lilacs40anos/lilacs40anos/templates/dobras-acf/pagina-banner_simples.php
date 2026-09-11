<?php
/**
 * Dobra: Banner simples (imagem + link full) com CTAs opcionais.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fundo        = get_sub_field( 'imagem_de_fundo_' );
$cor_de_fundo = get_sub_field( 'cor_de_fundo' );
$linkc        = get_sub_field( 'link' );
$buttons      = function_exists( 'lilacs_get_banner_cta_buttons' ) ? lilacs_get_banner_cta_buttons() : array();
$has_ctas     = ! empty( $buttons );
?>

<section
	class="pagina-banner_simples<?php echo $has_ctas ? ' pagina-banner_simples--has-ctas' : ''; ?>"
	style="height:450px;background-position:center;background-image:url('<?php echo esc_url( $fundo ); ?>');background-color:<?php echo esc_attr( $cor_de_fundo ); ?>;"
>
	<div class="pagina-banner_simples__content">
		<?php if ( $linkc ) : ?>
			<a href="<?php echo esc_url( $linkc ); ?>" style="height:450px;display:block;width:100%;" class="pagina-banner_simples__link"<?php echo $has_ctas ? ' tabindex="-1" aria-hidden="true"' : ''; ?>></a>
		<?php endif; ?>

		<?php if ( $has_ctas ) : ?>
			<?php
			if ( function_exists( 'lilacs_banner_cta_styles' ) ) {
				lilacs_banner_cta_styles();
			}
			?>
			<style>
				.pagina-banner_simples--has-ctas{position:relative;}
				.pagina-banner_simples--has-ctas .pagina-banner_simples__link{pointer-events:none;}
				.pagina-banner_simples__cta-wrap{
					position:absolute;
					inset:0;
					display:flex;
					align-items:flex-end;
					justify-content:center;
					padding:32px 20px;
					z-index:2;
					pointer-events:none;
				}
				.pagina-banner_simples__cta-wrap .lilacs-banner-ctas{pointer-events:auto;}
			</style>
			<div class="pagina-banner_simples__cta-wrap">
				<?php lilacs_render_banner_cta_buttons(); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
