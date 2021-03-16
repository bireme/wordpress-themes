<?php
	/*
	template name: Home
	*/
?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/banners') ?>

<section class="padding1">
	<div class="container">
		<?php
		$home = new WP_Query([
			'post_type' => 'page',
			'pagename' => 'Home'
		]);
		while($home->have_posts()) : $home->the_post();
			$sobre = get_field('sobre');
			?>
			<h3 class="title1"><?php pll_e('About'); ?></h3>
			<?php echo $sobre; ?>
		<?php endwhile;	?>
	</div>
</section>


<section class="padding1 color1">
	<div class="container">
		<div class="row row-cols-1 row-cols-md-3 g-4">
			<?php 
			$revista = new WP_Query([
				'post_type' 		=> 'revista',
				'posts_per_page' 	=> '-1'
			]);
			while($revista->have_posts()) : $revista->the_post();
				$texto = get_field('texto'); 
				$imagem = get_field('imagem'); 
				$link_revista = get_field('link_acessar_revista');
				$link_atual = get_field('link_edicao_atual');
				?>
				<div class="col">
					<div class="card h-100">
						<img src="<?php echo $imagem['url']; ?>" class="card-img-top" alt="...">
						<div class="card-body">
							<h5 class="card-title"><?php the_title(); ?></h5> <hr>
							<p class="card-text"><?php echo $texto;  ?></p>

						</div>
						<div class="card-footer">
							<a href="<?php echo $link_revista; ?>" target="_blank" class="btn btn-outline-primary btn-sm"><?php pll_e('Acessar revista'); ?></a>
							<a href="<?php echo $link_atual; ?>" target="_blank" class="btn btn-outline-primary btn-sm"><?php pll_e('Edição Atual'); ?></a>
						</div>
					</div>
				</div>
				<?php
			endwhile;	
			?>
		</div>
	</div>
</section>


<?php get_template_part('includes/noticias') ?>
<?php get_template_part('includes/miniBanners') ?>
<section class="padding1">
	<div class="container">
		<div class="row">
			<?php
			$home = new WP_Query([
				'post_type' => 'page',
				'pagename' => 'Home'
			]);
			while($home->have_posts()) : $home->the_post();
				$sobre = get_field('sobre'); 
				$imagem_1 = get_field('imagem_1');
				$link_1 = get_field('link_1');
				$abrir_1 = get_field('abrir_1');
				$imagem_2 = get_field('imagem_2');
				$link_2 = get_field('link_2');
				$abrir_2 = get_field('abrir_2');
				?>

				<div class="col-md-6 marginM1">
					<a href="<?php echo $link_1; ?>" target="<?php echo $abrir_1; ?>">
						<img src="<?php echo $imagem_1['url']; ?>" class="img-fluid" alt="<?php echo $imagem_1['alt']; ?>">
					</a>
				</div>
				<div class="col-md-6 marginM1">
					<a href="<?php echo $link_2; ?>" target="<?php echo $abrir_2; ?>">
						<img src="<?php echo $imagem_2['url']; ?>" class="img-fluid" alt="<?php echo $imagem_2['alt']; ?>">
					</a>
				</div>
			<?php endwhile;	?>
		</div>
	</div>
</section>

<?php get_footer(); ?>