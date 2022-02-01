<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<main class="padding1" id="main_container">
	<div class="container clearfix">
		<h2 class="title1"><?php the_title(); ?></h2>
		<?php while(have_posts()) : the_post();	?>
			<div class="col-md-4 float-md-end mb-3 ms-md-3">
				<?php the_post_thumbnail('large',['class' => 'img-fluid']); ?>
			</div>
			<?php the_content();
		endwhile;
		?>
	</div>
</main>
<?php get_footer(); ?>