<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<section class="container">
	<div class="row" id="main_container">
		<div class="col-12">
			<h4 class="title1"><?php single_cat_title() ?></h4>
		</div>
		<div class="col-md-12">
			<div class="row">
				<?php while(have_posts()) : the_post(); ?>
					<article class="col-md-4 categoryHome imEffect">
						<a href="<?php permalink_link(); ?>">
							<?php 
							if ( has_post_thumbnail()) {
								the_post_thumbnail('banners',['class' => 'img-fluid']);
							}else{ ?>
								<img src="<?php bloginfo( 'template_directory')?>/img/indisponivel.jpg" class="img-fluid" alt="">
							<?php }	 ?>
							<b><?php the_title(); ?></b> <br>
							<small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></small>
						</a><br><br>
					</article>
					<?php
				endwhile;
				?>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
