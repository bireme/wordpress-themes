<section id="news">
	<div class="container">
		<h2 class="title1 mb-5">
			<img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt="">
			<?php _e( 'News', 'tmgl' ); ?>
		</h2>
		<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
			<?php 
			$posts = new WP_Query(['post_type' => 'post','posts_per_page' => '4']);
			$url_news = get_field('url_news');
			while($posts->have_posts()) : $posts->the_post(); ?>

				<div class="col">
					<div class="card h-100 news-card">
						<?php the_post_thumbnail('news', ['class' => 'card-img-top', 'alt' => get_the_title()]); ?>
						<div class="card-body">
							<small><?php echo get_the_date('d F Y'); ?></small>
							<h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
						</div>
						<div class="card-footer">
							<div class="news-footer">	
								<?php
								$categories = get_the_category();
								if (!empty($categories)) {
									$category_link = esc_url(get_category_link($categories[0]->term_id));
									$category_name = esc_html($categories[0]->name);
									echo '<a href="' . $category_link . '" class="badge text-bg-danger mt-3">' . $category_name . '</a>';
								}
								?>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<p class="mt-4"><?php _e( 'Explore archived news', 'tmgl' ); ?> <a href="<?= $url_news;?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></p>
	</div>
</section>