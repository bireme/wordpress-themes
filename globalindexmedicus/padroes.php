<?php
	/*
		template name: Default
	*/
?>
<?php get_header(); ?>
<?php get_template_part( 'includes/search', 'box' ) ?>
<main class="padding1" id="main_container" role="main">
	<div class="container">
		<h2 class="titulo1"><?php the_title(); ?></h2>
		<div class="clearfix"><?php echo do_shortcode('[DISPLAY_ULTIMATE_SOCIAL_ICONS]'); ?></div>
		<?php while(have_posts()) : the_post();
			the_content();
		endwhile;
		?>
		
	</div>
</main>
<?php get_footer(); ?>