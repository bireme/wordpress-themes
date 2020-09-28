<?php /* Template Name: Informação para a saúde */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>

<section class="margin4">
	<div class="container">
		<h1 class=" title1"><?php the_title(); ?></h1><br> 
		<div class="row">
			<nav class="col-md-3 navBoletim" >
				<?php
				wp_nav_menu(array(
					'theme_location'    => 'boletim-nav',
					'depth'             => 2,
					'container'         => 'div',
					'container_class'   => '',
					'container_id'      => 'navbarSupportedContent',
					'menu_class'        => 'navbar-nav mr-auto',
					'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
					'walker'            => new WP_Bootstrap_Navwalker())
			);
			?>
		</nav>
		<div class="col-md-9">
			<?php while(have_posts()) : the_post();?>
				<?php the_content(); ?>
			<?php endwhile;	?>
		</div>		
	</div>

</div>
</section>
<?php get_footer(); ?>