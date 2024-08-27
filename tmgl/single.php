<?php get_header(); ?>
<div class="container">
	<?php get_template_part('includes/breadcrumb') ?>
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>
</div>
<?php get_footer(); ?>