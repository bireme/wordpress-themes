<?php /* Template Name: Home */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<?php get_template_part('includes/banners') ?>
<section class="container">
	<div class="row margin1">
		<div class="col-md-12">
			<h3 class="title1">Acervo da Biblioteca</h3>
			<div class="text-center">
				<a href="" class="btnAcervo"><i class="fas fa-book"></i> <br> Livros</a>
				<a href="" class="btnAcervo"><i class="fas fa-newspaper"></i> <br>Periódicos</a>
				<a href="" class="btnAcervo"><i class="fas fa-tablet-alt"></i> <br>E-books</a>
				<a href="" class="btnAcervo"><i class="fas fa-chart-pie"></i> <br>Iconográficos</a>
				<a href="" class="btnAcervo"><i class="fas fa-film"></i> <br>Vídeos</a>
				<a href="" class="btnAcervo"><i class="fas fa-file"></i> <br>Folhetos</a>
				<a href="" class="btnAcervo"><i class="fas fa-sticky-note"></i> <br>Cartazes</a>
				<a href="" class="btnAcervo"><i class="fas fa-file"></i><br>Folder</a>
			</div>
		</div>
	</div>
</section>

<section class="padding1" id="temas">
	<div class="container">
		<!-- <h2 class="title1">Temas</h2> -->
		<div class="row">
			<?php 
			$Tema = new WP_Query(array(
				'post_type' => 'Tema',
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
			<div class="col-md-4">
				<!-- <h2 class="title1">Legislação da Saúde</h2> -->
				<div class="margin3">
					<a href="">
						<img src="<?php bloginfo('template_directory') ?>/img/slegis.jpg" class="img-fluid imgOpacity" alt="">
					</a>
				</div>
				<div class="margin3">
					<a href="">
						<img src="<?php bloginfo('template_directory') ?>/img/legislacao.jpg" class="img-fluid imgOpacity" alt="">
					</a>
				</div>
				<div class="margin3">
					<a href="">
						<img src="<?php bloginfo('template_directory') ?>/img/bse.jpg" class="img-fluid imgOpacity" alt="">
					</a>
				</div>
			</div>
			<div class="col-md-8 text-center">
				<!-- <h2 class="title1">Produtos da BVS</h2> -->
				<p>
					<a href="" class="btn btn-lg btn-outline-success btnRadius">ColecionaSUS</a>
					<a href="" class="btn btn-lg btn-outline-success btnRadius">Boletim Informações para Saúde</a>
					<a href="" class="btn btn-lg btn-outline-success btnRadius">Datas da Saúde</a>
					<a href="" class="btn btn-lg btn-outline-success btnRadius">Dicas em Saúde</a>
					<a href="" class="btn btn-lg btn-outline-success btnRadius">Eventos</a>
					<a href="" class="btn btn-lg btn-outline-success btnRadius">Catálogos</a>
					<a href="" class="btn btn-lg btn-outline-success btnRadius">Terminologia da Saúde</a>
					<a href="" class="btn btn-lg btn-outline-success btnRadius">Galeria dos Ministros</a>
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
					<div class="col margin2">
						<div class="card cardRecursos">
							<div class="card-body text-center">
								<a href="">
									<img src="<?php bloginfo('template_directory') ?>/img/icone-politicas.svg" width="150" alt="">
									Políticas e Diretrizes do SUS
								</a>
							</div>
						</div>
					</div>
					<div class="col margin2">
						<div class="card cardRecursos">
							<div class="card-body text-center">
								<a href="">
									<img src="<?php bloginfo('template_directory') ?>/img/icone-protocolos.svg" width="150" alt="">
									Protocolos Clinícos
								</a>
							</div>
						</div>
					</div>
					<div class="col margin2">
						<div class="card cardRecursos">
							<div class="card-body text-center">
								<a href="">
									<img src="<?php bloginfo('template_directory') ?>/img/icone-protocolos2.svg" width="150" alt="">
									Protocolos da Atenção Básica
								</a>
							</div>
						</div>
					</div>
					<div class="col margin2">
						<div class="card cardRecursos">
							<div class="card-body text-center">
								<a href="">
									<img src="<?php bloginfo('template_directory') ?>/img/icone-indicadores.svg" width="150" alt="">
									Indicadores de Saúde e Sistemas de Informação
								</a>
							</div>
						</div>
					</div>
					<div class="col margin2">
						<div class="card cardRecursos">
							<div class="card-body text-center">
								<a href="">
									<img src="<?php bloginfo('template_directory') ?>/img/icone-tabela.svg" width="150" alt="">
									Tabelas de Procedimentos SIGTAP
								</a>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>
<?php get_template_part('includes/miniBanners') ?>
<?php get_template_part('includes/noticias') ?>
<?php get_footer(); ?>