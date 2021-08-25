<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>

<?php
/*
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
<?php endwhile; else: endif;
*/
?>



<section class="padding1">
	<div class="container" id="main_container">
		<h3 class="title1">Results found:: <?php echo esc_html(get_query_var('s')); ?></h3>
		<div class="row">
			<div class="col-md-9">
				<?php for ($i=0; $i < 9; $i++) { ?>
					<article>
						<div class="destaqueBP">
							<a href="boaPratica.php">
								<b>Lorem ipsum dolor sit amet.</b>
							</a>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia ea tempora, illum aliquam dolores nostrum doloremque inventore quo, ipsa delectus iste temporibus minus, earum labore odio natus, blanditiis sed tempore.</p>
							<b>Objetivos:</b> 
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 3 - Target 3.1</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 3 - Target 3.2</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 3 - Target 3.3</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 3 - Target 3.4</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 3 - Target 3.5</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 3 - Target 3.6</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 3 - Target 3.7</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 3 - Target 3.8</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 1</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 2</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 4</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 5</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 6</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 7</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 8</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 9</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 10</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 11</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 12</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 13</a>
							<a href="#" class="aSpan" data-toggle="tooltip" data-placement="top" title="Descrição">Goal 14</a>
						</div>
					</article>
				<?php } ?>

				<nav aria-label="Navegação de página exemplo">
					<ul class="pagination justify-content-center">
						<li class="page-item disabled">
							<a class="page-link" href="#" tabindex="-1">Prev</a>
						</li>
						<li class="page-item"><a class="page-link" href="#">1</a></li>
						<li class="page-item"><a class="page-link" href="#">2</a></li>
						<li class="page-item"><a class="page-link" href="#">3</a></li>
						<li class="page-item">
							<a class="page-link" href="#">Next</a>
						</li>
					</ul>
				</nav>

			</div>
			<div class="col-md-3" style="background-color: #f8f9fa; padding: 20px 10px;">
				<h4>Filtrar</h4>
				<hr>

				<div class="boxFiltros">
					<b>Objetivo</b><br>
					<label for="1" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="1"> Goal 3 - Target 3.1
					</label>
					<label for="2" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="2"> Goal 3 - Target 3.1
					</label>
					<label for="3" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="3"> Goal 3 - Target 3.2
					</label>
					<label for="4" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="4"> Goal 3 - Target 3.3
					</label>
					<label for="5" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="5"> Goal 3 - Target 3.4
					</label>
					<label for="6" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="6"> Goal 3 - Target 3.5
					</label>
					<label for="7" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="7"> Goal 3 - Target 3.6
					</label>
					<label for="8" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="8"> Goal 3 - Target 3.7
					</label>
					<label for="9" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="9"> Goal 3 - Target 3.8
					</label>
					<label for="10" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="10"> Goal 1
					</label>
					<label for="11" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="11"> Goal 2
					</label>
					<label for="12" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="12"> Goal 4
					</label>
					<label for="13" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="13"> Goal 5
					</label>
					<label for="14" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="14"> Goal 6
					</label>
					<label for="15" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="15"> Goal 7
					</label>
					<label for="16" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="16"> Goal 8
					</label>
					<label for="17" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="17"> Goal 9
					</label>
					<label for="18" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="18"> Goal 10
					</label>
					<label for="19" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="19"> Goal 11
					</label>
					<label for="20" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="20"> Goal 12
					</label>
					<label for="21" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="21"> Goal 13
					</label>
					<label for="22" class="aSpan">
						<input type="checkbox" class="form-check-input goalCheck" id="22"> Goal 14
					</label>
				</div>

				<div class="boxFiltros flagsFiltros">
					<b>Páises</b><br>
					<label for="f1">
						<input type="checkbox" class="form-check-input goalCheck" id="f1">
						<img src="<?php bloginfo('template_directory'); ?>/img/argentina.svg" title="Argentina" alt="">
					</label>

					<label for="f2">
						<input type="checkbox" class="form-check-input goalCheck" id="f2">
						<img src="<?php bloginfo('template_directory'); ?>/img/bolivia.svg" title="Bolivia" alt="" >
					</label>
					<label for="f3">
						<input type="checkbox" class="form-check-input goalCheck" id="f3">
						<img src="<?php bloginfo('template_directory'); ?>/img/brasil.svg" title="Brasil" alt="">
					</label>
					<label for="f4">
						<input type="checkbox" class="form-check-input goalCheck" id="f4">
						<img src="<?php bloginfo('template_directory'); ?>/img/canada.svg" title="Canada" alt="">
					</label>
					<label for="f5">
						<input type="checkbox" class="form-check-input goalCheck" id="f5">
						<img src="<?php bloginfo('template_directory'); ?>/img/chile.svg" title="Chile" alt="">
					</label>
					<label for="f6">
						<input type="checkbox" class="form-check-input goalCheck" id="f6">
						<img src="<?php bloginfo('template_directory'); ?>/img/colombia.svg" title="Colombia" alt="">
					</label>
					<label for="f7">
						<input type="checkbox" class="form-check-input goalCheck" id="f7">
						<img src="<?php bloginfo('template_directory'); ?>/img/cuba.svg" title="Cuba" alt="">
					</label>
					<label for="f8">
						<input type="checkbox" class="form-check-input goalCheck" id="f8">
						<img src="<?php bloginfo('template_directory'); ?>/img/mexico.svg" title="Mexico" alt="">
					</label>
					<label for="f9">
						<input type="checkbox" class="form-check-input goalCheck" id="f9">
						<img src="<?php bloginfo('template_directory'); ?>/img/panama.svg" title="Panama" alt="">
					</label>
					<label for="f10">
						<input type="checkbox" class="form-check-input goalCheck" id="f10">
						<img src="<?php bloginfo('template_directory'); ?>/img/paraguai.svg" title="paraguai" alt="">
					</label>
					<label for="f11">
						<input type="checkbox" class="form-check-input goalCheck" id="f11">
						<img src="<?php bloginfo('template_directory'); ?>/img/uruguai.svg" title="Uruguai" alt="">
					</label>
				</div>

				<div class="boxFiltros">
					<b>Data</b><br>
					de: <input type="date" class="form-control form-control-sm">
					até: <input type="date" class="form-control form-control-sm">
				</div>
			</div>
		</div>
	</div>
</section>



<?php get_footer(); ?>