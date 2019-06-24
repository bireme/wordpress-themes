<!-- Banners -->
<div id="banners" class="carousel slide d-none d-md-block" data-ride="carousel">
	<div class="carousel-inner">
		
		<?php $banners = new WP_Query([
            'posts_per_page' => 3,
            'post_type' => 'banners'
        ]); 
        $i=0;
        while($banners->have_posts()) : $banners->the_post()
        ?>
		<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">
			<?php the_post_thumbnail('slide-home'); ?>
			<div class="carousel-caption d-none d-md-block text-left">
				<h5><?php the_title(); ?></h5>
				<div class="clearfix"></div>
				<a href="" class="bannerLink">Saiba Mais [+]</a>
			</div>
		</div>
		<?php $i++; endwhile; ?>
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