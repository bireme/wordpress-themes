<!-- Banners -->
<div id="banners" class="carousel slide" data-ride="carousel">
	<div class="carousel-inner">
		<?php 
	$banners = new WP_Query(array(
		'post_type' => 'banners',
	));
	$i = 0;
	while($banners->have_posts()) : $banners->the_post();
		$itens = get_field('cadastrar_banners');
		while( have_rows('cadastrar_banners') ): the_row(); 
			$fotoMobile = get_sub_field('foto_mobile'); 
			$fotoDesktop = get_sub_field('foto_desktop'); 
			$texto = get_sub_field('texto'); 
			$link = get_sub_field('link');
			?>
			<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?> ">
				<img src="<?php echo $fotoDesktop['url']; ?>"  class="d-none d-md-block"  alt="<?php echo $fotoDesktop['alt'] ?>" />
				<img src="<?php echo $fotoMobile['url']; ?>"  class="d-sm-block d-md-none"  alt="<?php echo $fotoMobile['alt'] ?>" />
				<div class="carousel-caption text-left">
					<h5><?php echo $texto; ?></h5>
					<div class="clearfix"></div>
					<a href="<?php echo $link; ?>" class="btn btn-info"><?php echo pll_e('Saiba Mais'); ?> [+]</a>
				</div>
			</div>
			<?php $i++; endwhile;
		endwhile;
		?>
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