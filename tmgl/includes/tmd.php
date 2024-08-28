<?php
if (function_exists('have_rows')) {
	if (have_rows('tmd')) : 
		while (have_rows('tmd')) : the_row(); 
			$tmd_title = get_sub_field('title');
			$tmd_subtitle = get_sub_field('subtitle');
		endwhile;
	endif;
}
?>
<section class="tmd-section">
	<video autoplay muted loop class="background-video">
		<source src="https://s3-figma-videos-production-sig.figma.com/video/1302605490711481880/TEAM/c13f/40ea/-9667-4f82-a5ab-6cedb81e54e0?Expires=1725840000&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=a7pUgJ0kfSzoCWc8EnYa8kBgUrD6CV7isUKHs-Uj1zr-7VMFheJ1OIXEpFVT7BkT6FpHkEENmhlxYGZFzVvWENzNctixmSHBotgg7iObEqyEzjuy39KaPlo4w26hCVZ71jpAGO~4OqqnhIP7fzcm-8UB4uwhiZ46L7j1ooToTUVBJ5G2222NC7eceHWUKRjQMOrg0oSShQxnlLlEWX2tV9UN3IjZF8t3R--0dwYC96s0UuTNgSSWVd865iMD0oOYBhldt5w5tT0eNM~ocY906OpTGQmvILlsHku5RUHYM~apw-5jCb0-HrbJT~bXLBYkyDJEbFeHs2a0hJrdyL3mLA__" type="video/mp4">
		</video>
		<div class="content text-center">
			<div class="container">
				<h2 class="title1"><?= esc_html($tmd_title);?></h2>
				<p><?= esc_html($tmd_subtitle);?></p>
			</div>
			<div class="container mt-5">
				<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">

					<?php
					$total_posts = wp_count_posts('featured_stories')->publish;
					$offset = $total_posts - 2;
					$args = array(
						'post_type' => 'dimensions',
						'posts_per_page' => -1,
						'offset' => $offset,
					);
					$dimensions_query = new WP_Query($args);
					if ($dimensions_query->have_posts()) : 
						while ($dimensions_query->have_posts()) : $dimensions_query->the_post();
							$dimensions_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
							?>
							<article class="col tmd-loop">
								<a href="<?php the_permalink(); ?>">
								<div class="card h-100 tmd-card">
									<div class="card-body">
										<img src="<?php echo esc_url($dimensions_image_url); ?>" alt="">
										<h5 class="card-title"><?php the_title(); ?></h5>
									</div>
								</div>
								</a>
							</article>

						<?php endwhile;
						wp_reset_postdata();
					else : 
						echo '<p>Featured Stories not found</p>';
					endif;
					?>
				</div>
			</div>
		</div>
	</section>