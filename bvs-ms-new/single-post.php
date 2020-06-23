<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>

<section class="margin4">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1 class="title1"><?php the_title(); ?></h1> <br>
				<?php while(have_posts()) : the_post();	?>
					<?php the_post_thumbnail('large',['class' => 'img-fluid imgPost']); ?>
					<?php the_content();
				endwhile;
				?>
				<div class="clearfix"></div> <br>
				<div class="paginacao text-center">
					<?php previous_post_link( '%link', 'Anterior', true, '13' ); ?>  
					<?php next_post_link( '%link', 'Próximo', true, '13' ); ?> 
				</div>
			</div>
		</div>
	</div>
</section>

<section class="padding1 color1">
	<div class="container">
		<h2 class="title1">Clipping de Notícias</h2>
		<div class="row">
			<?php 
			$atual = get_the_title();
			$posts = new WP_Query([
				'post_type' => 'post',
				'posts_per_page' => '8'
			]);
			while($posts->have_posts()) : $posts->the_post();?>
				<article class="col-12 col-md-4 col-lg-3 clippingNews">
					<a href="<?php permalink_link(); ?>">
						<!-- <img src="img/news1.jpg" alt="" class="img-fluid"> -->
						<h4><?php the_title(); ?></h4>
						<div class="slideNewsDate"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></div>
					</a>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<p class="text-center">
			<a href="<?php echo get_option('siteurl'); ?>/clipping-de-noticias" class="btn btn-success">Ver todas</a>
		</p>
	</div>
</section>


<?php get_footer(); ?>