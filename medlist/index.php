<?php get_header() ?>

<section class="container">
	<h1><?php the_title(); ?></h1> <hr>
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
		the_content();
		endwhile;
	else :
		echo wpautop( 'Sorry, no posts were found' );
	endif;
	?>
</section>
<?php get_footer() ?>