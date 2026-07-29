<?php
/**
 * Template Name: LILACS Depoimentos
 * Description: Lista todos os depoimentos (post_type=depoimentos) em cards, com busca e paginação.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$q     = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

$acf_intro     = function_exists( 'get_field' ) ? (string) get_field( 'intro' ) : '';
$acf_per_page  = function_exists( 'get_field' ) ? (int) get_field( 'itens_por_pagina' ) : 0;
$rss_ativo     = function_exists( 'get_field' ) ? get_field( 'rss_ativo' ) : true;
$rss_titulo    = function_exists( 'get_field' ) ? (string) get_field( 'rss_titulo' ) : '';
$rss_link      = function_exists( 'get_field' ) ? (string) get_field( 'rss_link' ) : '';
$rss_max       = function_exists( 'get_field' ) ? (int) get_field( 'rss_max_itens' ) : 6;

$per_page = $acf_per_page > 0 ? $acf_per_page : 12;
if ( $rss_titulo === '' ) {
	$rss_titulo = __( 'Multimídia LILACS', 'lilacs' );
}
if ( $rss_link === '' ) {
	$rss_link = 'https://lilacs.bvsalud.org/multimedia/multimedia-feed?q=&filter=LILACS';
}
if ( $rss_max < 1 ) {
	$rss_max = 6;
}
$rss_ativo = ( $rss_ativo === null || $rss_ativo === '' ) ? true : (bool) $rss_ativo;

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

/**
 * Fetch multimídia RSS (cache 15 min)
 */
