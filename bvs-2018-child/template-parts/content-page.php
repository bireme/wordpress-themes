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
		<div class="col-md-9">
			<?php
		    $enable_vc = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);
		    $parent_page = get_post_ancestors(get_the_ID());

		    if(!$enable_vc && !empty($parent_page)) { ?>
		    <header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header><!-- .entry-header -->
		    <?php } ?>
		</div>
		<div class="col-md-3 text-right">
			<div class="dropdown btn-share">
				<button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-share-alt m-r-5"></i> <span><?php _e('Compartilhar', 'bvs_lang'); ?></span>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="mailto:?body=<?php echo get_the_permalink(); ?>&subject=<?php echo get_the_title(); ?>">
						<i class="fas fa-envelope-square m-r-5"></i> Email
					</a>
					<a class="dropdown-item" target="_blank" href="https://www.facebook.com/share.php?u=<?php echo get_the_permalink(); ?>" >
						<i class="fab fa-facebook-square m-r-5"></i> Facebook
					</a>
					<a class="dropdown-item" target="_blank" href="http://twitter.com/share?text=<?php echo urlencode(get_the_title()); ?>&url=<?php echo get_the_permalink(); ?>">
						<i class="fab fa-twitter-square m-r-5"></i> Twitter
					</a>
					<a class="dropdown-item" target="_blank" href="https://web.whatsapp.com/send?text=<?php echo get_the_title() .' - '. get_the_permalink(); ?>">
						<i class="fab fa-whatsapp-square m-r-5"></i> WhatsApp
					</a>					
				</div>
			</div>
		</div>
	</div>

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() && !$enable_vc ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'wp-bootstrap-starter' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->
