<?php get_header(); ?>
<?php
if (function_exists('have_rows')) {
	$long_title = get_field('long_title');
	/*$cover_image = get_field('cover_image');
	if ( $cover_image ) {
		$cover_image_url = $cover_image['url'];
	} else {
		$cover_image_url = $cover_image['url'];
	}*/
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
			<div class="col-md-12">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>