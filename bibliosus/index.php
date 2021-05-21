<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<?php get_template_part('includes/banners') ?>
<section id="produtos" class="padding2">
	<div class="container" id="main_container">
		<div class="slideNews">
			<?php 
			$Tema = new WP_Query(array(
				'post_type' => 'Produto',
				'posts_per_page' => '-1'
			));
			while($Tema->have_posts()) : $Tema->the_post();
				$itens = get_field('group');
				while( have_rows('group') ): the_row(); 
					$foto = get_sub_field('foto'); 
					$link = get_sub_field('link');
					$abrir = get_sub_field('abrir');
					?>
					<article class="produtosBox">
						<a href="<?php permalink_link(); ?>">
							<?php 
							if ( $foto == "") { ?>
								<img src="<?php bloginfo('template_directory')?>/img/produtoIndisponivel.jpg" class="img-fluid" alt="sem fotos">
							<?php }else{ ?>
								<img src="<?php echo esc_url($foto['sizes']['mini-banners']); ?>" alt="<?php echo $foto['alt'] ?>" class="img-fluid rounded">
							<?php }	 ?>
							<h5><?php the_title(); ?></h5>
						</a>
					</article>
					<?php
					$i++;
				endwhile;
			endwhile;
			?>
		</div>
	</div>
</section>

<section class="padding2 color1">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<?php
				$posts = new WP_Query([
					'post_type' => 'page',
					'pagename' => 'diretorio-de-instituicoes'
				]);
				while($posts->have_posts()) : $posts->the_post();?>
					<a href="<?php permalink_link(); ?>">
						<div class="row">
							<div class="col-md-12 col-lg-6">
								<?php the_post_thumbnail('medium_size_w',['class' => 'img-fluid rounded marginM1']); ?>
							</div>
							<div class="col-md-12 col-lg-6">
								<h4 class="title2"><?php the_title(); ?></h4>
								<p><?php the_excerpt(); ?></p>
							</div>
						</div>
					</a>
				<?php endwhile;	?>
			</div>
			<div class="col-md-6">
				<?php
				$posts = new WP_Query([
					'post_type' => 'page',
					'pagename' => 'comite-nacional'
				]);
				while($posts->have_posts()) : $posts->the_post();?>
					<a href="<?php permalink_link(); ?>">
						<div class="row">
							<div class="col-md-12 col-lg-6">
								<?php the_post_thumbnail('medium_size_w',['class' => 'img-fluid rounded marginM1']); ?>
							</div>
							<div class="col-md-12 col-lg-6">
								<h4 class="title2"><?php the_title(); ?></h4>
								<p><?php the_excerpt(); ?></p>
							</div>
						</div>
					</a>
				<?php endwhile;	?>
			</div>
		</div>
	</div>
</section>

<section id="" class="padding2 color2">
	<div class="container">
		<div class="row">
			<?php
			$home = new WP_Query([
				'post_type' => 'page',
				'pagename' => 'home'
			]);
			while($home->have_posts()) : $home->the_post();
				$group = get_field('group1');
				while( have_rows('group1') ): the_row(); 
					$titulo = get_sub_field('titulo'); 
					$texto = get_sub_field('texto');
					$foto = get_sub_field('foto');
						?>
			<div class="col-md-8">
				<h2 class="title1"><?php echo $titulo; ?></h2>
				<?php echo $texto; ?>
			</div>
			<div class="col-md-4">
				<img src="<?php echo $foto['url']; ?>" alt="<?php echo $foto_parceiro_2['alt'] ?>" class="img-fluid">
			</div>
			<?php endwhile;
			endwhile;
			?>
		</div>
	</div>		
</section>
<section class="padding2">
	<div class="container">
		<div class="row">
			<?php
			$home = new WP_Query([
				'post_type' => 'page',
				'pagename' => 'home'
			]);
			while($home->have_posts()) : $home->the_post();
				$group = get_field('group2');
				while( have_rows('group2') ): the_row(); 
					$foto_parceiro_1 = get_sub_field('foto_parceiro_1'); 
					$link_parceiro_1 = get_sub_field('link_parceiro_1');
					$abrir_parceiro_1 = get_sub_field('abrir_parceiro_1');
					$foto_parceiro_2 = get_sub_field('foto_parceiro_2'); 
					$link_parceiro_2 = get_sub_field('link_parceiro_2');
					$abrir_parceiro_2 = get_sub_field('abrir_parceiro_2');
					?>
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
				<?php endwhile;
			endwhile;
			?>
		</div>
	</div>
</section>
<?php get_template_part('includes/noticias') ?>
<?php get_footer(); ?>
