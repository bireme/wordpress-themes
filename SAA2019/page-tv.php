<?php
/*	Template Name: TV*/
?>
<meta http-equiv="refresh" content="3600">
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
			<div id="tvCarousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="8000" data-touch="false" data-pause="false">
				<div class="carousel-inner">
					<?php 
					$i = 0;
					$posts = new WP_Query([
						'post_type' => 'post',
						'posts_per_page' => '-1'
					]);
					while($posts->have_posts()) : $posts->the_post();
						$image_tv = get_field('image_tv'); 
						$subtitulo = get_field('subtitulo'); 
						$mostrar = get_field('mostrar'); 
						$qr_code = get_field('qr_code'); 
						if ($mostrar == 2 ||  $mostrar == 4) { ?>
							<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">
								<img src="<?php echo $image_tv['url']; ?>" class="d-block w-100" alt="...">
								<div class="carousel-caption">
									<h5><?php the_title(); ?></h5>
									<p><?php echo $subtitulo; ?></p>
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
				<h2>Notícias</h2>
				<?php 
				$posts = new WP_Query([
					'post_type' => 'post',
					'posts_per_page' => '-1'
				]);
				$i = 0;
				while($posts->have_posts()) : $posts->the_post();
					$mostrar = get_field('mostrar'); 
					
					if ($mostrar == 2 ||  $mostrar == 4) { ?>
						<article class="tvNewsLoop <?php echo ($i == 0) ? 'active' : ''; ?>">
							<b><?php the_title(); ?></b> <br>
							<small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></small>
						</article>
					<?php $i++; 
						} 
					endwhile;
					?>
			</div>
			<div id="tvNewsEquipe">
				<b>Equipe de Divulgação Interna</b> <br>
				Subsecretaria de Assuntos Administrativos (SAA/SE/MS)<br>
				Secretaria-Executiva<br>
				Ministério da Saúde <br>
				<img src=" <?php bloginfo('template_directory');?>/img/logoBrTV.png" class="img-fluid" alt="">
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