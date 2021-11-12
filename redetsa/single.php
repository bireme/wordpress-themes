<?php get_header();?>
<?php get_template_part('includes/nav'); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h1 class="title1"><?php the_title(); ?></h1>
		<div class="row">
			<div class="col-md-<?php echo !is_active_sidebar( 'sidebar-1' ) ? '12' : '9'; ?>">
				<?php while(have_posts()) : the_post();	?>
					<?php the_content();
				endwhile;
				?>
				<div class="row">
					<hr>
					<div class="col-12 col-md-6">
						<?php previous_post_link( '%link' ); ?>  
					</div>
					<div class="col-12 col-md-6 text-end">
						<?php next_post_link( '%link'); ?>  
					</div>
				</div>
			</div>
			<div class="col-md-3 <?php echo !is_active_sidebar( 'sidebar-1' ) ? 'd-none' : ''; ?>">
				<?php dynamic_sidebar('sidebar-1') ?>
			</div>
		</div>	
	</div>
</main>
<?php get_footer(); ?>