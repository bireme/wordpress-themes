<?php get_header('interno'); ?>
<main id="main_container" class="mb-5">
	<div class="container">
		<div class="breadcrumb">
			<?php if (function_exists('bcn_display')) { bcn_display(); } ?>
		</div>
		<h1 class="title"><?php  the_title(); ?></h1>
		<?php the_content(); ?>
		<div class="clearfix"></div>
	</div>
</main>
<?php get_footer(); ?>