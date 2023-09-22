<?php get_header(); ?>

<section class="container" id="main_container">
	<div class="row padding2">
		<div class="col-12">
			<?php get_template_part('includes/search') ?>
		</div>
	</div>
</section>

<?php get_template_part('includes/banners') ?>
<?php
$home = new WP_Query([
	'post_type' => 'home',
	'orderby' => 'title',
	'order' => 'ASC'
]);
?>
<?php while($home->have_posts()):$home->the_post();
	the_content();
endwhile;
?>
<?php get_template_part('includes/partners') ?>
<?php get_footer(); ?>