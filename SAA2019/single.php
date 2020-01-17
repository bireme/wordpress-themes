<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<section class="container">
	<div class="row" id="main_container">
		<div class="col-md-12">
			<h4 class="title1">
				<?php the_title(); ?> <br>
				<?php echo  '<small>'.get_field('subtitulo').'</small>'; ?>
			</h4>
			
			<?php while(have_posts()) : the_post();?>
				<?php the_post_thumbnail('large',['class' => 'img-fluid  imgPost', 'title' => the_title_attribute( 'echo=0' )]); ?>
				<?php the_content();
			endwhile;
			?>
			<div class="clearfix"></div>
			<div class="paginacao text-center">
				<span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav"><i class="fas fa-angle-double-left"></i> Anterior</span> ' ) ); ?></span>
				<span class="nav-next"><?php next_post_link( '%link', __( '<span class="meta-nav">Próxima <i class="fas fa-angle-double-right"></i></span>' ) ); ?></span>
			</div>
		</div>

		<div class="col-md-12"><hr><h4><b>Últimas Notícias</b></h4></div>
		<?php 
		$atual = get_the_title();
		$posts = new WP_Query([
			'post_type' => 'post',
			'posts_per_page' => '9'
		]);
		while($posts->have_posts()) : $posts->the_post();
			if(get_the_title()==$atual){continue;}
			?>
			<article class="col-md-4 col-lg-3 postsInter imEffect">
				<a href="<?php permalink_link(); ?>">
					<div class="row">
						<div class="col-12">
							<?php 
							if ( has_post_thumbnail()) {
								the_post_thumbnail('banners',['class' => 'img-fluid']);
							}else{ ?>
								<img src="<?php bloginfo( 'template_directory')?>/img/indisponivel.jpg" class="img-fluid" alt="">
							<?php }	 ?>
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