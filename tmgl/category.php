<?php get_header(); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<?php get_template_part('includes/breadcrumb') ?>
		<h1 class="title1"><img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt=""> <?php $cat = get_the_category(); echo $cat[0]->cat_name; ?></h1>
		<?php while(have_posts()) : the_post(); ?>
			<article>
				<a href="<?php the_permalink() ?>">
					<b><?php the_title(); ?></b>
				</a>
				<?php the_excerpt(); ?>
				<hr>
			</article>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>