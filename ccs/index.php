<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>

<section class="padding1">
	<div class="container">
		<h2 class="title1"><?php pll_e('Áreas Temáticas'); ?></h2>
		<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
			<?php 
			$tematica = new WP_Query([
				'post_type' => 'tematica',
				'orderby' => 'title',
				'order'   => 'asc',
			]);
			while($tematica->have_posts()) : $tematica->the_post();
				$imagem = get_field('imagem');
				$link = get_field('link');
				?>
				<div class="col">
					<div class="card h-100">
						<img src="<?php echo esc_url($imagem['sizes']['medium']); ?>" class="card-img-top" alt="<?php echo $imagem['alt'] ?>" />
						<div class="card-body">
							<h5 class="card-title"><a href="<?php echo $link; ?>" target="_blank"><?php the_title(); ?></a></h5>
						</div>
					</div>
				</div>
				<?php
			endwhile;	
			?>
		</div>
	</div>
</section>

<section class="padding2 bg1">
	<div class="container">
		<h2 class="title1"><?php pll_e('Normas e diretrizes em comunicação científica'); ?></h2>
		<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
			<?php 
			$normas = new WP_Query([
				'post_type' => 'normas',
				'orderby' => 'title',
				'order'   => 'asc',
			]);
			while($normas->have_posts()) : $normas->the_post();
				$link = get_field('link');
				?>
				<div class="col">
					<div class="card border-primary h-100">
						<div class="card-body">
							<p class="card-text"><a href="<?php echo $link; ?>" target="_blank"><?php the_title(); ?></a></p>
						</div>
					</div>
				</div>
				<?php
			endwhile;	
			?>
		</div>
	</div>
</section>

<section class="padding2">
	<div class="container">
		<h2 class="title1"><?php pll_e('Cursos e capacitações'); ?></h2>
		<div class="row">
			<?php 
			$cursos = new WP_Query([
				'post_type' => 'cursos'
			]);
			?>
			<?php while($cursos->have_posts()) : $cursos->the_post(); ?>
				<div class="col-md-12 col-lg-6">
					<div class="row">
						<div class="col-md-6">
							<?php the_post_thumbnail('large',['class' => 'img-fluid']); ?>
						</div>
						<div class="col-md-6">
							<h4><?php the_title(); ?></h4>
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			<?php endwhile; ?>	
		</div>
	</div>
</section>

<section class="padding2 bg1">
	<div class="container">
		<h2 class="title1"><?php pll_e('Critérios de seleção de periódicos em bases de dados'); ?></h2>
		<div class="row row-cols-2 row-cols-md-3 g-4">
			<?php 
			$criterios = new WP_Query([
				'post_type' => 'criterios'
			]);
			?>
			<?php while($criterios->have_posts()) : $criterios->the_post(); ?>
				<div class="col">
					<div class="card border-primary h-100">
						<?php the_post_thumbnail('large',['class' => 'card-img-top']); ?>
						<?php if(have_rows('criterios')): ?>
							<?php while(have_rows('criterios') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
								<ul class="list-group list-group-flush">
									<?php while ($count > $loop) : $loop++;
										$titulo = get_sub_field('titulo_'.$loop);
										$link = get_sub_field('link_'.$loop);
										?>
										<?php if ( $titulo ) : ?>
											<li class="list-group-item"><a href="<?php echo $link; ?>" target="_blank"><?php echo $titulo; ?></a></li>
										<?php endif; ?>	
									<?php endwhile;	?>	
								</ul>
							<?php endwhile;	?>	
						<?php endif; ?>	
					</div>
				</div>
			<?php endwhile; ?>	
		</div>
	</div>
</section>


<?php
$home = new WP_Query([ 'post_type' => 'page', 'pagename' => 'Home']);
while($home->have_posts()):$home->the_post(); endwhile;
?>
<?php
while(have_rows('sessao_1')):the_row(); 
	$titulo = get_sub_field('titulo'); 
	$texto = get_sub_field('texto'); 
	$imagem = get_sub_field('imagem'); 
	?>
	<section class="padding2">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<h2 class="title1"><?php echo $titulo ?></h2>
					<?php echo $texto ?>
				</div>
				<div class="col-md-4">
					<img src="<?php echo esc_url($imagem['sizes']['medium']); ?>" alt="" class="img-fluid" alt="<?php echo $imagem['alt'] ?>">
				</div>
			</div>
		</div>
	</section>
	<?php
endwhile;
?>

<?php
while(have_rows('sessao_2')):the_row(); 
	$titulo = get_sub_field('titulo'); 
	$texto = get_sub_field('texto'); 
	?>
	<section class="padding2 bg1">
		<div class="container">
			<h2 class="title1"><?php echo $titulo ?></h2>
			<?php echo $texto ?>

		</div>
	</section>
	<?php
endwhile;
?>

<?php
$home = new WP_Query([ 'post_type' => 'page', 'pagename' => 'Home']);
while($home->have_posts()):$home->the_post(); endwhile;
?>
<section class="padding2 bg2" id="parceiros">
	<div class="container">
		<div class="row row-cols-2 row-cols-md-3 g-4">
			<?php while(have_rows('sessao_3') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
				<?php while ($count > $loop) : $loop++; 
					$imagem = get_sub_field('imagem_'.$loop);
					$link = get_sub_field('link_'.$loop);
					?>
					<?php if ( $link ) : ?>
						<div class="col text-center">
							<div class="card border-primary ">
								<div>
									<a href="<?php echo $link ?>" target="_blank">
										<img src="<?php echo esc_url($imagem['sizes']['medium']); ?>" alt="" class="img-fluid" alt="<?php echo $imagem['alt'] ?>">
									</a>
								</div>
							</div>
						</div>
					<?php endif; ?>	
				<?php endwhile; ?>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>