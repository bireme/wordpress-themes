<?php
/* Template Name: OPAS */
?>
<?php get_header('opas'); ?>
<?php get_template_part('includes/nav-opas') ?>
<?php get_template_part('includes/banners') ?>
<?php get_template_part('includes/agenda-opas') ?>
<main id="main_container">
	<?php the_content(); ?>
</main>
<?php get_footer('opas'); ?>