<?php get_header(); ?>
<div id="highlights" class="header-inter m">
	<div class="container">
		<h1>404</h1>
	</div>
</div>
<main id="main" class="ptb-50">
	<div class="container">
		<div class="text-center">
			<h3>Desculpe, não conseguimos encontrar o conteúdo que você tentou acessar.</h3>
			<p>Você pode voltar à <a href="<?php echo get_option('siteurl'); ?>/<?php echo $lang=='pt'?'':$lang; ?>">página inicial</a> e continuar navegando por lá.</p>
			<hr>

			<h3>Lo sentimos, no pudimos encontrar el contenido que intentaste acceder.</h3>
			<p>Puedes volver a la <a href="<?php echo get_option('siteurl'); ?>/<?php echo $lang=='pt'?'':$lang; ?>">página de inicio</a> y seguir navegando desde allí.</p>
			<hr>

			<h3>Sorry, we couldn’t find the content you were trying to access.</h3>
			<p>You can go back to the <a href="<?php echo get_option('siteurl'); ?>/<?php echo $lang=='pt'?'':$lang; ?>">homepage</a> and continue browsing from there.</p>
			<hr>
		</div>

		<?php the_content(); ?>
	</div>
</main>
<?php get_footer(); ?>