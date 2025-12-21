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
	</div>
</main>
<?php get_footer(); ?>