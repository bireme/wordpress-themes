<?php
	/*
		template name: Accordion
	*/
?>
<?php get_header(); ?>
<main class="padding1" id="main_container" role="main">
	<div class="container">
		<h2 class="titulo1"><?php the_title(); ?></h2>
		<?php while(have_posts()) : the_post();
			the_content();
		endwhile;
		?>
		<div class="clearfix"><?php echo do_shortcode('[DISPLAY_ULTIMATE_SOCIAL_ICONS]'); ?></div><br>
		<div class="accordion" id="accordionExample">
			<?php $itens  = get_field('accordion');
			$i = 1;
			foreach ($itens as $key => $item) { ?>
				<div class="card" data-aos="fade-up" data-aos-delay="<?php echo $i ?>00">
					<div class="card-header" id="headingOne">
						<h2 class="mb-0">
							<span class="acordionIcone float-right fas <?php echo ($key == 0 ? "fa-minus": "fa-plus" ); ?>"></span>
							<button class="btn btn-link" data-toggle="collapse" data-target="#item-<?= $key ?>" aria-expanded="true" aria-controls="item-<?= $key ?>">
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
				<?php 
				$i++;
			}
			?>		
		</div>
		<br>
	</div>
</main>
<?php get_footer(); ?>