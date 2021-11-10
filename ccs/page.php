<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<main class="padding1" id="main_container">
	<div class="container">
		<h2 class="title1"><?php the_title(); ?></h2>
		<?php while(have_posts()) : the_post();	?>
			<?php the_post_thumbnail('large',['class' => 'img-fluid imgPost']); ?>
			<?php the_content();
		endwhile;
		?>
	</div>
</main>
<?php get_footer(); ?>