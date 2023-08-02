<?php get_header(); ?>
<?php while(have_posts()) : the_post();
	$menu 			= get_field('menu');
	$imagem_rodape 	= get_field('imagem_rodape');
endwhile;
?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/banners') ?>
<?php get_template_part('includes/frase') ?>
<main id="main_container">
	<div class="container padding5">
		<?php the_content(); ?>
	</div>
</main>
<?php get_template_part('includes/frases') ?>
<?php get_template_part('includes/produtos') ?>
<?php get_template_part('includes/agenda') ?>
<?php get_template_part('includes/videos') ?>
<section class="padding2 color1">
	<div class="container">
		<img src="<?php echo $imagem_rodape['url']; ?>" alt="<?php echo $imagem_rodape['alt']; ?>" class="img-fluid rounded">
	</div>
</section>
<?php get_template_part('includes/modal') ?>
<?php get_footer(); ?>