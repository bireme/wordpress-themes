<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<main id="main_container" class="container margin1">
	<h1 class="text-center margin3">Erro 404!!!</h1>
	<h2 class="text-center"><small><a href="<?php echo get_option('siteurl'); ?>">Voltar para home page!!!</a></small></h2>
	<?php the_content(); ?>
</main>
<?php get_footer(); ?>