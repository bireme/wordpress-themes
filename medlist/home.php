<?php
/*
	template name: HOME
*/
	?>
	<?php get_header() ?>
	<section class="container" style="position: relative;">
		<?php get_template_part('includes/banners') ?>
		<?php get_template_part('includes/search') ?>
		<?php get_template_part('includes/contadores') ?>
	</section>

	<section class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row" id="listasHome">
					<!-- lista 1 -->
					<div class="col-md-6 col-lg-3">
						<div class="homeBox text-center">
							<img src="<?php bloginfo('template_directory') ?>/img/lista1.png" alt="">
							<?php 
							$grupoListas = new WP_Query([
								'post_type' => 'listas',
							]);
							while($grupoListas->have_posts()) : $grupoListas->the_post();
								$grupo = get_field('grupo');
								$titulo = get_field('titulo');
								$link = get_field('link');
								$janela = get_field('janela');
								if ($grupo == 'WHO') {
									?>
									<a href="<?php echo $link; ?>" class="btn btn-sm btn-primary btn-block" target="<?php echo $janela; ?>"><?php echo $titulo; ?></a>
								<?php } 
							endwhile;
							?>
						</div>
					</div>

					<!-- lista 2 -->
					<div class="col-md-6 col-lg-3">
						<div class="homeBox text-center">
							<img src="<?php bloginfo('template_directory') ?>/img/lista2.png" alt="">
							<?php 

							while($grupoListas->have_posts()) : $grupoListas->the_post();
								$grupo = get_field('grupo');
								$titulo = get_field('titulo');
								$link = get_field('link');
								$janela = get_field('janela');
								if ($grupo == 'PAHO') {
									?>
									<a href="<?php echo $link; ?>" class="btn btn-sm btn-primary btn-block" target="<?php echo $janela; ?>"><?php echo $titulo; ?></a>
								<?php } 
							endwhile;
							?>
						</div>
					</div>

					<!-- lista 3 -->
					<div class="col-md-6 col-lg-3">
						<div class="homeBox text-center">
							<img src="<?php bloginfo('template_directory') ?>/img/lista3.png" alt="">
							<?php 
							
							while($grupoListas->have_posts()) : $grupoListas->the_post();
								$grupo = get_field('grupo');
								$titulo = get_field('titulo');
								$link = get_field('link');
								$janela = get_field('janela');
								if ($grupo == 'Dispositivo') {
									?>
									<a href="<?php echo $link; ?>" class="btn btn-sm btn-primary btn-block" target="<?php echo $janela; ?>"><?php echo $titulo; ?></a>
								<?php } 
							endwhile;
							?>
						</div>
					</div>

					<!-- lista 2 -->
					<div class="col-md-6 col-lg-3">
						<div class="homeBox text-center">
							<img src="<?php bloginfo('template_directory') ?>/img/lista4.png" alt="">
							<?php 

							while($grupoListas->have_posts()) : $grupoListas->the_post();
								$grupo = get_field('grupo');
								$titulo = get_field('titulo');
								$link = get_field('link');
								$janela = get_field('janela');
								if ($grupo == 'Paises') {
									?>
									<a href="<?php echo $link; ?>" class="btn btn-sm btn-primary btn-block" target="<?php echo $janela; ?>"><?php echo $titulo; ?></a>
								<?php } 
							endwhile;
							?>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>



	<section class=" padding1">
		<div class="container">
			<h3 class="titulo1"><span class="colorText"><?php echo pll_e('Sumários de evidência'); ?></span></h3>

			<hr>
			<div class="row">
				<?php 
				$home = new WP_Query([
					'post_type' => 'Home',
				]);
				while($home->have_posts()):$home->the_post();
					while( have_rows('sumarios_summaries') ): the_row(); 
						$texto = get_sub_field('texto'); 
						$foto = get_sub_field('foto'); 
						$link = get_sub_field('link'); 
						?>
						<div class="col-md-4">
							<img src="<?php echo $foto['url']; ?>" alt="" class="img-fluid">
						</div>
						<div class="col-md-8">
							<p class="text-justify"><?php echo $texto; ?></p>
							<a href="<?php echo $link; ?>" class="btn btn-success"><?php echo pll_e('Ver Sumários'); ?></a>
						</div>
					<?php endwhile;
				endwhile; ?>
			</div>
		</div>
	</section>

	<section class="sectionCinza padding1">
		<div class="container">
			<h3 class="titulo1"><span class="colorText"><?php echo pll_e('Comparar Listas por Países'); ?> </span></h3>
			<hr>
			<div class="row">
				<?php 
				$home = new WP_Query([
					'post_type' => 'Home',
				]);
				while($home->have_posts()):$home->the_post();
					while( have_rows('paises_countries') ): the_row(); 
						$texto = get_sub_field('texto'); 
						$foto = get_sub_field('foto'); 
						$link = get_sub_field('link'); 
						?>
						<div class="col-md-7">
							<p class="text-justify"><?php echo $texto; ?></p>
							<a href="<?php echo $link; ?>" class="btn btn-success"><?php echo pll_e('Comparar Listas'); ?></a>
						</div>
						<div class="col-6 offset-3 col-md-5 offset-md-0 col-lg-2 offset-lg-3">
							<img src="<?php echo $foto['url']; ?>" alt="" class="img-fluid">
						</div>
					<?php endwhile;
				endwhile; ?>
			</div>
		</div>
	</section>
	<?php get_footer() ?>