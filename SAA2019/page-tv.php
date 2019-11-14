<?php
/*	Template Name: TV*/
?>
<?php wp_head(); ?>
<div id="tvContainer">
	<div class="row" style="position: relative">
		<div class="col-9" id="tvMain">
			<div id="tvTitle">
				<img src="<?php bloginfo( 'template_directory')?>/img/tvLogo.png" alt="">
				<span class="float-right">
					<ul class="list-unstyled"><?php dynamic_sidebar('Clima') ?></ul>
				</span>
			</div>
			<div id="tvCarousel" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<?php 
					$i = 0;
					$posts = new WP_Query([
						'post_type' => 'post',
						'posts_per_page' => '-1'
					]);
					while($posts->have_posts()) : $posts->the_post();
						$image_tv = get_field('image_tv'); 
						$release = get_field('release'); 
						$show = get_field('show'); 
						$qr_code = get_field('qr_code'); 
						if ($show == 2 ||  $show == 4) { ?>
							<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">
								<img src="<?php echo $image_tv['url']; ?>" class="d-block w-100" alt="...">
								<div class="carousel-caption d-none d-md-block">
									<h5><?php the_title(); ?></h5>
									<p><?php echo $release; ?></p>
									<div class="tvQRCode">
										<div class="tvQRCodeText">Posicione seu celular na imagem para escanear o QRCode e leia a matéria completa</div>
										<?php echo $qr_code; ?>
									</div>
								</div>
							</div>
							<?php $i++; 
						} 
					endwhile;
					?>
				</div>
			</div>
		</div>
		<div class="col-3" id="tvNews">
			<div id="tvNewsNext">
				<h2 class="">Mais Recentes</h2>
				<?php 
				$posts = new WP_Query([
					'post_type' => 'post',
					'posts_per_page' => '6'
				]);
				while($posts->have_posts()) : $posts->the_post();
					$show = get_field('show'); 
					if ($show == 2 ||  $show == 4) { ?>
						<article class="tvNewsLoop">
							<b><?php the_title(); ?></b> <br>
							<small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></small>
						</article>
						<?php
					} 
				endwhile;
				?>
			</div>
			<div id="tvNewsEquipe">
				<b>Equipe de Divulgação Interna</b> <br>
				Subsecretaria de Assuntos Administrativos (SAA/SE/MS)<br>
				Secretaria-Executiva - Ministério da Saúde
			</div>
		</div>
		<footer id="tvFooter">
			<div class="row">
				<div class="col-md-4" id="tvFooterHora">00h00</div>
				<div class="col-md-8 text-right" id="tvFooterEmail">Envie a sua notícia ou comentários - <b>saacomunica@saude.gov.br</b></div>
			</div>
		</footer>
	</div>
</div>
<?php wp_footer(); ?>