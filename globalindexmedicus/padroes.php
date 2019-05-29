<?php
	/*
		template name: Padrão
	*/
?>

<?php get_header() ?>
<?php get_template_part( 'includes/search', 'box' ) ?>
<section class="padding1">
	<div class="container">
		<h2 class="titulo1"><?php the_title(); ?></h2>
	</div>
</section>
<?php get_template_part('includes/widgets') ?>
<?php get_footer() ?>