<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<section class="margin4">
	<div class="container">
		<h1 class=" title1"><?php the_title(); ?></h1><br> 
		<?php while(have_posts()) : the_post();?>
			<?php the_content(); ?>
		<?php endwhile;	?>
	</div>
</section>
<?php get_footer(); ?>