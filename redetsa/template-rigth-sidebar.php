<?php
/**
 * Template Name: Right Sidebar
 *
 */
?>
<?php get_header();?>
<?php get_template_part('includes/nav'); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h1 class="title1"><?php the_title(); ?></h1>
		<div class="row">
			<div class="col-md-9">
				<?php while(have_posts()) : the_post();	?>
					<?php the_post_thumbnail('large',['class' => 'img-fluid margin1 mx-auto d-block']); ?>
					<?php the_content();
				endwhile;
				?>
			</div>
			<div class="col-md-3">
				<?php dynamic_sidebar('sidebar-1') ?>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>