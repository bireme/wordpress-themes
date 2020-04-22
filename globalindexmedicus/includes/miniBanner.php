<section id="miniBanner" class="padding1">
	<div class="container">
		<h2 class="titulo1"><?php pll_e('Title Mini Banners'); ?></h2>
		<div class="line"></div>
		<div class="sliderMiniBanner">
			<?php 
			$MiniBanners = new WP_Query(array(
				'post_type' => 'MiniBanners',
			));
			while($MiniBanners->have_posts()) : $MiniBanners->the_post();
				$itens = get_field('group');
				while( have_rows('group') ): the_row(); 
					$picture = get_sub_field('picture'); 
					$release = get_sub_field('release'); 
					$link = get_sub_field('link');
					$window = get_sub_field('window');
					?>
					<div class="col-12 boxParceiros" data-aos="fade-up">
						<a href="<?php echo $link; ?>"  target="<?php echo $window; ?>">
							<img src="<?php echo $picture['url']; ?>" alt="" class="img-fluid imgBlack">
							<h5 style="margin-top: 20px;"><?php echo $release; ?></h5>
						</a>
					</div>
					<?php
					$i++; endwhile;
				endwhile;
				?>
			</div>
		</div>	
	</section>