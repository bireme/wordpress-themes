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

if($ancestors) {
    $first_ancestor = array_slice($ancestors, -1);
    foreach( $list as $key => $value ) {
        if($value['collection_id'] == $first_ancestor[0])
            $collection = $list[$key];
    }
}

if ($collection && isset($collection['child_order']))
    $child_sort = $collection['child_order'];
else
    $child_sort = 'menu_order';

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
		</header><!-- .entry-header -->

<div class="meta-block">
<?php
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( __( ', ', 'twentyeleven' ) );

        /* translators: used between list items, there is a space after the comma */
        $tag_list = get_the_tag_list( '', __( ', ', 'twentyeleven' ) );
        if ( '' != $tag_list ) {                $utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>.', 'twentyeleven' );
        } elseif ( '' != $categories_list ) {                $utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>.', 'twentyeleven' );
        } else {                $utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a>.', 'twentyeleven' );
        }

        printf(
                $utility_text,
                $categories_list,
                $tag_list,
                esc_url( get_permalink() ),
                the_title_attribute( 'echo=0' ),
                get_the_author(),
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
        );
?>
</div>



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
                        $pages = get_pages( 'post_type=' . $post_type . '&child_of=' . $id . '&parent=' . $id . '&sort_column=' . $child_sort );

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
