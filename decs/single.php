<?php get_header(); ?>
<?php $idioma = pll_current_language(); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo get_option('siteurl'); ?>/<?php echo $idioma=='pt'?'':$idioma; ?>">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php the_category(', '); ?></li>
				<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
			</ol>
		</nav>
		<div id="main_container">
			<h3><?php the_title(); ?></h3>
			<hr>
			<?php the_content();?>
			<hr>
			<span><?php pll_e('Category'); ?></span>: <?php the_category(', '); ?> <br>
			<?php the_tags( 'Tags: ', ', ' ); ?>
			<hr>
			<div class="row">
				<div class="col-12 col-md-6 blog-more">
					<?php previous_post_link( '%link' ); ?>  
				</div>
				<div class="col-12 col-md-6 blog-more text-right">
					<?php next_post_link( '%link'); ?>  
				</div>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>
