<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<main id="main_container">
	<div class="container padding1">
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer(); ?>