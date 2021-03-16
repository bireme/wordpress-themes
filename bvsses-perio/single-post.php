<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>

<main class="padding1">
	<div class="container">
		<h1 class="title1"><?php the_title(); ?></h1>
		<div class="boxThumbnail"><?php the_post_thumbnail('full',['class' => 'img-fluid imgPost']); ?></div>
		<?php the_content(); ?>
		<hr>
		<div class="pagination text-center">
			<?php previous_post_link( '%link', 'Anterior', true ); ?>  
			<?php next_post_link( '%link', 'Próximo', true ); ?> 
		</div>
	</div>
</main>

<?php get_template_part('includes/noticias-outras') ?>
<?php get_footer(); ?>