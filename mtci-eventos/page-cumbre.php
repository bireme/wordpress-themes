<?php
/* Template Name: Pages Cumbre - Default */
?>
<?php get_header('opas'); ?>
<?php get_template_part('includes/nav-opas') ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h1 class="title1-opas"><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer('opas'); ?>