<?php get_header(); ?>
	
	<div class="content">
	
		<?php if ( have_posts() ) : ?>

			<header class="archive-header page-header">
				<?php
					$allsearch = &new WP_Query("s=$s&showposts=-1");
					$key = esc_html($s, 1);
					$count = $allsearch->post_count;
				?>
				<a href="<?php echo get_search_feed_link(); ?>" title="<?php _e( 'Subscribe to this search results', 'panamazonica' )?>" class="icon-alone feed-link"><span aria-hidden="true" data-icon="&#xf09e;"></span><span class="assistive-text"><?php _e( 'Search results feed', 'panamazonica' ); ?></span></a>		
				<h1 class="archive-title page-title"><?php printf( __( '%1$s Results for %2$s', 'panamazonica' ), $count, get_search_query() ); ?></h1>
			</header>

			<?php while ( have_posts() ) : the_post();
			
				 if ( 'agenda' == get_post_type() ) : ?>
				
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            			<?php $tipo_agenda = wp_get_post_terms( $post->ID, 'agenda_tipo' ); ?>
						
						<header class="entry-header">
							<span class="entry-meta"><?php echo $tipo_agenda[0]->name; ?></span>
							<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('More info on &ldquo;%s&rdquo;', 'panamazonica'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>	
						    <div class="entry-date"><?php echo panamazonica_get_agenda_date(); ?> <a href="<?php the_permalink(); ?>" title="<?php printf( __('More info on &ldquo;%s&rdquo;', 'panamazonica'), the_title_attribute('echo=0') ); ?>" class="read-more"><?php _e( 'More info', 'panamazonica' ); ?></a></div>
						</header>				         
					</article><!-- /post-<?php the_ID(); ?> -->
					
				<?php elseif ( 'documento' == get_post_type() ) : ?>
			
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        	
		                <header class="entry-header">
		                	<?php if ( $blog_id == 1 && $original_blog_id = get_post_meta( $post->ID, '_original_blog_id', true ) ) : ?>
		                	<div class="entry-meta"><?php echo get_blog_details( $original_blog_id )->blogname; ?></div>
		                	<?php endif; ?>
		                	<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Read, comment and share &ldquo;%s&rdquo;', 'panamazonica'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>	
		                    <?php if ( $autor = panamazonica_get_documento_meta( '_pan_autor' ) ) : ?><small>/ Por <?php echo $autor; ?></small><?php endif; ?>
		                </header>
		                
		                <div class="entry-summary">
		                	<?php the_excerpt(); ?>
		                </div><!-- /entry-summary -->
		                     
		            </article><!-- /post-<?php the_ID(); ?> -->
					
				<?php else : ?>
			
					<?php get_template_part( 'content', get_post_format() ); ?>
				
				<?php endif; ?><!-- check post type -->			
				
			<?php endwhile; ?>

			<?php panamazonica_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>			

	</div><!-- /content -->		
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>
