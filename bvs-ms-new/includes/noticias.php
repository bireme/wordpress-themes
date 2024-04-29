<section class="padding1">
	<div class="container">
		<h2 class="title2">Notícias</h2>
		<div class="slideNews">
			<?php 
			$atual = get_the_title();
			$posts = new WP_Query([
				'post_type' => 'post',
				'category_name'  => 'ultimas-noticias',
				'posts_per_page' => '12'
			]);
			while($posts->have_posts()) : $posts->the_post();?>
				<article class="slideNewsBox">
					<a href="<?php permalink_link(); ?>">
						<!-- <img src="<?php bloginfo('template_directory') ?>/img/news1.jpg" alt="" class="img-fluid"> -->
						<h4><?php the_title(); ?></h4>
						<div class="slideNewsDate"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></div>
					</a>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<p class="text-center">
			<a href="<?php echo get_option('siteurl'); ?>/noticias" class="btn btn-success">Ver todas</a>
		</p>
	</div>
</section>