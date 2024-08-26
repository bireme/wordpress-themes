<section id="news">
	<div class="container">
		<h2 class="title1 mb-5">
			<img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt="">
			News
		</h2>
		<div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 g-4">
			<?php 
			$posts = new WP_Query(['post_type' => 'post','posts_per_page' => '2']);
			while($posts->have_posts()) : $posts->the_post(); ?>
				<div class="col">
					<div class="card h-100 news-card">
						<?php the_post_thumbnail('full', ['class' => 'card-img-top', 'alt' => get_the_title()]); ?>
						<div class="card-body">
							<small><?php echo get_the_date('d F Y'); ?></small>
							<h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
						</div>
						<div class="card-footer">
							<div class="news-footer">	
								<?php
								$categories = get_the_category();
								if (!empty($categories)) {
									echo '<span class="badge text-bg-danger mt-3">' . esc_html($categories[0]->name) . '</span>';
								}
								?>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<p class="mt-4">Explore archived news <a href="#" class="btn btn-primary btn-sm"><img src="<?php bloginfo('template_directory'); ?>/img/arrow-right.svg" alt=""></a></p>
	</div>
</section>