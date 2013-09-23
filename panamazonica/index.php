<?php get_header(); ?>

<div class="content">
	<?php
	if ( have_posts() ) :

		while ( have_posts() ) : the_post();
			get_template_part( 'content', get_post_format() );
		endwhile;
		
	endif;
	
	panamazonica_content_nav( 'nav-below' );
	?>
		
</div><!-- /content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>