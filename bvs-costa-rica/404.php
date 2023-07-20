<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="padding1">
	<section id="title">
		<div class="container">
			<h1 class="title1">404</h1>
			<?php if (!is_home()): ?><div class="breadcrumb"><?php get_breadcrumb(); ?></div><?php endif; ?>
		</div>
	</section>
	<div class="container padding1 text-center">
		<div class="row align-items-center">
			<div class="col-md-6">
				
				<img src="<?php bloginfo('template_directory'); ?>/img/404.jpg" alt="404" class="img-fluid">
			</div>
			<div class="col-md-6">
				<div class="d-grid gap-2">
					<a href="<?php echo get_option('siteurl'); ?>" class="btn btn-lg btn-warning">Parece que te perdiste. ¿Qué tal volver a la página de inicio?</a>
					<a href="<?php echo get_option('siteurl'); ?>/pt" class="btn btn-lg btn-warning">Parece que você se perdeu. Que tal voltar para a página inicial?</a>
					<a href="<?php echo get_option('siteurl'); ?>/en" class="btn btn-lg btn-warning">Looks like you got lost. How about going back to the home page?</a>
				</div>	
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>