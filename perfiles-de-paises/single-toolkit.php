<?php get_header(); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h1 class=" title1"><?php the_title(); ?></h1><br> 
		<div class="row">
			<div class="col-md-9">
				<?php the_content(); ?>
			</div>
			<div class="col-md-3">
				<div class="card bg-light" style="position:sticky; top: 0;">
					<div class="card-body">
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat nemo mollitia error facere est, esse accusamus numquam. Quae ratione amet, assumenda culpa quam vel nam nobis asperiores molestias quo corrupti.
					</div>
					<div class="card-footer">
						<a class="btn btn-primary" href="f1.php" role="button">Volver al kit de herramientas</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?> 