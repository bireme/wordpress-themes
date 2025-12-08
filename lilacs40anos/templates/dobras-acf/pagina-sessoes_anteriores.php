<?php
/**
 * Dobra: Sessões Anteriores (Capacitação)
 * Slug: pagina-sessoes_anteriores
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Repeater do ACF
$sessoes = get_sub_field( 'escolha_abaixo_as_paginas_das_sessoes_anteriores' );
$titulo = get_sub_field( 'titulo' );
if ( ! $sessoes ) {
	return;
}
?>
<section id="cap-sessoes-anteriores" aria-label="<?php esc_attr_e( 'Sessões anteriores', 'lilacs' ); ?>">
	<style>
		#cap-sessoes-anteriores {
			background: #fff;
			padding: 40px 0 60px;
		}
		#cap-sessoes-anteriores * {
			box-sizing: border-box;
			font-family: "Noto Sans", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
		}
		#cap-sessoes-anteriores .cap-sessoes-inner {
			max-width: 1180px;
			margin: 0 auto;
			padding: 0 16px;
		}
		#cap-sessoes-anteriores .cap-sessoes-search {
			margin-bottom: 24px;
		}
		#cap-sessoes-anteriores .cap-sessoes-search-input {
			width: 100%;
			max-width: 480px;
			padding: 10px 14px;
			border-radius: 999px;
			border: 1px solid #c5cee0;
			font-size: 14px;
			color: #163b72;
			outline: none;
			background: #f7f9fc;
			box-shadow: 0 0 0 0 rgba(51, 102, 204, 0.15);
			transition: box-shadow .15s ease, border-color .15s ease, background .15s ease;
		}
		#cap-sessoes-anteriores .cap-sessoes-search-input:focus {
			border-color: #3366cc;
			box-shadow: 0 0 0 3px rgba(51, 102, 204, 0.18);
			background: #fff;
		}

		#cap-sessoes-anteriores .cap-sessoes-list {
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		#cap-sessoes-anteriores .cap-sessao-item {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 16px;
			text-decoration: none;
			background: #f3f5fb;
			border-radius: 6px;
			padding: 14px 20px;
			border: 1px solid transparent;
			color: #163b72;
			transition: background .15s ease, box-shadow .15s ease, border-color .15s ease, transform .1s ease;
		}
		#cap-sessoes-anteriores .cap-sessao-item:hover {
			background: #e7ecf9;
			border-color: #cfd8f3;
			box-shadow: 0 3px 8px rgba(12, 49, 116, 0.12);
			transform: translateY(-1px);
		}
		#cap-sessoes-anteriores .cap-sessao-text {
			flex: 1 1 auto;
			min-width: 0;
		}
		#cap-sessoes-anteriores .cap-sessao-title {
			margin: 0 0 4px;
			font-size: 16px;
			font-weight: 700;
			color: #163b72;
		}
		#cap-sessoes-anteriores .cap-sessao-sub {
			margin: 0;
			font-size: 13px;
			color: #4f5b75;
		}

		#cap-sessoes-anteriores .cap-sessao-arrow {
			flex: 0 0 auto;
			width: 24px;
			height: 24px;
			border-radius: 999px;
			border: 1px solid #c5cee0;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 14px;
			color: #163b72;
			background: #fff;
		}

		#cap-sessoes-anteriores .cap-sessoes-empty {
			margin-top: 16px;
			font-size: 14px;
			color: #6b7a90;
		}

		@media (max-width: 768px) {
			#cap-sessoes-anteriores {
				padding: 28px 0 40px;
			}
			#cap-sessoes-anteriores .cap-sessao-item {
				padding: 12px 14px;
			}
			#cap-sessoes-anteriores .cap-sessao-title {
				font-size: 15px;
			}
			#cap-sessoes-anteriores .cap-sessao-sub {
				font-size: 12px;
			}
		}
	</style>

	<div class="cap-sessoes-inner">
        <h2><?=$titulo;?></h2>
		<div class="cap-sessoes-search">
			<label class="screen-reader-text" for="cap-sessoes-search-input">
				<?php esc_html_e( 'Buscar sessões anteriores', 'lilacs' ); ?>
			</label>
			<input
				type="search"
				id="cap-sessoes-search-input"
				class="cap-sessoes-search-input"
				placeholder="<?php echo esc_attr__( 'Buscar por título…', 'lilacs' ); ?>"
				autocomplete="off"
			/>
		</div>

		<div class="cap-sessoes-list">
			<?php foreach ( $sessoes as $linha ) :
				$sessao_obj = isset( $linha['sessao_'] ) ? $linha['sessao_'] : null;
				if ( ! $sessao_obj ) {
					continue;
				}

				$sessao_id    = is_object( $sessao_obj ) ? $sessao_obj->ID : (int) $sessao_obj;
				$title        = get_the_title( $sessao_id );
				$excerpt      = get_the_excerpt( $sessao_id );
				$permalink    = get_permalink( $sessao_id );

				// Texto completo para busca (título + resumo).
				$search_blob = mb_strtolower( wp_strip_all_tags( $title . ' ' . $excerpt ) );
				?>
				<a
					href="<?php echo esc_url( $permalink ); ?>"
					class="cap-sessao-item"
					data-search="<?php echo esc_attr( $search_blob ); ?>"
				>
					<div class="cap-sessao-text">
						<h3 class="cap-sessao-title"><?php echo esc_html( $title ); ?></h3>

						<?php if ( $excerpt ) : ?>
							<p class="cap-sessao-sub">
								<?php echo esc_html( $excerpt ); ?>
							</p>
						<?php endif; ?>
					</div>

					<span class="cap-sessao-arrow" aria-hidden="true">›</span>
				</a>
			<?php endforeach; ?>

			<p class="cap-sessoes-empty" style="display:none;">
				<?php esc_html_e( 'Nenhuma sessão encontrada para este termo.', 'lilacs' ); ?>
			</p>
		</div>
	</div>

	<script>
		(function() {
			var wrapper = document.getElementById('cap-sessoes-anteriores');
			if (!wrapper) return;

			var input  = wrapper.querySelector('#cap-sessoes-search-input');
			var items  = wrapper.querySelectorAll('.cap-sessao-item');
			var empty  = wrapper.querySelector('.cap-sessoes-empty');

			if (!input || !items.length) return;

			input.addEventListener('input', function() {
				var q = (this.value || '').toLowerCase().trim();
				var visibleCount = 0;

				items.forEach(function(item) {
					var haystack = (item.getAttribute('data-search') || '').toLowerCase();
					var show = !q || haystack.indexOf(q) !== -1;

					item.style.display = show ? '' : 'none';
					if (show) visibleCount++;
				});

				if (empty) {
					empty.style.display = (q && visibleCount === 0) ? '' : 'none';
				}
			});
		})();
	</script>
</section>
