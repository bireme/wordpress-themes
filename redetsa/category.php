<?php get_header();?>
<?php get_template_part('includes/nav'); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h1 class="title1"><?php the_title(); ?></h1>
		<?php
		$posts = new WP_Query([
			'post_type' => 'post',
			's' => $_GET['s'],
			'posts_per_page' => '-1'
		]);
		if($posts->have_posts()): while ($posts->have_posts()) : $posts->the_post(); ?>
			<article class="">
				<a href="<?php permalink_link(); ?>">
					<b><?php the_title(); ?></b> <br>
					<small><?php the_excerpt(); ?></small>
					<hr>
				</a>
			</article>
		<?php endwhile; else: endif;?>
	</div>
</main>
<?php get_footer(); ?>