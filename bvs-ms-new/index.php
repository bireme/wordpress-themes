<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<?php get_template_part('includes/banners') ?>
<?php
$home = new WP_Query([
	'post_type' => 'page',
	'pagename' => 'home'
]);
while($home->have_posts()) : $home->the_post();
	$acervo = get_field('acervo');
	while( have_rows('acervo') ): the_row(); 
		$link_livros = get_sub_field('link_livros'); 
		$link_periodicos = get_sub_field('link_periodicos');
		$links_books = get_sub_field('links_books');
		$link_infograficos = get_sub_field('link_infograficos');
		$link_videos = get_sub_field('link_videos');
		$link_folhetos = get_sub_field('link_folhetos');
		$link_cartezes = get_sub_field('link_cartezes');
		$link_folders = get_sub_field('link_folders');
		?>
		<section class="container">
			<div class="row margin1">
				<div class="col-md-12">
					<h3 class="title1">Acervo da Biblioteca</h3>
					<div class="text-center">
						<a href="<?php echo $link_livros; ?>" class="btnAcervo" target="_blank"><i class="fas fa-book"></i> <br> Livros</a>
						<a href="<?php echo $link_periodicos; ?>" class="btnAcervo" target="_blank"><i class="fas fa-newspaper"></i> <br>Periódicos</a>
						<a href="<?php echo $links_books ?>" class="btnAcervo" target="_blank"><i class="fas fa-tablet-alt"></i> <br>E-books</a>
						<a href="<?php echo $link_infograficos; ?>" class="btnAcervo" target="_blank"><i class="fas fa-chart-pie"></i> <br>Iconográficos</a>
						<a href="<?php echo $link_videos; ?>" class="btnAcervo" target="_blank"><i class="fas fa-film"></i> <br>Vídeos</a>
						<a href="<?php echo $link_folhetos; ?>" class="btnAcervo" target="_blank"><i class="fas fa-file"></i> <br>Folhetos</a>
						<a href="<?php echo $link_cartezes; ?>" class="btnAcervo" target="_blank"><i class="fas fa-sticky-note"></i> <br>Cartazes</a>
						<a href="<?php echo $link_folders; ?>" class="btnAcervo" target="_blank"><i class="fas fa-file"></i><br>Folder</a>
					</div>
				</div>
			</div>
		</section>
		<?php
		$i++;
	endwhile;
endwhile;
?>
<section class="padding1" id="temas">
	<div class="container">
		<!-- <h2 class="title1">Temas</h2> -->
		<div class="row">
			<?php 
			$Tema = new WP_Query(array(
				'post_type' => 'Tema',
				'posts_per_page' => '-1'
			));
			while($Tema->have_posts()) : $Tema->the_post();
				$itens = get_field('group');
				while( have_rows('group') ): the_row(); 
					$foto = get_sub_field('foto'); 
					$link = get_sub_field('link');
					$abrir = get_sub_field('abrir');
					?>
					<article class="col-6 col-md-4 margin2">
						<a href="<?php echo $link; ?>" target="<?php echo $abrir; ?>">
							<div class="row">
								<div class="col-md-4">
									<img src="<?php echo $foto['url']; ?>" alt="" class="img-fluid rounded">
								</div>
								<div class="col-md-8">
									<h6><?php the_title(); ?></h6>
								</div>
							</div>
						</a>
					</article>
					<?php
					$i++;
				endwhile;
			endwhile;
			?>

		</div>
	</div>
</section>



<section class="padding2">
	<div class="container">
		<div class="row">
			<!-- <h2 class="title1">Legislação da Saúde</h2> -->
			<div class="col-md-4">
				<?php
				$home = new WP_Query([
					'post_type' => 'page',
					'pagename' => 'home'
				]);
				while($home->have_posts()) : $home->the_post();
					$legistacao = get_field('legistacao');
					while( have_rows('legistacao') ): the_row(); 
						$foto_ssl = get_sub_field('foto_ssl'); 
						$link_ssl = get_sub_field('link_ssl');
						$foto_lbs = get_sub_field('foto_lbs');
						$link_lbs = get_sub_field('link_lbs');
						$foto_bsens = get_sub_field('foto_bsens');
						$link_bsens = get_sub_field('link_bsens');
						?>
						<article class="margin3">
							<a href="<?php echo $link; ?>" target="_blank">
								<img src="<?php echo $foto_ssl['url']; ?>" class="img-fluid imgOpacity" alt="">
							</a>
						</article>
						<article class="margin3">
							<a href="<?php echo $link; ?>" target="_blank">
								<img src="<?php echo $foto_lbs['url']; ?>" class="img-fluid imgOpacity" alt="">
							</a>
						</article>
						<article class="margin3">
							<a href="<?php echo $link; ?>" target="_blank">
								<img src="<?php echo $foto_bsens['url']; ?>" class="img-fluid imgOpacity" alt="">
							</a>
						</article>

						<?php
						$i++;
					endwhile;
				endwhile;
				?>
			</div>

			<div class="col-md-8 text-center">
				<!-- <h2 class="title1">Produtos da BVS</h2> -->
				<p>
					<?php
				
					while($home->have_posts()) : $home->the_post();
						$produtos_bvs = get_field('produtos_bvs');
						while( have_rows('produtos_bvs') ): the_row(); 
							$link_colecionasus = get_sub_field('link_colecionasus'); 
							$link_boletim = get_sub_field('link_boletim'); 
							$link_datas = get_sub_field('link_datas'); 
							$link_dicas = get_sub_field('link_dicas'); 
							$link_eventos = get_sub_field('link_eventos'); 
							$link_eventos = get_sub_field('link_eventos'); 
							$link_catalogos = get_sub_field('link_catalogos'); 
							$link_terminologia = get_sub_field('link_terminologia'); 
							$link_galeria = get_sub_field('link_galeria'); 

							?>
							<a href="<?php echo $link_colecionasus; ?>" target="_blank" class="btn btn-lg btn-outline-success btnRadius">Coleciona SUS</a>
							<a href="<?php echo $link_datas; ?>" target="_blank" class="btn btn-lg btn-outline-success btnRadius">Boletim Informações para Saúde</a>
							<a href="<?php echo $link_dicas; ?>" target="_blank" class="btn btn-lg btn-outline-success btnRadius">Datas da Saúde</a>
							<a href="<?php echo $link_eventos; ?>" target="_blank" class="btn btn-lg btn-outline-success btnRadius">Dicas em Saúde</a>
							<a href="<?php echo $link_eventos; ?>" target="_blank" class="btn btn-lg btn-outline-success btnRadius">Eventos</a>
							<a href="<?php echo $link_catalogos; ?>" target="_blank" class="btn btn-lg btn-outline-success btnRadius">Catálogos</a>
							<a href="<?php echo $link_terminologia; ?>" target="_blank" class="btn btn-lg btn-outline-success btnRadius">Terminologia da Saúde</a>
							<a href="<?php echo $link_galeria; ?>" target="_blank" class="btn btn-lg btn-outline-success btnRadius">Galeria dos Ministros</a>
							<?php
							$i++;
						endwhile;
					endwhile;
					?>
				</p>
			</div>
		</div>
	</div>
