<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<section class="padding1">
	<div class="container">
		<div class="breadcrumbs">
			<?php if(function_exists('bcn_display')){bcn_display();}?>
		</div>
		<h1 class="title1"><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>
</section>
<?php get_footer(); ?>