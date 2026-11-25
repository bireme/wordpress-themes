<?php
/**
 * Template Name: LILACS Depoimentos
 * Description: Lista todos os depoimentos (post_type=depoimentos) em cards, com busca e paginação.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Permalink da PÁGINA de listagem (não usar get_permalink() após o loop do CPT).
$list_page_id  = get_queried_object_id();
$list_page_url = get_permalink( $list_page_id );

$q = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';

// Paginação via query string (evita 404 de /page/2/ em Page templates).
$paged = 1;
if ( isset( $_GET['depo_page'] ) ) {
	$paged = max( 1, (int) wp_unslash( $_GET['depo_page'] ) );
} else {
	$paged = max( 1, (int) get_query_var( 'paged' ) );
}

$acf_intro     = function_exists( 'get_field' ) ? (string) get_field( 'intro' ) : '';
$acf_per_page  = function_exists( 'get_field' ) ? (int) get_field( 'itens_por_pagina' ) : 0;

$per_page = $acf_per_page > 0 ? $acf_per_page : 12;

/**
 * Amplia a busca do WP_Query para também procurar nos meta ACF:
 * cargo, pais, depoimento (+ título/conteúdo padrão via 's').
 */
$depo_search_hooks = static function () use ( $q ) {
	if ( $q === '' ) {
		return;
	}

	$join = static function ( $join, $query ) {
		global $wpdb;
		if ( empty( $query->query_vars['lilacs_depo_search'] ) ) {
			return $join;
		}
		$join .= " LEFT JOIN {$wpdb->postmeta} AS lilacs_depo_meta ON ({$wpdb->posts}.ID = lilacs_depo_meta.post_id) ";
		return $join;
	};

	$search = static function ( $search, $query ) use ( $q ) {
		global $wpdb;
		if ( empty( $query->query_vars['lilacs_depo_search'] ) || $q === '' ) {
			return $search;
		}

		$like = '%' . $wpdb->esc_like( $q ) . '%';
		$meta_keys = [ 'cargo', 'pais', 'depoimento' ];
		$meta_sql  = [];
		foreach ( $meta_keys as $key ) {
			$meta_sql[] = $wpdb->prepare(
				'(lilacs_depo_meta.meta_key = %s AND lilacs_depo_meta.meta_value LIKE %s)',
				$key,
				$like
			);
		}

		$extra = ' OR (' . implode( ' OR ', $meta_sql ) . ')';

		// Injeta OR dentro do bloco de search gerado pelo WP
		if ( $search !== '' && preg_match( '/\)\s*$/', $search ) ) {
			$search = preg_replace( '/\)\s*$/', $extra . ')', $search, 1 );
		}

		return $search;
	};

	$groupby = static function ( $groupby, $query ) {
		global $wpdb;
		if ( empty( $query->query_vars['lilacs_depo_search'] ) ) {
			return $groupby;
		}
		return "{$wpdb->posts}.ID";
	};

	add_filter( 'posts_join', $join, 10, 2 );
	add_filter( 'posts_search', $search, 10, 2 );
	add_filter( 'posts_groupby', $groupby, 10, 2 );

	return static function () use ( $join, $search, $groupby ) {
		remove_filter( 'posts_join', $join, 10 );
		remove_filter( 'posts_search', $search, 10 );
		remove_filter( 'posts_groupby', $groupby, 10 );
	};
};

$remove_hooks = $depo_search_hooks();

$args = [
	'post_type'           => 'depoimentos',
	'post_status'         => 'publish',
	'posts_per_page'      => $per_page,
	'paged'               => $paged,
	'orderby'             => 'title',
	'order'               => 'ASC',
	'ignore_sticky_posts' => true,
];

if ( $q !== '' ) {
	$args['s']                   = $q;
	$args['lilacs_depo_search']  = 1;
}

$query = new WP_Query( $args );

if ( is_callable( $remove_hooks ) ) {
	$remove_hooks();
}

$page_title = get_the_title() ?: __( 'Depoimentos', 'lilacs' );
if ( $acf_intro !== '' ) {
	$page_intro = $acf_intro;
} elseif ( has_excerpt() ) {
	$page_intro = get_the_excerpt();
} else {
	$page_intro = __( 'Conheça as vozes da rede LILACS: experiências de editores, pesquisadores e instituições.', 'lilacs' );
}
$total = (int) $query->found_posts;

