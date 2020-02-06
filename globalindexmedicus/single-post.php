<?php get_header() ?>

<?php get_template_part( 'banners','include/banner' ) ?>
<?php get_template_part( 'includes/search', 'box' ) ?>

<!-- Bibliotecas -->
<main class="padding1" id="main_container" role="main">
	<div class="container">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post(); ?>
				<h2 class="titulo1"><?php the_title() ?></h2>
				<?php the_content(); ?>
			<?php }
		}
		?>
	</div>
</main>
<?php get_template_part( 'includes/widgets') ?>
<?php get_footer() ?>