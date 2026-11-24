<?php
/**
 * Single do CPT FAQ (ufaq).
 *
 * O index.php imprime título e conteúdo direto em #site-content, sem a
 * largura do restante do site. Aqui o artigo fica no mesmo container do
 * breadcrumb (max-width 1230px).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<main class="lilacs-ufaq-single" id="lilacs-ufaq-<?php echo esc_attr( (string) get_the_ID() ); ?>">
			<div class="lilacs-ufaq-single__inner">
				<h1 class="lilacs-ufaq-single__title"><?php the_title(); ?></h1>
				<div class="lilacs-ufaq-single__content">
					<?php the_content(); ?>
				</div>
			</div>
		</main>
	<?php endwhile; ?>
<?php endif; ?>

<style>
	.lilacs-ufaq-single {
		background: #fff;
		color: #1e293b;
	}

	.lilacs-ufaq-single__inner {
		max-width: 1230px;
		margin: 0 auto;
		padding: 32px 20px 72px;
		box-sizing: border-box;
	}

	.lilacs-ufaq-single__title {
		margin: 0 0 20px;
		font-family: "Noto Sans", system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
		font-size: clamp(26px, 3vw, 36px);
		line-height: 1.25;
		font-weight: 700;
		color: #00205c;
	}

	.lilacs-ufaq-single__content {
		font-family: "Noto Sans", system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
		font-size: 16px;
		line-height: 1.7;
		color: #1e293b;
		overflow-wrap: break-word;
	}

	.lilacs-ufaq-single__content p,
	.lilacs-ufaq-single__content li {
		margin: 0 0 1em;
	}

	.lilacs-ufaq-single__content img,
	.lilacs-ufaq-single__content iframe,
	.lilacs-ufaq-single__content video,
	.lilacs-ufaq-single__content table,
	.lilacs-ufaq-single__content pre {
		max-width: 100%;
		height: auto;
	}

	.lilacs-ufaq-single__content pre {
		white-space: pre-wrap;
	}

	/* Na página individual o plugin ainda envolve o texto no acordeão.
	   O título da página já está no h1; o corpo fica sempre visível. */
	.lilacs-ufaq-single__content .ewd-ufaq-faq-title,
	.lilacs-ufaq-single__content .ewd-ufaq-faq-categories,
	.lilacs-ufaq-single__content .ewd-ufaq-author-date {
		display: none;
	}

	.lilacs-ufaq-single__content .ewd-ufaq-faq-body,
	.lilacs-ufaq-single__content .ewd-ufaq-faq-post {
		display: block;
	}

	.lilacs-ufaq-single__content .ewd-ufaq-faq-div,
	.lilacs-ufaq-single__content .ewd-ufaq-faqs,
	.lilacs-ufaq-single__content #ewd-ufaq-faq-list,
	.lilacs-ufaq-single__content .ewd-ufaq-post-margin {
		max-width: 100%;
		margin-left: 0;
		margin-right: 0;
	}
</style>

<?php
get_footer();
