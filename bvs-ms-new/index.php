<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<?php get_template_part('includes/banners') ?>
<section class="container">
	<div class="row margin1">
		<div class="col-md-12">
			<h3 class="title2">Acervo da Biblioteca</h3>
			<div class="text-center">
				<?php
				$home = new WP_Query([
					'post_type' => 'page',
					'pagename' => 'home'
				]);
				while($home->have_posts()) : $home->the_post();
					if( have_rows('acervo') ): ?>
						<?php while( have_rows('acervo') ): the_row(); $row = get_row(); $count = count($row)/3; $loop = 0; ?>
							<?php while ($count > $loop) : $loop++; ?>
								<?php
								$icone = get_sub_field('icone_'.$loop);
								$titulo = get_sub_field('titulo_'.$loop);
								$link = get_sub_field('link_'.$loop);
								?>
								<?php if ( $link ) : ?>
									<a href="<?php echo $link; ?>" class="btnAcervo" target="_blank"><?php echo $icone; ?> <br> <?php echo $titulo; ?></a>
								<?php endif; ?>
							<?php endwhile; ?>
						<?php endwhile; ?>
					<?php endif; ?>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</section>

<section class="padding2" id="temas">
	<div class="container">
		<h3 class="title2">Temas</h3>
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
									<?php 
									if ( $foto == "") { ?>
										<img src="<?php bloginfo( 'template_directory')?>/img/blogIndisponivel.jpg" alt="imagem indisponível">
									<?php }else{ ?>
										<img src="<?php echo esc_url($foto['sizes']['tema']); ?>" alt="<?php echo $foto['alt'] ?>" class="img-fluid rounded">
									<?php }	 ?>
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
			<h3 class="title2">Produtos da Biblioteca MS</h3>
				<?php
				$home = new WP_Query([
					'post_type' => 'page',
					'pagename' => 'home'
				]);
				while($home->have_posts()) : $home->the_post();
					if( have_rows('legistacao') ): ?>
						<?php while( have_rows('legistacao') ): the_row(); $row = get_row(); $count = count($row)/3; $loop = 0; ?>
							<?php while ($count > $loop) : $loop++; ?>
								<?php
								$foto = get_sub_field('foto_'.$loop);
								$link = get_sub_field('link_'.$loop);
								$abrir = get_sub_field('abrir_'.$loop);
								?>
								<?php if ( $link ) : ?>
									<article class="margin3">
										<a href="<?php echo $link; ?>" target="<?php echo $abrir; ?>">
											<img src="<?php echo esc_url($foto['url']); ?>" alt="<?php echo $foto['alt'] ?>" class="img-fluid imgOpacity rounded">
										</a>
									</article>

								<?php endif; ?>
							<?php endwhile; ?>
						<?php endwhile; ?>
					<?php endif; ?>
				<?php endwhile; ?>
			</div>

			<div class="col-md-8">
				<div class="text-center"><h3 class="title2 title3">Produtos da BVS</h3></div>
				<p class="text-center">
					<?php
					while($home->have_posts()) : $home->the_post();
						if( have_rows('produtos_bvs') ): ?>
							<?php while( have_rows('produtos_bvs') ): the_row(); $row = get_row(); $count = count($row)/3; $loop = 0; ?>
								<?php while ($count > $loop) : $loop++; ?>
									<?php
									$titulo = get_sub_field('titulo_'.$loop);
									$link = get_sub_field('link_'.$loop);
									$janela = get_sub_field('janela_'.$loop);
									?>
									<?php if ( $titulo ) : ?>
										<a href="<?php echo $link; ?>" target="<?php echo $janela; ?>" class="btn btn-lg btn-outline-success btnRadius"><?php echo $titulo; ?></a>
									<?php endif; ?>
								<?php endwhile; ?>
							<?php endwhile; ?>
						<?php endif; ?>
					<?php endwhile; ?>
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
						if( have_rows('recursos') ): ?>
							<?php while( have_rows('recursos') ): the_row(); $row = get_row(); $count = count($row)/3; $loop = 0; ?>
								<?php while ($count > $loop) : $loop++; ?>
									<?php
									$image = get_sub_field('imagem_'.$loop);
									$texto = get_sub_field('texto_'.$loop);
									$link = get_sub_field('link_'.$loop);
									$abrir = get_sub_field('abrir_'.$loop);
									?>
									<?php if ( $image ) : ?>
										<div class="col-6 col-md-4 col-lg margin2">
											<div class="card cardRecursos">
												<div class="card-body text-center">
													<a href="<?php echo $link; ?>" target="<?php echo $abrir; ?>">
														<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo $foto['alt'] ?>" class="img-fluid rounded">
														<br><br>
														<?php echo $texto; ?>
													</a>
												</div>
											</div>
										</div>
									<?php endif; ?>
								<?php endwhile; ?>
							<?php endwhile; ?>
						<?php endif; ?>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_template_part('includes/miniBanners') ?>
<?php get_template_part('includes/noticias') ?>
<?php get_footer(); ?>