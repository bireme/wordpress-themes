<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<main id="main_container" class="padding1">
	<div class="container">
	<h1 class=" title1"><?php the_title(); ?></h1><br> 
		<?php while(have_posts()) : the_post();?>
			<?php  the_post_thumbnail('large',['class' => 'img-fluid margin1 mx-auto d-block']); ?><br>
			<?php the_content();?>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>

