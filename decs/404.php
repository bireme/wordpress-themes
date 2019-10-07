<?php get_template_part('includes/topAcessibility') ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<div class="titulo1 text-center">
	<h2>404</h2>
</div>
<main id="main_container" class="padding1">
	<div class="container">
		<p class="text-justify">
			<br>
			Página não encontrada!
		</p>
	</div>
</main>
<?php if( is_active_sidebar('home_widget') ) { ?>
     <section class="container" id="widgetHome">
         <?php dynamic_sidebar('home_widget'); ?>
     </section>
<?php } ?>
<?php get_template_part('includes/partners') ?>
</section>
<?php get_footer(); ?>