<?php get_header('in'); ?>
<section class="padding50">
	<div class="container" id="main_container">
		<h1><?php the_title(); ?></h1>
		<hr>
		<?php while(have_posts()) : the_post();
			the_content();
		endwhile;
		?>
	</div>
</section>


<?php get_footer(); ?>
<?php get_template_part('includes/modais') ?>