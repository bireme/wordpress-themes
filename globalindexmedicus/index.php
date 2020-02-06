<?php get_header() ?>
<?php get_template_part( 'includes/banner' ) ?>
<?php get_template_part( 'includes/search', 'box' ) ?>

<!-- Bibliotecas -->
<main class="padding1" id="main_container" role="main">
	<div class="container">
		<h2 class="titulo1"><?php pll_e('Índices Regionais'); ?></h2>
		<div class="row" id="libray">
			<?php 
			$biblioteca = new WP_Query(array(
				// 'posts_per_page' => 6,
				'post_type' => 'biblioteca',
				'orderby' => 'title',
				'order'   => 'ASC'
			));
			$i = 1;
			while($biblioteca->have_posts()) : $biblioteca->the_post();
				?>
				<artigle class="col-12 col-sm-6 col-md-4 bibliotecaHome" data-aos="zoom-in" data-aos-delay="<?php echo $i ?>00">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('Bibliotecas', array('class'=>'img-fluid')); ?>
						<h4><span><?php the_title(); ?></span></h4>
						<?php the_excerpt(); ?>
					</a> <br><br>
				</artigle>
			<?php
				$i++;
				endwhile;
			?>
		</div>
	</div>
</main>
<?php get_template_part('includes/widgets') ?>
<?php get_footer() ?>