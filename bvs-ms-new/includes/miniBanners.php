<section class="padding2" id="sectionInteresse">
		<div class="container">
			<div class="interesse">
				<?php 
			$MiniBanners = new WP_Query(array(
				'post_type' => 'MiniBanners',
			));
			while($MiniBanners->have_posts()) : $MiniBanners->the_post();
				$itens = get_field('group');
				while( have_rows('group') ): the_row(); 
					$foto = get_sub_field('foto'); 
					$link = get_sub_field('link');
					$abrir = get_sub_field('abrir');
					?>
				<div class="slideNewsBox">
					<a href="<?php echo $link; ?>" target="<?php echo $abrir; ?>">
						<img src="<?php echo $foto['url']; ?>" alt="" class="img-fluid">
					</a>
				</div>	
				<?php
					$i++; endwhile;
				endwhile;
				?>
			</div>
		</div>
	</section>
