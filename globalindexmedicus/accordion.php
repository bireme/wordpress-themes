<?php
	/*
		template name: Accordion
	*/
?>
<?php get_header(); ?>
<section class="padding1">
	<div class="container">
		<h2 class="titulo1"><?php the_title(); ?></h2>
		<div class="accordion" id="accordionExample">
			<?php $itens  = get_field('accordion');
			foreach ($itens as $key => $item) { ?>
				<div class="card">
					<div class="card-header" id="headingOne">
						<h2 class="mb-0">
							<span class="acordionIcone float-right fas fa-minus"></span>
							<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#item-<?= $key ?>" aria-expanded="true" aria-controls="item-<?= $key ?>">
								<b><?= $item['titulo'] ?></b>
							</button>
						</h2>
					</div>

					<div id="item-<?= $key ?>" class="collapse <?php echo ($key == 0 ? "show": "" ); ?>"  aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<?= $item["texto"] ?>
						</div>
					</div>
				</div>
			<?php } ?>	
		</div>
	</div>
</section>
<?php get_footer(); ?>