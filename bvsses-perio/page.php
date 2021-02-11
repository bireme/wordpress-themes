<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>

<main class="padding1">
	<div class="container">
		<h1 class="title1"><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>
</main>

<?php # get_template_part('includes/noticias') ?>
<?php get_footer(); ?>