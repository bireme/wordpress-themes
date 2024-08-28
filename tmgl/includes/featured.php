<?php
if (function_exists('have_rows')) {
	if (have_rows('events')) : 
		while (have_rows('events')) : the_row(); 
			$events_title = get_sub_field('title');
			$events_subtitle = get_sub_field('subtitle');
		endwhile;
	endif;
}
?>

<h2 class="title1 mb-5">
	<img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt="">
	Featured Stories
</h2>
<div class="container-featured mb-5">
	<!-- start 1 card -->
	<?php
	$args = array(
		'post_type' => 'featured_stories',
		'posts_per_page' => 1,
	);
	$featured_stories_query = new WP_Query($args);
	if ($featured_stories_query->have_posts()) : 
		while ($featured_stories_query->have_posts()) : $featured_stories_query->the_post();
			$featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
			?>
			<article class="card maior card-featured featured1" style="background-image: linear-gradient(to right, rgba(0, 0, 0, .8), rgba(0, 0, 0, 0)), url(<?php echo esc_url($featured_image_url); ?>);">
				<div class="box-card-maior">
					<h2 class="title"><?php the_title(); ?></h2>
					<p><?php the_excerpt(); ?></p>
					<a href="<?php the_permalink(); ?>" class="btn btn-primary mb-3">Read full story</a>
				</div>
			</article>
		<?php endwhile;
		wp_reset_postdata();
	else : 
		echo '<p>Featured Stories not found</p>';
	endif;
	?>

	<!-- //start 2 and 3 card -->
	<div class="card-container">
		<?php
		$total_posts = wp_count_posts('featured_stories')->publish;
		$offset = $total_posts - 2;
		$args = array(
			'post_type' => 'featured_stories',
			'posts_per_page' => 2,
			'offset' => $offset,
		);
		$featured_stories_query = new WP_Query($args);
		if ($featured_stories_query->have_posts()) : 
			while ($featured_stories_query->have_posts()) : $featured_stories_query->the_post();
				$featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
				?>
				<article class="card card-featured featured2" style="background-image: linear-gradient(to right, rgba(0, 0, 0, .8), rgba(0, 0, 0, 0)), url(<?php echo esc_url($featured_image_url); ?>);" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h3 class="title"><?php the_title(); ?></h3>
					<div class="mt-3"><a href="<?php the_permalink(); ?>" class="btn btn-primary mb-3">Read full story</a></div>
				</article>
			<?php endwhile;
			wp_reset_postdata();
		else : 
			echo '<p>Featured Stories not found</p>';
		endif;
		?>
	</div>
</div>