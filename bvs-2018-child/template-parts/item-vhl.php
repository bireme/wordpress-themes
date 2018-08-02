<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<div class="col-12 col-sm-12 col-md-6 col-lg-3 item-vhl">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entries">
			<?php
			$target = get_post_meta( get_the_ID(), '_links_to_target', true );
			$target_tag = (!empty($target))? 'target="_blank"' : '';
			?>

			<header class="entry-header">
				<?php the_title( '<h2 class="entry-title"><a '.$target_tag.' href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
			<footer class="entry-footer">
				<a <?php echo $target_tag; ?> href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-primary btn-sm">
					<?php _e('Veja mais', 'bvs_lang'); ?> <i class="fas fa-arrow-right"></i>
				</a>
			</footer><!-- .entry-footer -->
		</div>
	</article><!-- #post-## -->
</div>