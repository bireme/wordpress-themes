<?php get_header() ?>
<?php get_template_part( 'includes/banner' ) ?>
<?php get_template_part( 'includes/search', 'box' ) ?>

<!-- Bibliotecas -->
<section class="padding1">
	<div class="container">
		<h2 class="titulo1"><?php pll_e('Índices Regionais'); ?></h2>
		<div class="row">
			<?php 
			$biblioteca = new WP_Query(array(
				// 'posts_per_page' => 6,
				'post_type' => 'biblioteca',
				'orderby' => 'title',
				'order'   => 'ASC'
			));
			while($biblioteca->have_posts()) : $biblioteca->the_post();
				?>
				<artigle class="col-12 col-sm-6 col-md-4 bibliotecaHome">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('Bibliotecas', array('class'=>'img-fluid')); ?>
						<h4><span><?php the_title(); ?></span></h4>
						<?php the_excerpt(); ?>
					</a> <br><br>
				</artigle>
			<?php endwhile; ?>

			<!-- Fixo -->
			<?php
				$args = array(
					'post_type' => 'page',
					'name' => 'home-en', 'home-pt','home-es','home-ru','home-zh','home-fr','home-ar'
				); 
				$query = new WP_Query( $args ); 
				if ( $query->have_posts() ) { 
					while ( $query->have_posts() ) {
						$query->the_post(); 
					}
				} 
			?>
			<artigle class="col-12 col-sm-6 col-md-4 bibliotecaHome">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('Bibliotecas', array('class'=>'img-fluid')); ?>
					<h4><span><?php the_title(); ?></span></h4>
					<?php the_excerpt(); ?>
				</a> <br><br>
			</artigle>
		</div>
	</div>
</section>
<?php get_template_part('includes/widgets') ?>
<?php get_footer() ?>