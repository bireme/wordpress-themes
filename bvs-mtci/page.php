<?php get_header(); ?>
<?php $lang = pll_current_language(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container">
	<section id="title">
		<div class="container">
			<h1 class="title1"><?php the_title(); ?></h1>			
			<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
				<a href="<?php echo get_option('siteurl'); ?>/<?php echo $lang=='es'?'':$lang; ?>">HOME</a>
				<?php if(function_exists('bcn_display'))
				{
					bcn_display();
				}?>
			</div>
		</div>

	</section>
	<div class="container padding1">
		<div class="<?php echo has_post_thumbnail() ? 'margin1 thumbpost' : 'd-none'; ?>">
			<?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
		</div>
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer(); ?>