$rss_items = [];
if ( $rss_ativo && $rss_link !== '' ) {
	$cache_key = 'lilacs_multimedia_rss_' . md5( $rss_link . '|' . $rss_max );
	$cached    = get_transient( $cache_key );

	if ( false !== $cached && is_array( $cached ) ) {
		$rss_items = $cached;
	} else {
		$response = wp_remote_get( $rss_link, [
			'timeout' => 12,
			'headers' => [
				'Accept' => 'application/rss+xml, application/xml, text/xml, */*;q=0.1',
			],
		] );

		if ( ! is_wp_error( $response ) ) {
			$body = wp_remote_retrieve_body( $response );
			if ( $body ) {
				libxml_use_internal_errors( true );
				$xml = simplexml_load_string( $body );
				if ( $xml && isset( $xml->channel->item ) ) {
					$count = 0;
					foreach ( $xml->channel->item as $it ) {
						if ( $count >= $rss_max ) {
							break;
						}
						$title = trim( (string) $it->title );
						$link  = trim( (string) $it->link );
						$desc  = trim( wp_strip_all_tags( (string) $it->description ) );
						if ( $title === '' && $link === '' ) {
							continue;
						}
						$rss_items[] = [
							'title'       => $title,
							'link'        => $link,
							'description' => $desc,
						];
						$count++;
					}
				}
				libxml_clear_errors();
			}
		}

		set_transient( $cache_key, $rss_items, 15 * MINUTE_IN_SECONDS );
	}
}
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

		/* Multimídia RSS */
		.lilacs-depo-rss {
			padding: 48px 20px 0;
		}
		.lilacs-depo-rss__title {
			margin: 0 0 22px;
			text-align: center;
			font-size: clamp(1.4rem, 2vw, 1.85rem);
			color: var(--blue-800);
			letter-spacing: -0.02em;
		}
		.lilacs-depo-rss__grid {
			display: grid;
			grid-template-columns: repeat(3, minmax(0, 1fr));
			gap: 18px;
		}
		.lilacs-depo-rss__card {
			background: #fff;
			border: 1px solid var(--stroke);
			border-radius: var(--radius);
			padding: 22px;
			box-shadow: 0 12px 28px rgba(2, 23, 55, .06);
			display: flex;
			flex-direction: column;
			gap: 12px;
			min-height: 100%;
			transition: transform .15s ease, box-shadow .15s ease;
			text-align: left;
		}
		.lilacs-depo-rss__card:hover {
			transform: translateY(-2px);
			box-shadow: 0 16px 36px rgba(2, 23, 55, .10);
		}
		.lilacs-depo-rss__card h3 {
			margin: 0;
			font-size: 1.02rem;
			line-height: 1.35;
			color: var(--blue-900);
		}
		.lilacs-depo-rss__card h3 a {
			color: inherit;
			text-decoration: none;
		}
		.lilacs-depo-rss__card h3 a:hover {
			color: var(--blue-800);
			text-decoration: underline;
		}
		.lilacs-depo-rss__card p {
			margin: 0;
			color: var(--muted);
			font-size: 14px;
			line-height: 1.55;
			flex: 1;
			display: -webkit-box;
			-webkit-line-clamp: 4;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}
		.lilacs-depo-rss__btn {
			align-self: flex-start;
			display: inline-flex;
			align-items: center;
			gap: 8px;
			margin-top: auto;
			padding: 10px 16px;
			border-radius: 999px;
			background: linear-gradient(90deg, var(--blue-800), #0b3a70);
			color: #fff;
			text-decoration: none;
			font-weight: 700;
			font-size: 13px;
		}
		.lilacs-depo-rss__btn:hover {
			filter: brightness(1.05);
			color: #fff;
		}
		.lilacs-depo-rss__empty {
			text-align: center;
			color: var(--muted);
			padding: 24px;
			border: 1px dashed var(--stroke);
			border-radius: var(--radius);
			background: #fff;
		}

		@media (max-width: 980px) {
			.lilacs-depo-grid { grid-template-columns: 1fr 1fr; }
			.lilacs-depo-rss__grid { grid-template-columns: 1fr 1fr; }
		}
		@media (max-width: 640px) {
			.lilacs-depo-hero { padding: 40px 16px 20px; }
			.lilacs-depo-toolbar,
			.lilacs-depo-grid-wrap,
			.lilacs-depo-rss { padding-left: 16px; padding-right: 16px; }
			.lilacs-depo-grid,
			.lilacs-depo-rss__grid { grid-template-columns: 1fr; }
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
			<form class="lilacs-depo-search" method="get" action="<?php echo esc_url( get_permalink() ); ?>" role="search">
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
						printf(
							/* translators: 1: total results, 2: search term */
							esc_html( _n( '%1$s resultado para “%2$s”', '%1$s resultados para “%2$s”', $total, 'lilacs' ) ),
							esc_html( number_format_i18n( $total ) ),
							esc_html( $q )
						);
						?>
					</span>
					<a class="lilacs-depo-clear" href="<?php echo esc_url( get_permalink() ); ?>">
						<?php esc_html_e( 'Limpar busca', 'lilacs' ); ?>
					</a>
				<?php else : ?>
					<span>
						<?php
						printf(
							/* translators: %s: total testimonials */
							esc_html( _n( '%s depoimento', '%s depoimentos', $total, 'lilacs' ) ),
							esc_html( number_format_i18n( $total ) )
						);
						?>
					</span>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="lilacs-depo-grid-wrap">
		<div class="lilacs-depo-inner">
			<?php if ( $query->have_posts() ) : ?>
				<div class="lilacs-depo-grid">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();

						$nome       = get_the_title();
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
									<h2 class="lilacs-depo-card__name"><?php echo esc_html( $nome ); ?></h2>
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
						</article>
					<?php endwhile; ?>
				</div>

				<?php
				$total_pages = (int) $query->max_num_pages;
				if ( $total_pages > 1 ) :
					$pagination_base = trailingslashit( get_permalink() ) . '%_%';
					$pagination = paginate_links( [
						'base'      => $pagination_base,
						'format'    => user_trailingslashit( 'page/%#%', 'single_paged' ),
						'current'   => $paged,
						'total'     => $total_pages,
						'type'      => 'list',
						'prev_text' => '←',
						'next_text' => '→',
						'add_args'  => $q !== '' ? [ 'q' => $q ] : false,
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

			<?php else : ?>
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
							<a class="lilacs-depo-clear" href="<?php echo esc_url( get_permalink() ); ?>">
								<?php esc_html_e( 'Ver todos os depoimentos', 'lilacs' ); ?>
							</a>
						</p>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php wp_reset_postdata(); ?>
		</div>
	</section>

	<?php if ( $rss_ativo ) : ?>
	<section class="lilacs-depo-rss" aria-label="<?php echo esc_attr( $rss_titulo ); ?>">
		<div class="lilacs-depo-inner">
			<h2 class="lilacs-depo-rss__title"><?php echo esc_html( $rss_titulo ); ?></h2>

			<?php if ( ! empty( $rss_items ) ) : ?>
				<div class="lilacs-depo-rss__grid">
					<?php foreach ( $rss_items as $item ) :
						$item_title = (string) ( $item['title'] ?? '' );
						$item_link  = (string) ( $item['link'] ?? '' );
						$item_desc  = (string) ( $item['description'] ?? '' );
						if ( $item_title === '' ) {
							continue;
						}
					?>
						<article class="lilacs-depo-rss__card">
							<h3>
								<?php if ( $item_link !== '' ) : ?>
									<a href="<?php echo esc_url( $item_link ); ?>" target="_blank" rel="noopener">
										<?php echo esc_html( $item_title ); ?>
									</a>
								<?php else : ?>
									<?php echo esc_html( $item_title ); ?>
								<?php endif; ?>
							</h3>

							<?php if ( $item_desc !== '' ) : ?>
								<p><?php echo esc_html( $item_desc ); ?></p>
							<?php endif; ?>

							<?php if ( $item_link !== '' ) : ?>
								<a class="lilacs-depo-rss__btn" href="<?php echo esc_url( $item_link ); ?>" target="_blank" rel="noopener">
									<?php esc_html_e( 'Assistir / Acessar', 'lilacs' ); ?> →
								</a>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<div class="lilacs-depo-rss__empty">
					<?php esc_html_e( 'Não foi possível carregar os itens do feed multimídia no momento.', 'lilacs' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

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
	})();
	</script>
</main>

<?php
get_footer();
