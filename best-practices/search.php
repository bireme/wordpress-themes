<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>

	<?php
		$posts = new WP_Query([
			'post_type' => 'post',
			's' => $_GET['s'],
			'posts_per_page' => '-1'
		]);
		if($posts->have_posts()): while ($posts->have_posts()) : $posts->the_post(); ?>
			<article class="">
				<a href="<?php permalink_link(); ?>">
					<b><?php the_title(); ?></b> <br>
					<small><?php the_excerpt(); ?></small>
					<hr>
				</a>
			</article>
		<?php endwhile; else: endif;?>



		<section class="padding1">
		<div class="container" id="main_container">
			<h3 class="title1">Resultados encontrados: <?php echo esc_html(get_query_var('s')); ?></h3>
			<div class="row">
				<div class="col-md-9">
					<?php for ($i=0; $i < 9; $i++) { ?>
						<article>
							<div class="destaqueBP">
								<a href="boaPratica.php">
									<b>Lorem ipsum dolor sit amet.</b>
								</a>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia ea tempora, illum aliquam dolores nostrum doloremque inventore quo, ipsa delectus iste temporibus minus, earum labore odio natus, blanditiis sed tempore.</p>

								<b>ODS 3:</b> 

								<a href="ods.php" class="aSpan a3" data-toggle="tooltip" data-placement="top" title="Reducir muertes prevenibles en recién nacidos y niños menores de cinco años.">3.2</a>
								<a href="ods.php" class="aSpan a3" data-toggle="tooltip" data-placement="top" title="Detener la transmisión de enfermedades transmisibles como el SIDA, malaria, TB y enfermedades desatendidas.">3.3</a>
								<a href="ods.php" class="aSpan a3" data-toggle="tooltip" data-placement="top" title="Prevención y tratamiento del consumo de sustancias psicoactivas.">3.5</a>
								<a href="ods.php" class="aSpan a3" data-toggle="tooltip" data-placement="top" title="Reducir muertes y trauma causado por accidentes de tránsito.">3.6</a>
								<a href="ods.php" class="aSpan a3" data-toggle="tooltip" data-placement="top" title="educir la cantidad de muertes producidas por químicos peligrosos y la contaminación del aire, agua y suelo.">3.9</a>

							</div>
						</article>
					<?php } ?>

					<nav aria-label="Navegação de página exemplo">
						<ul class="pagination justify-content-center">
							<li class="page-item disabled">
								<a class="page-link" href="#" tabindex="-1">Anterior</a>
							</li>
							<li class="page-item"><a class="page-link" href="#">1</a></li>
							<li class="page-item"><a class="page-link" href="#">2</a></li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item">
								<a class="page-link" href="#">Próximo</a>
							</li>
						</ul>
					</nav>

				</div>
				<div class="col-md-3" style="background-color: #f8f9fa; padding: 20px 10px;">
					<h4>Filtrar</h4>
					<hr>
					
					<div class="boxFiltros">
						<b>Metas</b><br>
						<a href="ods.php" class="aSpan a3" data-toggle="tooltip" data-placement="top"  title="Reducir muertes prevenibles en recién nacidos y niños menores de cinco años.">3.2</a>
						<a href="ods.php" class="aSpan a3" data-toggle="tooltip" data-placement="top" title="Detener la transmisión de enfermedades transmisibles como el SIDA, malaria, TB y enfermedades desatendidas.">3.3</a>
						<a href="ods.php" class="aSpan a3" data-toggle="tooltip" data-placement="top" title="Prevención y tratamiento del consumo de sustancias psicoactivas.">3.5</a>
						<a href="ods.php" class="aSpan a3" data-toggle="tooltip" data-placement="top" title="Reducir muertes y trauma causado por accidentes de tránsito.">3.6</a>
						<a href="ods.php" class="aSpan a3" data-toggle="tooltip" data-placement="top" title="educir la cantidad de muertes producidas por químicos peligrosos y la contaminación del aire, agua y suelo.">3.9</a>
					</div>

					<div class="boxFiltros">
						<b>Páises</b><br>
						<a href="" data-toggle="tooltip" data-placement="top" title="Argentina"><img src="img/argentina.svg" alt="" style="width: 30px;"></a>
						<a href="" data-toggle="tooltip" data-placement="top" title="Bolivia"><img src="img/bolivia.svg" alt="" style="width: 30px;"></a>
						<a href="" data-toggle="tooltip" data-placement="top" title="Brasil"><img src="img/brasil.svg" alt="" style="width: 30px;"></a>
						<a href="" data-toggle="tooltip" data-placement="top" title="Canada"><img src="img/canada.svg" alt="" style="width: 30px;"></a>
						<a href="" data-toggle="tooltip" data-placement="top" title="Chile"><img src="img/chile.svg" alt="" style="width: 30px;"></a>
						<a href="" data-toggle="tooltip" data-placement="top" title="Colombia"><img src="img/colombia.svg" alt="" style="width: 30px;"></a>
						<a href="" data-toggle="tooltip" data-placement="top" title="Cuba"><img src="img/cuba.svg" alt="" style="width: 30px;"></a>
						<a href="" data-toggle="tooltip" data-placement="top" title="Mexico"><img src="img/mexico.svg" alt="" style="width: 30px;"></a>
						<a href="" data-toggle="tooltip" data-placement="top" title="Panama"><img src="img/panama.svg" alt="" style="width: 30px;"></a>
						<a href="" data-toggle="tooltip" data-placement="top" title="paraguai"><img src="img/paraguai.svg" alt="" style="width: 30px;"></a>
						<a href="" data-toggle="tooltip" data-placement="top" title="Uruguai"><img src="img/uruguai.svg" alt="" style="width: 30px;"></a>
					</div>

					<div class="boxFiltros">
						<b>Data</b><br>
						<!-- https://www.zabuto.com/dev/calendar/examples/show_data.html -->
						<div id="my-calendar"></div>
					</div>
				</div>
			</div>
		</div>
	</section>



<?php get_footer(); ?>