/*
 * Playlist dos 40 anos. Os dois primeiros vídeos são as gravações dos
 * eventos, não depoimentos. A playlist dos 35 anos
 * (PLZkQ-JIKvi_2P79NdZLhEYw9Ychk2akzu) entra quando esta página
 * reunir também esses relatos.
 */
$videos = function_exists( 'bireme_lilacs_youtube_playlist_videos' )
	? bireme_lilacs_youtube_playlist_videos( 'PLZkQ-JIKvi_0r9524zQ_Y75Li5vD_OmJH', 2 )
	: array();

if ( $q !== '' && $videos ) {
	$needle = function_exists( 'mb_strtolower' ) ? mb_strtolower( $q ) : strtolower( $q );
	$videos = array_values(
		array_filter(
			$videos,
			static function ( $video ) use ( $needle ) {
				$title = isset( $video['title'] ) ? (string) $video['title'] : '';
				$hay   = function_exists( 'mb_strtolower' ) ? mb_strtolower( $title ) : strtolower( $title );
				if ( function_exists( 'mb_strpos' ) ) {
					return mb_strpos( $hay, $needle ) !== false;
				}
				return strpos( $hay, $needle ) !== false;
			}
		)
	);
}

$video_total   = count( $videos );
$show_videos   = $video_total > 0 && ( $paged === 1 || $q !== '' );
$has_written   = $query->have_posts();
?>

