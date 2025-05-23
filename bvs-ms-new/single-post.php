<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container">
	<div class="container pt-4 pb-5">
		<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
			<?php if(function_exists('bcn_display'))
			{
				bcn_display();
			}?>
		</div>
		<h1 class="title1"><?php the_title(); ?></h1>
		<div class="mt-5">
			<?php if (has_post_thumbnail()) : ?>
				<div class="single-thumb">
					<?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
				</div>
			<?php endif; ?>
			<?php the_content(); ?>
			<br>
			<hr class="border">	
			<?php
			setlocale(LC_TIME, 'pt_BR.UTF-8');
			echo 'Publicado: '. strftime('%A, %d de %B de %Y', strtotime(get_the_date()));
			?>

			<div class="clearfix mt-5"></div>
		</div>
		<div class="row">
			<hr class="border">	
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