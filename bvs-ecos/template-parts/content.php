<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	$enable_vc = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);
	if (!$enable_vc) { ?>
		<header class="entry-header">
			<?php the_title('<h1 class="title">', '</h1>'); ?>
		</header><!-- .entry-header -->
	<?php } ?>

	<div class="entry-content">
		<?php if (has_post_thumbnail()) { ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div>
		<?php } ?>

		<?php
		the_content();

		wp_link_pages(array(
			'before' => '<div class="page-links">' . esc_html__('Pages:', 'bvs-ecos'),
			'after'  => '</div>',
		));
		?>
	</div><!-- .entry-content -->


	<?php if( !function_exists("bp_is_groups_directory") || !bp_is_groups_directory() ){ ?>
	<footer class="entry-footer">
		<?php get_template_part('template-parts/share-buttons'); ?>

		<?php if ( shortcode_exists( 'posts_like_dislike' ) ) { ?>
			<div class="reactions-group">
				<?php echo do_shortcode('[posts_like_dislike id='.get_the_ID().']');?>
			</div>
		<?php } ?>

		<?php if (get_edit_post_link() && !$enable_vc) {
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__('Editar %s', 'bvs-ecos'),
					the_title('<span class="screen-reader-text">"', '"</span>', false)
				),
				'<span class="edit-link">',
				'</span>'
			);
		} ?>
	</footer><!-- .entry-footer -->
	<?php } ?>
	
</article><!-- #post-## -->