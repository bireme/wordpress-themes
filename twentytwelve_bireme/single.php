<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
	<div class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="home">Home</a> > <?php the_title(); ?></div>
	<div id="primary" class="site-content">
		<div id="content" class="single1column" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>
		</div><!-- #content -->
	<div class="single2column">
		<?php dynamic_sidebar( 'level2' ); ?>
	</div>
	</div><!-- #primary -->
<?php get_footer(); ?>