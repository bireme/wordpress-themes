<section class="padding1 color1">
	<div class="container">
		<h2 class="title1 marginB1"><?php pll_e('Latest News'); ?></h2>
		<div class="slideNews">
			<?php 
			$atual = get_the_title();
			$posts = new WP_Query([
				'post_type' => 'post',
				'category_name'  => 'noticias-es, noticias-pt, noticias-en',
				'posts_per_page' => '12'
			]);
			while($posts->have_posts()) : $posts->the_post();?>
				<article class="slideNewsBox">
					<a href="<?php permalink_link(); ?>">
						<div class="text-center slideNewsBoxImg">
							<?php if ( has_post_thumbnail()) {
								the_post_thumbnail('thumbnail',['class' => 'img-fluid']);
							}else{ ?>
								<img src="<?php bloginfo( 'template_directory')?>/img/indisponivel.jpg" class="img-fluid" alt="">
							<?php }	 ?>
						</div>
						<div class="slideNewsDate"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></div>
						<h3><?php the_title(); ?></h3>
					</a>
				</article>
				<?php
			endwhile;
			?>
		</div>
	</div>
</section>