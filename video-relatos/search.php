<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
	<div class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>" class="home">Home</a> > <?php the_title(); ?></div>
	<section id="primary" class="site-content">
		<div id="content" class="single1column" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<strong class="archive-title"><?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></strong>
			</header>

			

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article>
                        <header>
                                <div class="entry-image"><?php the_post_thumbnail('thumbnail'); ?></div>
                        </header>
                        <div class="news-content">
                                <div class="entry-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></div>
                                <div class="custom-field custom-field-autor"><?php $key="autor"; echo get_post_meta($post->ID, $key, true); ?></div>
                                <div class="entry-summary"><?php the_excerpt(); ?></div>
                        </div>
                        <div class="spacer"></div>
                </article>

				<?php // get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			

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
		<div class="single2column">
            <?php if ( is_active_sidebar( 'level2' ) ) : ?>
                    <?php dynamic_sidebar( 'level2' ); ?>
            <?php endif; ?>
        </div>

	</section><!-- #primary -->

<?php get_footer(); ?>
