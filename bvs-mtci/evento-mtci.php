<?php /* Template Name: Event */ ?>
<?php  get_header('events'); ?>
<?php # get_template_part('includes/nav') ?>
<main id="main_container" class="pb-5 mtci-events">
	<div class="container">
		<div id="mtci-events-header"><?php the_post_thumbnail(); ?></div>
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer(); ?>