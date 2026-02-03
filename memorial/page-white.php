<?php /* Template Name: Default White */ ?>
<?php get_header('interno-home'); ?>
<?php 
$thumb = get_the_post_thumbnail_url(get_the_ID(), 'full'); 
$bg = $thumb ? $thumb : get_template_directory_uri() . '/img/header-memorial.jpg';
?>
<div class="title-white">
	<div class="container">
		<h1><?php the_title(); ?></h1>
		<div class="breadcrumb">
			<?php if (function_exists('bcn_display')) { bcn_display(); } ?>
		</div>
	</div>
</div>
<main id="main_container" class="mb-5">
	<div class="container">
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer('home'); ?>