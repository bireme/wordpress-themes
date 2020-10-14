<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/banners') ?>

<section class="padding2 color2" id="main_container">
	<div class="container">

		<div class="row">
			<div class="col-md-6 col-lg-3 slideNewsBox text-center">
				<?php $home = new WP_Query([
					'post_type' => 'page',
					'pagename' => 'novas-estacoes'
				]);
				while($home->have_posts()) : $home->the_post();	?>
					<a href="<?php the_permalink(); ?>">
						<img src="<?php bloginfo('template_directory') ?>/img/novidades.svg" alt="" class="img-fluid" style="width: 150px">
						<h4><?php the_title(); ?></h4>
						<p><?php the_excerpt(); ?></p>
					</a>
				<?php endwhile; ?>
			</div>
			<div class="col-md-6 col-lg-3 slideNewsBox text-center">
				<?php $home = new WP_Query([
					'post_type' => 'page',
					'pagename' => 'planejamento'
				]);
				while($home->have_posts()) : $home->the_post(); ?>
					<a href="<?php the_permalink(); ?>">
						<img src="<?php bloginfo('template_directory') ?>/img/planejamento.svg" alt="" class="img-fluid" style="width: 150px">
						<h4><?php the_title(); ?></h4>
						<p><?php the_excerpt(); ?></p>
					</a>
				<?php endwhile; ?>
			</div>
			<div class="col-md-6 col-lg-3 slideNewsBox text-center">
				<?php $home = new WP_Query([
					'post_type' => 'page',
					'pagename' => 'revitalizacoes'
				]);
				while($home->have_posts()) : $home->the_post(); ?>
					<a href="<?php the_permalink(); ?>">
						<img src="<?php bloginfo('template_directory') ?>/img/revistalizacao.svg" alt="" class="img-fluid" style="width: 150px">
						<h4><?php the_title(); ?></h4>
						<p><?php the_excerpt(); ?></p>
					</a>
				<?php endwhile; ?>
			</div>
			<div class="col-md-6 col-lg-3 slideNewsBox text-center">
				<?php $home = new WP_Query([
					'post_type' => 'page',
					'pagename' => 'atividades'
				]);
				while($home->have_posts()) : $home->the_post(); ?>
					<a href="<?php the_permalink(); ?>">
						<img src="<?php bloginfo('template_directory') ?>/img/atividades.svg" alt="" class="img-fluid" style="width: 150px">
						<h4><?php the_title(); ?></h4>
						<p><?php the_excerpt(); ?></p>
					</a>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</section>

<section class="padding2 ">
	<div class="container">
		<h3>Serviços</h3><br>
		<div class="row">
			<div class="col-md-12">
				<ul class="nav nav-tabs" id="tabServicos" role="tablist">
					<?php 
					$loop = new WP_Query([
						'post_type' => 'servicos',
						'posts_per_page' => -1
					]);
					$i = 0;
					while($loop->have_posts()) : $loop->the_post();
						$i++;
						?>
						<li class="nav-item" role="presentation">
							<a class="nav-link <?=($i == 1) ? 'active' : ''?>" id="" data-toggle="tab" href="#post-<?php the_ID(); ?>" role="tab" aria-controls="servico1" aria-selected="true"><?php the_title(); ?></a>
						</li>
					<?php endwhile; wp_reset_query(); ?>
				</ul>
				<div class="tab-content" id="tabServicosConteudo">
					<?php 
					$loop = new WP_Query([
						'post_type' => 'servicos',
						'posts_per_page' => -1
					]);
					$i = 0;
					while($loop->have_posts()) : $loop->the_post();
						$i++;
						?>
						<div class="tab-pane fade show <?=($i == 1) ? 'active' : ''?>" id="post-<?php the_ID(); ?>" role="tabpanel" aria-labelledby="">
							<p><?php the_excerpt(); ?></p>
							<a href="<?php permalink_link(); ?>" class="btn btn-primary">Ver Mais [+]</a>
						</div>
					<?php endwhile; wp_reset_query(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_template_part('includes/miniBanners') ?>
<?php
$home = new WP_Query([
	'post_type' => 'page',
	'pagename' => 'home'
]);
while($home->have_posts()) : $home->the_post();
	$group = get_field('group');
	while( have_rows('group') ): the_row(); 
		$foto_selo_desktop = get_sub_field('foto_selo_desktop'); 
		$foto_selo_mobile = get_sub_field('foto_selo_mobile'); 
		$link_selo = get_sub_field('link_selo');
		$abrir_selo = get_sub_field('abrir_selo');
		$foto_parceiro_1 = get_sub_field('foto_parceiro_1'); 
		$link_parceiro_1 = get_sub_field('link_parceiro_1');
		$abrir_parceiro_1 = get_sub_field('abrir_parceiro_1');
		$foto_parceiro_2 = get_sub_field('foto_parceiro_2'); 
		$link_parceiro_2 = get_sub_field('link_parceiro_2');
		$abrir_parceiro_2 = get_sub_field('abrir_parceiro_2');
		?>
		<section class="padding3">	
			<div class="container">
				<a href="<?php echo $link_selo; ?>" target="<?php echo $abrir_selo; ?>">
					<img src="<?php echo $foto_selo_desktop['url']; ?>" alt="<?php echo $foto_selo_desktop['alt'] ?>" class="img-fluid rounded d-none d-md-block">
					<img src="<?php echo $foto_selo_mobile['url']; ?>" alt="<?php echo $foto_selo_mobile['alt'] ?>" class="img-fluid rounded d-block d-md-none">
				</a>
			</div>
		</section>
		<section class="padding2">
			<div class="container">
				<div class="row">

					<div class="col-md-6">
						<a href="<?php echo $link_parceiro_1; ?>" target="<?php echo $abrir_parceiro_1; ?>">
							<img src="<?php echo $foto_parceiro_1['url']; ?>" alt="<?php echo $foto_parceiro_1['alt'] ?>" class="img-fluid marginM1">
						</a>
					</div>
					<div class="col-md-6">
						<a href="<?php echo $link_parceiro_2; ?>" target="<?php echo $abrir_parceiro_2; ?>">
							<img src="<?php echo $foto_parceiro_2['url']; ?>" alt="<?php echo $foto_parceiro_2['alt'] ?>" class="img-fluid marginM1">
						</a>
					</div>

				</div>
			</div>
		</section>
	<?php endwhile;
endwhile;
?>
<?php get_template_part('includes/noticias') ?>
<?php get_footer(); ?>