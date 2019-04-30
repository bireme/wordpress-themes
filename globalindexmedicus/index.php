<?php get_header() ?>
<?php get_template_part( 'banners','include/banner' ) ?>
<?php get_template_part( 'includes/search', 'box' ) ?>

<!-- Bibliotecas -->
<section class="padding1">
	<div class="container">
		<h2 class="titulo1">Bibliotecas da OMS</h2>
		<div class="row">
			<?php 
			$biblioteca = new WP_Query(arrat(
				// 'posts_per_page' => 6,
				'post_type' => 'biblioteca',
				'orderby' => 'title',
    			'order'   => 'ASC'
			));
			while($biblioteca->have_posts()) : $biblioteca->the_post();
				?>
				<artigle class="col-12 col-sm-6 col-md-4 biblitecaHome">
					<a href="<?php the_permalink(); ?>">
						 <?php the_post_thumbnail('Bibliotecas', array('class'=>'img-fluid')); ?>
						<h4><?php the_title(); ?></h4>
						<?php echo substr(get_the_excerpt(), 0, 150).'...'; ?>
					</a> <br><br>
				</artigle>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php get_template_part( 'includes/widgets') ?>
<?php get_footer() ?>