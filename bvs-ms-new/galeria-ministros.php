<?php
/* Template Name: Galeria de Ministros */
?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<section class="margin4">
	<div class="container">
		<div class="row">
			<nav class="col-md-3 navBoletim" >
				<?php
				wp_nav_menu(array(
					'theme_location'    => 'ministros-nav',
					'depth'             => 2,
					'container'         => 'div',
					'container_class'   => 'navBoletimUl',
				));
				?>
			</nav>
			<div class="col-md-9" id="contMinistros">
				<h1 class=" title1"><?php the_title(); ?></h1><br> 
				<?php while(have_posts()) : the_post();?>
					<?php the_content(); ?>

					<br><?php the_category(', '); ?>
				<?php endwhile;	?>
			</div>		
		</div>
	</div>
</section>
<?php get_footer(); ?>