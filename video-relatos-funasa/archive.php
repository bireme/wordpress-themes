<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Twelve already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
			<header class="archive-header">
				<strong class="archive-title"><?php
					if ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'twentytwelve' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'twentytwelve' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'twentytwelve' ) ) . '</span>' );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'twentytwelve' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'twentytwelve' ) ) . '</span>' );
                    elseif (is_tax() ) :
                            echo 'Tema: ' . get_queried_object()->name;
                    elseif (is_tag() ) :
                            echo 'Tag: ' . get_queried_object()->name;
					else :
						_e( 'Relatos', 'twentytwelve' );
					endif;
				?></strong>
			</header><!-- .archive-header -->
			
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
			<?php endwhile; ?>

			<?php the_posts_pagination( array('mid_size' => 2) ); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
		</div><!-- #content -->
		<div class="single2column">
			<?php if ( is_active_sidebar( 'level2' ) ) : ?>
				<?php dynamic_sidebar( 'level2' ); ?>
			<?php endif; ?>
		</div>
	</section><!-- #primary -->

<?php get_footer(); ?>
