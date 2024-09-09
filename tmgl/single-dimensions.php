<?php get_header(); ?>
<?php
if (function_exists('have_rows')) {
	$long_title = get_field('long_title');
	$cover_image = get_field('cover_image');
	if ( $cover_image ) {
		$cover_image_url = $cover_image['url'];
	} else {
		$cover_image_url = $cover_image['url'];
	}
}
?>
<section id="header-title" style="background-image: linear-gradient(to right, rgba(0, 0, 0, .8), rgba(0, 0, 0, 0)), url(<?= $cover_image_url ?>);">
	<div class="container">
		<?php get_template_part('includes/breadcrumb') ?>
		<div class="header-box">
			<h3 class="title1"><img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt=""> TM Dimensions</h3>
			<h1 class="title1"><?= $long_title; ?></h1>
			<?php the_excerpt(); ?>
		</div>
	</div>
</section>
<main id="main_container" class="padding1">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<?php the_content(); ?>
			</div>
			<div class="col-md-3">
				<div class="sticky-top">
					<h3 class="font-1 color-1 mb-3">Lorem ipsum dolor sit amet consectetur.</h3>
					<?php
					$args = array(
						'post_type' => 'trending_topics',
						'posts_per_page' => 3,
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
		</div>
	</div>
</main>
<section class="related">
	<div class="container">
		<h4 class="font-2 mb-4">Related videos</h4>

		<p class="mt-4 text-end"><?php _e( 'Explore more videos', 'tmgl' ); ?> <a href="<?= $url_news;?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></p>
	</div>
</section>
<section class="recommended">
	<div class="container">
		<h4 class="font-2 mb-4">Recommended articles</h4>
		<div class="row row-flex">
			<article class="col">
				<div class="card card-trend h-100">
					<div class="card-body">
						<h5 class="card-title">Guia das Parteiras Tradicionais na Amazônia</h5>
						<p class="card-text">Schweickardt, Júlio Cesar; Melo, Camila Pimentel Lopes de; Moraes, Inna Silva de; Souza, Lupuna Corrêa de.</p>
					</div>
					<div class="card-footer text-end">
						<small class="text-body-secondary"><a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></small>
					</div>
				</div>
			</article>

			<article class="col">
				<div class="card card-trend h-100">
					<div class="card-body">
						<h5 class="card-title">Spirituality and Well-Being: Theory, Science, and the Nature Connection.</h5>
						<p class="card-text">Ryff, Carol D.</p>
					</div>
					<div class="card-footer text-end">
						<small class="text-body-secondary"><a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></small>
					</div>
				</div>
			</article>


			<article class="col">
				<div class="card card-trend h-100">
					<div class="card-body">
						<h5 class="card-title">Use of traditional medication on the health of women and children of the Togutil tribe in North Moluccas Province.</h5>
						<p class="card-text">Taib, Zulkiflia; Sibarani, Robert; Zuska, Fikarwin.</p>
					</div>
					<div class="card-footer text-end">
						<small class="text-body-secondary"><a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></small>
					</div>
				</div>
			</article>
		</div>


		<p class="mt-4 text-end"><?php _e( 'Explore more articles', 'tmgl' ); ?> <a href="<?= $url_news;?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></p>
	</div>
</section>



<?php get_footer(); ?>