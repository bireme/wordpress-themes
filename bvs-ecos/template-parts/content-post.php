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

	<div class="row grid-taxonomy-date">	
		<?php if(get_post_type() == 'post'){ ?>
			<div class="col-sm-6 col-md-6 taxonomy-grid">
				<label class="categories-post d-block">
					<?php 
					$categories = get_the_category();
					$separator = ' | ';
					$output = '';
					if ( ! empty( $categories ) ) {
						foreach( $categories as $category ) {
							$output .= '<a class="taxonomy '. esc_attr($category->slug) .'" href="'. esc_url( get_category_link( $category->term_id ) ) .'">'. esc_html( $category->name ) .'</a>'. $separator;
						}
						echo trim( $output, $separator );
					}
					?>
				</label>
			</div>
			<div class="col-sm-6 col-md-6 date-grid">			
				<label class="date-post d-block"><?php echo get_the_date("d/F/Y"); ?></label>			
			</div>
		<?php } else if(get_post_type() == 'course'){ ?>
			<div class="col-sm-12 col-md-12">
				<label class="date-post d-block"><?php echo get_date_and_location_course(); ?></label>
			</div>
		<?php } ?>		
	</div>

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