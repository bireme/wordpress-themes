<?php
	/*
		template name: Default
	*/
?>

<?php get_header(); ?>
<?php get_template_part( 'includes/banner' ) ?>
<?php get_template_part( 'includes/search', 'box' ) ?>
<section class="padding1" id="main_container">
	<div class="container">
		<h2 class="titulo1"><?php the_title(); ?></h2>
		<?php while(have_posts()) : the_post();
					the_content();
				endwhile;
		?>
		
	</div>
</section>
<?php get_template_part('includes/widgets') ?>
<?php get_footer(); ?>