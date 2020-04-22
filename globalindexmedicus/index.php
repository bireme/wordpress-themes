<?php get_header() ?>
<?php get_template_part( 'includes/banner' ) ?>
<?php get_template_part( 'includes/search', 'box' ) ?>
<?php $idioma = pll_current_language(); ?>
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
<?php get_template_part('includes/miniBanner') ?>
<?php get_template_part('includes/widgets') ?>
<section class="guia">
	<div class="container text-center">
		<div class="row">
			<div class="col-md-4">
				<img src="<?php bloginfo('template_directory') ?>/img/guia<?php echo ( in_array($idioma, ['ar', 'ru']) ? "en" : $idioma ); ?>.png " alt="" class="img-fluid">
			</div>
			<div class="col-md-8">
				<h2><?php pll_e('Veja como é fácil pesquisar no GIM'); ?></h2>
				<h5><a href="<?php bloginfo('template_directory') ?>/img/guia<?php echo ( in_array($idioma, ['ar', 'ru']) ? "en" : $idioma ); ?>.pdf" target="_blank" class="btn btn-lg btn-warning"><?php pll_e('Clique para baixar o guia rápido de pesquisa GIM'); ?></a></h5>
			</div>
		</div>
	</div>
</section>
<?php get_footer() ?>