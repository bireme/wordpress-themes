<?php get_header();?>
<div id="title-vagas">
	<h2 class="text-center"><?php the_title(); ?></h2>
</div>
<main id="main_container">
	<div class="container">
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer();?>