<section class="padding1 color2">
	<div class="container">
		<h2 class="title1">Outroas Notícias</h2>
		<div class="slideNews">
			<?php 
			$atual = get_the_title();
			$posts = new WP_Query([
				'post_type' => 'post',
				'posts_per_page' => '12'
			]);
			while($posts->have_posts()) : $posts->the_post();
				if(get_the_title()==$atual){continue;}?>
				<article class="slideNewsBox">
					<a href="<?php permalink_link(); ?>">
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
			<a href="noticias" class="btn btn-outline-success">Ver todas</a>
		</p>
	</div>
</section>