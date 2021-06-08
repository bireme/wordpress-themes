<section class="padding1">	
	<div class="container">
		<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
			<div class="carousel-inner">
				<?php 
				$banners = new WP_Query([
					'post_type' => 'banners',
				]);
				$i = 0;
				while($banners->have_posts()) : $banners->the_post();
					$itens = get_field('cadastrar_banners');
					while( have_rows('cadastrar_banners') ): the_row(); 
						$fotoMobile = get_sub_field('foto_mobile'); 
						$fotoDesktop = get_sub_field('foto_desktop'); 
						$texto = get_sub_field('texto'); 
						$link = get_sub_field('link');
						$abrir = get_sub_field('abrir');
						?>
						<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?> ">
							<a href="<?php echo $link; ?>" target="<?php echo $abrir; ?>">
								<img src="<?php echo esc_url($fotoDesktop['sizes']['banners']); ?>" class="img-fluid d-none d-sm-block"alt="<?php echo $fotoDesktop['alt'] ?>" />
								<img src="<?php echo esc_url($fotoMobile['sizes']['banners-mobile']); ?>" class="img-fluid d-block d-sm-none"alt="<?php echo $fotoMobile['alt'] ?>" />
								<div class="carousel-caption  <?php echo ($texto == "") ? 'd-none' : ''; ?>">
									<?php echo ($texto ==! "") ? '<h5><span>'.$texto.'</span></h5>': '' ; ?>
								</div>
							</a>
						</div>
						<?php
						$i++;
					endwhile;
				endwhile;	
				?>
			</div>
			<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</a>
		</div>
	</div>
</section>