<?php get_header('interno'); ?>
<main id="main_container" class="mt-5 mb-5">
	<div class="container">
		<div class="breadcrumb">
			<?php if (function_exists('bcn_display')) { bcn_display(); } ?>
		</div>
		<?php the_content(); ?>
	</div>
</main>
<section>
	<div class="container">
		<?php the_content(); ?>
	</div>
</section>
<?php get_footer(); ?>