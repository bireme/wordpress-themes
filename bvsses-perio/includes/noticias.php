<section class="padding1 color2">
	<div class="container">
		<h2 class="title1"><?php pll_e('Notícias'); ?></h2>
		<div class="slideNews">
			<?php 
			$atual = get_the_title();
			$posts = new WP_Query([
				'post_type' => 'post',
				'posts_per_page' => '12'
			]);
			while($posts->have_posts()) : $posts->the_post();?>
				<article class="slideNewsBox">
					<a href="<?php permalink_link(); ?>">
						<?php
						if ( has_post_thumbnail()) {
							the_post_thumbnail('medium_large',['class' => 'img-fluid rounded']);
						}else{ ?>
							<img src="<?php bloginfo('template_directory')?>/img/indisponivel.jpg" class="img-fluid rounded" alt="">
						<?php }	 ?>
						<br>		
						<div class="slideNewsDate"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></div>
						<h4><?php the_title(); ?></h4>
						<?php the_excerpt(); ?>
					</a>
				</article>
				<?php
			endwhile;
			?>
			
		</div>
		<p class="text-center">
			<a href="noticias" class="btn btn-outline-success"><?php pll_e('Ver todas'); ?></a>
		</p>
	</div>
</section>