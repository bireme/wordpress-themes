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
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<div class="featured-post">
				<?php _e( 'Featured post', 'twentytwelve' ); ?>
			</div>
		<?php endif; ?>
		
		<header class="entry-header">
			<!--?php twentytwelve_entry_meta(); ?-->
			<? 	
				if(!function_exists('get_content')) {
					function get_content($array) {
						if(is_array($array)) {
							foreach($array as $item) {
								if(!empty($item)) {
									return $item;
								}
							}
						} else {
							return "";	
						}					
					}

				}
				$meta = get_post_meta(get_the_ID()); 
				//print '<pre>'; print_r($meta);
				foreach($meta as $key => $item) {
					$key = str_replace('-', '', $key);
					$$key = get_content($item);
				}			
			?>
			<div class="byline">
				<span class="date">
				<!--?php the_time('d.m.Y, G:i'); ?-->
				<? if(isset($datadepublicacao) and !empty($datadepublicacao)): ?>
					<?= $datadepublicacao; ?>
				<? endif ?>
				</span> - <span class="author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php printf(get_the_author() ); ?></a></span>
			</div>
			
			<?php if ( is_single() ) : ?>
				<?php the_post_thumbnail(); ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		
				
		<div class="entry-content">
			
			<div class="home_thumb">
				<?php the_post_thumbnail('home_thumb'); ?>
			</div>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			<span class="btn more">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">leia mais >></a>
			</span>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
			
		</div><!-- .entry-content -->
		<?php endif; ?>
		
		
		<footer class="entry-meta">
			<?php if ( is_single() ) : ?>
			<?php twentytwelve_entry_meta(); ?>
			<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
			<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
				<div class="author-info">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentytwelve_author_bio_avatar_size', 68 ) ); ?>
					</div><!-- .author-avatar -->
					<div class="author-description">
						<h2><?php printf( __( 'About %s', 'twentytwelve' ), get_the_author() ); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentytwelve' ), get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			<?php endif; ?>
			<?php endif; ?>
		</footer><!-- .entry-meta -->
		
	</article><!-- #post -->
