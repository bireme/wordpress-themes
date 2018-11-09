<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

	<section id="primary" class="content-area col-sm-12 col-lg-12">
		<main id="main" class="site-main" role="main">			

			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
			    	<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
				    <li class="breadcrumb-item active" aria-current="page">
				    	<?php _e('Buscando por', 'bvs_lang'); ?>: 
				    </li>
			  	</ol>
			</nav>

			<div class="row justify-content-center">
				<div class="col-md-11">
					<header class="page-header">
						<?php echo get_search_query(); ?>
					</header><!-- .page-header -->

					<?php
					if ( have_posts() ) : ?>			
						
						<div class="row">
							<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();
								
								get_template_part( 'template-parts/item', 'sof' );

							endwhile; 
							?>
						</div>

						<?php
						get_template_part( 'template-parts/navigation' );

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif; ?>
				</div>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
