<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="padding1">
	<div class="container">
		<?php
		$posts = new WP_Query([
			's' => $_GET['s'],
			'posts_per_page' => '-1'
		]);
		if($posts->have_posts()): while ($posts->have_posts()) : $posts->the_post(); ?>
			<article>
				<a href="<?php the_permalink(); ?>">
					<b><?php the_title(); ?></b>
					<?php the_excerpt(); ?>
				</a>
				<hr>
			</article>
		<?php endwhile; else: endif;?>
	</div>
</main>
<?php get_footer(); ?>