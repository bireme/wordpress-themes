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
									<small><?php echo get_the_date( 'j F Y' ); ?></small>
									<h5 class="card-title"><?php the_title(); ?></h5>
									<p class="card-text"><?php the_excerpt(); ?></p>
									<div class="small">
										<hr>
										<?php echo get_the_term_list(get_the_ID(), 'categoria-da-evidencia', '', ', '); ?> <br>
										<?php echo get_the_term_list(get_the_ID(), 'teleconsultor', '', ', '); ?> <br>
										
										<?php $solicitante =  get_the_term_list(get_the_ID(), 'tipo-de-profissional', '', ', ');?>
										<?php $ciap =  get_the_term_list(get_the_ID(), 'ciap2', '', ', ');?>
										<?php $decs =  get_the_term_list(get_the_ID(), 'decs', '', ', ');?>
										<?php $evidencia =  get_the_term_list(get_the_ID(), 'grau-da-evidencia', '', ', ');?>
										<?php $tematico =  get_the_term_list(get_the_ID(), 'recorte-tematico', '', ', ');?>

										<?php echo $solicitante != "" ? "<b>Solicitante:</b> $solicitante <br>" : ""; ?>
										<?php echo $ciap != "" ? "<b>CIAP2:</b> $ciap <br>" : ""; ?>
										<?php echo $decs != "" ? "<b>DeCS/MeSH:</b> $decs <br>" : ""; ?>
										<?php echo $evidencia != "" ? "<b>Graus da Evidência:</b> $evidencia <br>" : ""; ?>
										<?php echo $tematico != "" ? "<b>Recorte Temático:</b> $tematico <br>" : ""; ?>
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