 <?php get_header(); ?>
 <?php get_template_part('includes/nav') ?>
 <section class="padding1">
 	<div class="container">
 		<div class="breadcrumbs">
 			<?php if(function_exists('bcn_display')){bcn_display();}?>
 		</div>
 		<h1 class="title1">404</h1>
 		<?php the_content(); ?>
 		<div class="text-center">
 			<div class="d-grid gap-2">
 				<a href="<?php echo get_option('siteurl'); ?>" class="btn btn-lg btn-warning">Parece que te perdiste. ¿Qué tal volver a la página de inicio?</a>

 			</div>	
 			<img src="<?php bloginfo('template_directory'); ?>/img/404.jpg" alt="404" class="img-fluid">
 		</div>
 	</div>
 </section>
 <?php the_content(); ?>
 <?php get_footer(); ?>