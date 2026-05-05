<?php /* Template Name: Estação BVS */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>

<main>
	<div class="container pt-4 pb-5">
		<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
			<?php if (function_exists('bcn_display')) {
				bcn_display();
			} ?>
		</div>
		<h1 class="title1"><?php the_title (); ?></h1>
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer(); ?>