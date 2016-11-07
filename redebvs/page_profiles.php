<?php
/**
 * Template Name: Profiles
 *
 *
 * @package WordPress
 * @subpackage redebvs
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<?php dynamic_sidebar( 'aux-top-level2' ); ?>
	<?php if ( function_exists( 'vhl_breadcrumb' ) ) { vhl_breadcrumb(); } ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
		                        $post_type = get_post_type( $id );
		                        $pages = get_pages( 'post_type=' . $post_type . '&child_of=' . $id . '&parent=' . $id . '&sort_column=' . $order_by );

		                        if ($pages) {
		                            foreach ( $pages as $page ) { ?>

		                                <?php $meta = get_post_meta( $page->ID ); ?>

		                                <li>
		                                    <a href="<?php echo get_permalink( $page->ID ) ?>" rel="bookmark" title="Permanent Link to <?php echo esc_attr(strip_tags($page->post_title)); ?>"><?php echo $page->post_title; ?></a>
		                                    <?php if ($page->post_excerpt) { ?>
		                        				<div class="excerpt">
		                        				    <?php echo '<p>' . $page->post_excerpt;
		                                                if ($meta['_links_to'] && $page->post_content) { ?>
		                        			                <br />
		                                                    <span class="read_more"><a href="javascript:void(0)">[ Read More &rarr; ]</a></span>
		                                                <?php } ?>
		                                            <?php echo '</p>'; ?>
		                        				</div>
		    			                    <?php } ?>
		                                    <?php if ($page->post_content) { ?>
		                    			        <div class="desc <?php echo $single; ?>">
		                    				        <?php echo html_tidy(wpautop($page->post_content)); ?>
		                                            <span class="show_excerpt"><a href="javascript:void(0)">[ &larr; Show Excerpt ]</a></span>
		                    				    </div>
		                			        <?php } ?>
		                                </li>

		                            <?php }
		                        }
		                    ?>
		                    </ul>
		                </div>
				</div><!-- .entry-content -->
				
				<?php endif; ?>

			</article><!-- #post -->
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
		<div class="spacer"></div>
	</div><!-- #primary -->
	<div class="spacer"></div>
	</div>
	<div class="spacer"></div>
	<div class="footer_sidebar">       
                <?php dynamic_sidebar( 'single-sidebar' ); ?>
                <div class="spacer"></div>
        </div>
<?php get_footer(); ?>
