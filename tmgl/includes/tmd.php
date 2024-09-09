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
		<source src="<?php bloginfo('template_directory'); ?>/video/bg.mp4" type="video/mp4"></video>
		<div class="content text-center">
			<div class="container">
				<h2 class="title1"><?= esc_html($tmd_title);?></h2>
				<p><?= esc_html($tmd_subtitle);?></p>
			</div>
			<div class="container mt-5">
				<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">

					<?php
					$args = array(
						'post_type' => 'dimensions',
						'posts_per_page' => -1,
						'post_parent' => 0,
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