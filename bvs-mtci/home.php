<?php /* Template Name: Default without container */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php #get_template_part('includes/search') ?>
<main id="main_container">
	<?php the_content(); ?>
</main>
<?php get_footer(); ?>