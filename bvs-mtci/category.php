<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container">
	<section id="title">
		<div class="container">
			<h1 class="title1"><?php $cat = get_the_category(); echo $cat[0]->cat_name; ?></h1>
			<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
				<?php if(function_exists('bcn_display'))
				{
					bcn_display();
				}?>
			</div>
		</div>
	</section>
	<div class="container padding1">
		<?php while(have_posts()) : the_post(); ?>
			<article>
				<a href="<?php the_permalink() ?>">
					<b><?php the_title(); ?></b>
					<?php the_excerpt(); ?>
				</a>
				<hr>
			</article>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>