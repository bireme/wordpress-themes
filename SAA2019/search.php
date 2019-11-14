<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<section class="container">
	<h4 class="title1">Resultado de Busca: <?php echo esc_html(get_query_var('s')); ?></h4>
	<div class="row" id="main_container">
		<?php if(have_posts()): while (have_posts()) : the_post(); ?>
			<article class="col-md-4 imEffect">
				<a href="<?php permalink_link(); ?>">
					<?php the_post_thumbnail('medium',['class' => 'img-fluid  imgPost']); ?>
					<b><?php the_title(); ?></b> <br>
					<small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></small>
				</a>
				<br><br>
			</article>
		<?php endwhile; else:?>
			<div class="col-12">
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					Desculpe não encontramos o que você procura! Você pode tentar outros termos!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		<?php endif;?>
	</div>
</section>

<br><br>
<section class="container">
	<h4 class="title1">Últimas Notícais</h4>
	<div class="row">
		<?php 
		$posts = new WP_Query([
			'post_type' => 'post',
			'posts_per_page' => '8'
		]);
		while($posts->have_posts()) : $posts->the_post(); ?>
			<article class="col-md-3 imEffect">
				<a href="<?php permalink_link(); ?>">
					<?php the_post_thumbnail('medium_large',['class' => 'img-fluid  imgPost']); ?>
					<b><?php the_title(); ?></b> <br>
					<small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></small>
				</a>
			</article>
			<?php
		endwhile;
		?>
	</div>
</section>
<?php get_footer(); ?>