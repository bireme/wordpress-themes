<?php get_header(); ?>
<section class="padding1">
	<div class="container">
		<?php while(have_posts()) : the_post(); ?>
			<h2 class="titulo1"><?php the_title(); ?></h2>
			<div class="row">
				<div class="col-12 col-md-4">
					<?php the_post_thumbnail('Bibliotecas', array('class'=>'img-fluid')); ?>
				</div>
				<div class="col-12 col-md-8">
					<?php //the_excerpt(); ?>
					<?php the_content(); ?>
				</div>
			</div>
			<br>
			<!-- Opções -->
			<div class="row">
				<?php 
				$descricoes = get_field('descricoes');
				if($descricoes != 0) {
					foreach ($descricoes as $item) { 
						$imagem = $item['imagem'];
						?>
						<div class="col-md-4 paddingM1">
							<div class="area text-center">
								<a href="<?= $item['link'] ?>">
									<img src="<?php echo $imagem['url']; ?>" alt="<?php echo $imagem['alt'] ?>" />
									<h4><?= $item['titulo'] ?></h4>
									<p class="text-justify"><?= $item['texto'] ?></p>
								</a>
							</div>
						</div>
					<?php }
				} ?>
			</div>
			<br>
		<?php endwhile; ?>

		<!-- Outros -->
		<h2 class="titulo1"><p><?php pll_e('World Health Organization'); ?></p></h2>
		<div class="row text-center">
			<?php 
			$x = get_the_title();
			$biblioteca = new WP_Query(array(
				'post_type' => 'biblioteca',
				'orderby' => 'title',
    			'order'   => 'ASC'
			));
			while($biblioteca->have_posts()) : $biblioteca->the_post();
				if(get_the_title()==$x){$biblioteca->the_post();}
				?>
				<div class="col-4 col-md-2">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('Bibliotecas', array('class'=>'img-fluid')); ?>
						<h6><?php the_title(); ?></h6>
					</a>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>