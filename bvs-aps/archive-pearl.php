<?php get_header(); ?>
<main class="padding1">
	<div class="container">
		<h2 class="margin2">REVISÕES COMENTADAS (POEMS)</h2>
		<div class="row row-cols-1 row-cols-md-3 g-4">
			<?php if (have_posts() ) : 
				while (have_posts() ) :the_post(); 
					?>
					<div class="col">
						<div class="card h-100 box1">
							<a href="<?php the_permalink(); ?>">
								<div class="card-body">
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
			<?php the_posts_pagination( array(
				'mid_size'  => 2,
				'prev_text' => 'Anterior',
				'next_text' => 'Próximo',
			) ); ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>