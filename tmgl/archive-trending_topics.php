<?php get_header(); ?>
<main id="main_container" class="pt-3 pb-3">
	<div class="container">
		<div class="float-end" id="trending-bts">
			<button id="trending-blocks" class="btn btn-light disabled"><i class="bi bi-grid-3x3-gap"></i></button>
			<button id="trending-list" class="btn btn-light"><i class="bi bi-hdd-stack"></i></button>
		</div>
		<div class="row pt-5  pb-5">
			<div class="col-md-3">
				<div class="title-filter">Filters</div>

				<p class="font-1"><b>Search</b></p>
				<input type="text" class="form-control">

				<p class="mt-3 font-1"><b>Regions</b></p>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="africa">
					<label class="form-check-label" for="africa">África</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="Americas">
					<label class="form-check-label" for="Americas">Americas</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="East-Mediterranean">
					<label class="form-check-label" for="East-Mediterranean">East-Mediterranean</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="Europe">
					<label class="form-check-label" for="Europe">Europe</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="South-East-Asia">
					<label class="form-check-label" for="South-East-Asia">South-East Asia</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="Western-Pacific">
					<label class="form-check-label" for="Western-Pacific">Western Pacific</label>
				</div>

				<div class="d-grid gap-2 mt-3">
					<button class="btn btn-sm btn-primary" type="button">Apply Filters</button>
				</div>
			</div>
			<div class="col-md-9">
				<div id="trend" class="row row-cols-1 row-cols-md-3 g-4">
					<?php
					$args = array(
						'post_type' => 'trending_topics',
						'posts_per_page' => -1,
					);
					$trending_topics_query = new WP_Query($args);
					if ($trending_topics_query->have_posts()) : 
						while ($trending_topics_query->have_posts()) : $trending_topics_query->the_post(); ?>
							<article class="col">
								<div class="card card-trend h-100">
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
<?php get_footer(); ?>