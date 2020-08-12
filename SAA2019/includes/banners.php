<section class="text-center">
	<div id="banner" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<div class="carousel-inner">
				<?php 
				$i = 0;
				while(have_posts()) : the_post();
					$image_banner = get_field('image_banner'); 
					$subtitulo = get_field('subtitulo'); 
					$mostrar = get_field('mostrar'); 
					if ($mostrar == 3 ||  $mostrar == 4) {
						?>
						<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">

							<!-- <img src="<?php echo esc_url($image_banner['sizes']['tv']); ?>" class="img-fluid" alt="<?php echo $image_banner['alt']; ?>"> -->
							<img src="<?php echo $image_banner['url']; ?>" class="img-fluid d-none d-sm-block" alt="<?php echo $image_banner['alt']; ?>">
							<img src="<?php echo $image_banner['url']; ?>" class="img-fluid d-block d-sm-none" alt="<?php echo $image_banner['alt']; ?>">
							<div class="carousel-caption">
								<a href="<?php permalink_link(); ?>">
									<h5><?php the_title(); ?></h5>
									<p><?php echo $subtitulo; ?></p>
								</a>
							</div>
						</div>
						<?php $i++; 
					} 
				endwhile;
				?>
			</div>
		</div>
		<a class="carousel-control-prev" href="#banner" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#banner" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</section>