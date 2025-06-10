<?php /* Template Name: Event */ ?>
<?php  get_header('events'); ?>
<main id="main_container" class="pb-5 mtci-events">
	<div class="container">
		<div id="mtci-events-header"><?php the_post_thumbnail(); ?></div>
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer(); ?>