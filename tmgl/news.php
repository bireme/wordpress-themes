<?php /* Template Name: News */ ?>
<?php get_header(); ?>
<main id="main_container" class="pt-3 pb-5">
	<div class="container">
		<?php get_template_part('includes/breadcrumb') ?>
		<h1 class="title1"><img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt=""> <?php the_title(); ?></h1>
		<?php the_content(); ?>
		<div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 g-4 mt-3">
			<?php 
			$posts = new WP_Query(['post_type' => 'post','posts_per_page' => '-1']);
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
	</div>
</main>
<?php get_footer(); ?>