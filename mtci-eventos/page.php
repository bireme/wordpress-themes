<?php get_header('opas'); ?>
<?php get_template_part('includes/nav-opas') ?>
<main id="main_container">
	<h1 class="title1"><?php the_title(); ?></h1>
	<div class="container">
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer('opas'); ?>