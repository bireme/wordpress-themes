<?php /* Template Name: Comité Científico */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="margin1 padding2">
	<div class="container">
		<h1 class="title1"><?php the_title(); ?></h1>
		<?php the_content(); ?>
		<hr class="text-prymary border-2 opacity-25">
		<?php 
		$acessor = get_the_title();
		$posts = new WP_Query([
			'post_type' => 'cientifico',
			'posts_per_page' => '-1'
		]);
		while($posts->have_posts()) : $posts->the_post();?>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br><?php the_excerpt(); ?>
		<?php endwhile;	?>
	</div>
</main>
<?php get_footer(); ?>