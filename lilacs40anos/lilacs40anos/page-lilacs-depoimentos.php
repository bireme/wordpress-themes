<?php
/**
 * Template Name: LILACS Depoimentos
 * Lista os depoimentos no layout de histórias: destaque, filtros, grade, país e tema.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lilacs_depo_story_card' ) ) {
	/**
	 * Card de um depoimento publicado.
	 *
	 * @param callable $label
	 * @param callable $photo_of
	 */
	function lilacs_depo_story_card( $post_id, $label, $photo_of ) {
		$post_id = (int) $post_id;
		$nome    = function_exists( 'bireme_lilacs_depoimento_nome' ) ? bireme_lilacs_depoimento_nome( $post_id ) : get_the_title( $post_id );
		$titulo  = get_the_title( $post_id );
		$citacao = trim( (string) get_post_meta( $post_id, 'citacao', true ) );
		$heading = $citacao !== '' ? $citacao : $titulo;
		$cargo   = trim( (string) get_post_meta( $post_id, 'cargo', true ) );
		$org     = trim( (string) get_post_meta( $post_id, 'instituicao', true ) );
		$pais    = trim( (string) get_post_meta( $post_id, 'pais', true ) );
		$formato = (string) get_post_meta( $post_id, 'formato', true );
		if ( $formato !== 'video' ) {
			$formato = 'escrito';
		}
		$photo = $photo_of( $post_id );
		$youtube_id = (string) get_post_meta( $post_id, '_lilacs_youtube_id', true );
		if ( $photo === '' && preg_match( '/^[A-Za-z0-9_-]{11}$/', $youtube_id ) ) {
			$photo = 'https://i.ytimg.com/vi/' . rawurlencode( $youtube_id ) . '/hqdefault.jpg';
		}
		$duration = trim( (string) get_post_meta( $post_id, '_lilacs_youtube_duration', true ) );
		$meta  = implode( ' · ', array_filter( array( $nome !== $heading ? $nome : '', $cargo, $org, $pais ) ) );

		ob_start();
		?>
		<article class="story-card">
			<a class="story-card__hit" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
				<?php if ( $photo !== '' ) : ?>
					<span class="story-card__media">
						<img src="<?php echo esc_url( $photo ); ?>" alt="" loading="lazy" />
						<span class="story-card__badge"><?php echo esc_html( $label( 'formato', $formato ) ); ?></span>
						<?php if ( $duration !== '' ) : ?>
							<span class="story-card__time"><?php echo esc_html( $duration ); ?></span>
						<?php endif; ?>
					</span>
				<?php endif; ?>
				<span class="story-card__body">
					<?php if ( $photo === '' ) : ?>
						<span class="story-card__badge" style="position:static;display:inline-block;margin-bottom:8px;background:#ede9fe;color:#6d28d9;"><?php echo esc_html( $label( 'formato', $formato ) ); ?></span>
					<?php endif; ?>
					<h3><?php echo esc_html( $heading ); ?></h3>
					<?php if ( $meta !== '' ) : ?>
						<p><?php echo esc_html( $meta ); ?></p>
					<?php endif; ?>
				</span>
			</a>
		</article>
		<?php
		return (string) ob_get_clean();
	}
}

if ( function_exists( 'bireme_lilacs_sync_youtube_depoimentos' ) ) {
	bireme_lilacs_sync_youtube_depoimentos();
}

get_header();

$list_page_id  = get_queried_object_id();
$list_page_url = get_permalink( $list_page_id );

$q = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
$paged = 1;
if ( isset( $_GET['depo_page'] ) ) {
	$paged = max( 1, (int) wp_unslash( $_GET['depo_page'] ) );
} else {
	$paged = max( 1, (int) get_query_var( 'paged' ) );
}

$acf_intro    = function_exists( 'get_field' ) ? trim( (string) get_field( 'intro' ) ) : '';
$acf_per_page = function_exists( 'get_field' ) ? (int) get_field( 'itens_por_pagina' ) : 0;
$per_page     = $acf_per_page > 0 ? $acf_per_page : 12;

$filters = array(
	'pais'    => isset( $_GET['pais'] ) ? sanitize_text_field( wp_unslash( $_GET['pais'] ) ) : '',
	'papel'   => isset( $_GET['papel'] ) ? sanitize_key( wp_unslash( $_GET['papel'] ) ) : '',
	'colecao' => isset( $_GET['colecao'] ) ? sanitize_title( wp_unslash( $_GET['colecao'] ) ) : '',
	'formato' => isset( $_GET['formato'] ) ? sanitize_key( wp_unslash( $_GET['formato'] ) ) : '',
	'tema'    => isset( $_GET['tema'] ) ? sanitize_key( wp_unslash( $_GET['tema'] ) ) : '',
	'idioma'  => isset( $_GET['idioma'] ) ? sanitize_key( wp_unslash( $_GET['idioma'] ) ) : '',
	'ano'     => isset( $_GET['ano'] ) ? preg_replace( '/[^0-9]/', '', (string) wp_unslash( $_GET['ano'] ) ) : '',
	'ordem'   => ( isset( $_GET['ordem'] ) && sanitize_key( wp_unslash( $_GET['ordem'] ) ) === 'titulo' ) ? 'titulo' : 'recentes',
	'destaque'=> ( isset( $_GET['destaque'] ) && (string) wp_unslash( $_GET['destaque'] ) === '1' ) ? '1' : '',
);

