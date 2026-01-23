<?php get_header('interno'); ?>
<main id="main_container" class="mb-5">
	<div class="container">
		<div class="breadcrumb mt-3">
			<?php if (function_exists('bcn_display')) { bcn_display(); } ?>
		</div>
		<h1 class="title"><?php  the_title(); ?></h1>
		<div class="float-start me-5 mb-4">
			
		<?php
		if ( has_post_thumbnail() ) { 
			the_post_thumbnail('full', ['class' => 'img-fluid rounded marginb1']); 
		}
		?>
		</div>
		<?php the_content(); ?>
		<div class="clearfix"></div>
			<hr class="border">	
		<div class="row">
			<div class="col-12 col-md-4">
				<?php previous_post_link( '%link' ); ?>  
			</div>
			<div class="col-12 offset-md-4 col-md-4 text-end">
				<?php next_post_link( '%link'); ?> 
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>