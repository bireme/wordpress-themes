<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container">
	<section id="title">
		<div class="container">
			<h1 class="title1"><?php the_title(); ?></h1>
			<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
				<?php if(function_exists('bcn_display'))
				{
					bcn_display();
				}?>
			</div>
		</div>
	</section>
	<div class="container padding1">
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