$has_structured_filter = (bool) array_filter( $filters );

$label = static function ( $group, $value ) {
	if ( function_exists( 'bireme_lilacs_depoimento_label' ) ) {
		return bireme_lilacs_depoimento_label( $group, $value );
	}
	return (string) $value;
};

$papeis = array( 'centro-cooperante', 'editor-periodico', 'coordenador-lilacs', 'pesquisador', 'rede-indexadores', 'rede-referencistas' );
$temas  = array( 'trabalho-em-rede', 'indexacao', 'decs', 'formacao', 'cooperacao-automatizada', 'visibilidade', 'acesso-aberto', 'edicao-cientifica', 'cooperacao' );
$idiomas = array( 'pt', 'es', 'en', 'fr' );
$paises = array( 'Argentina', 'Barbados', 'Belize', 'Bolívia', 'Brasil', 'Chile', 'Colômbia', 'Costa Rica', 'Cuba', 'El Salvador', 'Equador', 'Espanha', 'Estados Unidos', 'Guatemala', 'Guiana', 'Haiti', 'Honduras', 'Jamaica', 'México', 'Nicarágua', 'Panamá', 'Paraguai', 'Peru', 'Portugal', 'República Dominicana', 'Suriname', 'Trinidad e Tobago', 'Uruguai', 'Venezuela', 'Outro' );
$tema_colors = array(
	'trabalho-em-rede'        => '#6d28d9',
	'cooperacao-automatizada' => '#2563eb',
	'indexacao'               => '#ea580c',
	'visibilidade'            => '#059669',
	'acesso-aberto'           => '#db2777',
	'formacao'                => '#ca8a04',
	'decs'                    => '#0891b2',
	'edicao-cientifica'       => '#7c3aed',
	'cooperacao'              => '#4f46e5',
);

$colecoes = get_terms( array(
	'taxonomy'   => 'depoimento_colecao',
	'hide_empty' => false,
) );
if ( is_wp_error( $colecoes ) ) {
	$colecoes = array();
}

$stats_ids = get_posts( array(
	'post_type'      => 'depoimentos',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'fields'         => 'ids',
	'orderby'        => 'date',
	'order'          => 'DESC',
	'lang'           => '',
) );

$by_country = array();
$by_theme   = array();
$years      = array();
foreach ( $stats_ids as $stat_id ) {
	$stat_pais = trim( (string) get_post_meta( $stat_id, 'pais', true ) );
	if ( $stat_pais !== '' ) {
		$by_country[ $stat_pais ] = ( $by_country[ $stat_pais ] ?? 0 ) + 1;
		if ( ! in_array( $stat_pais, $paises, true ) ) {
			$paises[] = $stat_pais;
		}
	}
	$stat_temas = get_post_meta( $stat_id, 'tema', true );
	if ( is_string( $stat_temas ) ) {
		$stat_temas = maybe_unserialize( $stat_temas );
	}
	if ( is_array( $stat_temas ) ) {
		foreach ( $stat_temas as $stat_tema ) {
			$stat_tema = (string) $stat_tema;
			if ( $stat_tema === '' ) {
				continue;
			}
			$by_theme[ $stat_tema ] = ( $by_theme[ $stat_tema ] ?? 0 ) + 1;
		}
	}
	$stat_date = preg_replace( '/[^0-9]/', '', (string) get_post_meta( $stat_id, 'data_depoimento', true ) );
	if ( strlen( $stat_date ) >= 4 ) {
		$years[ substr( $stat_date, 0, 4 ) ] = true;
	}
}
arsort( $by_country );
arsort( $by_theme );
krsort( $years );

