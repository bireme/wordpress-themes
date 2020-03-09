<?php /* Template Name: Notícias */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<section class="container">
	<h4 class="title1"><?php the_title(); ?></h4>
	<div class="row" id="main_container">
		<?php 
		$posts = new WP_Query([
			'post_type' => 'post',
			'posts_per_page' => '-1'
		]);
		while($posts->have_posts()) : $posts->the_post(); ?>
			<article class="col-md-4 col-lg-3 postsInter imEffect">
				<a href="<?php permalink_link(); ?>">
					<div class="row">
						<div class="col-12">
							<?php the_post_thumbnail('medium_large',['class' => 'img-fluid']); ?>
						</div>
						<div class="col-12">
							<b><?php the_title(); ?></b> <br>
							<small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></small>
						</div>
					</div>
				</a>
			</article>
			<?php
		endwhile;
		?>
	</div>
</section>
<?php get_footer(); ?>