<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="padding1">
	<div class="container">
		<small><?php if (!is_home()): ?><div class="breadcrumb"><?php get_breadcrumb(); ?></div><?php endif; ?></small>
		<h1 class="title1"><?php the_title(); ?></h1>
	<?php the_content(); ?>
	</div>
</main>
<?php get_footer(); ?>