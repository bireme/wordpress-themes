<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'twentytwelve' ); ?>
		</div>
		<?php endif; ?>
		<header class="entry-header">
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
			
		</header><!-- .entry-header -->

		<!-- displays child items -->
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
	                <div class="storycontent">
	                        <?php //the_content(__('(more...)')); ?>
	                </div>
	        </div>
		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
 		        <div class="childPages">
                                <ul>
                                <?php
                                        global $id;
                                        global $post;
                                        $post_type = get_post_type( $id );
                                        $args=array(
                                                'post_type' => $post_type,
                                                'post_status' => 'publish',
                                                'posts_per_page' => -1,
                                                'caller_get_posts' => 1,
                                                'post_parent' => $id,
                                                'orderby' => 'title',
                                                'order' => 'ASC',
                                        );
                                        $my_query = null;
                                        $my_query = new WP_Query($args);
                                        if( $my_query->have_posts() ) {
                                                while ($my_query->have_posts()) : $my_query->the_post();
                                ?>
                                                <li>
                                                        <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                                        <?php echo "<p>" . $post->post_excerpt . "</p>"; // echo get_post($post->ID)->post_excerpt; ?>
                                                </li>
                                <?php
                                                endwhile;
                                        }
                                        wp_reset_query();  // Restore global post data stomped by the_post().
                                ?>
                                </ul>
                        </div>

		</div><!-- .entry-content -->
		<?php endif; ?>

	</article><!-- #post -->
