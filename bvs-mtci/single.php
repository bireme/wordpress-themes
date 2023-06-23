<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container">
	<section id="title">
		<div class="container">
			<div class="row">
				<div class="col-md-<?php echo has_post_thumbnail() ? '5' : '12'; ?>">
					<div class="text-center"><?php if ( has_post_thumbnail()) { the_post_thumbnail('large', ['class' => 'img-fluid margin2']);} ?></div>
				</div>
				<div class="col-md-<?php echo has_post_thumbnail() ? '7' : '12'; ?>">
					<h1 class="title1"><?php the_title(); ?></h1>
				</div>
			</div>
			<?php if (!is_home()): ?><div class="breadcrumb"><?php get_breadcrumb(); ?></div><?php endif; ?>
		</div>
	</section>
	<div class="container padding1">
		<div class="row">

			<div class="col-12">
				<?php the_content(); ?>	
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>