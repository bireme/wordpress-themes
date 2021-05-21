<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h1 class="title3"><?php the_title(); ?></h1><br> 
		<?php while(have_posts('')) : the_post();
			$itens = get_field('group');
			while( have_rows('group') ): the_row(); 
				$foto = get_sub_field('foto'); 
				?>
				<?php 
				if ( $foto == "") { ?>
					<div class="text-center margin1"><img src="<?php bloginfo('template_directory')?>/img/produtoIndisponivel.jpg" class="img-fluid" alt="sem fotos"></div>
				<?php }else{ ?>
					<div class="text-center margin1"><img src="<?php echo esc_url($foto['sizes']['mini-banners']); ?>" alt="<?php echo $foto['alt'] ?>" class="img-fluid rounded"></div>
				<?php }	 ?>	
				<?php the_content(); ?>
			<?php	endwhile;
		endwhile;	?>
	</div>
</main>
<?php get_template_part('includes/produtosOutros') ?>
<?php get_template_part('includes/noticias') ?>
<?php get_footer(); ?>