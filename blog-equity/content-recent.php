<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

global $post;


?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( has_post_thumbnail() ) :  ?>
			<div class="entry-image">
				<a href="<?php the_permalink(); ?>" rel="bookmark">
              				<?php the_post_thumbnail(); ?>
            			</a>
			</div>
		<?php endif; ?>
		<div class="r-block">
			<header class="entry-header">
				<div class="entry-meta">
					<time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time> | 
                  			<span class="author vcard">
                    				<?php echo __('By', 'upw'); ?>
                    				<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn">
                      					<?php echo get_the_author(); ?>
                    				</a>
                  			</span>
				</div>
				<h4 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h4>
			</header><!-- .entry-header -->
			<div class="entry-summary">
				<?php if ( has_excerpt ) : ?>
            				<div class="entry-summary">
              					<p>
                					<?php echo get_the_excerpt(); ?>
                  					<a href="<?php the_permalink(); ?>" class="more-link"><?php echo 'more'; ?></a>
              					</p>
            				</div>
          			<?php elseif ($instance['show_content']) : ?>
            				<div class="entry-content">
              					<?php the_content() ?>
            				</div>
          			<?php endif; ?>
			</div>
 			<footer>

		        	<?php
            				$categories = get_the_term_list($post->ID, 'category', '', ', ');
            				if ( has_category ) :
            			?>
              				<div class="entry-categories">
                				<strong class="entry-cats-label"><?php _e('Theme', 'upw'); ?>:</strong>
                				<span class="entry-cats-list"><?php echo $categories; ?></span>
              				</div>
            			<?php endif; ?>
			</footer>
		</div>
	</article><!-- #post -->
	
	<div class="navigation">
		<?php if(function_exists('wp_paginate')) {
    			wp_paginate();
			}
			else {
    				twentytwelve_content_nav( 'nav-below' );
			}
		?> 	
	</div>
