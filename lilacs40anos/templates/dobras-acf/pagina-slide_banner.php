<?php
/**
 * Dobra: Slide Banner (layout "slide_banner")
 * Arquivo: pagina-slide_banner.php
 *
 * Slide em largura total, com conteúdo encaixotado em 1180px.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ID único para esse bloco (caso existam vários na página)
$slider_id = 'capacitacao-slide-' . get_row_index();
?>

<section id="<?php echo esc_attr( $slider_id ); ?>" class="capacitacao-slide-banner">
	<style>
		.capacitacao-slide-banner {
			width: 100%;
			background: #00659b; /* azul de fundo */
			color: #fff;
			padding: 60px 0 80px;
			position: relative;
			overflow: hidden;
		}

		.capacitacao-slide-banner * {
			box-sizing: border-box;
			font-family: 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
		}

		.capacitacao-slide-container {
			max-width: 1180px;
			margin: 0 auto;
			padding: 0 20px;
		}

		.capacitacao-slide-titulo-geral {
			font-size: 32px;
			font-weight: 700;
			margin: 0 0 32px;
		}

		.capacitacao-slide-track {
			position: relative;
			overflow: hidden;
		}

		.capacitacao-slide-item {
			display: none;
			opacity: 0;
			transition: opacity .4s ease;
		}
		.capacitacao-slide-item.is-active {
			display: block;
			opacity: 1;
		}

		.capacitacao-slide-inner {
			display: flex;
			align-items: center;
			gap: 40px;
		}

		.capacitacao-slide-image {
			flex: 0 0 360px;
		}

		.capacitacao-slide-image img {
			display: block;
			width: 100%;
			height: auto;
			border-radius: 6px;
			box-shadow: 0 10px 26px rgba(0,0,0,.35);
		}

		.capacitacao-slide-content {
			flex: 1;
			min-width: 0;
		}

		.capacitacao-slide-titulo {
			font-size: 28px;
			font-weight: 700;
			margin: 0 0 16px;
			line-height: 1.3;
		}

		.capacitacao-slide-descricao {
			font-size: 16px;
			line-height: 1.6;
			margin: 0 0 24px;
		}

		.capacitacao-slide-descricao p {
			margin: 0 0 8px;
		}

		.capacitacao-slide-buttons {
			display: flex;
			flex-wrap: wrap;
			gap: 12px;
		}

		.capacitacao-slide-button {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			min-width: 180px;
			padding: 10px 26px;
			border-radius: 999px;
			border: 0;
			cursor: pointer;
			font-weight: 600;
			font-size: 15px;
			text-decoration: none;
			background: #ffffff;
			color: #00558c;
			box-shadow: 0 6px 12px rgba(0,0,0,.25);
			transition: transform .15s ease, box-shadow .15s ease, background .15s ease, color .15s ease;
		}

		.capacitacao-slide-button:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 18px rgba(0,0,0,.3);
			background: #f1f5ff;
		}

		.capacitacao-slide-dots {
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 8px;
			margin-top: 26px;
		}

		.capacitacao-slide-dot {
		    width: 18px;
    height: 18px;
    border: none;
    border-radius: 999px;
    background: rgba(255, 255, 255, .4);
    cursor: pointer;
    transition: background .2s ease, width .2s ease;
		}

		.capacitacao-slide-dot.is-active {
			background: #ffffff;
			width: 18px;
		}

		/* Responsivo */
		@media (max-width: 960px) {
			.capacitacao-slide-inner {
				flex-direction: column;
				align-items: center;
				text-align: center;
			}
			.capacitacao-slide-image {
				flex: 0 0 auto;
				max-width: 320px;
			}
			.capacitacao-slide-content {
				width: 100%;
			}
			.capacitacao-slide-buttons {
				justify-content: center;
			}
		}

		@media (max-width: 600px) {
			.capacitacao-slide-banner {
				padding: 40px 0 60px;
			}
			.capacitacao-slide-titulo-geral {
				font-size: 24px;
				text-align: center;
			}
			.capacitacao-slide-titulo {
				font-size: 22px;
			}
		}
	</style>

	<div class="capacitacao-slide-container">

		<?php
		// Se quiser um título geral para a sessão (ex: "Cursos autoinstrucionais"),
		// pode usar o próprio título da página ou um campo extra.
		$page_title = get_sub_field( 'titulo_geral' ); // opcional, se quiser criar depois
		if ( ! $page_title ) {
			$page_title = get_the_title();
		}
		?>
		<h2 class="capacitacao-slide-titulo-geral">
			<?php echo esc_html( $page_title ); ?>
		</h2>

		<?php if ( have_rows( 'slides' ) ) : ?>
			<div class="capacitacao-slide-track">
				<?php
				$slide_index = 0;
				while ( have_rows( 'slides' ) ) :
					the_row();
					$slide_index++;

					$titulo_slide    = get_sub_field( 'titulo_do_slide' );
					$imagem_slide    = get_sub_field( 'imagem_do_slide' );
					$titulo_lateral  = get_sub_field( 'titulo_lateral' );
					$descricao_lat   = get_sub_field( 'descricao_lateral' );
					?>
					<article class="capacitacao-slide-item <?php echo $slide_index === 1 ? 'is-active' : ''; ?>" data-slide-index="<?php echo esc_attr( $slide_index - 1 ); ?>">
						<div class="capacitacao-slide-inner">

							<?php if ( $imagem_slide ) : ?>
								<div class="capacitacao-slide-image">
									<img src="<?php echo esc_url( $imagem_slide ); ?>"
									     alt="<?php echo esc_attr( $titulo_slide ? $titulo_slide : $titulo_lateral ); ?>">
								</div>
							<?php endif; ?>

							<div class="capacitacao-slide-content">
								<?php if ( $titulo_slide ) : ?>
									<h3 class="capacitacao-slide-titulo">
										<?php echo esc_html( $titulo_slide ); ?>
									</h3>
								<?php endif; ?>

								<?php if ( $descricao_lat ) : ?>
									<div class="capacitacao-slide-descricao">
										<?php echo wp_kses_post( $descricao_lat ); ?>
									</div>
								<?php endif; ?>

								<?php if ( have_rows( 'botoes' ) ) : ?>
									<div class="capacitacao-slide-buttons">
										<?php while ( have_rows( 'botoes' ) ) : the_row(); ?>
											<?php
											$texto_botao = get_sub_field( 'texto_botao' );
											$link_botao  = get_sub_field( 'link_botao' );
											if ( ! $texto_botao || ! $link_botao ) {
												continue;
											}
											?>
											<a class="capacitacao-slide-button"
											   href="<?php echo esc_url( $link_botao ); ?>">
												<?php echo esc_html( $texto_botao ); ?>
											</a>
										<?php endwhile; ?>
									</div>
								<?php endif; ?>
							</div>

						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php if ( $slide_index > 1 ) : ?>
				<div class="capacitacao-slide-dots">
					<?php for ( $i = 0; $i < $slide_index; $i++ ) : ?>
						<button type="button"
						        class="capacitacao-slide-dot <?php echo $i === 0 ? 'is-active' : ''; ?>"
						        data-slide-dot="<?php echo esc_attr( $i ); ?>"
						        aria-label="<?php printf( esc_attr__( 'Ir para slide %d', 'lilacs' ), $i + 1 ); ?>"></button>
					<?php endfor; ?>
				</div>
			<?php endif; ?>

		<?php else : ?>
			<p><?php esc_html_e( 'Nenhum slide cadastrado.', 'lilacs' ); ?></p>
		<?php endif; ?>

	</div><!-- .capacitacao-slide-container -->

	<script>
		(function () {
			var root = document.getElementById('<?php echo esc_js( $slider_id ); ?>');
			if (!root) return;

			var slides = root.querySelectorAll('.capacitacao-slide-item');
			var dots   = root.querySelectorAll('.capacitacao-slide-dot');
			if (!slides.length) return;

			var current = 0;
			var total   = slides.length;
			var timer   = null;
			var delay   = 8000; // 8s

			function goTo(index) {
				if (index < 0) index = total - 1;
				if (index >= total) index = 0;

				slides.forEach(function (slide, i) {
					slide.classList.toggle('is-active', i === index);
				});
				dots.forEach(function (dot, i) {
					dot.classList.toggle('is-active', i === index);
				});

				current = index;
			}

			function startAuto() {
				if (timer) clearInterval(timer);
				timer = setInterval(function () {
					goTo(current + 1);
				}, delay);
			}

			dots.forEach(function (dot) {
				dot.addEventListener('click', function () {
					var idx = parseInt(this.getAttribute('data-slide-dot'), 10);
					if (!isNaN(idx)) {
						goTo(idx);
						startAuto();
					}
				});
			});

			goTo(0);
			startAuto();
		})();
	</script>
</section>
