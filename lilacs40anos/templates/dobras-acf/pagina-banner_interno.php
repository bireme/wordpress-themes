<?php
/**
 * Dobra: Banner interno (layout banner_interno)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$titulo    = get_sub_field( 'titulo' );
$descricao = get_sub_field( 'descricao' );
$imagem    = get_sub_field( 'imagem_de_fundo' );
$btn_text  = get_sub_field( 'texto_do_botao' );
$btn_bg    = get_sub_field( 'cor_de_fundo_do_botao' ) ?: '#00A0DF';
$btn_color = get_sub_field( 'cor_do_texto_do_botao' ) ?: '#ffffff';
$link      = get_sub_field( 'link_do_banner' );
$align     = get_sub_field( 'alinhamento_do_titulo_e_texto_descritivo' ) ?: 'esquerda';

$img_url = '';
if ( is_array( $imagem ) && ! empty( $imagem['url'] ) ) {
	$img_url = esc_url( $imagem['url'] );
}

// classes de alinhamento
$align_class = 'lbi-align-left';
if ( $align === 'centro' )  $align_class = 'lbi-align-center';
if ( $align === 'direita' ) $align_class = 'lbi-align-right';
?>

<section id="banner-interno-full">
	<style>
		/* Container do banner – full width real */
		#banner-interno-full {
			width: 100%;
			padding: 0;
			margin: 0;
			background: #f4f7fb;
		}

		/* Bloco full */
		#banner-interno-full .lbi-bg-wrapper {
			width: 100%;
			position: relative;
			overflow: hidden;
		}

		#banner-interno-full .lbi-card {
			position: relative;
			width: 100%;
			min-height: 360px;
			padding: 80px 20px;
			display: flex;
			align-items: center;
			isolation: isolate;
			color: #fff;
			background: #00205c;
		}

		/* Imagem pegando total */
		#banner-interno-full .lbi-card::before {
			content: "";
			position: absolute;
			inset: 0;
			background-image: url('<?php echo $img_url; ?>');
			background-size: cover;
			background-position: center right;
			background-repeat: no-repeat;
			z-index: 0;
			opacity: 1;
		}

		/* Overlay */
		#banner-interno-full .lbi-card::after {
			content: "";
			position: absolute;
			inset: 0;
			background: linear-gradient(
				90deg,
				rgba(0,32,92,0.92) 0%,
				rgba(0,32,92,0.82) 40%,
				rgba(0,32,92,0.20) 75%,
				rgba(0,32,92,0.01) 100%
			);
			z-index: 1;
		}

		/* Conteúdo centralizado em 1180px */
		#banner-interno-full .lbi-inner {
			max-width: 1180px;
			margin: 0 auto;
			position: relative;
			z-index: 2;
			display: flex;
			flex-direction: column;
			gap: 20px;
		}

		/* Alinhamentos */
		#banner-interno-full .lbi-align-left { text-align: left; align-items: flex-start; }
		#banner-interno-full .lbi-align-center { text-align: center; align-items: center; }
		#banner-interno-full .lbi-align-right { text-align: right; align-items: flex-end; }

		#banner-interno-full .lbi-title {
			font-size: 36px;
			line-height: 1.25;
			font-weight: 700;
			margin: 0;
		}

		#banner-interno-full .lbi-desc {
			font-size: 18px;
			line-height: 1.7;
			max-width: 760px;
		}

		#banner-interno-full .lbi-btn {
			margin-top: 8px;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			padding: 12px 38px;
			font-size: 16px;
			font-weight: 600;
			text-decoration: none;
			border-radius: 999px;
			color: <?php echo $btn_color; ?>;
			background: <?php echo $btn_bg; ?>;
			box-shadow: 0 4px 16px rgba(0,0,0,0.2);
			transition: 0.2s ease;
		}

		#banner-interno-full .lbi-btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 8px 28px rgba(0,0,0,0.25);
			opacity: .92;
		}

		@media (max-width: 900px) {
			#banner-interno-full .lbi-card {
				padding: 50px 20px;
				min-height: auto;
			}
			#banner-interno-full .lbi-title {
				font-size: 26px;
			}
			#banner-interno-full .lbi-desc {
				max-width: 100%;
				font-size: 16px;
			}
		}
	</style>

	<div class="lbi-bg-wrapper">
		<div class="lbi-card">
			<div class="lbi-inner <?php echo esc_attr( $align_class ); ?>">

				<?php if ( $titulo ) : ?>
					<h2 class="lbi-title"><?php echo esc_html( $titulo ); ?></h2>
				<?php endif; ?>

				<?php if ( $descricao ) : ?>
					<div class="lbi-desc"><?php echo wp_kses_post( nl2br( $descricao ) ); ?></div>
				<?php endif; ?>

				<?php if ( $btn_text && $link ): ?>
					<a href="<?php echo esc_url( $link ); ?>" class="lbi-btn">
						<?php echo esc_html( $btn_text ); ?>
					</a>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>
