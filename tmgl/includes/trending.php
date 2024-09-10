<?php
if (function_exists('have_rows')) {
	if (have_rows('events')) : 
		while (have_rows('events')) : the_row(); 
			$events_title = get_sub_field('title');
			$events_subtitle = get_sub_field('subtitle');
		endwhile;
	endif;
	$text_trending_topics = get_field('text_trending_topics');
	$url_trending_topics = get_field('url_trending_topics');
}
?>

<h2 class="title1">
	<img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt="">
	<?php _e( 'Trending Topics', 'tmgl' ); ?>
</h2>
<div class="row mt-5 mb-5">
	<div class="col-md-3">
		<?= esc_html($text_trending_topics);?> 
	</div>
	<div class="col-md-9">
		<div class="trending-slider">
			<?php
			$args = array(
				'post_type' => 'trending_topics',
				'posts_per_page' => 6,
			);
			$trending_topics_query = new WP_Query($args);
			if ($trending_topics_query->have_posts()) : 
				while ($trending_topics_query->have_posts()) : $trending_topics_query->the_post(); ?>
					<article class="col" style="margin: 0 15px; padding-bottom: 20px;">
						<div class="card card-trend ">
							<div class="card-body">
								<h5 class="card-title"><?php the_title(); ?></h5>
								<p class="card-text"><?php the_excerpt(); ?></p>
							</div>
							<div class="card-footer text-end">
								<small class="text-body-secondary"><a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></small>
							</div>
						</div>
					</article>
				<?php endwhile;
				wp_reset_postdata();
			else : 
				echo '<p>Trending Topic not found.</p>';
			endif;
			?>
		</div>
	</div>
	<p class="mt-4"><?php _e( 'Explore all trending topics', 'tmgl' ); ?> <a href="<?= $url_trending_topics;?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></p>
</div>