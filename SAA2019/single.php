<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<section class="container">
	<div class="row" id="main_container">
		<div class="col-md-12">
			<h4 class="title1"><?php the_title(); ?></h4>
			<?php while(have_posts()) : the_post();
				$qrcode = get_field('qr_code');
				?>
				<?php the_post_thumbnail('large',['class' => 'img-fluid  imgPost']); ?>
				<?php the_content();
				//echo get_field('qr_code');
			endwhile;
			?>
			<div class="paginacao text-center">
				<?php previous_post_link( '%link', 'Anterior', true, '13' ); ?>  
				<?php next_post_link( '%link', 'Próximo', true, '13' ); ?> 
			</div>
		</div>

		<div class="col-md-12"><hr><h4><b>Últimas Notícias</b></h4></div>
		<?php 
		$atual = get_the_title();
		$posts = new WP_Query([
			'post_type' => 'post',
			'posts_per_page' => '8'
		]);
		while($posts->have_posts()) : $posts->the_post();
			if(get_the_title()==$atual){continue;}
			?>
			<article class="col-md-4 col-lg-3 postsInter imEffect">
				<a href="<?php permalink_link(); ?>">
					<div class="row">
						<div class="col-12">
							<?php the_post_thumbnail('medium_large',['class' => 'img-fluid']); ?>
						</div>
						<div class="col-12">
							<b><?php the_title(); ?></b> <br>
							<small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></small>
						</div>
					</div>
				</a>
			</article>
			<?php
		endwhile;
		?>
	</div>
</section>
<?php get_footer(); ?>