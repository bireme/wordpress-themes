<?php get_header(); ?>
<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo get_option('siteurl'); ?>">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Página</li>
		</ol>
	</nav>
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>
</div>
<?php get_footer(); ?>