<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="container margin1">
	<h1 class="title1 margin3"><?php the_title(); ?></h1>
	<div class="text-center"><?php if (has_post_thumbnail()) { the_post_thumbnail('large', ['class' => 'margin2 img-fluid']);} ?></div>
	<?php the_content(); ?>
	<br>
	<hr>
	<div class="post-badge"><b>Categorias:</b> <?php the_category(); ?></div>

	<div class="row">
		<div class="col-12 col-md-6">
			<?php previous_post_link( '%link' ); ?>  
		</div>
		<div class="col-12 col-md-6 text-end">
			<?php next_post_link( '%link'); ?>  
		</div>
	</div>
</main>
<?php get_footer(); ?>