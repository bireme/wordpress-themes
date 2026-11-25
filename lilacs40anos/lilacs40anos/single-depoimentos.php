<?php
/**
 * Single: depoimentos
 * Vídeo ou relato escrito, com data, coleção e histórias relacionadas.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( ! have_posts() ) {
	echo '<main class="lilacs-depo-single"><div class="lilacs-depo-single__inner"><p>' . esc_html__( 'Depoimento não encontrado.', 'lilacs' ) . '</p></div></main>';
	get_footer();
	return;
}

while ( have_posts() ) :
	the_post();

	$post_id    = (int) get_the_ID();
	$nome       = function_exists( 'bireme_lilacs_depoimento_nome' ) ? bireme_lilacs_depoimento_nome( $post_id ) : get_the_title();
	$titulo     = get_the_title();
	$headline   = ( trim( wp_strip_all_tags( $titulo ) ) !== '' && $titulo !== $nome ) ? $titulo : $nome;
	$foto       = function_exists( 'get_field' ) ? get_field( 'foto' ) : null;
	$texto      = function_exists( 'get_field' ) ? get_field( 'depoimento' ) : '';
	$cargo      = function_exists( 'get_field' ) ? trim( (string) get_field( 'cargo' ) ) : '';
	$pais       = function_exists( 'get_field' ) ? trim( (string) get_field( 'pais' ) ) : '';
	$instituicao = function_exists( 'get_field' ) ? trim( (string) get_field( 'instituicao' ) ) : '';
	$sigla      = function_exists( 'get_field' ) ? trim( (string) get_field( 'sigla' ) ) : '';
	$citacao    = function_exists( 'get_field' ) ? trim( (string) get_field( 'citacao' ) ) : '';
	$transcricao = function_exists( 'get_field' ) ? get_field( 'transcricao' ) : '';
	$formato    = function_exists( 'get_field' ) ? (string) get_field( 'formato' ) : '';
	$idioma     = function_exists( 'get_field' ) ? (string) get_field( 'idioma' ) : '';
	$papeis     = function_exists( 'get_field' ) ? get_field( 'papel' ) : array();
	$temas      = function_exists( 'get_field' ) ? get_field( 'tema' ) : array();
	$destaque   = function_exists( 'get_field' ) ? (bool) get_field( 'destaque' ) : false;
	$data_raw   = function_exists( 'get_field' ) ? (string) get_field( 'data_depoimento' ) : '';
	$data_label = function_exists( 'bireme_lilacs_format_depoimento_date' ) ? bireme_lilacs_format_depoimento_date( $data_raw ) : '';
	$video_url  = function_exists( 'get_field' ) ? trim( (string) get_field( 'video_url' ) ) : '';
	$arquivo    = function_exists( 'get_field' ) ? get_field( 'video_arquivo' ) : null;
	$list_url   = function_exists( 'bireme_lilacs_depoimentos_list_url' ) ? bireme_lilacs_depoimentos_list_url() : home_url( '/' );

	$file_url = '';
	if ( is_array( $arquivo ) ) {
		$file_url = (string) ( $arquivo['url'] ?? '' );
	} elseif ( is_string( $arquivo ) ) {
		$file_url = $arquivo;
	}
	$media_url = $video_url !== '' ? $video_url : $file_url;

	if ( $formato !== 'video' && $formato !== 'escrito' ) {
		$formato = ( $media_url !== '' && trim( wp_strip_all_tags( (string) $texto ) ) === '' ) ? 'video' : 'escrito';
	}
	$is_video = $formato === 'video';

	$foto_url = '';
	$foto_alt = $nome;
	if ( is_array( $foto ) ) {
		$foto_url = (string) ( $foto['sizes']['medium_large'] ?? $foto['url'] ?? '' );
		$foto_alt = (string) ( $foto['alt'] ?? $nome );
	} elseif ( is_string( $foto ) && $foto !== '' ) {
		$foto_url = $foto;
	} elseif ( has_post_thumbnail() ) {
		$foto_url = (string) get_the_post_thumbnail_url( $post_id, 'medium_large' );
	}

	$org = $instituicao;
	if ( $sigla !== '' ) {
		$org = $org !== '' ? $org . ' (' . $sigla . ')' : $sigla;
	}
	$papel_labels = function_exists( 'bireme_lilacs_depoimento_labels' ) ? bireme_lilacs_depoimento_labels( 'papel', $papeis ) : array();
	$tema_labels  = function_exists( 'bireme_lilacs_depoimento_labels' ) ? bireme_lilacs_depoimento_labels( 'tema', $temas ) : array();
	$idioma_label = ( $idioma !== '' && function_exists( 'bireme_lilacs_depoimento_label' ) ) ? bireme_lilacs_depoimento_label( 'idioma', $idioma ) : $idioma;
	$formato_label = function_exists( 'bireme_lilacs_depoimento_label' ) ? bireme_lilacs_depoimento_label( 'formato', $formato ) : $formato;

	$byline = '';
	if ( $papel_labels && $org !== '' ) {
		$byline = $papel_labels[0] . ' – ' . $org;
	} elseif ( $org !== '' ) {
		$byline = $org;
	} elseif ( $papel_labels ) {
		$byline = $papel_labels[0];
	}

	$colecoes = get_the_terms( $post_id, 'depoimento_colecao' );
	$colecao  = ( $colecoes && ! is_wp_error( $colecoes ) ) ? $colecoes[0]->name : '';

	$media_html = ( $is_video && $media_url !== '' && function_exists( 'bireme_lilacs_depoimento_media_html' ) )
		? bireme_lilacs_depoimento_media_html( $media_url, $headline )
		: '';

	$related_args = array(
		'post_type'           => 'depoimentos',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'post__not_in'        => array( $post_id ),
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	);
	if ( $colecoes && ! is_wp_error( $colecoes ) ) {
		$related_args['tax_query'] = array(
			array(
				'taxonomy' => 'depoimento_colecao',
				'field'    => 'term_id',
				'terms'    => wp_list_pluck( $colecoes, 'term_id' ),
			),
		);
	}
	$related = new WP_Query( $related_args );
	if ( ! $related->have_posts() && isset( $related_args['tax_query'] ) ) {
		unset( $related_args['tax_query'] );
		$related = new WP_Query( $related_args );
	}
	?>
	<main class="lilacs-depo-single<?php echo $is_video ? ' is-video' : ' is-written'; ?>" id="lilacs-depoimento-<?php echo esc_attr( (string) $post_id ); ?>">
		<style>
			.lilacs-depo-single {
				--navy: #1e1b4b;
				--blue: #312e81;
				--muted: #64748b;
				--line: #e6eaf2;
				--violet: #6d28d9;
				--violet-bg: #f5f3ff;
				font-family: "Noto Sans", system-ui, -apple-system, "Segoe UI", sans-serif;
				color: #0f172a;
				background: #f8fafc;
				padding: 28px 0 72px;
			}
			.lilacs-depo-single * { box-sizing: border-box; }
			.lilacs-depo-single__inner { max-width: 1080px; margin: 0 auto; padding: 0 20px; }
			.lilacs-depo-single__top {
				display: flex;
				justify-content: space-between;
				align-items: flex-start;
				gap: 20px;
				margin-bottom: 22px;
			}
			.lilacs-depo-single__title {
				margin: 0;
				max-width: 18em;
				font-size: clamp(1.8rem, 3vw, 2.45rem);
				line-height: 1.15;
				letter-spacing: -0.03em;
				color: var(--navy);
			}
			.lilacs-depo-single__flag {
				display: inline-block;
				margin-bottom: 8px;
				padding: 3px 8px;
				border-radius: 999px;
				background: #ede9fe;
				color: var(--violet);
				font-size: 12px;
				font-weight: 700;
			}
			.lilacs-depo-single__actions { display: flex; gap: 8px; flex: 0 0 auto; }
			.lilacs-depo-single__actions button {
				appearance: none;
				border: 1px solid var(--line);
				background: #fff;
				color: var(--blue);
				border-radius: 999px;
				padding: 8px 12px;
				font: inherit;
				font-size: 13px;
				font-weight: 700;
				cursor: pointer;
			}
			.lilacs-depo-single__actions button.is-on { background: #fef2f2; border-color: #fecaca; color: #be123c; }
			.lilacs-depo-single__player {
				position: relative;
				margin-bottom: 22px;
				border-radius: 18px;
				overflow: hidden;
				background: #0f172a;
				aspect-ratio: 16 / 9;
			}
			.lilacs-depo-single__player iframe,
			.lilacs-depo-single__player video {
				position: absolute;
				inset: 0;
				width: 100%;
				height: 100%;
				border: 0;
			}
			.lilacs-depo-single__who {
				display: grid;
				grid-template-columns: auto minmax(0, 1fr) minmax(220px, 280px);
				gap: 22px;
				align-items: center;
				padding: 8px 0 22px;
			}
			.lilacs-depo-single__photo {
				width: 148px;
				height: 148px;
				border-radius: 18px;
				object-fit: cover;
				background: #e2e8f0;
				display: block;
			}
			.is-video .lilacs-depo-single__photo { width: 72px; height: 72px; border-radius: 50%; }
			.lilacs-depo-single__name { margin: 0 0 4px; font-size: 1.25rem; color: var(--navy); }
			.lilacs-depo-single__byline,
			.lilacs-depo-single__role { margin: 0; color: var(--muted); font-size: 14.5px; line-height: 1.45; }
			.lilacs-depo-single__country { margin: 8px 0 0; color: var(--blue); font-size: 14px; font-weight: 700; }
			.lilacs-depo-single__facts { display: grid; gap: 12px; }
			.lilacs-depo-single__fact { display: flex; gap: 10px; align-items: flex-start; }
			.lilacs-depo-single__fact span { display: block; color: var(--muted); font-size: 12px; }
			.lilacs-depo-single__fact strong { display: block; color: var(--navy); font-size: 14px; }
			.lilacs-depo-single__groups { display: grid; gap: 14px; margin: 8px 0 22px; }
			.lilacs-depo-single__group p { margin: 0 0 8px; color: var(--muted); font-size: 13px; font-weight: 700; }
			.lilacs-depo-single__chips { display: flex; flex-wrap: wrap; gap: 8px; }
			.lilacs-depo-single__chips span {
				border: 1px solid var(--line);
				background: #fff;
				border-radius: 999px;
				padding: 6px 10px;
				font-size: 13px;
				color: #334155;
			}
			.lilacs-depo-single__quote {
				margin: 0 0 28px;
				padding: 22px 24px 22px 56px;
				border-radius: 16px;
				background: var(--violet-bg);
				color: #4c1d95;
				font-size: 1.15rem;
				line-height: 1.45;
				position: relative;
			}
			.lilacs-depo-single__quote::before {
				content: "“";
				position: absolute;
				left: 18px;
				top: 8px;
				font-size: 42px;
				line-height: 1;
				color: var(--violet);
			}
			.lilacs-depo-single__section h2 {
				margin: 0 0 12px;
				font-size: 1.35rem;
				color: var(--navy);
			}
			.lilacs-depo-single__body,
			.lilacs-depo-single__transcript {
				color: #334155;
				font-size: 16.5px;
				line-height: 1.7;
			}
			.lilacs-depo-single__body p,
			.lilacs-depo-single__transcript p { margin: 0 0 1em; }
			.lilacs-depo-single__transcript { max-height: 11.5em; overflow: hidden; }
			.lilacs-depo-single__transcript.is-open { max-height: none; }
			.lilacs-depo-single__more {
				appearance: none;
				margin-top: 8px;
				border: 0;
				background: none;
				color: var(--violet);
				font: inherit;
				font-weight: 700;
				cursor: pointer;
			}
			.lilacs-depo-single__related { margin-top: 40px; }
			.lilacs-depo-single__related-head {
				display: flex;
				justify-content: space-between;
				align-items: baseline;
				gap: 12px;
				margin-bottom: 14px;
			}
			.lilacs-depo-single__related-head h2 { margin: 0; font-size: 1.35rem; color: var(--navy); }
			.lilacs-depo-single__related-head a { color: var(--violet); font-weight: 700; text-decoration: none; font-size: 14px; }
			.lilacs-depo-single__related-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; }
			.lilacs-depo-single__rel {
				display: grid;
				grid-template-columns: 72px minmax(0, 1fr);
				gap: 12px;
				padding: 12px;
				border: 1px solid var(--line);
				border-radius: 16px;
				background: #fff;
				text-decoration: none;
				color: inherit;
			}
			.lilacs-depo-single__rel img,
			.lilacs-depo-single__rel-fallback {
				width: 72px;
				height: 72px;
				border-radius: 12px;
				object-fit: cover;
				background: #e2e8f0;
			}
			.lilacs-depo-single__rel-fallback { display: grid; place-items: center; font-weight: 800; color: var(--blue); }
			.lilacs-depo-single__rel small { display: inline-block; margin-bottom: 4px; color: var(--violet); font-weight: 700; }
			.lilacs-depo-single__rel strong { display: block; color: var(--navy); font-size: 14px; line-height: 1.35; }
			.lilacs-depo-single__rel em { display: block; margin-top: 4px; color: var(--muted); font-style: normal; font-size: 12.5px; }
			@media (max-width: 860px) {
				.lilacs-depo-single__who,
				.lilacs-depo-single__related-grid { grid-template-columns: 1fr; }
				.lilacs-depo-single__top { flex-direction: column; }
				.lilacs-depo-single__title { max-width: none; }
			}
		</style>

		<div class="lilacs-depo-single__inner">
			<div class="lilacs-depo-single__top">
				<div>
					<?php if ( $destaque ) : ?>
						<span class="lilacs-depo-single__flag"><?php esc_html_e( 'Em destaque', 'lilacs' ); ?></span>
					<?php endif; ?>
					<h1 class="lilacs-depo-single__title"><?php echo esc_html( $headline ); ?></h1>
				</div>
				<div class="lilacs-depo-single__actions">
					<button type="button" data-share><?php esc_html_e( 'Compartilhar', 'lilacs' ); ?></button>
					<button type="button" data-fav data-id="<?php echo esc_attr( (string) $post_id ); ?>"><?php esc_html_e( 'Favorito', 'lilacs' ); ?></button>
				</div>
			</div>

			<?php if ( $media_html !== '' ) : ?>
				<div class="lilacs-depo-single__player">
					<?php echo $media_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- iframe/video gerados com URLs escapadas. ?>
				</div>
			<?php endif; ?>

			<section class="lilacs-depo-single__who">
				<?php if ( $foto_url !== '' ) : ?>
					<img class="lilacs-depo-single__photo" src="<?php echo esc_url( $foto_url ); ?>" alt="<?php echo esc_attr( $foto_alt ); ?>" />
				<?php endif; ?>
				<div>
					<p class="lilacs-depo-single__name"><?php echo esc_html( $nome ); ?></p>
					<?php if ( $byline !== '' ) : ?>
						<p class="lilacs-depo-single__byline"><?php echo esc_html( $byline ); ?></p>
					<?php endif; ?>
					<?php if ( $cargo !== '' ) : ?>
						<p class="lilacs-depo-single__role"><?php echo esc_html( $cargo ); ?></p>
					<?php endif; ?>
					<?php if ( $pais !== '' ) : ?>
						<p class="lilacs-depo-single__country"><?php echo esc_html( $pais ); ?></p>
					<?php endif; ?>
				</div>
				<?php if ( $data_label !== '' || $colecao !== '' || $idioma_label !== '' ) : ?>
					<div class="lilacs-depo-single__facts">
						<?php if ( $data_label !== '' ) : ?>
							<div class="lilacs-depo-single__fact">
								<div>
									<span><?php esc_html_e( 'Data do depoimento', 'lilacs' ); ?></span>
									<strong><?php echo esc_html( $data_label ); ?></strong>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( $colecao !== '' ) : ?>
							<div class="lilacs-depo-single__fact">
								<div>
									<span><?php esc_html_e( 'Coleção', 'lilacs' ); ?></span>
									<strong><?php echo esc_html( $colecao ); ?></strong>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( $idioma_label !== '' ) : ?>
							<div class="lilacs-depo-single__fact">
								<div>
									<span><?php esc_html_e( 'Idioma original', 'lilacs' ); ?></span>
									<strong><?php echo esc_html( $idioma_label ); ?></strong>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</section>

			<?php if ( $papel_labels || $tema_labels ) : ?>
				<div class="lilacs-depo-single__groups">
					<?php if ( $papel_labels ) : ?>
						<div class="lilacs-depo-single__group">
							<p><?php esc_html_e( 'Papel na Rede', 'lilacs' ); ?></p>
							<div class="lilacs-depo-single__chips">
								<?php foreach ( $papel_labels as $label ) : ?>
									<span><?php echo esc_html( $label ); ?></span>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( $tema_labels ) : ?>
						<div class="lilacs-depo-single__group">
							<p><?php esc_html_e( 'Temas', 'lilacs' ); ?></p>
							<div class="lilacs-depo-single__chips">
								<?php foreach ( $tema_labels as $label ) : ?>
									<span><?php echo esc_html( $label ); ?></span>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $citacao !== '' ) : ?>
				<blockquote class="lilacs-depo-single__quote"><?php echo esc_html( $citacao ); ?></blockquote>
			<?php endif; ?>

			<?php if ( ! $is_video && $texto ) : ?>
				<section class="lilacs-depo-single__section">
					<h2><?php esc_html_e( 'Depoimento', 'lilacs' ); ?></h2>
					<div class="lilacs-depo-single__body"><?php echo wp_kses_post( $texto ); ?></div>
				</section>
			<?php elseif ( ! $is_video && get_the_content() ) : ?>
				<section class="lilacs-depo-single__section">
					<h2><?php esc_html_e( 'Depoimento', 'lilacs' ); ?></h2>
					<div class="lilacs-depo-single__body"><?php the_content(); ?></div>
				</section>
			<?php endif; ?>

			<?php if ( $is_video && $transcricao ) : ?>
				<section class="lilacs-depo-single__section">
					<h2><?php esc_html_e( 'Transcrição do vídeo', 'lilacs' ); ?></h2>
					<div class="lilacs-depo-single__transcript" id="lilacs-depo-transcript"><?php echo wp_kses_post( $transcricao ); ?></div>
					<button type="button" class="lilacs-depo-single__more" data-transcript hidden><?php esc_html_e( 'Mostrar mais', 'lilacs' ); ?></button>
				</section>
			<?php endif; ?>

			<?php if ( $related->have_posts() ) : ?>
				<section class="lilacs-depo-single__related">
					<div class="lilacs-depo-single__related-head">
						<h2><?php esc_html_e( 'Histórias relacionadas', 'lilacs' ); ?></h2>
						<a href="<?php echo esc_url( $list_url ); ?>"><?php esc_html_e( 'Ver todas as histórias', 'lilacs' ); ?> →</a>
					</div>
					<div class="lilacs-depo-single__related-grid">
						<?php
						while ( $related->have_posts() ) :
							$related->the_post();
							$rel_id     = (int) get_the_ID();
							$rel_nome   = function_exists( 'bireme_lilacs_depoimento_nome' ) ? bireme_lilacs_depoimento_nome( $rel_id ) : get_the_title();
							$rel_title  = get_the_title();
							$rel_foto   = function_exists( 'get_field' ) ? get_field( 'foto' ) : null;
							$rel_pais   = function_exists( 'get_field' ) ? trim( (string) get_field( 'pais' ) ) : '';
							$rel_org    = function_exists( 'get_field' ) ? trim( (string) get_field( 'instituicao' ) ) : '';
							$rel_formato = function_exists( 'get_field' ) ? (string) get_field( 'formato' ) : 'escrito';
							$rel_thumb  = '';
							if ( is_array( $rel_foto ) ) {
								$rel_thumb = (string) ( $rel_foto['sizes']['thumbnail'] ?? $rel_foto['url'] ?? '' );
							} elseif ( is_string( $rel_foto ) ) {
								$rel_thumb = $rel_foto;
							} elseif ( has_post_thumbnail() ) {
								$rel_thumb = (string) get_the_post_thumbnail_url( $rel_id, 'thumbnail' );
							}
							$rel_badge = function_exists( 'bireme_lilacs_depoimento_label' )
								? bireme_lilacs_depoimento_label( 'formato', $rel_formato === 'video' ? 'video' : 'escrito' )
								: $formato_label;
							?>
							<a class="lilacs-depo-single__rel" href="<?php the_permalink(); ?>">
								<?php if ( $rel_thumb !== '' ) : ?>
									<img src="<?php echo esc_url( $rel_thumb ); ?>" alt="" />
								<?php else : ?>
									<span class="lilacs-depo-single__rel-fallback" aria-hidden="true"><?php echo esc_html( function_exists( 'mb_substr' ) ? mb_substr( $rel_nome, 0, 1 ) : substr( $rel_nome, 0, 1 ) ); ?></span>
								<?php endif; ?>
								<span>
									<small><?php echo esc_html( $rel_badge ); ?></small>
									<strong><?php echo esc_html( $rel_title ); ?></strong>
									<em>
										<?php echo esc_html( $rel_nome ); ?>
										<?php if ( $rel_org !== '' ) : ?>
											· <?php echo esc_html( $rel_org ); ?>
										<?php endif; ?>
										<?php if ( $rel_pais !== '' ) : ?>
											· <?php echo esc_html( $rel_pais ); ?>
										<?php endif; ?>
									</em>
								</span>
							</a>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				</section>
			<?php endif; ?>
		</div>

		<script>
		(function () {
			var share = document.querySelector('[data-share]');
			if (share) {
				share.addEventListener('click', function () {
					var url = window.location.href;
					var title = document.querySelector('.lilacs-depo-single__title');
					if (navigator.share) {
						navigator.share({ title: title ? title.textContent : document.title, url: url }).catch(function () {});
						return;
					}
					if (navigator.clipboard) {
						navigator.clipboard.writeText(url);
					}
					share.textContent = share.getAttribute('data-done') || 'Link copiado';
				});
				share.setAttribute('data-done', <?php echo wp_json_encode( __( 'Link copiado', 'lilacs' ) ); ?>);
			}
			var fav = document.querySelector('[data-fav]');
			if (fav) {
				var key = 'lilacs-depo-fav-' + fav.getAttribute('data-id');
				var mark = function () { fav.classList.toggle('is-on', window.localStorage.getItem(key) === '1'); };
				mark();
				fav.addEventListener('click', function () {
					window.localStorage.setItem(key, window.localStorage.getItem(key) === '1' ? '0' : '1');
					mark();
				});
			}
			var transcript = document.getElementById('lilacs-depo-transcript');
			var more = document.querySelector('[data-transcript]');
			if (transcript && more && transcript.scrollHeight > transcript.clientHeight + 8) {
				more.hidden = false;
				more.addEventListener('click', function () {
					var open = transcript.classList.toggle('is-open');
					more.textContent = open ? <?php echo wp_json_encode( __( 'Mostrar menos', 'lilacs' ) ); ?> : <?php echo wp_json_encode( __( 'Mostrar mais', 'lilacs' ) ); ?>;
				});
			}
		})();
		</script>
	</main>
	<?php
endwhile;

get_footer();
