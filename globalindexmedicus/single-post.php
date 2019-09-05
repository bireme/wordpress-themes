<?php get_header() ?>

<?php get_template_part( 'banners','include/banner' ) ?>
<?php get_template_part( 'includes/search', 'box' ) ?>

<!-- Bibliotecas -->
<section class="padding1">
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
</section>
<?php get_template_part( 'includes/widgets') ?>
<?php get_footer() ?>