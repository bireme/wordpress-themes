<?php get_header('home'); ?>
<main id="main_container"class="padding2">
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