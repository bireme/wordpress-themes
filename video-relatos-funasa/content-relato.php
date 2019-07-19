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
		<header>
			<div class="entry-image">
				<?php the_post_thumbnail( 'thumbnail' ); ?>
			</div>
		</header><!-- .entry-header -->
		<div class="news-content">
			<h4 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h4>
			<?php the_excerpt(); ?>
		</div><!-- .news-content -->

	</article><!-- #post -->
