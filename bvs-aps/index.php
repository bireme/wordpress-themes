<?php get_header(); ?>
<main class="padding1">
	<div class="container">
		<h2 class="margin2">SEGUNDA OPINIÃO FORMATIVA – SOF</h2>
		<div class="row row-cols-1 row-cols-md-3 g-4">
			<?php
			$arg = array(
				'posts_per_page' => 6,
				'post_type'  => 'aps',
				'orderby' => 'date',
				'order'   => 'DESC',
			);
			$arg = new WP_Query( $arg );
			?>
			<?php if ( $arg->have_posts() ) : 
				while ( $arg->have_posts() ) : $arg->the_post(); 
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
			<a href="aps" class="btn btn-success btnColor1">Ver todos</a>
		</div>

		<h2 class="margin1">REVISÕES COMENTADAS (POEMS)</h2>
		<div class="row row-cols-1 row-cols-md-3 g-4">
			<?php
			$arg = array(
				'posts_per_page' => 6,
				'post_type'  => 'pearl',
				'orderby' => 'date',
				'order'   => 'DESC',
			);
			$arg = new WP_Query( $arg );
			?>
			<?php if ( $arg->have_posts() ) : 
				while ( $arg->have_posts() ) : $arg->the_post(); 
					?>
					<div class="col">
						<div class="card h-100 box1">
							<a href="<?php the_permalink(); ?>">
								<div class="card-body">
									<small><?php echo get_the_date( 'j F Y' ); ?></small>
									<h5 class="card-title"><?php the_title(); ?></h5>
									<p class="card-text"><?php the_excerpt(); ?></p>
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
			<a href="pearl" class="btn btn-success btn- btnColor1">Ver todos</a>
		</div>
	</div>
</main>
<?php get_footer(); ?>