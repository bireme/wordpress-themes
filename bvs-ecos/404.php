<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

	<section id="primary" class="content-area col-sm-12 col-lg-12">
		<div id="main" class="site-main" role="main">

			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e("Home", "bvs-ecos"); ?></a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php _e( 'Página não encontrada', 'bvs-ecos' ); ?></li>
				</ol>
			</nav>

			<div class="entry-header">
				<h1 class="title"><?php esc_html_e( 'Página não encontrada', 'bvs-ecos' ); ?></h1>
			</div>

			<section class="error-404 not-found">
				<div class="page-content">
					<p><?php esc_html_e( 'Nada foi encontrado neste local. Tente utilizar a busca abaixo', 'bvs-ecos' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</div><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
