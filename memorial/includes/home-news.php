<section id="home-news" class="pt-5 pb-5">
	<div class="container">
		<h2 class="title mb-4">Destaque e Notícias</h2>
		<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
			<?php 
			$posts = new WP_Query([
				'post_type' => 'post',
				'posts_per_page' => '4'
			]);
			while($posts->have_posts()) : $posts->the_post();?>
				<article class="col">
					<div class="card h-100">
						<a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
							<?php 
							if (has_post_thumbnail()) {
								the_post_thumbnail('medium', ['class' => 'card-img-top card-img-fixed']);
							} else { ?>
								<img src="<?php bloginfo('template_directory')?>/img/blog-default.jpg" class="card-img-top" alt="">
							<?php } ?>
							<div class="card-body">
								<h5 class="card-title"><?php the_title(); ?></h5>
								<p class="card-text"><?php the_excerpt(); ?></p>
							</div>
						</a>
					</div>
				</article>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</section>