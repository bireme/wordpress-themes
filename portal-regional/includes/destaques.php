<section class="color-gray">
	<div class="container">
		<div class="multiple-items" data-aos="fade-up">
			<?php 
			$destaques = new WP_Query(array(
				'post_type' => 'destaques',
			));
			while($destaques->have_posts()) : $destaques->the_post();
				$link = get_field('link');
				$janela = get_field('janela');
				$imagem = get_field('imagem'); 
				?>
				<div class="multiple-card">
					<a href="<?php echo $link; ?>" target="<?php echo $janela; ?>"><img src="<?php echo esc_url( $imagem['url'] ); ?>" class="img-fluid" alt="<?= $imagem['alt']; ?>"></a>
				</div>
				<?php
			endwhile;?>
		</div>
	</div>
</section>