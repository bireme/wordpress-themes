<?php
/**
 * Template Name: Gutenberg
 * Template Post Type: Post, Page
 */
?>
<?php get_header();?>
<?php get_template_part('includes/nav'); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h1 class="title1"><?php the_title(); ?></h1>
		<?php while(have_posts()) : the_post();	?>
			<?php the_post_thumbnail('large',['class' => 'img-fluid imgPost']); ?>
			<?php the_content();
		endwhile;
		?>
	</div>
</main>
<?php get_footer(); ?>