<?php /* Template Name: Home */ ?>
<?php get_header(); ?>

<?php
if (function_exists('have_rows')) {
    // start loops
	if (have_rows('search')) : 
		while (have_rows('search')) : the_row(); 
            // Obtém os valores dos campos
			$search_title = get_sub_field('title');
			$search_subtitle = get_sub_field('subtitle');
		endwhile;
	endif;
	if (have_rows('events')) : 
		while (have_rows('events')) : the_row(); 
            // Obtém os valores dos campos
			$events_title = get_sub_field('title');
			$events_subtitle = get_sub_field('subtitle');
		endwhile;
	endif;
	$text_trending_topics = get_field('text_trending_topics');
	$shortcode_newsletter = get_field('shortcode_newsletter');
}
?>
<!-- Search -->
<section id="section-search">
	<div class="container">
		<div id="box-search">
			<div class="title"><?= esc_html($search_title);?></div>
			<p><?= esc_html($search_subtitle);?></p>
		</div>
		<form class="row" action="http://pesquisa.bvsalud.org/tmgl" method="get">
			<div class="col-7">
				<input type="text" class="form-control form-control-lg" id="search" placeholder="Articles, Evidence, Regulations and Policies, Thesis, Events, Multimedia, Digital resources..." name="q">
			</div>
			<div class="col-2">
				<button type="submit" class="btn btn-primary btn-lg mb-3">SEARCH </button>
			</div>
		</form>
		<div id="box-search-links">
			<a href="https://pesquisa.bvsalud.org/tmgl/advanced/?lang=en">How to search</a>
			<a href="https://pesquisa.bvsalud.org/tmgl/decs-locator/?lang=en">Advanced search</a>
		</div>
	</div>
</section>



