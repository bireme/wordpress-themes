<?php get_header(); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h1 class="title1"><?php pll_e('Ficha técnica del país'); ?></h1>
		<div>
			<?php $home = new WP_Query([ 'post_type' => 'page','pagename' => 'home']);
			while($home->have_posts()):$home->the_post();?>
				<?php the_content(); ?>
			<?php endwhile;	?>
		</div>
	</div>
</main>
<?php get_footer(); ?> 