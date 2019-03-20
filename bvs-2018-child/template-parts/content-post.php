<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="row">
		<div class="col-6 col-sm-6 col-md-9">
			<label class="categories-post">
				<?php 
				$categories = get_the_category();
				$separator = ' | ';
				$output = '';
				if ( ! empty( $categories ) ) {
				    foreach( $categories as $category ) {
				        $output .= '<a href="'. esc_url( get_category_link( $category->term_id ) ) .'">'. esc_html( $category->name ) .'</a>'. $separator;
				    }
				    echo trim( $output, $separator );
				}
				?>
			</label>
		</div>
		<div class="col-6 col-sm-6 col-md-3 text-right">
			<div class="dropdown btn-share">
				<button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="fa fa-share-alt m-r-5"></span> <span><?php _e('Compartilhar', 'bvs_lang'); ?></span>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="mailto:?body=<?php echo get_the_permalink(); ?>&subject=<?php echo get_the_title(); ?>">
						<span class="fas fa-envelope-square m-r-5"></span> Email
					</a>
					<a class="dropdown-item" target="_blank" href="https://www.facebook.com/share.php?u=<?php echo get_the_permalink(); ?>" >
						<span class="fab fa-facebook-square m-r-5"></span> Facebook
					</a>
					<a class="dropdown-item" target="_blank" href="http://twitter.com/share?text=<?php echo urlencode(get_the_title()); ?>&url=<?php echo get_the_permalink(); ?>">
						<span class="fab fa-twitter-square m-r-5"></span> Twitter
					</a>
					<a class="dropdown-item" target="_blank" href="https://web.whatsapp.com/send?text=<?php echo get_the_title() .' - '. get_the_permalink(); ?>">
						<span class="fab fa-whatsapp-square m-r-5"></span> WhatsApp
					</a>					
				</div>
			</div>
		</div>
	</div>
	
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php wp_bootstrap_starter_posted_on(); ?>
		</div><!-- .entry-meta -->

		<div class="entry-tags">
			<?php echo get_the_tag_list( '<span class="badge badge-pill badge-primary">', '</span><span class="badge badge-pill badge-primary">', '</span>' ); ?>
		</div>
		<?php endif; ?>
	</header><!-- .entry-header -->	
	
	<div class="entry-content">

		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	
		<?php
        if ( is_single() ) :
			the_content();
        else :
            the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wp-bootstrap-starter' ) );
        endif;

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php wp_bootstrap_starter_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
