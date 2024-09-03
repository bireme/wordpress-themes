<?php get_header(); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<?php get_template_part('includes/breadcrumb') ?>
		<h1 class="title1"><img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt=""> <?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer(); ?>