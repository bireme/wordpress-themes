<div class="col-md-12">
	<div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
		</ol>
		<div class="carousel-inner">
			<?php 
			$banners = new WP_Query([
				'post_type' => 'banners',
			]);
			$i = 0;
			while($banners->have_posts()) : $banners->the_post();
				$image1 = get_field('image_1');
				$image2 = get_field('image_2');
				$image3 = get_field('image_3');
				$image4 = get_field('image_4');
				$image5 = get_field('image_5');
				?>
				<div class="carousel-item active">
					<img src="<?php echo $image1['url']; ?>" class="d-block w-100" alt="...">
				</div>
				<div class="carousel-item ">
					<img src="<?php echo $image2['url']; ?>" class="d-block w-100" alt="...">
				</div>
				<div class="carousel-item ">
					<img src="<?php echo $image3['url']; ?>" class="d-block w-100" alt="...">
				</div>
				<div class="carousel-item ">
					<img src="<?php echo $image4['url']; ?>" class="d-block w-100" alt="...">
				</div>
				<div class="carousel-item ">
					<img src="<?php echo $image5['url']; ?>" class="d-block w-100" alt="...">
				</div>
			</div>
			<?php $i++; endwhile; ?>
			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>