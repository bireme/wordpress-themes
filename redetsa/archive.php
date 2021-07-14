<?php get_header();?>
<?php get_template_part('includes/nav'); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h1 class="title1">Categoria: <?php single_cat_title('' , true ); ?></h1>
		<div class="row">
			<div class="col-md-<?php echo !is_active_sidebar( 'sidebar-1' ) ? '12' : '9'; ?>">
				<?php while(have_posts()) : the_post();	?>
					<article>
						<a href="<?php the_permalink() ?>">
							<b><?php the_title(); ?></b>
							<?php the_excerpt(); ?>
						</a>
						<small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></small>
						<hr>
					</article>
				<?php endwhile;	?>
			</div>
			<div class="col-md-3 <?php echo !is_active_sidebar( 'sidebar-1' ) ? 'd-none' : ''; ?>">
				<?php dynamic_sidebar('sidebar-1') ?>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>