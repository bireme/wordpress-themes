<?php get_header();?>
<?php get_template_part('includes/nav'); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h1 class="title1">Search Results: <?php echo esc_html(get_query_var('s')); ?></h1>
		<div id="loopSearch">
			<?php
			$posts = new WP_Query([
				'post_type' => 'post',
				's' => $_GET['s'],
				'posts_per_page' => '-1'
			]);
			if($posts->have_posts()): while ($posts->have_posts()) : $posts->the_post(); ?>
				<?php $thumb = has_post_thumbnail();  ?>
				<article>
					<div class="row">
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
					</div>
				</article>
			<?php endwhile; else: endif;?>
		</div>
	</div>
</main>
<?php get_footer(); ?>