$depo_search_hooks = static function () use ( $q ) {
	if ( $q === '' ) {
		return null;
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
		$meta_keys = array( 'cargo', 'pais', 'depoimento', 'nome', 'instituicao', 'citacao', 'transcricao' );
		$meta_sql  = array();
		foreach ( $meta_keys as $key ) {
			$meta_sql[] = $wpdb->prepare(
				'(lilacs_depo_meta.meta_key = %s AND lilacs_depo_meta.meta_value LIKE %s)',
				$key,
				$like
			);
		}
		$extra = ' OR (' . implode( ' OR ', $meta_sql ) . ')';
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

$meta_query = array();
if ( $filters['pais'] !== '' ) {
	$meta_query[] = array( 'key' => 'pais', 'value' => $filters['pais'], 'compare' => '=' );
}
if ( $filters['formato'] !== '' ) {
	$meta_query[] = array( 'key' => 'formato', 'value' => $filters['formato'], 'compare' => '=' );
}
if ( $filters['idioma'] !== '' ) {
	$meta_query[] = array( 'key' => 'idioma', 'value' => $filters['idioma'], 'compare' => '=' );
}
if ( $filters['papel'] !== '' ) {
	$meta_query[] = array( 'key' => 'papel', 'value' => '"' . $filters['papel'] . '"', 'compare' => 'LIKE' );
}
if ( $filters['tema'] !== '' ) {
	$meta_query[] = array( 'key' => 'tema', 'value' => '"' . $filters['tema'] . '"', 'compare' => 'LIKE' );
}
if ( $filters['ano'] !== '' ) {
	$meta_query[] = array( 'key' => 'data_depoimento', 'value' => $filters['ano'], 'compare' => 'LIKE' );
}
if ( $filters['destaque'] === '1' ) {
	$meta_query[] = array( 'key' => 'destaque', 'value' => '1', 'compare' => '=' );
}
if ( count( $meta_query ) > 1 ) {
	$meta_query['relation'] = 'AND';
}

$tax_query = array();
if ( $filters['colecao'] !== '' ) {
	$tax_query[] = array(
		'taxonomy' => 'depoimento_colecao',
		'field'    => 'slug',
		'terms'    => $filters['colecao'],
	);
}

$remove_hooks = $depo_search_hooks();
$args = array(
	'post_type'           => 'depoimentos',
	'post_status'         => 'publish',
	'posts_per_page'      => $per_page,
	'paged'               => $paged,
	'orderby'             => $filters['ordem'] === 'titulo' ? 'title' : 'date',
	'order'               => $filters['ordem'] === 'titulo' ? 'ASC' : 'DESC',
	'ignore_sticky_posts' => true,
	// O Polylang escondia os depoimentos ainda sem idioma. A lista mostra todos os publicados.
	'lang'                => '',
);
if ( $q !== '' ) {
	$args['s']                  = $q;
	$args['lilacs_depo_search'] = 1;
}
if ( $meta_query ) {
	$args['meta_query'] = $meta_query;
}
if ( $tax_query ) {
	$args['tax_query'] = $tax_query;
}
$query = new WP_Query( $args );
if ( is_callable( $remove_hooks ) ) {
	$remove_hooks();
}

$featured = array();
if ( ! $has_structured_filter && $q === '' && $paged === 1 ) {
	$featured_query = new WP_Query( array(
		'post_type'      => 'depoimentos',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'lang'           => '',
		'meta_query'     => array(
			array( 'key' => 'destaque', 'value' => '1', 'compare' => '=' ),
		),
	) );
	$featured = $featured_query->posts;
	wp_reset_postdata();
}

$hero_post = null;
foreach ( $stats_ids as $stat_id ) {
	$quote = trim( (string) get_post_meta( $stat_id, 'citacao', true ) );
	if ( $quote !== '' ) {
		$hero_post = $stat_id;
		if ( (string) get_post_meta( $stat_id, 'destaque', true ) === '1' ) {
			break;
		}
	}
}

$page_title = get_the_title() ?: __( 'Depoimentos', 'lilacs' );
$word_count = count( preg_split( '/\s+/', trim( wp_strip_all_tags( $page_title ) ) ) );
$hero_title = ( $word_count < 4 && preg_match( '/depoimento/i', $page_title ) )
	? __( 'Histórias que conectam pessoas, conhecimento e saúde', 'lilacs' )
	: $page_title;
$page_intro = $acf_intro !== ''
	? $acf_intro
	: ( has_excerpt()
		? get_the_excerpt()
		: __( 'Depoimentos de pessoas e instituições que fazem parte da Rede LILACS e contribuem para ampliar o acesso à informação científica e técnica em saúde na América Latina e no Caribe.', 'lilacs' ) );

$contato = get_page_by_path( 'contato' );
$enviar_url = $contato ? get_permalink( $contato ) : home_url( '/contato/' );

$filter_url = static function ( $extra = array() ) use ( $list_page_url, $q, $filters ) {
	$args = array(
		'q'        => $q,
		'pais'     => $filters['pais'],
		'papel'    => $filters['papel'],
		'colecao'  => $filters['colecao'],
		'formato'  => $filters['formato'],
		'tema'     => $filters['tema'],
		'idioma'   => $filters['idioma'],
		'ano'      => $filters['ano'],
		'ordem'    => $filters['ordem'] === 'titulo' ? 'titulo' : '',
		'destaque' => $filters['destaque'],
	);
	$args = array_merge( $args, $extra );
	$args = array_filter(
		$args,
		static function ( $value ) {
			return $value !== '' && $value !== null;
		}
	);
	return add_query_arg( $args, $list_page_url );
};

$total = (int) $query->found_posts;

$photo_of = static function ( $post_id ) {
	$foto = function_exists( 'get_field' ) ? get_field( 'foto', $post_id ) : null;
	if ( is_array( $foto ) ) {
		return (string) ( $foto['sizes']['large'] ?? $foto['url'] ?? '' );
	}
	if ( is_string( $foto ) && $foto !== '' ) {
		return $foto;
	}
	$thumb = get_the_post_thumbnail_url( $post_id, 'large' );
	return $thumb ? (string) $thumb : '';
};
?>

<main class="lilacs-stories" id="lilacs-depoimentos">
	<style>
		.lilacs-stories {
			--ink: #1e1b4b;
			--violet: #6d28d9;
			--violet-2: #7c3aed;
			--muted: #64748b;
			--line: #e7e5f4;
			--card: #fff;
			font-family: "Noto Sans", system-ui, -apple-system, "Segoe UI", sans-serif;
			color: #0f172a;
			background: linear-gradient(180deg, #fbfaff 0%, #f4f2fb 220px, #f7f6fb 100%);
			padding-bottom: 72px;
		}
		.lilacs-stories * { box-sizing: border-box; }
		.lilacs-stories a { color: inherit; }
		.lilacs-stories__inner { max-width: 1180px; margin: 0 auto; padding: 0 20px; }
		.lilacs-stories__hero { padding: 42px 0 18px; }
		.lilacs-stories__hero .lilacs-stories__inner { display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(280px, .95fr); gap: 36px; align-items: center; }
		.lilacs-stories__kicker { display: inline-flex; margin-bottom: 12px; padding: 5px 10px; border-radius: 999px; background: #ede9fe; color: var(--violet); font-size: 12px; font-weight: 800; letter-spacing: .04em; }
		.lilacs-stories__hero h1 { margin: 0 0 12px; font-size: clamp(2rem, 4vw, 3.1rem); line-height: 1.08; letter-spacing: -.035em; color: var(--ink); }
		.lilacs-stories__hero p { margin: 0 0 20px; max-width: 58ch; color: var(--muted); font-size: 1.05rem; line-height: 1.6; }
		.lilacs-stories__ctas { display: flex; flex-wrap: wrap; gap: 10px; }
		.lilacs-stories__ctas a, .lilacs-stories__search button, .lilacs-stories__cta a {
			display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; text-decoration: none; font-weight: 800;
		}
		.lilacs-stories__ctas a { padding: 12px 18px; background: var(--violet); color: #fff; }
		.lilacs-stories__ctas a.ghost { background: #fff; color: var(--ink); border: 1px solid var(--line); }
		.lilacs-stories__visual { position: relative; min-height: 280px; }
		.lilacs-stories__visual img { width: 100%; height: 340px; object-fit: cover; border-radius: 28px; background: #ddd6fe; }
		.lilacs-stories__quote {
			position: absolute; left: 16px; right: 16px; bottom: 16px; margin: 0; padding: 16px 16px 14px;
			border-radius: 18px; background: rgba(255,255,255,.94); color: var(--ink); box-shadow: 0 12px 30px rgba(49, 46, 129, .12);
		}
		.lilacs-stories__quote p { margin: 0 0 8px; font-size: 1rem; line-height: 1.4; }
		.lilacs-stories__quote strong { display: block; font-size: 14px; }
		.lilacs-stories__quote span { color: var(--muted); font-size: 12.5px; }
		.lilacs-stories__search { display: flex; gap: 10px; align-items: center; margin: 8px 0 14px; padding: 8px; border: 1px solid var(--line); border-radius: 999px; background: #fff; box-shadow: 0 10px 24px rgba(49,46,129,.05); }
		.lilacs-stories__search input { flex: 1; border: 0; outline: none; background: transparent; font: inherit; font-size: 15px; padding: 10px 8px; min-width: 0; }
		.lilacs-stories__search button { border: 0; background: var(--violet); color: #fff; padding: 12px 22px; cursor: pointer; font: inherit; }
		.lilacs-stories__filters { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 10px; margin-bottom: 28px; }
		.lilacs-stories__filters label { display: grid; gap: 4px; font-size: 12px; font-weight: 700; color: var(--muted); }
		.lilacs-stories__filters select { width: 100%; border: 1px solid var(--line); background: #fff; border-radius: 12px; padding: 10px 8px; font: inherit; color: var(--ink); }
		.lilacs-stories__head { display: flex; justify-content: space-between; align-items: end; gap: 16px; margin: 10px 0 14px; }
		.lilacs-stories__head h2 { margin: 0 0 4px; font-size: 1.55rem; letter-spacing: -.02em; color: var(--ink); }
		.lilacs-stories__head p, .lilacs-stories__head a { margin: 0; color: var(--muted); }
		.lilacs-stories__head a { color: var(--violet); font-weight: 800; text-decoration: none; }
		.lilacs-stories__tools { display: flex; gap: 8px; align-items: center; }
		.lilacs-stories__tools select, .lilacs-stories__tools button { border: 1px solid var(--line); background: #fff; border-radius: 10px; padding: 8px 10px; font: inherit; }
		.lilacs-stories__tools button { cursor: pointer; font-weight: 800; }
		.lilacs-stories__tools button.is-on { background: var(--ink); color: #fff; }
		.stories { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
		.stories.compact { grid-template-columns: repeat(5, minmax(0, 1fr)); }
		.stories.is-list { grid-template-columns: 1fr; }
		.story-card { display: flex; flex-direction: column; overflow: hidden; border: 1px solid var(--line); border-radius: 18px; background: var(--card); text-decoration: none; min-width: 0; }
		.story-card__hit { display: flex; flex-direction: column; height: 100%; color: inherit; text-decoration: none; background: none; border: 0; padding: 0; text-align: left; font: inherit; cursor: pointer; }
		.story-card__media { position: relative; aspect-ratio: 16/10; background: #e9e4f8; }
		.story-card__media img { width: 100%; height: 100%; object-fit: cover; display: block; }
		.story-card__badge, .story-card__time { position: absolute; border-radius: 999px; background: rgba(15,23,42,.78); color: #fff; font-size: 11px; font-weight: 800; padding: 5px 8px; }
		.story-card__badge { top: 10px; left: 10px; }
		.story-card__time { right: 10px; bottom: 10px; }
		.story-card__body { padding: 14px 14px 16px; }
		.story-card__body h3 { margin: 0 0 8px; font-size: 1rem; line-height: 1.35; color: var(--ink); }
		.story-card__body p { margin: 0; color: var(--muted); font-size: 13px; line-height: 1.4; }
		.story-card.is-feature .story-card__body h3 { font-size: 1.15rem; }
		.stories.is-list .story-card__hit { flex-direction: row; }
		.stories.is-list .story-card__media { width: 220px; aspect-ratio: auto; flex: 0 0 220px; }
		.lilacs-stories__split { display: grid; grid-template-columns: 1.15fr .85fr; gap: 18px; margin-top: 36px; }
		.panel { background: #fff; border: 1px solid var(--line); border-radius: 22px; padding: 22px; }
		.panel h2 { margin: 0 0 4px; color: var(--ink); font-size: 1.4rem; }
		.panel > p { margin: 0 0 16px; color: var(--muted); }
		.map-layout { display: grid; grid-template-columns: 180px 1fr; gap: 16px; align-items: center; }
		.country-list { list-style: none; margin: 0; padding: 0; display: grid; gap: 7px; }
		.country-list a, .country-list span { display: grid; grid-template-columns: 1fr auto; gap: 8px; text-decoration: none; font-size: 14px; }
		.country-list em { font-style: normal; font-weight: 800; color: var(--ink); }
		.country-list i { grid-column: 1 / -1; height: 4px; border-radius: 99px; background: #ddd6fe; display: block; }
		.country-list i b { display: block; height: 100%; border-radius: inherit; background: var(--violet); }
		.theme-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
		.theme-card { display: block; padding: 14px; border-radius: 16px; text-decoration: none; background: #f5f3ff; }
		.theme-card strong, .theme-card span { display: block; }
		.theme-card span { color: var(--muted); font-size: 13px; }
		.lilacs-stories__cta { display: flex; justify-content: space-between; align-items: center; gap: 18px; margin-top: 28px; padding: 22px 24px; border-radius: 22px; background: linear-gradient(90deg, #5b21b6, #7c3aed); color: #fff; }
		.lilacs-stories__cta h2 { margin: 0 0 6px; font-size: 1.4rem; }
		.lilacs-stories__cta p { margin: 0; max-width: 62ch; color: rgba(255,255,255,.88); }
		.lilacs-stories__cta a { background: #fff; color: var(--violet); padding: 12px 16px; white-space: nowrap; }
		.lilacs-stories__empty { padding: 36px 16px; text-align: center; color: var(--muted); }
		.lilacs-stories__pager { display: flex; justify-content: center; gap: 6px; margin-top: 22px; }
		.lilacs-stories__pager .page-numbers { display: inline-flex; min-width: 36px; height: 36px; align-items: center; justify-content: center; border-radius: 999px; border: 1px solid var(--line); background: #fff; text-decoration: none; font-weight: 800; }
		.lilacs-stories__pager .page-numbers.current { background: var(--ink); color: #fff; }
		.lilacs-stories__player { width: min(960px, calc(100vw - 32px)); border: 0; border-radius: 16px; padding: 0; background: #041426; color: #fff; }
		.lilacs-stories__player::backdrop { background: rgba(15, 23, 42, .72); }
		.lilacs-stories__player header { display: flex; justify-content: space-between; gap: 12px; align-items: center; padding: 10px 12px; }
		.lilacs-stories__player header p { margin: 0; font-weight: 700; }
		.lilacs-stories__player button { border: 0; border-radius: 999px; background: rgba(255,255,255,.14); color: #fff; padding: 8px 12px; cursor: pointer; }
		.lilacs-stories__player .frame { position: relative; aspect-ratio: 16/9; background: #000; }
		.lilacs-stories__player iframe, .lilacs-stories__player video { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }
		@media (max-width: 1100px) {
			.lilacs-stories__filters, .stories.compact { grid-template-columns: repeat(3, minmax(0, 1fr)); }
			.lilacs-stories__split, .lilacs-stories__hero .lilacs-stories__inner { grid-template-columns: 1fr; }
		}
		@media (max-width: 720px) {
			.lilacs-stories__filters, .stories, .stories.compact, .theme-grid, .map-layout { grid-template-columns: 1fr; }
			.lilacs-stories__search { border-radius: 16px; flex-wrap: wrap; }
			.lilacs-stories__search button, .lilacs-stories__cta { width: 100%; }
			.lilacs-stories__cta { flex-direction: column; align-items: flex-start; }
			.stories.is-list .story-card__hit { flex-direction: column; }
			.stories.is-list .story-card__media { width: 100%; aspect-ratio: 16/10; }
		}
	</style>

	<section class="lilacs-stories__hero">
			<div class="lilacs-stories__inner">
			<div>
				<span class="lilacs-stories__kicker"><?php esc_html_e( 'LILACS 40 ANOS', 'lilacs' ); ?></span>
				<h1><?php echo esc_html( $hero_title ); ?></h1>
				<p><?php echo esc_html( $page_intro ); ?></p>
				<div class="lilacs-stories__ctas">
					<a href="<?php echo esc_url( $enviar_url ); ?>"><?php esc_html_e( 'Envie seu depoimento', 'lilacs' ); ?> →</a>
					<a class="ghost" href="#lilacs-depo-todos"><?php esc_html_e( 'Assistir ao vídeo', 'lilacs' ); ?></a>
				</div>
			</div>
			<div class="lilacs-stories__visual">
				<?php
				$hero_photo = $hero_post ? $photo_of( $hero_post ) : '';
				if ( $hero_photo !== '' ) :
					?>
					<img src="<?php echo esc_url( $hero_photo ); ?>" alt="" />
				<?php endif; ?>
				<?php if ( $hero_post ) :
					$hero_nome = function_exists( 'bireme_lilacs_depoimento_nome' ) ? bireme_lilacs_depoimento_nome( $hero_post ) : get_the_title( $hero_post );
					$hero_role = trim( (string) get_post_meta( $hero_post, 'cargo', true ) );
					$hero_org  = trim( (string) get_post_meta( $hero_post, 'instituicao', true ) );
					$hero_pais = trim( (string) get_post_meta( $hero_post, 'pais', true ) );
					?>
					<blockquote class="lilacs-stories__quote">
						<p>“<?php echo esc_html( trim( (string) get_post_meta( $hero_post, 'citacao', true ) ) ); ?>”</p>
						<strong><?php echo esc_html( $hero_nome ); ?></strong>
						<span>
							<?php echo esc_html( implode( ' · ', array_filter( array( $hero_role, $hero_org, $hero_pais ) ) ) ); ?>
						</span>
					</blockquote>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<div class="lilacs-stories__inner">
		<form id="depo-filters" method="get" action="<?php echo esc_url( $list_page_url ); ?>">
			<div class="lilacs-stories__search">
				<label class="screen-reader-text" for="lilacs-depo-q" style="position:absolute;left:-999px;"><?php esc_html_e( 'Buscar depoimentos', 'lilacs' ); ?></label>
				<input id="lilacs-depo-q" type="search" name="q" value="<?php echo esc_attr( $q ); ?>" placeholder="<?php esc_attr_e( 'Busque por nome, instituição, país, tema ou palavra-chave…', 'lilacs' ); ?>" />
				<button type="submit"><?php esc_html_e( 'Buscar', 'lilacs' ); ?></button>
			</div>
			<div class="lilacs-stories__filters">
				<label><?php esc_html_e( 'País', 'lilacs' ); ?>
					<select name="pais" onchange="this.form.submit()">
						<option value=""><?php esc_html_e( 'Todos', 'lilacs' ); ?></option>
						<?php foreach ( $paises as $pais_option ) : ?>
							<option value="<?php echo esc_attr( $pais_option ); ?>" <?php selected( $filters['pais'], $pais_option ); ?>><?php echo esc_html( $pais_option ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
				<label><?php esc_html_e( 'Papel na Rede', 'lilacs' ); ?>
					<select name="papel" onchange="this.form.submit()">
						<option value=""><?php esc_html_e( 'Todos', 'lilacs' ); ?></option>
						<?php foreach ( $papeis as $papel_option ) : ?>
							<option value="<?php echo esc_attr( $papel_option ); ?>" <?php selected( $filters['papel'], $papel_option ); ?>><?php echo esc_html( $label( 'papel', $papel_option ) ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
				<label><?php esc_html_e( 'Coleção', 'lilacs' ); ?>
					<select name="colecao" onchange="this.form.submit()">
						<option value=""><?php esc_html_e( 'Todas', 'lilacs' ); ?></option>
						<?php foreach ( $colecoes as $colecao_term ) : ?>
							<option value="<?php echo esc_attr( $colecao_term->slug ); ?>" <?php selected( $filters['colecao'], $colecao_term->slug ); ?>><?php echo esc_html( $colecao_term->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
				<label><?php esc_html_e( 'Formato do relato', 'lilacs' ); ?>
					<select name="formato" onchange="this.form.submit()">
						<option value=""><?php esc_html_e( 'Todos', 'lilacs' ); ?></option>
						<option value="escrito" <?php selected( $filters['formato'], 'escrito' ); ?>><?php echo esc_html( $label( 'formato', 'escrito' ) ); ?></option>
						<option value="video" <?php selected( $filters['formato'], 'video' ); ?>><?php echo esc_html( $label( 'formato', 'video' ) ); ?></option>
					</select>
				</label>
				<label><?php esc_html_e( 'Tema', 'lilacs' ); ?>
					<select name="tema" onchange="this.form.submit()">
						<option value=""><?php esc_html_e( 'Todos', 'lilacs' ); ?></option>
						<?php foreach ( $temas as $tema_option ) : ?>
							<option value="<?php echo esc_attr( $tema_option ); ?>" <?php selected( $filters['tema'], $tema_option ); ?>><?php echo esc_html( $label( 'tema', $tema_option ) ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
				<label><?php esc_html_e( 'Idioma', 'lilacs' ); ?>
					<select name="idioma" onchange="this.form.submit()">
						<option value=""><?php esc_html_e( 'Todos', 'lilacs' ); ?></option>
						<?php foreach ( $idiomas as $idioma_option ) : ?>
							<option value="<?php echo esc_attr( $idioma_option ); ?>" <?php selected( $filters['idioma'], $idioma_option ); ?>><?php echo esc_html( $label( 'idioma', $idioma_option ) ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
				<label><?php esc_html_e( 'Ano do depoimento', 'lilacs' ); ?>
					<select name="ano" onchange="this.form.submit()">
						<option value=""><?php esc_html_e( 'Todos', 'lilacs' ); ?></option>
						<?php foreach ( array_keys( $years ) as $year_option ) : ?>
							<option value="<?php echo esc_attr( $year_option ); ?>" <?php selected( $filters['ano'], (string) $year_option ); ?>><?php echo esc_html( $year_option ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			</div>
		</form>

		<?php if ( $featured ) : ?>
			<div class="lilacs-stories__head">
				<div>
					<h2><?php esc_html_e( 'Histórias em destaque', 'lilacs' ); ?></h2>
					<p><?php esc_html_e( 'Depoimentos que inspiram e mostram o impacto da cooperação na saúde.', 'lilacs' ); ?></p>
				</div>
				<a href="<?php echo esc_url( $filter_url( array( 'destaque' => '1' ) ) ); ?>"><?php esc_html_e( 'Ver todos os destaques', 'lilacs' ); ?> →</a>
			</div>
			<div class="stories">
				<?php foreach ( $featured as $feature ) : ?>
					<?php echo lilacs_depo_story_card( $feature->ID, $label, $photo_of ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="lilacs-stories__head" id="lilacs-depo-todos">
			<div>
				<h2><?php esc_html_e( 'Todos os depoimentos', 'lilacs' ); ?></h2>
				<p>
					<?php
					printf(
						esc_html( _n( '%s depoimento', '%s depoimentos', $total, 'lilacs' ) ),
						esc_html( number_format_i18n( $total ) )
					);
					?>
				</p>
			</div>
			<div class="lilacs-stories__tools">
				<label>
					<span class="screen-reader-text" style="position:absolute;left:-999px;"><?php esc_html_e( 'Ordenar por', 'lilacs' ); ?></span>
					<select name="ordem" form="depo-filters" onchange="document.getElementById('depo-filters').submit()">
						<option value="recentes" <?php selected( $filters['ordem'], 'recentes' ); ?>><?php esc_html_e( 'Mais recentes', 'lilacs' ); ?></option>
						<option value="titulo" <?php selected( $filters['ordem'], 'titulo' ); ?>><?php esc_html_e( 'Nome', 'lilacs' ); ?></option>
					</select>
				</label>
				<button type="button" data-view="grid" class="is-on" aria-label="<?php esc_attr_e( 'Grade', 'lilacs' ); ?>">▦</button>
				<button type="button" data-view="list" aria-label="<?php esc_attr_e( 'Lista', 'lilacs' ); ?>">☰</button>
			</div>
		</div>

		<?php if ( $query->have_posts() ) : ?>
			<div class="stories compact" id="lilacs-depo-grid">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					echo lilacs_depo_story_card( get_the_ID(), $label, $photo_of ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				endwhile;
				wp_reset_postdata();
				?>
			</div>

			<?php
			$total_pages = (int) $query->max_num_pages;
			if ( $total_pages > 1 ) :
				$big = 999999999;
				$pagination = paginate_links( array(
					'base'      => str_replace( (string) $big, '%#%', esc_url( $filter_url( array( 'depo_page' => $big ) ) ) ),
					'format'    => '',
					'current'   => $paged,
					'total'     => $total_pages,
					'type'      => 'list',
					'prev_text' => '←',
					'next_text' => '→',
				) );
				if ( $pagination ) :
					$pagination = str_replace( array( "<ul class='page-numbers'>", '<ul class="page-numbers">' ), '<ul class="page-numbers lilacs-stories__pager">', $pagination );
					echo wp_kses_post( $pagination );
				endif;
			endif;
			?>
		<?php else : ?>
			<div class="lilacs-stories__empty">
				<h2><?php esc_html_e( 'Nenhum depoimento encontrado', 'lilacs' ); ?></h2>
				<p><?php esc_html_e( 'Tente outro termo ou limpe os filtros.', 'lilacs' ); ?></p>
				<p><a href="<?php echo esc_url( $list_page_url ); ?>"><?php esc_html_e( 'Ver todos os depoimentos', 'lilacs' ); ?></a></p>
			</div>
		<?php endif; ?>

		<section class="lilacs-stories__split">
			<div class="panel">
				<h2><?php esc_html_e( 'Histórias por país', 'lilacs' ); ?></h2>
				<p><?php esc_html_e( 'Explore os depoimentos da sua região.', 'lilacs' ); ?></p>
				<div class="map-layout">
					<svg viewBox="0 0 180 220" aria-hidden="true">
						<path fill="#ddd6fe" d="M92 12c28 6 48 28 46 58 18 10 28 36 18 58-8 28-6 48-28 62-18 12-34 8-42-8-16 6-34-8-42-28-10-24-6-46 8-62-16-20-8-52 18-68 8-6 14-12 22-12z"/>
						<circle cx="78" cy="78" r="5" fill="#6d28d9"/>
						<circle cx="96" cy="108" r="4" fill="#7c3aed"/>
						<circle cx="70" cy="128" r="4" fill="#8b5cf6"/>
						<circle cx="108" cy="146" r="4" fill="#6d28d9"/>
					</svg>
					<ol class="country-list">
						<?php
						$shown = array_slice( $by_country, 0, 8, true );
						$max_country = $shown ? max( $shown ) : 1;
						$others = array_sum( array_slice( $by_country, 8 ) );
						if ( ! $shown ) :
							?>
							<li><span><?php esc_html_e( 'Os países aparecem aqui quando o campo País estiver preenchido.', 'lilacs' ); ?></span></li>
						<?php else : ?>
							<?php foreach ( $shown as $country_name => $country_count ) : ?>
								<li>
									<a href="<?php echo esc_url( $filter_url( array( 'pais' => $country_name, 'destaque' => '' ) ) ); ?>">
										<strong><?php echo esc_html( $country_name ); ?></strong>
										<em><?php echo esc_html( (string) $country_count ); ?></em>
									</a>
									<i><b style="width:<?php echo esc_attr( (string) max( 8, (int) round( ( $country_count / $max_country ) * 100 ) ) ); ?>%"></b></i>
								</li>
							<?php endforeach; ?>
							<?php if ( $others > 0 ) : ?>
								<li><span><strong><?php esc_html_e( 'Outros países', 'lilacs' ); ?></strong><em><?php echo esc_html( (string) $others ); ?></em></span></li>
							<?php endif; ?>
						<?php endif; ?>
					</ol>
				</div>
			</div>
			<div class="panel">
				<h2><?php esc_html_e( 'Histórias por tema', 'lilacs' ); ?></h2>
				<p><?php esc_html_e( 'Conheça relatos organizados pelos principais temas da cooperação LILACS.', 'lilacs' ); ?></p>
				<div class="theme-grid">
					<?php if ( ! $by_theme ) : ?>
						<p><?php esc_html_e( 'Os temas aparecem quando os depoimentos estiverem classificados.', 'lilacs' ); ?></p>
					<?php else : ?>
						<?php foreach ( array_slice( $by_theme, 0, 6, true ) as $theme_key => $theme_count ) :
							$theme_color = $tema_colors[ $theme_key ] ?? '#6d28d9';
							?>
							<a class="theme-card" href="<?php echo esc_url( $filter_url( array( 'tema' => $theme_key, 'destaque' => '' ) ) ); ?>" style="background:<?php echo esc_attr( $theme_color ); ?>14">
								<strong style="color:<?php echo esc_attr( $theme_color ); ?>"><?php echo esc_html( $label( 'tema', $theme_key ) ); ?></strong>
								<span><?php echo esc_html( sprintf( _n( '%s relato', '%s relatos', $theme_count, 'lilacs' ), number_format_i18n( $theme_count ) ) ); ?></span>
							</a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section class="lilacs-stories__cta">
			<div>
				<h2><?php esc_html_e( 'Sua história também faz parte da LILACS', 'lilacs' ); ?></h2>
				<p><?php esc_html_e( 'Compartilhe sua experiência em vídeo ou texto e ajude a registrar a trajetória da nossa rede.', 'lilacs' ); ?></p>
			</div>
			<a href="<?php echo esc_url( $enviar_url ); ?>"><?php esc_html_e( 'Enviar meu depoimento', 'lilacs' ); ?> →</a>
		</section>
	</div>

	<dialog class="lilacs-stories__player" id="lilacs-depo-player">
		<header>
			<p id="lilacs-depo-player-title"></p>
			<button type="button" data-close><?php esc_html_e( 'Fechar', 'lilacs' ); ?></button>
		</header>
		<div class="frame" id="lilacs-depo-player-frame"></div>
	</dialog>
	<script>
	(function () {
		var grid = document.getElementById('lilacs-depo-grid');
		document.querySelectorAll('[data-view]').forEach(function (btn) {
			btn.addEventListener('click', function () {
				if (!grid) return;
				grid.classList.toggle('is-list', btn.getAttribute('data-view') === 'list');
				document.querySelectorAll('[data-view]').forEach(function (other) {
					other.classList.toggle('is-on', other === btn);
				});
			});
		});
		var dialog = document.getElementById('lilacs-depo-player');
		var frame = document.getElementById('lilacs-depo-player-frame');
		var titleEl = document.getElementById('lilacs-depo-player-title');
		function closePlayer() {
			if (frame) frame.replaceChildren();
			if (dialog && dialog.open) dialog.close();
		}
		document.querySelectorAll('[data-video]').forEach(function (card) {
			card.addEventListener('click', function () {
				var id = card.getAttribute('data-video');
				if (!id || !dialog || !dialog.showModal) {
					window.open('https://www.youtube.com/watch?v=' + encodeURIComponent(id), '_blank', 'noopener');
					return;
				}
				if (titleEl) titleEl.textContent = card.getAttribute('data-title') || '';
				frame.replaceChildren();
				var iframe = document.createElement('iframe');
				iframe.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) + '?autoplay=1';
				iframe.title = card.getAttribute('data-title') || 'YouTube';
				iframe.allow = 'autoplay; encrypted-media; picture-in-picture';
				iframe.allowFullscreen = true;
				frame.appendChild(iframe);
				dialog.showModal();
			});
		});
		if (dialog) {
			dialog.addEventListener('close', function () { if (frame) frame.replaceChildren(); });
			dialog.addEventListener('click', function (event) {
				if (event.target === dialog || event.target.closest('[data-close]')) closePlayer();
			});
		}
	})();
	</script>
</main>
<?php
get_footer();
