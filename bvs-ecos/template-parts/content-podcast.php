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

	<div class="row">	
		<div class="col-sm-12 col-md-12">			
			<label class="date-post d-block"><?php echo get_the_date("d/F/Y"); ?></label>			
		</div>	
	</div>

	<header class="entry-header">
		<?php the_title('<h1 class="title">', '</h1>'); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(array(
			'before' => '<div class="page-links">' . esc_html__('Pages:', 'bvs-ecos'),
			'after'  => '</div>',
		));
		?>
	</div><!-- .entry-content -->

	<?php
		$tag_list = get_the_tag_list( '', '&nbsp;&nbsp;&nbsp;&nbsp;', '' );
		if( !empty( $tag_list ) ) { ?>
			<div class="tags-post">
				<?php _e( 'Tags: ', 'bvs-ecos' ); echo $tag_list; ?>
			</div>
	<?php
		}
	?>

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
</article><!-- #post-## -->