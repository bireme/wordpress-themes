<?php /* Template Name: 404 */ ?>
<?php get_header(); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<?php get_template_part('includes/breadcrumb') ?>
		<div class="row">
			<div class="col-md-6">
				<img src="<?php bloginfo('template_directory'); ?>/img/404.png" class="img-fluid" alt="">
			</div>
			<div class="col-md-6">
				<h1 class="mt-5 title1"> Error 404</h1>
				<p class="mb-5">That's embarrassing... e couldn't find the page you're looking for. But don't worry, you can go to the homepage to browse TMGL or do a new search.</p>
				</p>
				<a href="<?php echo get_option('siteurl'); ?>" class="btn btn-primary">TMGL Homepage</a>
				<a href="<?php echo get_option('siteurl'); ?>/contact-us" class="btn btn-outline-primary">Contact US</a>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>