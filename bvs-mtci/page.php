<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container">
	<section id="title">
		<div class="container">
			<h1 class="title1"><?php the_title(); ?></h1>
			<?php if (!is_home()): ?><div class="breadcrumb"><?php get_breadcrumb(); ?></div><?php endif; ?>
		</div>
	</section>
	<div class="container padding1">
		<div class="<?php echo has_post_thumbnail() ? 'margin1 text-center' : 'd-none'; ?>">
			<?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
		</div>
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer(); ?>