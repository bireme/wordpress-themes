<!-- Banners -->
<div id="banners" class="carousel slide" data-ride="carousel">
	<div class="carousel-inner">
		<?php 
		$banners = new WP_Query(array(
			'post_type' => 'banners',
				// 'orderby' => 'title',
				// 'order'   => 'ASC'
		));
			$i = 0;
		while($banners->have_posts()) : $banners->the_post();
			$itens  = get_field('banners');
			while( have_rows('banners') ): the_row(); 
				// vars
				$imagem = get_sub_field('imagem');
				$texto = get_sub_field('texto');
				$link = get_sub_field('link');
				
				?>
				<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?> ">
					<img src="<?php echo $imagem['url']; ?>" alt="<?php echo $imagem['alt'] ?>" />
					<div class="carousel-caption d-none d-md-block text-left">
						<h5><?php echo $texto; ?></h5>
						<div class="clearfix"></div>
						<a href="<?php echo $link; ?>"  class="bannerLink" >link <?php echo $i; ?></a>
					</div>
				</div>
			<?php $i++;  endwhile ;  
		endwhile; ?>
	</div>
	<a class="carousel-control-prev" href="#banners" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#banners" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>







