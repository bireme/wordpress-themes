<?php get_header(); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<strong>404!!!</strong> Page not found.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
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