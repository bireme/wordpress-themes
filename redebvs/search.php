<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<?php dynamic_sidebar( 'aux-top-level2' ); ?>
<?php if ( function_exists( 'vhl_breadcrumb' ) ) { vhl_breadcrumb(); } ?>
	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();?>
				<article class="entry-header">
			        <?php the_post_thumbnail( 'category-thumb' ); ?>
			        <div class="entry-content">
		                <h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		                <?php the_excerpt(); ?>
			        </div>
				</article>
			<?php endwhile; ?>

			<?php twentytwelve_content_nav( 'nav-below' );?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php dynamic_sidebar( 'level2' ); ?>
<?php get_footer(); ?>