</section>

<section class="padding2 color1">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- <h2 class="title1">Recursos de Informação</h2> -->
				<div class="row">
					<?php
					$home = new WP_Query([
						'post_type' => 'page',
						'pagename' => 'home'
					]);
					while($home->have_posts()) : $home->the_post();
						$recursos = get_field('recursos');
						while( have_rows('recursos') ): the_row(); 
							$link_politicas = get_sub_field('link_politicas'); 
							$link_protocolos = get_sub_field('link_protocolos');
							$link_atencao = get_sub_field('link_atencao');
							$link_indicadores = get_sub_field('link_indicadores');
							$link_tabelas = get_sub_field('link_tabelas');
							?>
							<div class="col margin2">
								<div class="card cardRecursos">
									<div class="card-body text-center">
										<a href="<?php echo $link_politicas; ?>" target="_blank">
											<img src="<?php bloginfo('template_directory') ?>/img/icone-politicas.svg" width="150" alt="">
											Políticas e Diretrizes do SUS
										</a>
									</div>
								</div>
							</div>
							<div class="col margin2">
								<div class="card cardRecursos">
									<div class="card-body text-center">
										<a href="<?php echo $link_protocolos; ?>" target="_blank">
											<img src="<?php bloginfo('template_directory') ?>/img/icone-protocolos.svg" width="150" alt="">
											Protocolos Clinícos
										</a>
									</div>
								</div>
							</div>
							<div class="col margin2">
								<div class="card cardRecursos">
									<div class="card-body text-center">
										<a href="<?php echo $link_atencao; ?>" target="_blank">
											<img src="<?php bloginfo('template_directory') ?>/img/icone-protocolos2.svg" width="150" alt="">
											Protocolos da Atenção Básica
										</a>
									</div>
								</div>
							</div>
							<div class="col margin2">
								<div class="card cardRecursos">
									<div class="card-body text-center">
										<a href="<?php echo $link_indicadores; ?>" target="_blank">
											<img src="<?php bloginfo('template_directory') ?>/img/icone-indicadores.svg" width="150" alt="">
											Indicadores de Saúde e Sistemas de Informação
										</a>
									</div>
								</div>
							</div>
							<div class="col margin2">
								<div class="card cardRecursos">
									<div class="card-body text-center">
										<a href="<?php echo $link_tabelas; ?>" target="_blank">
											<img src="<?php bloginfo('template_directory') ?>/img/icone-tabela.svg" width="150" alt="">
											Tabelas de Procedimentos SIGTAP
										</a>
									</div>
								</div>
							</div>
							<?php
							$i++;
						endwhile;
					endwhile;
					?>

				</div>
			</div>
		</div>
	</div>
</section>
<?php get_template_part('includes/miniBanners') ?>
<section class="padding1 ">
	<div class="container">
		<h2 class="title1">Clipping de Notícias</h2>
		<div class="slideNews">
			<?php 
			$atual = get_the_title();
			$posts = new WP_Query([
				'post_type' => 'post',
				'posts_per_page' => '12'
			]);
			while($posts->have_posts()) : $posts->the_post();?>
				<article class="slideNewsBox">
					<a href="<?php permalink_link(); ?>">
						<!-- <img src="<?php bloginfo('template_directory') ?>/img/news1.jpg" alt="" class="img-fluid"> -->
						<h4><?php the_title(); ?></h4>
						<div class="slideNewsDate"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></div>
					</a>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<p class="text-center">
			<a href="<?php echo get_option('siteurl'); ?>/clipping-de-noticias" class="btn btn-success">Ver todas</a>
		</p>
	</div>
</section>
<?php get_footer(); ?>