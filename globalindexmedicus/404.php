<?php get_header() ?>

<?php get_template_part( 'banners','include/banner' ) ?>
<?php get_template_part( 'includes/search', 'box' ) ?>

<!-- Bibliotecas -->
<main class="padding1" id="main_container" role="main">
	<div class="container text-center">
		<h2 class="titulo1">404 Page not found!</h2>
		<br><br><br>
		
		<h1>Ooops! <?php pll_e('Página não encontrada!'); ?></h1>
		<h5><?php pll_e('A página que você tentou acessar está indisponível ou não existe.'); ?></h5>
		<br><br><br>
	</div>
</main>
<?php get_template_part( 'includes/widgets') ?>
<?php get_footer() ?>