<?php
/**
 * Single: depoimentos
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

	$nome       = get_the_title();
	$foto       = function_exists( 'get_field' ) ? get_field( 'foto' ) : null;
	$depoimento = function_exists( 'get_field' ) ? get_field( 'depoimento' ) : '';
	$cargo      = function_exists( 'get_field' ) ? (string) get_field( 'cargo' ) : '';
	$pais       = function_exists( 'get_field' ) ? (string) get_field( 'pais' ) : '';
	$list_url   = function_exists( 'bireme_lilacs_depoimentos_list_url' )
		? bireme_lilacs_depoimentos_list_url()
		: home_url( '/' );

	$foto_url = '';
	$foto_alt = $nome;
	if ( is_array( $foto ) ) {
		$foto_url = (string) ( $foto['url'] ?? '' );
		$foto_alt = (string) ( $foto['alt'] ?? $nome );
	} elseif ( is_string( $foto ) && $foto !== '' ) {
		$foto_url = $foto;
	} elseif ( has_post_thumbnail() ) {
		$foto_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
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
	?>
	<main class="lilacs-depo-single" id="lilacs-depoimento-<?php echo esc_attr( (string) get_the_ID() ); ?>">
		<style>
			.lilacs-depo-single {
				--blue-900: #002a4d;
				--blue-800: #0c4380;
				--muted: #475569;
				--stroke: #d6e2f1;
				font-family: "Noto Sans", system-ui, -apple-system, "Segoe UI", sans-serif;
				color: #0f172a;
				background:
					radial-gradient(900px 240px at 12% 0%, rgba(12, 67, 128, .10), transparent 60%),
					linear-gradient(180deg, #fff, #f3f7fc 42%, #fff);
				padding: 0 0 72px;
			}
			.lilacs-depo-single__inner {
				max-width: 820px;
				margin: 0 auto;
				padding: 40px 20px 0;
			}
			.lilacs-depo-single__back {
				display: inline-flex;
				align-items: center;
				gap: 6px;
				margin-bottom: 24px;
				color: var(--blue-800);
				font-weight: 600;
				text-decoration: none;
				font-size: 14px;
			}
			.lilacs-depo-single__back:hover { text-decoration: underline; }
			.lilacs-depo-single__card {
				background: #fff;
				border: 1px solid var(--stroke);
				border-radius: 18px;
				padding: 36px 32px;
				box-shadow: 0 16px 40px rgba(2, 23, 55, .08);
			}
			.lilacs-depo-single__head {
				display: flex;
				align-items: center;
				gap: 18px;
				margin-bottom: 28px;
			}
			.lilacs-depo-single__avatar {
				width: 88px;
				height: 88px;
				border-radius: 999px;
				object-fit: cover;
				flex-shrink: 0;
				background: #e8eef7;
			}
			.lilacs-depo-single__avatar--empty {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				font-size: 28px;
				font-weight: 700;
				color: var(--blue-800);
			}
			.lilacs-depo-single__name {
				margin: 0 0 6px;
				font-size: clamp(1.5rem, 2.2vw, 2rem);
				line-height: 1.2;
				color: var(--blue-900);
			}
			.lilacs-depo-single__role {
				margin: 0 0 8px;
				color: var(--muted);
				font-size: 16px;
			}
			.lilacs-depo-single__country {
				display: inline-block;
				padding: 4px 10px;
				border-radius: 999px;
				background: #eef4fb;
				color: var(--blue-800);
				font-size: 13px;
				font-weight: 600;
			}
			.lilacs-depo-single__quote {
				margin: 0;
				padding: 0;
				border: 0;
				font-size: 18px;
				line-height: 1.7;
				color: #1e293b;
			}
			.lilacs-depo-single__quote p { margin: 0 0 1em; }
			.lilacs-depo-single__quote p:last-child { margin-bottom: 0; }
			@media (max-width: 640px) {
				.lilacs-depo-single__card { padding: 24px 18px; }
				.lilacs-depo-single__head { flex-direction: column; align-items: flex-start; }
			}
		</style>

		<div class="lilacs-depo-single__inner">
			<a class="lilacs-depo-single__back" href="<?php echo esc_url( $list_url ); ?>">
				← <?php esc_html_e( 'Voltar aos depoimentos', 'lilacs' ); ?>
			</a>

			<article class="lilacs-depo-single__card">
				<header class="lilacs-depo-single__head">
					<?php if ( $foto_url !== '' ) : ?>
						<img
							class="lilacs-depo-single__avatar"
							src="<?php echo esc_url( $foto_url ); ?>"
							alt="<?php echo esc_attr( $foto_alt ); ?>"
							width="88"
							height="88"
						/>
					<?php else : ?>
						<span class="lilacs-depo-single__avatar lilacs-depo-single__avatar--empty" aria-hidden="true">
							<?php echo esc_html( $initials ?: '?' ); ?>
						</span>
					<?php endif; ?>

					<div>
						<h1 class="lilacs-depo-single__name"><?php echo esc_html( $nome ); ?></h1>
						<?php if ( $cargo !== '' ) : ?>
							<p class="lilacs-depo-single__role"><?php echo esc_html( $cargo ); ?></p>
						<?php endif; ?>
						<?php if ( $pais !== '' ) : ?>
							<span class="lilacs-depo-single__country"><?php echo esc_html( $pais ); ?></span>
						<?php endif; ?>
					</div>
				</header>

				<?php if ( $depoimento !== '' && $depoimento !== false ) : ?>
					<div class="lilacs-depo-single__quote">
						<?php echo wp_kses_post( $depoimento ); ?>
					</div>
				<?php elseif ( get_the_content() ) : ?>
					<div class="lilacs-depo-single__quote">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>
			</article>
		</div>
	</main>
	<?php
endwhile;

get_footer();
