<section class="padding1" style="background: #43d4e6;">
	<div class="container">
		<div id="carouselExampleControls" class="carousel slide carousel-fade" data-ride="carousel">
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
			<!-- <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a> -->
		</div>
	</div>
</section>

<!-- Modal lancameto-->
<!--?php $idioma = pll_current_language(); ?>
<div class="modal fade" id="lancamento" tabindex="-1" role="dialog" aria-labelledby="lancamento" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				
				<img src="<?php bloginfo( 'template_directory' ) ?>/img/lancamentoH-<?php echo $idioma; ?>.jpg" alt="" class="img-fluid d-none d-md-block">
				<img src="<?php bloginfo( 'template_directory' ) ?>/img/lancamento-<?php echo $idioma; ?>.jpg" alt="" class="img-fluid d-sm-block d-md-none">
				
			</div>
			<div class="modal-footer">
				<a href="https://bit.ly/e-blueinfo2" class="btn btn-lg btn-primary" target="_blank"><?php pll_e('Get involved'); ?> </a>
			</div>
		</div>
	</div>
</div-->