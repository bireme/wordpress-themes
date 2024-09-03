<?php /* Template Name: Dimensions */ ?>
<?php get_header(); ?>
<main id="main_container" class="pt-3 pb-5">
	<div class="container">
		<?php get_template_part('includes/breadcrumb') ?>
		<h1 class="title1"><img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt=""> <?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>
	<div class="container" id="tmd-section-in">
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
</main>
<?php get_footer(); ?>