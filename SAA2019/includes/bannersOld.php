<section class="text-center">
	<div id="banner" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<div class="carousel-inner">
				<?php 
				$Banners = new WP_Query(array(
					'post_type' => 'banner',
				));
				$i = 0;
				while($Banners->have_posts()) : $Banners->the_post();
					$itens = get_field('group');
					while( have_rows('group') ): the_row(); 
						$title = get_sub_field('title'); 
						$release = get_sub_field('release'); 
						$desktop_picture = get_sub_field('desktop_picture'); 
						$mobile_picture = get_sub_field('mobile_picture'); 
						$link = get_sub_field('link');
						$window = get_sub_field('window');
					?>

					<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">
						<img src="<?php echo $desktop_picture['url']; ?>" class="img-fluid d-none d-sm-block" alt="...">
						<img src="<?php echo $mobile_picture['url']; ?>" class="img-fluid d-block d-sm-none" alt="...">
						<div class="carousel-caption d-none d-md-block">
							<a href="<?php permalink_link(); ?>">
								<h5><?php echo $title; ?></h5>
								<p><?php echo $release; ?></p>
							</a>
						</div>
					</div>
					<?php $i++; endwhile;
				endwhile;?>
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