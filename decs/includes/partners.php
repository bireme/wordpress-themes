<section id="parceiros">
	<div class="container">
		<h4><?php pll_e('Partners'); ?></h4>
		<div id="linha"></div>

		<div class="sliderParceiros">
			<?php 
			$Partners = new WP_Query(array(
				'post_type' => 'Partners',
			));
			while($Partners->have_posts()) : $Partners->the_post();
				$itens = get_field('group');
				while( have_rows('group') ): the_row(); 
					$picture = get_sub_field('picture'); 
					$link = get_sub_field('link');
					$window = get_sub_field('window');
				?>
					<div class="col-12 boxParceiros">
						<a href="<?php echo $link; ?>"><img src="<?php echo $picture['url']; ?>" alt="" class="img-fluid"></a>
					</div>
				<?php
				$i++; endwhile;
			endwhile;?>
		</div>
	</div>	
</section>