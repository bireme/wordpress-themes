<?php
	/*
		template name: Single Page
	*/
?>
<?php get_header(); ?>
<section class="padding1" id="main_container">>
	<div class="container">
		<h2 class="titulo1"><?php the_title(); ?></h2>
		<?php while(have_posts()) : the_post();
					the_content();
				endwhile;
		?>
		
	</div>
</section>
<?php get_footer(); ?>