<?php get_header(); the_post(); ?>
	
	<div class="content">
	    			
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    	<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Read, comment and share &ldquo;%s&rdquo;', 'panamazonica'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link( __( 'Edit', 'panamazonica' ), '', '' ) ?></h1>
	    	<div class="entry-content">
	    	    <?php the_content(); ?>
	    	    <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'panamazonica' ) . '&after=</div>') ?>
	    	</div><!-- /entry-content -->
	    </article><!-- /page-<?php the_ID(); ?> -->			
	
	</div><!-- /content -->		
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>