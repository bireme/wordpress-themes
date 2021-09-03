<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<?php get_template_part('includes/banners') ?>
<section class="padding2 color1">
	<div class="container">
		<p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas facere id tenetur numquam cumque unde amet ab accusantium libero architecto accusamus exercitationem magnam similique reprehenderit, nesciunt voluptate itaque? Expedita, animi.</p>
		<a href="https://bestpractices.teste.bvsalud.org/login" class="alert-link"  target="_blank">Haga clic aquí y registre su buena práctica</a>.
	</div>
</section>
<section class="padding1">
	<div class="container">
		<h3 class="title1">Latest registered good practices</h3>
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

		<br>
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
</section>
<?php get_footer(); ?> 