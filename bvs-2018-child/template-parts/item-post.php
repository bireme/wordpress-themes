<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<div class="col-md-3 item-post">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<?php if( has_post_thumbnail( get_the_ID() ) ){ 
			$url = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
		} else{
			$url = get_default_img();
		} ?>
		<div class="post-thumbnail" style="background-image: url(<?php echo $url; ?>);"></div>
		
		<div class="entries">
			<label class="entry-category">
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
			<header class="entry-header">
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->
			<label class="entry-date">
				<?php echo get_the_date('d M Y', get_the_ID()); ?>
			</label>
			<div class="entry-content">
				<?php crop_text( get_the_excerpt(), 130 ); ?>
			</div><!-- .entry-content -->
			<footer class="entry-footer">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-primary btn-sm">
					<?php _e('Veja mais', 'bvs_lang'); ?> <span class="fas fa-arrow-right"></span>
				</a>
			</footer><!-- .entry-footer -->
		</div>
	</article><!-- #post-## -->
</div>