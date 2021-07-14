<section class="padding1 color1">
	<div class="container">
		<h2 class="title1 marginB1">Ultimas Noticias</h2>
		<div class="slideNews">
			<?php 
			$atual = get_the_title();
			$posts = new WP_Query([
				'post_type' => 'post',
				// 'category_name'  => 'ultimas-noticias',
				'posts_per_page' => '12'
			]);
			while($posts->have_posts()) : $posts->the_post();?>
			<article class="slideNewsBox">
				<a href="<?php permalink_link(); ?>">
					<div class="slideNewsDate"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></div>
					<h3><?php the_title(); ?></h3>
				</a>
			</article>
			<?php
			endwhile;
			?>
		</div>
		<p class="text-center">
			<a href="category/noticias-es/" class="btn btn-outline-success btn-sm">Ver todas las noticias</a>
		</p>
	</div>
</section>