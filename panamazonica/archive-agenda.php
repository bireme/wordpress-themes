<?php
/*
 * A query dessa pagina é filtrada no inc/post-type-agenda.php
 */

global $paged;
$showing_past = ($paged > 0 || $_GET['filtro'] == 'passados');
?>

<?php get_header(); ?>
    
    <div class="content">
    
    	<header class="archive-header">	        
    		<div class="archive-filter">
    			<?php if ($showing_past): ?>
    				<span class="archive-filter-current"><?php _e( 'Past Events', 'panamazonica' ); ?></span> <a class="view-events" href="<?php echo add_query_arg('filtro', 'futuros'); ?>" title="<?php _e( 'View Future Events', 'panamazonica' ); ?>"><?php _e( 'Future Events', 'panamazonica' ); ?></a>
    			<?php else: ?>
    				<a class="view-events" href="<?php echo add_query_arg('filtro', 'passados'); ?>" title="<?php _e( 'View Past Events', 'panamazonica' ); ?>"><?php _e( 'Past Events', 'panamazonica' ); ?></a> <span class="archive-filter-current"><?php _e( 'Future Events', 'panamazonica' ); ?></span>
    			<?php endif; ?>
    		</div>
    		<h1 class="archive-title">Agenda</h1>
    	</header>
       
            <?php if (have_posts()) : ?>

                <?php while ( have_posts() ) : the_post(); ?>

            	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            		<?php $tipo_agenda = wp_get_post_terms( $post->ID, 'agenda_tipo' ); ?>
	
					<header class="entry-header">
						<span class="entry-meta"><?php echo $tipo_agenda[0]->name; ?></span>
						<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('More info on &ldquo;%s&rdquo;', 'panamazonica'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>	
					    <div class="entry-date"><?php echo panamazonica_get_agenda_date(); ?> <a href="<?php the_permalink(); ?>" title="<?php printf( __('More info on &ldquo;%s&rdquo;', 'panamazonica'), the_title_attribute('echo=0') ); ?>" class="read-more"><?php _e( 'More info', 'panamazonica' ); ?></a></div>
					</header>
				         
				</article><!-- /post-<?php the_ID(); ?> -->

				<?php endwhile; ?>

            <?php panamazonica_content_nav( 'nav-below' ); ?>

        <?php else: ?>
        
        	<p class="no-posts no-posts--agenda"><?php _e('No events scheduled.', 'panamazonica'); ?> <a class="view-events" href="<?php echo add_query_arg('filtro', 'passados'); ?>" title="<?php _e( 'View Past Events', 'panamazonica' ); ?>"><?php _e( 'View Past Events', 'panamazonica' ); ?></a>?</p>
        
        <?php endif; ?>

    </div>

<?php get_sidebar() ?>
<?php get_footer(); ?>
