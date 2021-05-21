<?php /* Template Name: Produtos */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h2 class="title1">Produtos</h2>
		
		<div class="row">
			<?php 
			$atual = get_the_title();
			$produto = new WP_Query(array(
				'post_type' => 'Produto',
				'posts_per_page' => '-1'
			));
			while($produto->have_posts()) : $produto->the_post();
				if(get_the_title()==$atual){continue;}
				$itens = get_field('group');
				while( have_rows('group') ): the_row(); 
					$foto = get_sub_field('foto'); 
					$link = get_sub_field('link');
					$abrir = get_sub_field('abrir');
					?>
					<article class="col-6 col-md-4 col-lg-4 produtosBox">
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
</main>
<?php get_footer(); ?>