<section class="tmg-section">
	<video autoplay muted loop class="background-video">
		<source src="https://s3-figma-videos-production-sig.figma.com/video/1302605490711481880/TEAM/c13f/40ea/-9667-4f82-a5ab-6cedb81e54e0?Expires=1725840000&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=a7pUgJ0kfSzoCWc8EnYa8kBgUrD6CV7isUKHs-Uj1zr-7VMFheJ1OIXEpFVT7BkT6FpHkEENmhlxYGZFzVvWENzNctixmSHBotgg7iObEqyEzjuy39KaPlo4w26hCVZ71jpAGO~4OqqnhIP7fzcm-8UB4uwhiZ46L7j1ooToTUVBJ5G2222NC7eceHWUKRjQMOrg0oSShQxnlLlEWX2tV9UN3IjZF8t3R--0dwYC96s0UuTNgSSWVd865iMD0oOYBhldt5w5tT0eNM~ocY906OpTGQmvILlsHku5RUHYM~apw-5jCb0-HrbJT~bXLBYkyDJEbFeHs2a0hJrdyL3mLA__" type="video/mp4">
		</video>
		<div class="content text-center">
			<div class="container">
				<h2 class="title1">Traditional Medicine Dimentions</h2>
				<p>Lorem ipsum dolor sit amet consectetur. Gravida eu augue ullamcorper duis. Id nec mollis proin nullam. At odio ornare.</p>
			</div>
			<div class="container mt-5">
				<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
					<div class="col">
						<div class="card h-100 tmd-card">
							<div class="card-body">
								<img src="<?php bloginfo('template_directory'); ?>/img/tmd-1.svg" alt="">
								<h5 class="card-title">Health & Well-being</h5>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100 tmd-card">
							<div class="card-body">
								<img src="<?php bloginfo('template_directory'); ?>/img/tmd-2.svg" alt="">
								<h5 class="card-title">Leadership & Policies</h5>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100 tmd-card">
							<div class="card-body">
								<img src="<?php bloginfo('template_directory'); ?>/img/tmd-3.svg" alt="">
								<h5 class="card-title">Research & Evidence</h5>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100 tmd-card">
							<div class="card-body">
								<img src="<?php bloginfo('template_directory'); ?>/img/tmd-4.svg" alt="">
								<h5 class="card-title">Health Systems & Services</h5>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card h-100 tmd-card">
							<div class="card-body">
								<img src="<?php bloginfo('template_directory'); ?>/img/tmd-5.svg" alt="">
								<h5 class="card-title">Digital Health Frontiers</h5>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card h-100 tmd-card">
							<div class="card-body">
								<img src="<?php bloginfo('template_directory'); ?>/img/tmd-6.svg" alt="">
								<h5 class="card-title">Biodiversity & Sustainability</h5>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card h-100 tmd-card">
							<div class="card-body">
								<img src="<?php bloginfo('template_directory'); ?>/img/tmd-7.svg" alt="">
								<h5 class="card-title">Rights, Equity & Ethics</h5>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card h-100 tmd-card">
							<div class="card-body">
								<img src="<?php bloginfo('template_directory'); ?>/img/tmd-8.svg" alt="">
								<h5 class="card-title">TM for Daily Life</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>




	<!-- trending / Featured-->
	<section id="home-highlights">
		<div class="container">
			<h2 class="title1">
				<img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt="">
				Trending Topics
			</h2>
			<div class="row mt-5 mb-5">
				<div class="col-md-3">
					<?= esc_html($text_trending_topics);?> 
				</div>
				<div class="col-md-9">
					<div class="row g-4 trending-slider">
						<?php
						$args = array(
							'post_type' => 'trending_topics',
							'posts_per_page' => 3,
						);
						$trending_topics_query = new WP_Query($args);
						if ($trending_topics_query->have_posts()) : 
							while ($trending_topics_query->have_posts()) : $trending_topics_query->the_post(); ?>
								<div style="margin: 20px; height: 320px;"> 
									<article class="card card-trend h-100">
										<div class="card-body">
											<h5 class="card-title"><?php the_title(); ?></h5>
											<p class="card-text"><?php the_excerpt(); ?></p>
											<a href="<?php the_permalink(); ?>">Explore this topic</a>
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
			</div>

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
								<?php the_excerpt(); ?>
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
		</div>
	</section>

	<!-- Events -->
	<div class="container mt-5">
		<h2 class="title1">
			<img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt="">
			Events
		</h2>
	</div>
	<section id="events">
		<div class="container">
			<div id="box-events">
				<h3 class="title1"><?= esc_html($events_title);?></h3>
				<p><?= esc_html($events_subtitle);?></p>

				<a href="" class="btn btn-sm btn-primary">Webcasts</a>
				<a href="" class="btn btn-sm btn-primary">Meeting Reports</a>
				<a href="" class="btn btn-sm btn-primary">Concept Notes</a>
			</div>

			<div class="pb-5">
				Explore all events <a href="#" class="btn btn-primary btn-sm" ><img src="<?php bloginfo('template_directory'); ?>/img/arrow-right.svg" alt=""></a>
			</div>
		</div>
	</section>

	<!-- News -->
	<section id="news">
		<div class="container">
			<h2 class="title1 mb-5">
				<img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt="">
				News
			</h2>
			<div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
				<?php 
				$posts = new WP_Query(['post_type' => 'post','posts_per_page' => '2']);
				while($posts->have_posts()) : $posts->the_post(); ?>
					<div class="col">
						<div class="card h-100 news-card">
							<?php the_post_thumbnail('full', ['class' => 'card-img-top', 'alt' => get_the_title()]); ?>
							<div class="card-body">
								<small><?php echo get_the_date('d F Y'); ?></small>
								<h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
								<?php
								$categories = get_the_category();
								if (!empty($categories)) {
									echo '<span class="badge text-bg-danger mt-3">' . esc_html($categories[0]->name) . '</span>';
								}
								?>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			<p class="mt-4">Explore archived news <a href="#" class="btn btn-primary btn-sm"><img src="<?php bloginfo('template_directory'); ?>/img/arrow-right.svg" alt=""></a></p>
		</div>
	</section>

	<!-- Newsletter -->
	<section id="newsletter">
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<form class="">
						<?php echo do_shortcode(esc_html($shortcode_newsletter)); ?>
					</form>
				</div>
				<div class="col-md-5" id="news-img">

				</div>
			</div>
		</div>
	</section>
	<?php get_footer(); ?>