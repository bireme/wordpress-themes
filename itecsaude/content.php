<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $post;
global $level2;

$all_options = wp_load_alloptions();
$list = unserialize($all_options['widget_vhl_collection']);
$ancestors = get_post_ancestors( $post->ID );
$first_ancestor = ! empty($ancestors) ? implode("", array_slice($ancestors, -1)) : $post->ID;

foreach( $list as $key => $value ) {
    if($value['collection_id'] == $first_ancestor)
        $collection = $list[$key];
}

if ($collection && isset($collection['order_by']))
    $order_by = $collection['order_by'];
else
    $order_by = 'menu_order';

if (is_active_sidebar($level2))
    $single = "single";
else
    $single = "";

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


			<div class="entry-meta">
				<?php twentytwelve_entry_meta(); ?>
				<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
				<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
				<div class="author-info">
					<div class="author-avatar">
						<?php
						/** This filter is documented in author.php */
						$author_bio_avatar_size = apply_filters( 'twentytwelve_author_bio_avatar_size', 68 );
						echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
						?>
					</div><!-- .author-avatar -->
					<div class="author-description">
						<h2><?php printf( __( 'About %s', 'twentytwelve' ), get_the_author() ); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentytwelve' ), get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
				<?php endif; ?>
			</div><!-- .entry-meta -->


			<?php if ( comments_open() ) : ?>
				<div class="comments-link">
					<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentytwelve' ) . '</span>', __( '1 Reply', 'twentytwelve' ), __( '% Replies', 'twentytwelve' ) ); ?>
				</div><!-- .comments-link -->
			<?php endif; // comments_open() ?>
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
                    				        <span class="show_excerpt"><a href="javascript:void(0)">[ Show Excerpt &rarr; ]</a></span>
                    				        <?php echo html_tidy(wpautop($page->post_content)); ?>
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
