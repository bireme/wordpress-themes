<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="container margin1">
	<h1 class="title1 margin3"><?php the_title(); ?></h1>
	<div class="text-center"><?php if (has_post_thumbnail()) { the_post_thumbnail('large', ['class' => 'margin2 img-fluid']);} ?></div>
	<?php the_content(); ?>
</main>
<?php get_footer(); ?>