<?php get_header(); ?>
<?php $idioma = pll_current_language(); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo get_option('siteurl'); ?>/<?php echo $idioma=='pt'?'':$idioma; ?>">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php the_category(', '); ?></li>
			</ol>
		</nav>
		<div id="main_container">
			<h3><?php single_cat_title(); ?></h3>
			<hr>
			<?php while(have_posts()) : the_post(); ?>
				<a href="<?php the_permalink(); ?>"><b><?php the_title(); ?></b></a>
				<?php if(has_post_thumbnail()){ the_post_thumbnail('thumbnail', ['class' => 'img-post']);} ?>
				<p><?php the_excerpt(); ?></p>
				<div class="clearfix"></div>
				<hr>
			<?php endwhile; ?>      
		</div>
	</div>
</main>
<?php get_footer(); ?>