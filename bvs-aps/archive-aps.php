<?php get_header(); ?>
<main class="padding1">
	<div class="container">
		<h2 class="margin2">SEGUNDA OPINIÃO FORMATIVA – SOF</h2>
		<div class="row row-cols-1 row-cols-md-3 g-4">
			<?php if ( have_posts() ) : 
				while ( have_posts() ) : the_post(); 
					?>
					<div class="col">
						<div class="card h-100 box1">
							<a href="<?php the_permalink(); ?>">
								<div class="card-body">
									<h5 class="card-title"><?php the_title(); ?></h5>
									<p class="card-text"><?php the_excerpt(); ?></p>
									<div class="small">
										<hr>
										<?php echo get_the_term_list(get_the_ID(), 'categoria-da-evidencia', '', ', '); ?> <br>
										<?php echo get_the_term_list(get_the_ID(), 'teleconsultor', '', ', '); ?> <br>
										<b>Solicitante:</b>  <?php echo get_the_term_list(get_the_ID(), 'tipo-de-profissional', '', ', '); ?> <br>
										<b>CIAP2:</b> <?php echo get_the_term_list(get_the_ID(), 'ciap2', '', ', '); ?> <br>
										<b>DeCS/MeSH:</b> <?php echo get_the_term_list(get_the_ID(), 'decs', '', ', '); ?> <br>
									</div>
								</div>
							</a>
						</div>
					</div>
					<?php
				endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
		<div class="text-center">
			<hr>	
			<?php the_posts_pagination( array(
				'mid_size'  => 2,
				'prev_text' => 'Anterior',
				'next_text' => 'Próximo',
			) ); ?>
		</div>
		
	</div>
</main>
<?php get_footer(); ?>