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
<section class="tmg-section">
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