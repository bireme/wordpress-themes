<section>
	<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<?php 
			$banners = new WP_Query([
				'post_type' => 'banners',
			]);
			$i = 0;
			while($banners->have_posts()) : $banners->the_post();
				$itens = get_field('banners');
				while( have_rows('banners') ): the_row(); 
					$image_mobile = get_sub_field('image_mobile'); 
					$image_desktop = get_sub_field('image_desktop'); 
					$title = get_sub_field('title'); 
					$text = get_sub_field('text'); 
					$link = get_sub_field('link');
					$window = get_sub_field('window');
					?>
					<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">
						<a href="<?php echo $link; ?>" target="<?php echo $window; ?>">
							<img src="<?php echo esc_url($image_desktop['sizes']['bannerDesktop']); ?>" class="w-100 d-none d-sm-block" alt="<?php echo $image_desktop['alt'] ?>">
							<img src="<?php echo esc_url($image_mobile['sizes']['bannerMobile']); ?>" class="w-100 d-block d-sm-none" alt=" mobilie<?php echo $image_desktop['alt'] ?>">
							<div class="carousel-caption  <?php echo ($title == "") ? 'd-none' : ''; ?>">
								<h5><?php echo $title; ?></h5>
								<p><?php echo $text; ?></p>
							</div>
						</a>
					</div>
					<?php
					$i++;
				endwhile;
			endwhile; 
			?>
		</div>
		<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</section>