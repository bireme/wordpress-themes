<?php /* Template Name: Notícias */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h2 class="title1">Notícias</h2>
		
		<div class="row">
			<?php 
			$atual = get_the_title();
			$posts = new WP_Query([
				'post_type' => 'post',
				'posts_per_page' => '-1'
			]);
			while($posts->have_posts()) : $posts->the_post();?>
				<article class="col-6 col-md-4 col-lg-4 newsBox">
					<a href="<?php permalink_link(); ?>">
						<div class="slideNewsDate"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></div>
						<h6><?php the_title(); ?></h6>
					</a>
				</article>
				<?php
			endwhile;
			?>
		</div>
	</div>
</main>
<?php get_footer(); ?>