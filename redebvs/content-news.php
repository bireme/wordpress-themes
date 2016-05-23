<?php
/**
 * The template for displaying posts in the Aside post format
 *
 * @package WordPress
 * @subpackage redebvs
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if (current_theme_supports('post-thumbnails') && has_post_thumbnail()) : ?>
			<div class="thumb-img">
      			<div class="entry-image">
        			<a href="<?php the_permalink(); ?>" rel="bookmark">
						<?php the_post_thumbnail('category-thumb', array('class' => 'list-img')); ?>
					</a>
				</div>
			</div>
		<?php endif ?>
		<div class="metadata">
			<?php
				$categories = get_the_term_list($post->ID, 'category', '', ', ');
				if ($categories) :
			?>
				<div class="entry-categories">
					<span class="entry-cats-list"><?php echo $categories; ?></span>
				</div>
			<?php endif; ?>
			<div class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</div>
			<div class="byline">
				<time class="published" datetime="<?php echo get_the_time(); ?>"><?php the_time('j/M/Y');?> - <?php the_time('H:i'); ?></time> - <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a>
			</div>
			<div class="entry-summary">
				<p>
					<?php // echo get_the_excerpt(); ?>
					<?php echo substr(get_the_excerpt(), 0,80) . '...'; ?>
				</p>
			</div>
		</div><!-- .metadata -->
		<div class="spacer"></div>
	</article><!-- #post -->
