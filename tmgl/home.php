<?php /* Template Name: Home */ ?>
<?php get_header(); ?>

<?php
if (function_exists('have_rows')) {
	$shortcode_newsletter = get_field('shortcode_newsletter');
}
?>
<?php get_template_part('includes/search') ?>
<?php get_template_part('includes/tmd') ?>
<!-- trending / Featured-->
<section id="home-highlights">
	<div class="container">
		<?php get_template_part('includes/trending') ?>
		<?php get_template_part('includes/featured') ?>
	</div>
</section>
<?php get_template_part('includes/events') ?>
<?php get_template_part('includes/news') ?>

<!-- Newsletter -->
<section id="newsletter">
	<div class="container">
		<div class="row">
			<div class="col-md-7">
					<?php echo do_shortcode(esc_html($shortcode_newsletter)); ?>
			</div>
			<div class="col-md-5" id="news-img">

			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>