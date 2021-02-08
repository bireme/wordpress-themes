<section class="text-center container">
	<div id="carouselExampleControls" class="carousel slide carousel-fade" data-ride="carousel" style=" margin-bottom: 30px; z-index: 0">
		<div class="carousel-inner">
			<div class="carousel-inner">
				<?php 
				$Banners = new WP_Query(array(
					'post_type' => 'Banners',
				));
				$i = 0;
				while($Banners->have_posts()) : $Banners->the_post();
					$itens = get_field('group');
					while( have_rows('group') ): the_row(); 
						$desktop_picture = get_sub_field('desktop_picture'); 
						$mobile_picture = get_sub_field('mobile_picture'); 
						$link = get_sub_field('link');
						$window = get_sub_field('window');
						?>
						<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?> ">
							<a href="<?php echo $link; ?>">
								<img src="<?php echo $desktop_picture['url']; ?>" class="img-fluid d-none d-sm-block" alt="...">
							</a>
							<a href="<?php echo $link; ?>">
								<img src="<?php echo $mobile_picture['url']; ?>" class="img-fluid d-block d-sm-none" alt="...">
							</a>
						</div>
						<?php
						$i++;
					endwhile;
				endwhile;?>
			</div>
		</div>
		<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</section>