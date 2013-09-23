<?php
session_start();

/*
 * A query dessa pagina é filtrada no inc/post-type-documentos.php
 */

global $blog_id, $paged;
?>

<?php get_header(); ?>
    
    <div class="content">
		
		<header class="archive-header">
			<?php
			// Muda o título caso seja uma pesquisa
			
			$page_title = ( empty ( $_SESSION['meta_query'] ) ) ? __('Published Documents', 'panamazonica') : __('Search Documents', 'panamazonica');
			
			?>
			<h1 class="archive-title"><?php echo $page_title; ?></h1>
		</header>
       
        <?php if (have_posts()) : while ( have_posts() ) : the_post(); ?>

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

		<?php endwhile; ?>

        <?php panamazonica_content_nav( 'nav-below' ); ?>

        <?php else:
	    
        	if ( ! empty ( $_SESSION['meta_query'] ) )
        	{
        		session_unset($_SESSION['meta_query']);
        		session_destroy();
        	}
        	
        	//get_template_part( 'content', 'none' ); ?>
            
            <?php _e('No documents found', 'panamazonica'); ?>
        
        <?php endif; ?>

    </div>

<?php get_sidebar( 'documentos' ) ?>
<?php get_footer(); ?>
