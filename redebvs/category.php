<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<?php dynamic_sidebar( 'aux-top-level2' ); ?>
<?php if ( function_exists( 'portal_breadcrumb' ) ) { portal_breadcrumb(); } ?>
	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php printf( __( 'Category: %s', 'twentytwelve' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>

			<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
			<?php endif; ?>
			</header><!-- .archive-header -->

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

		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php dynamic_sidebar( 'level2' ); ?>
<div class="spacer"></div>
	<div class="footer_sidebar">
		<?php dynamic_sidebar( 'single-sidebar' ); ?>
		<div class="spacer"></div>
	</div>
<?php get_footer(); ?>
