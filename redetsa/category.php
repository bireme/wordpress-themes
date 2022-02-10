<?php get_header();?>
<?php get_template_part('includes/nav'); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h1 class="title1"><?php single_cat_title(); ?></h1>
		<div class="row">
			<div class="col-md-9">
				<?php
				
				if(have_posts()): while (have_posts()) : the_post(); ?>
					<?php $thumb = has_post_thumbnail();  ?>
					<article class="row">
						<div class="col-md-2 <?php echo $thumb == "" ? "d-none" : ""; ?>">
							<?php the_post_thumbnail('thumbnail',['class' => 'img-fluid']);?>
						</div>
						<div class="col-md-<?php echo $thumb == ""? "12" : "10"; ?>">
							<a href="<?php permalink_link(); ?>">
								<b><?php the_title(); ?></b> <br>
								<small><?php the_excerpt(); ?></small>
							</a>
						</div>
						<hr>
					</article>
				<?php endwhile; else: endif;?>
			</div>
			<div class="col-md-3">
				<div class="card text-dark bg-light widgets-category">
					<div class="card-header">Filtros</div>
					<?php dynamic_sidebar('sidebar-1') ?>
				</div>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>