<main class="lilacs-depo-archive" id="lilacs-depoimentos">
	<style>
		.lilacs-depo-archive {
			--blue-900: #002a4d;
			--blue-800: #0c4380;
			--blue-600: #085695;
			--blue-50: #f3f7fc;
			--muted: #475569;
			--stroke: #d6e2f1;
			--radius: 18px;
			font-family: "Noto Sans", system-ui, -apple-system, "Segoe UI", sans-serif;
			color: #0f172a;
			background:
				radial-gradient(900px 240px at 12% 0%, rgba(12, 67, 128, .10), transparent 60%),
				radial-gradient(700px 220px at 88% 8%, rgba(226, 88, 44, .08), transparent 55%),
				linear-gradient(180deg, #fff, var(--blue-50) 42%, #fff);
			padding: 0 0 72px;
		}
		.lilacs-depo-archive * { box-sizing: border-box; }

		.lilacs-depo-hero {
			padding: 56px 20px 28px;
			text-align: center;
		}
		.lilacs-depo-inner {
			max-width: 1180px;
			margin: 0 auto;
		}
		.lilacs-depo-hero h1 {
			margin: 0 0 12px;
			font-size: clamp(1.8rem, 2.4vw, 2.5rem);
			line-height: 1.15;
			color: var(--blue-800);
			letter-spacing: -0.02em;
		}
		.lilacs-depo-hero p {
			margin: 0 auto;
			max-width: 70ch;
			color: var(--muted);
			font-size: 1.05rem;
			line-height: 1.6;
		}

		.lilacs-depo-toolbar {
			padding: 0 20px 28px;
		}
		.lilacs-depo-search {
			display: flex;
			gap: 10px;
			flex-wrap: wrap;
			align-items: stretch;
			background: #fff;
			border: 1px solid var(--stroke);
			border-radius: 999px;
			padding: 8px;
			box-shadow: 0 12px 28px rgba(2, 23, 55, .06);
			max-width: 760px;
			margin: 0 auto;
		}
		.lilacs-depo-search__field {
			flex: 1 1 280px;
			display: flex;
			align-items: center;
			gap: 10px;
			padding: 0 14px;
			min-width: 0;
		}
		.lilacs-depo-search__field svg {
			width: 18px;
			height: 18px;
			color: var(--blue-800);
			opacity: .85;
			flex: 0 0 auto;
		}
		.lilacs-depo-search input[type="search"] {
			width: 100%;
			border: 0;
			outline: none;
			background: transparent;
			font: inherit;
			font-size: 15px;
			color: var(--blue-900);
			padding: 10px 0;
		}
		.lilacs-depo-search button {
			appearance: none;
			border: 0;
			border-radius: 999px;
			background: linear-gradient(90deg, var(--blue-800), #0b3a70);
			color: #fff;
			font-weight: 700;
			font-size: 14px;
			padding: 12px 22px;
			cursor: pointer;
			transition: transform .15s ease, box-shadow .15s ease;
			box-shadow: 0 10px 18px rgba(12, 67, 128, .18);
		}
		.lilacs-depo-search button:hover {
			transform: translateY(-1px);
			box-shadow: 0 14px 24px rgba(12, 67, 128, .24);
		}
		.lilacs-depo-meta {
			margin-top: 14px;
			font-size: 13.5px;
			color: var(--muted);
			display: flex;
			flex-wrap: wrap;
			gap: 8px 16px;
			align-items: center;
			justify-content: center;
		}
		.lilacs-depo-meta strong { color: var(--blue-900); }
		.lilacs-depo-clear {
			color: var(--blue-800);
			text-decoration: none;
			font-weight: 600;
		}
		.lilacs-depo-clear:hover { text-decoration: underline; }

		.lilacs-depo-formats {
			display: flex;
			justify-content: center;
			flex-wrap: wrap;
			gap: 8px;
			margin-top: 16px;
		}
		.lilacs-depo-formats button {
			appearance: none;
			border: 1px solid var(--stroke);
			background: #fff;
			color: var(--blue-800);
			border-radius: 999px;
			padding: 8px 16px;
			font: inherit;
			font-size: 14px;
			font-weight: 700;
			cursor: pointer;
		}
		.lilacs-depo-formats button[aria-pressed="true"] {
			background: var(--blue-800);
			border-color: var(--blue-800);
			color: #fff;
		}

		.lilacs-depo-block { margin-top: 8px; }
		.lilacs-depo-block + .lilacs-depo-block { margin-top: 36px; }
		.lilacs-depo-block__head { margin: 0 0 16px; }
		.lilacs-depo-block__head h2 {
			margin: 0 0 6px;
			font-size: 1.45rem;
			line-height: 1.2;
			color: var(--blue-900);
			letter-spacing: -0.02em;
		}
		.lilacs-depo-block__head p {
			margin: 0;
			color: var(--muted);
			font-size: 15px;
			line-height: 1.5;
		}

		.lilacs-depo-video {
			appearance: none;
			display: flex;
			flex-direction: column;
			width: 100%;
			padding: 0;
			border: 1px solid var(--stroke);
			border-radius: var(--radius);
			background: #fff;
			overflow: hidden;
			text-align: left;
			color: inherit;
			font: inherit;
			cursor: pointer;
			box-shadow: 0 12px 28px rgba(2, 23, 55, .06);
			transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
		}
		.lilacs-depo-video:hover {
			transform: translateY(-2px);
			border-color: #bfd4ec;
			box-shadow: 0 16px 36px rgba(2, 23, 55, .10);
		}
		.lilacs-depo-video__media {
			position: relative;
			aspect-ratio: 16 / 9;
			background: #0b2348;
		}
		.lilacs-depo-video__media img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			display: block;
		}
		.lilacs-depo-video__badge,
		.lilacs-depo-video__time {
			position: absolute;
			z-index: 1;
			border-radius: 999px;
			background: rgba(8, 22, 48, .78);
			color: #fff;
			font-size: 12px;
			font-weight: 700;
			line-height: 1;
			padding: 6px 8px;
		}
		.lilacs-depo-video__badge { top: 10px; left: 10px; }
		.lilacs-depo-video__time { right: 10px; bottom: 10px; }
		.lilacs-depo-video__play {
			position: absolute;
			inset: 0;
			margin: auto;
			width: 54px;
			height: 54px;
			border-radius: 50%;
			background: rgba(255, 255, 255, .94);
			display: grid;
			place-items: center;
			box-shadow: 0 8px 20px rgba(0, 0, 0, .25);
		}
		.lilacs-depo-video__play::before {
			content: "";
			display: block;
			width: 0;
			height: 0;
			margin-left: 4px;
			border-style: solid;
			border-width: 8px 0 8px 14px;
			border-color: transparent transparent transparent var(--blue-800);
		}
		.lilacs-depo-video__title {
			display: block;
			padding: 14px 16px 16px;
			font-size: 15px;
			font-weight: 700;
			line-height: 1.35;
			color: var(--blue-900);
		}

		.lilacs-depo-player {
			width: min(960px, calc(100vw - 32px));
			max-height: calc(100vh - 32px);
			padding: 0;
			border: 0;
			border-radius: 16px;
			background: #041426;
			color: #fff;
			overflow: hidden;
		}
		.lilacs-depo-player::backdrop { background: rgba(2, 12, 32, .72); }
		.lilacs-depo-player__bar {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 12px;
			padding: 10px 12px 10px 16px;
		}
		.lilacs-depo-player__title {
			margin: 0;
			font-size: 14px;
			font-weight: 700;
			line-height: 1.35;
		}
		.lilacs-depo-player__close {
			appearance: none;
			border: 0;
			border-radius: 999px;
			background: rgba(255, 255, 255, .12);
			color: #fff;
			font: inherit;
			font-size: 13px;
			font-weight: 700;
			padding: 8px 12px;
			cursor: pointer;
		}
		.lilacs-depo-player__frame {
			position: relative;
			aspect-ratio: 16 / 9;
			background: #000;
		}
		.lilacs-depo-player__frame iframe {
			position: absolute;
			inset: 0;
			width: 100%;
			height: 100%;
			border: 0;
		}

		.lilacs-depo-grid-wrap { padding: 0 20px; }
		.lilacs-depo-grid {
			display: grid;
			grid-template-columns: repeat(3, minmax(0, 1fr));
			gap: 18px;
		}

		.lilacs-depo-card {
			background: #fff;
			border: 1px solid var(--stroke);
			border-radius: var(--radius);
			padding: 22px;
			box-shadow: 0 12px 28px rgba(2, 23, 55, .06);
			display: flex;
			flex-direction: column;
			gap: 14px;
			min-height: 100%;
			transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
		}
		.lilacs-depo-card:hover {
			transform: translateY(-2px);
			border-color: #bfd4ec;
			box-shadow: 0 16px 36px rgba(2, 23, 55, .10);
		}
		.lilacs-depo-card__head {
			display: flex;
			gap: 14px;
			align-items: center;
		}
		.lilacs-depo-card__avatar {
			width: 64px;
			height: 64px;
			border-radius: 999px;
			object-fit: cover;
			background: #e9eef5;
			flex: 0 0 64px;
			display: block;
		}
		.lilacs-depo-card__avatar--empty {
			display: grid;
			place-items: center;
			color: var(--blue-800);
			font-weight: 800;
			font-size: 1.1rem;
			background: linear-gradient(135deg, #eaf2fb, #d7e6f7);
		}
		.lilacs-depo-card__identity { min-width: 0; }
		.lilacs-depo-card__name {
			margin: 0;
			font-size: 1.05rem;
			line-height: 1.25;
			color: var(--blue-900);
			font-weight: 800;
		}
		.lilacs-depo-card__role,
		.lilacs-depo-card__country {
			margin: 4px 0 0;
			font-size: 13px;
			color: var(--muted);
			line-height: 1.35;
		}
		.lilacs-depo-card__country {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			margin-top: 6px;
			padding: 4px 10px;
			border-radius: 999px;
			background: rgba(12, 67, 128, .07);
			color: var(--blue-800);
			font-weight: 600;
			font-size: 12px;
		}
		.lilacs-depo-card__quote {
			margin: 0;
			color: var(--muted);
			font-size: 14.5px;
			line-height: 1.65;
			position: relative;
			flex: 1;
		}
		.lilacs-depo-card__quote::before {
			content: "“";
			position: absolute;
			top: -8px;
			left: -4px;
			font-size: 42px;
			line-height: 1;
			color: rgba(12, 67, 128, .18);
			font-family: Georgia, serif;
			pointer-events: none;
		}
		.lilacs-depo-card__quote .lilacs-depo-excerpt {
			display: -webkit-box;
			-webkit-line-clamp: 6;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}
		.lilacs-depo-card__quote.is-expanded .lilacs-depo-excerpt {
			display: block;
			-webkit-line-clamp: unset;
			overflow: visible;
		}
		.lilacs-depo-card__quote p { margin: 0 0 8px; }
		.lilacs-depo-card__quote p:last-child { margin-bottom: 0; }
		.lilacs-depo-toggle {
			appearance: none;
			border: 0;
			background: none;
			color: var(--blue-800);
			font-weight: 700;
			font-size: 13px;
			padding: 0;
			cursor: pointer;
			margin-top: 8px;
			align-self: flex-start;
		}
		.lilacs-depo-toggle:hover { text-decoration: underline; }

		.lilacs-depo-empty {
			text-align: center;
			padding: 56px 20px;
			background: #fff;
			border: 1px dashed var(--stroke);
			border-radius: var(--radius);
			color: var(--muted);
		}
		.lilacs-depo-empty h2 {
			margin: 0 0 8px;
			color: var(--blue-900);
			font-size: 1.25rem;
		}

		.lilacs-depo-pagination {
			margin-top: 36px;
			display: flex;
			justify-content: center;
		}
		.lilacs-depo-pagination .page-numbers {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			min-width: 40px;
			height: 40px;
			padding: 0 12px;
			margin: 0 4px;
			border-radius: 999px;
			border: 1px solid var(--stroke);
			background: #fff;
			color: var(--blue-800);
			text-decoration: none;
			font-weight: 700;
			font-size: 14px;
			transition: .15s ease;
		}
		.lilacs-depo-pagination .page-numbers:hover {
			border-color: #bfd4ec;
			transform: translateY(-1px);
		}
		.lilacs-depo-pagination .page-numbers.current {
			background: var(--blue-800);
			border-color: var(--blue-800);
			color: #fff;
		}
		.lilacs-depo-pagination .page-numbers.dots {
			border: 0;
			background: transparent;
		}

		.lilacs-depo-card__name a {
			color: inherit;
			text-decoration: none;
		}
		.lilacs-depo-card__name a:hover {
			color: var(--blue-800);
			text-decoration: underline;
		}
		.lilacs-depo-card__more {
			display: inline-flex;
			margin-top: 10px;
			font-size: 14px;
			font-weight: 700;
			color: var(--blue-800);
			text-decoration: none;
		}
		.lilacs-depo-card__more:hover {
			text-decoration: underline;
		}

		@media (max-width: 980px) {
			.lilacs-depo-grid { grid-template-columns: 1fr 1fr; }
		}
		@media (max-width: 640px) {
			.lilacs-depo-hero { padding: 40px 16px 20px; }
			.lilacs-depo-toolbar,
			.lilacs-depo-grid-wrap { padding-left: 16px; padding-right: 16px; }
			.lilacs-depo-grid { grid-template-columns: 1fr; }
			.lilacs-depo-search { border-radius: 16px; }
			.lilacs-depo-search button { width: 100%; }
		}

		.sr-only {
			position: absolute !important;
			width: 1px; height: 1px;
			padding: 0; margin: -1px;
			overflow: hidden; clip: rect(0,0,0,0);
			white-space: nowrap; border: 0;
		}
	</style>

	<section class="lilacs-depo-hero">
		<div class="lilacs-depo-inner">
			<h1><?php echo esc_html( $page_title ); ?></h1>
			<p><?php echo esc_html( $page_intro ); ?></p>
		</div>
	</section>

	<section class="lilacs-depo-toolbar">
		<div class="lilacs-depo-inner">
			<form class="lilacs-depo-search" method="get" action="<?php echo esc_url( $list_page_url ); ?>" role="search">
				<label class="sr-only" for="lilacs-depo-q"><?php esc_html_e( 'Buscar depoimentos', 'lilacs' ); ?></label>
				<div class="lilacs-depo-search__field">
					<svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
						<circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
						<path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
					</svg>
					<input
						id="lilacs-depo-q"
						type="search"
						name="q"
						value="<?php echo esc_attr( $q ); ?>"
						placeholder="<?php esc_attr_e( 'Buscar por nome, cargo, país ou texto…', 'lilacs' ); ?>"
						autocomplete="off"
					/>
				</div>
				<button type="submit"><?php esc_html_e( 'Buscar', 'lilacs' ); ?></button>
			</form>

			<div class="lilacs-depo-meta" aria-live="polite">
				<?php if ( $q !== '' ) : ?>
					<span>
						<?php
						$found = $total + $video_total;
						printf(
							/* translators: 1: total results, 2: search term */
							esc_html( _n( '%1$s resultado para “%2$s”', '%1$s resultados para “%2$s”', $found, 'lilacs' ) ),
							esc_html( number_format_i18n( $found ) ),
							esc_html( $q )
						);
						?>
					</span>
					<a class="lilacs-depo-clear" href="<?php echo esc_url( $list_page_url ); ?>">
						<?php esc_html_e( 'Limpar busca', 'lilacs' ); ?>
					</a>
				<?php else : ?>
					<span>
						<?php
						$summary = array();
						if ( $total > 0 ) {
							$summary[] = sprintf(
								/* translators: %s: number of written testimonials */
								_n( '%s escrito', '%s escritos', $total, 'lilacs' ),
								number_format_i18n( $total )
							);
						}
						if ( $video_total > 0 ) {
							$summary[] = sprintf(
								/* translators: %s: number of video testimonials */
								_n( '%s em vídeo', '%s em vídeo', $video_total, 'lilacs' ),
								number_format_i18n( $video_total )
							);
						}
						echo esc_html( $summary ? implode( ' · ', $summary ) : __( 'Nenhum depoimento publicado', 'lilacs' ) );
						?>
					</span>
				<?php endif; ?>
			</div>
			<?php if ( $show_videos && $has_written ) : ?>
				<div class="lilacs-depo-formats" role="group" aria-label="<?php esc_attr_e( 'Formato do depoimento', 'lilacs' ); ?>">
					<button type="button" data-format="all" aria-pressed="true"><?php esc_html_e( 'Todos', 'lilacs' ); ?></button>
					<button type="button" data-format="video" aria-pressed="false"><?php esc_html_e( 'Vídeos', 'lilacs' ); ?></button>
					<button type="button" data-format="text" aria-pressed="false"><?php esc_html_e( 'Escritos', 'lilacs' ); ?></button>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="lilacs-depo-grid-wrap">
		<div class="lilacs-depo-inner">
			<?php if ( $show_videos ) : ?>
				<div class="lilacs-depo-block" data-panel="video">
					<div class="lilacs-depo-block__head">
						<h2><?php esc_html_e( 'Depoimentos em vídeo', 'lilacs' ); ?></h2>
						<p><?php esc_html_e( 'Relatos gravados para a celebração dos 40 anos da LILACS.', 'lilacs' ); ?></p>
					</div>
					<div class="lilacs-depo-grid">
						<?php foreach ( $videos as $video ) :
							$video_id    = isset( $video['id'] ) ? (string) $video['id'] : '';
							$video_title = isset( $video['title'] ) ? (string) $video['title'] : '';
							$video_time  = isset( $video['duration'] ) ? (string) $video['duration'] : '';
							if ( ! preg_match( '/^[A-Za-z0-9_-]{11}$/', $video_id ) ) {
								continue;
							}
							$thumb = 'https://i.ytimg.com/vi/' . rawurlencode( $video_id ) . '/hqdefault.jpg';
							?>
							<button
								type="button"
								class="lilacs-depo-video"
								data-video="<?php echo esc_attr( $video_id ); ?>"
								data-title="<?php echo esc_attr( $video_title ); ?>"
							>
								<span class="lilacs-depo-video__media">
									<img src="<?php echo esc_url( $thumb ); ?>" alt="" loading="lazy" width="480" height="360" />
									<span class="lilacs-depo-video__badge"><?php esc_html_e( 'Vídeo', 'lilacs' ); ?></span>
									<?php if ( $video_time !== '' ) : ?>
										<span class="lilacs-depo-video__time"><?php echo esc_html( $video_time ); ?></span>
									<?php endif; ?>
									<span class="lilacs-depo-video__play" aria-hidden="true"></span>
								</span>
								<span class="lilacs-depo-video__title"><?php echo esc_html( $video_title !== '' ? $video_title : __( 'Depoimento em vídeo', 'lilacs' ) ); ?></span>
							</button>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $query->have_posts() ) : ?>
				<div class="lilacs-depo-block" data-panel="text">
				<?php if ( $show_videos ) : ?>
					<div class="lilacs-depo-block__head">
						<h2><?php esc_html_e( 'Depoimentos escritos', 'lilacs' ); ?></h2>
					</div>
				<?php endif; ?>
				<div class="lilacs-depo-grid">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();

						$nome       = get_the_title();
						$permalink  = get_permalink();
						$foto       = function_exists( 'get_field' ) ? get_field( 'foto' ) : null;
						$depoimento = function_exists( 'get_field' ) ? get_field( 'depoimento' ) : '';
						$cargo      = function_exists( 'get_field' ) ? (string) get_field( 'cargo' ) : '';
						$pais       = function_exists( 'get_field' ) ? (string) get_field( 'pais' ) : '';

						$foto_url = '';
						$foto_alt = $nome;
						if ( is_array( $foto ) ) {
							$foto_url = (string) ( $foto['url'] ?? '' );
							$foto_alt = (string) ( $foto['alt'] ?? $nome );
						} elseif ( is_string( $foto ) && $foto !== '' ) {
							$foto_url = $foto;
						} elseif ( has_post_thumbnail() ) {
							$foto_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
						}

						$initials = '';
						$parts = preg_split( '/\s+/', trim( wp_strip_all_tags( $nome ) ) );
						if ( is_array( $parts ) && $parts ) {
							$first = function_exists( 'mb_substr' ) ? mb_substr( $parts[0], 0, 1 ) : substr( $parts[0], 0, 1 );
							$initials = strtoupper( $first );
							if ( count( $parts ) > 1 ) {
								$last = end( $parts );
								$last_ch = function_exists( 'mb_substr' ) ? mb_substr( $last, 0, 1 ) : substr( $last, 0, 1 );
								$initials .= strtoupper( $last_ch );
							}
						}

						$plain = trim( wp_strip_all_tags( (string) $depoimento ) );
						$len = function_exists( 'mb_strlen' ) ? mb_strlen( $plain ) : strlen( $plain );
						$needs_toggle = $len > 280;
						?>
						<article class="lilacs-depo-card">
							<header class="lilacs-depo-card__head">
								<?php if ( $foto_url !== '' ) : ?>
									<img
										class="lilacs-depo-card__avatar"
										src="<?php echo esc_url( $foto_url ); ?>"
										alt="<?php echo esc_attr( $foto_alt ); ?>"
										loading="lazy"
										width="64"
										height="64"
									/>
								<?php else : ?>
									<span class="lilacs-depo-card__avatar lilacs-depo-card__avatar--empty" aria-hidden="true">
										<?php echo esc_html( $initials ?: '?' ); ?>
									</span>
								<?php endif; ?>

								<div class="lilacs-depo-card__identity">
									<h2 class="lilacs-depo-card__name">
										<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $nome ); ?></a>
									</h2>
									<?php if ( $cargo !== '' ) : ?>
										<p class="lilacs-depo-card__role"><?php echo esc_html( $cargo ); ?></p>
									<?php endif; ?>
									<?php if ( $pais !== '' ) : ?>
										<span class="lilacs-depo-card__country"><?php echo esc_html( $pais ); ?></span>
									<?php endif; ?>
								</div>
							</header>

							<?php if ( $depoimento !== '' && $depoimento !== false ) : ?>
								<blockquote class="lilacs-depo-card__quote<?php echo $needs_toggle ? '' : ' is-expanded'; ?>">
									<div class="lilacs-depo-excerpt">
										<?php echo wp_kses_post( $depoimento ); ?>
									</div>
									<?php if ( $needs_toggle ) : ?>
										<button type="button" class="lilacs-depo-toggle" data-more="<?php esc_attr_e( 'Ler mais', 'lilacs' ); ?>" data-less="<?php esc_attr_e( 'Mostrar menos', 'lilacs' ); ?>">
											<?php esc_html_e( 'Ler mais', 'lilacs' ); ?>
										</button>
									<?php endif; ?>
								</blockquote>
							<?php endif; ?>

							<a class="lilacs-depo-card__more" href="<?php echo esc_url( $permalink ); ?>">
								<?php esc_html_e( 'Ver depoimento completo', 'lilacs' ); ?> →
							</a>
						</article>
					<?php endwhile; ?>
				</div>

				<?php
				wp_reset_postdata();

				$total_pages = (int) $query->max_num_pages;
				if ( $total_pages > 1 ) :
					$big = 999999999;
					$query_args = [ 'depo_page' => $big ];
					if ( $q !== '' ) {
						$query_args['q'] = $q;
					}
					$pagination_base = str_replace(
						(string) $big,
						'%#%',
						esc_url_raw( add_query_arg( $query_args, $list_page_url ) )
					);
					$pagination = paginate_links( [
						'base'      => $pagination_base,
						'format'    => '',
						'current'   => $paged,
						'total'     => $total_pages,
						'type'      => 'list',
						'prev_text' => '←',
						'next_text' => '→',
					] );

					if ( $pagination ) :
						$pagination = str_replace(
							[ "<ul class='page-numbers'>", '<ul class="page-numbers">' ],
							'<ul class="page-numbers" style="display:flex;flex-wrap:wrap;gap:0;list-style:none;margin:0;padding:0;justify-content:center;">',
							$pagination
						);
						?>
						<nav class="lilacs-depo-pagination" aria-label="<?php esc_attr_e( 'Paginação de depoimentos', 'lilacs' ); ?>">
							<?php echo wp_kses_post( $pagination ); ?>
						</nav>
					<?php endif; ?>
				<?php endif; ?>
				</div>

			<?php elseif ( ! $show_videos ) : ?>
				<div class="lilacs-depo-empty">
					<h2><?php esc_html_e( 'Nenhum depoimento encontrado', 'lilacs' ); ?></h2>
					<p>
						<?php
						echo $q !== ''
							? esc_html__( 'Tente outro termo ou limpe a busca para ver todos os depoimentos.', 'lilacs' )
							: esc_html__( 'Ainda não há depoimentos publicados.', 'lilacs' );
						?>
					</p>
					<?php if ( $q !== '' ) : ?>
						<p style="margin-top:16px;">
							<a class="lilacs-depo-clear" href="<?php echo esc_url( $list_page_url ); ?>">
								<?php esc_html_e( 'Ver todos os depoimentos', 'lilacs' ); ?>
							</a>
						</p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<dialog class="lilacs-depo-player" id="lilacs-depo-player">
		<div class="lilacs-depo-player__bar">
			<p class="lilacs-depo-player__title" id="lilacs-depo-player-title"></p>
			<button type="button" class="lilacs-depo-player__close" data-close><?php esc_html_e( 'Fechar', 'lilacs' ); ?></button>
		</div>
		<div class="lilacs-depo-player__frame" id="lilacs-depo-player-frame"></div>
	</dialog>

	<script>
	(function () {
		document.querySelectorAll('.lilacs-depo-toggle').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var quote = btn.closest('.lilacs-depo-card__quote');
				if (!quote) return;
				var expanded = quote.classList.toggle('is-expanded');
				btn.textContent = expanded ? (btn.getAttribute('data-less') || 'Mostrar menos') : (btn.getAttribute('data-more') || 'Ler mais');
			});
		});

		document.querySelectorAll('.lilacs-depo-formats button').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var format = btn.getAttribute('data-format');
				document.querySelectorAll('.lilacs-depo-formats button').forEach(function (other) {
					other.setAttribute('aria-pressed', other === btn ? 'true' : 'false');
				});
				document.querySelectorAll('[data-panel]').forEach(function (panel) {
					var show = format === 'all' || panel.getAttribute('data-panel') === format;
					panel.hidden = !show;
				});
			});
		});

		var dialog = document.getElementById('lilacs-depo-player');
		var frame = document.getElementById('lilacs-depo-player-frame');
		var titleEl = document.getElementById('lilacs-depo-player-title');
		if (!dialog || !frame) return;

		function closePlayer() {
			frame.replaceChildren();
			if (dialog.open && dialog.close) dialog.close();
		}

		document.querySelectorAll('.lilacs-depo-video').forEach(function (card) {
			card.addEventListener('click', function () {
				var id = card.getAttribute('data-video');
				if (!id) return;
				if (!dialog.showModal) {
					window.open('https://www.youtube.com/watch?v=' + encodeURIComponent(id), '_blank', 'noopener');
					return;
				}
				if (titleEl) titleEl.textContent = card.getAttribute('data-title') || '';
				frame.replaceChildren();
				var iframe = document.createElement('iframe');
				iframe.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) + '?autoplay=1';
				iframe.title = card.getAttribute('data-title') || 'YouTube';
				iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
				iframe.allowFullscreen = true;
				frame.appendChild(iframe);
				dialog.showModal();
			});
		});

		dialog.addEventListener('close', function () { frame.replaceChildren(); });
		dialog.addEventListener('click', function (event) {
			if (event.target === dialog || event.target.closest('[data-close]')) closePlayer();
		});
	})();
	</script>
</main>

<?php
get_footer();
