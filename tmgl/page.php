<?php get_header(); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<?php get_template_part('includes/breadcrumb') ?>
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer(); ?>