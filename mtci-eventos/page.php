<?php get_header('opas'); ?>
<?php get_template_part('includes/nav-opas') ?>
<main id="main_container">
	<div class="container">
		<h1 class="title1"><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer('opas'); ?>