<?php
/**
 * Template Name: LILACS Single Post
 * Description: Modelo de single de notícia seguindo o layout LILACS + compatível com Polylang.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

/**
 * ============================================================
 * POLYLANG – DEFINIR LINK CORRETO PARA A PÁGINA DE NOTÍCIAS
 * ============================================================
 */

// Tenta obter a página "blog" traduzida (se você tiver uma página criada com esse slug)
$blog_page = function_exists('pll_get_post') ? pll_get_post(get_option('page_for_posts')) : null;

if ($blog_page) {
    $blog_url = '/blog';
} else {
    // fallback para o arquivo de posts traduzido
    $blog_url = '/blog';
}

?>
<style>
/* ========= SINGLE BLOG LILACS – UX/UI ========= */
.site-content{
    background:#f1f1f1;
}
.lilacs-single-wrapper {
	max-width: 1180px;
	margin: 0 auto 60px;
	padding: 32px 16px;
	font-family: system-ui, sans-serif;
}

.lilacs-single-back {
	margin-bottom: 20px;
}

.lilacs-single-back a {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	font-size: 0.9rem;
	text-decoration: none;
	color: #005aa7;
	padding: 6px 10px;
	border-radius: 999px;
	background: #eef4fb;
	transition: background 0.18s ease, transform 0.12s ease;
}

.lilacs-single-back a:hover {
	background: #dbe7fb;
	transform: translateX(-2px);
}

/* CARD PRINCIPAL */

.lilacs-single-card {
	background: #ffffff;
	border-radius: 16px;
	box-shadow: 0 10px 30px rgba(0,0,0,0.06);
	padding: 26px 24px 28px;
	position: relative;
}

/* DATA */

.lilacs-single-date {
	position: absolute;
	top: 18px;
	right: 24px;
	font-size: 0.8rem;
	color: #666;
	background: #f0f2f6;
	padding: 4px 10px;
	border-radius: 999px;
}

/* TÍTULO */

.lilacs-single-title {
	font-size: 2rem;
	line-height: 1.25;
	font-weight: 700;
	color: #222;
	margin: 8px 0 12px;
	padding-right: 120px;
}

/* META */

.lilacs-single-meta {
	font-size: 0.9rem;
	color: #777;
	margin-bottom: 18px;
}

.lilacs-single-meta span + span::before {
	content: "•";
	margin: 0 6px;
	color: #ccc;
}

/* CONTEÚDO */

.lilacs-single-content {
	font-size: 1rem;
	color: #333;
	line-height: 1.7;
}

.lilacs-single-content p {
	margin-bottom: 1.1em;
}

.lilacs-single-content h2,
.lilacs-single-content h3,
.lilacs-single-content h4 {
	margin: 1.6em 0 0.6em;
	color: #1d2b3a;
}

.lilacs-single-content a {
	color: #005aa7;
	text-decoration: underline;
}

.lilacs-single-content a:hover {
	text-decoration: none;
}

/* NAVEGAÇÃO */

.lilacs-single-nav {
	display: flex;
	justify-content: space-between;
	gap: 12px;
	margin-top: 24px;
	padding-top: 18px;
	border-top: 1px solid #e5e7eb;
	font-size: 0.9rem;
}

.lilacs-single-nav a {
	color: #005aa7;
	text-decoration: none;
}

.lilacs-single-nav a:hover {
	text-decoration: underline;
}

@media (max-width: 768px) {
	.lilacs-single-card { padding: 22px 16px 24px; }
	.lilacs-single-date { position: static; margin-bottom: 8px; }
	.lilacs-single-title { padding-right: 0; font-size: 1.6rem; }
	.lilacs-single-nav { flex-direction: column; }
}
</style>

<main class="lilacs-single-wrapper">

	<div class="lilacs-single-back">
		<a href="<?php echo esc_url($blog_url); ?>">
			<span>←</span>
			<span><?php echo function_exists('pll__') ? pll__('Voltar para notícias') : __('Voltar para notícias'); ?></span>
		</a>
	</div>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class('lilacs-single-card'); ?>>

				<span class="lilacs-single-date">
					<?php echo esc_html(get_the_date()); ?>
				</span>

				<h1 class="lilacs-single-title"><?php the_title(); ?></h1>

				<div class="lilacs-single-meta">
					<?php
					$author_label = function_exists('pll__') ? pll__('Por') : __('Por');
					echo esc_html($author_label . ' ' . get_the_author());
					?>
				</div>

<div class="lilacs-single-content entry-content">
    <?php the_content(); ?>

    <?php wp_link_pages([
        'before' => '<div class="page-links">' . __('Páginas:', 'lilacs'),
        'after'  => '</div>',
    ]); ?>
</div>


				<div class="lilacs-single-nav">
					<div><?php previous_post_link('%link', '← %title'); ?></div>
					<div><?php next_post_link('%link', '%title →'); ?></div>
				</div>

			</article>

	<?php endwhile; else : ?>

		<p><?php echo function_exists('pll__') ? pll__('Post não encontrado') : __('Post não encontrado'); ?></p>

	<?php endif; ?>

</main>

<?php get_footer(); ?>
