<?php /* Template Name: Notícias */ ?>
<?php get_header('interno'); ?>
<main id="main_container" class="mb-5">
	<div class="container">
		<div class="breadcrumb mt-3">
			<?php if ( function_exists('bcn_display') ) { bcn_display(); } ?>
		</div>
		<h1 class="title mb-5"><?php the_title(); ?></h1>
		<?php
		$posts = new WP_Query([
			'post_type'      => 'post',
			'posts_per_page' => -1,
			'paged'          => max( 1, get_query_var('paged') ),
		]);
		?>
		<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="news">
			<?php if ( $posts->have_posts() ) : ?>
				<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

					<article class="col">
						<div class="card h-100">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="d-block">
									<?php the_post_thumbnail('medium', ['class' => 'card-img-top card-img-fixed']); ?>
								</a>
							<?php else : ?>
								<a href="<?php the_permalink(); ?>" class="d-block">
									<img
									src="<?php echo esc_url( get_template_directory_uri() . '/img/blog-default.jpg' ); ?>"
									class="card-img-top card-img-fixed"
									alt="<?php echo esc_attr( get_the_title() ); ?>"
									>
								</a>
							<?php endif; ?>
							<div class="card-body">
								<h5 class="card-title mb-2">
									<a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
										<?php the_title(); ?>
									</a>
								</h5>
								<?php
								$categories = get_the_category();
								if ( ! empty( $categories ) ) :

									$limit = 3; // <<< ajuste aqui quantos badges quer mostrar
									$count = 0;
									?>
									<div class="mb-3">
										<?php foreach ( $categories as $category ) :
											if ( $count >= $limit ) {
												break;
											}
											$count++;
											?>
											<a
											href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"
											class="text-decoration-none me-1"
											aria-label="Ver posts da categoria <?php echo esc_attr( $category->name ); ?>"
											>
											<span class="badge bg-primary d-inline-block">
												<?php echo esc_html( $category->name ); ?>
											</span>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<p class="card-text">
								<?php the_excerpt(); ?>
							</p>

						</div>
					</div>
				</article>

			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>

		<?php else : ?>
			<p>Nenhum post encontrado nesta categoria.</p>
		<?php endif; ?>
	</div>

	<?php
		// Paginação simples (opcional)
		$total_pages = $posts->max_num_pages;
		if ( $total_pages > 1 ) :
			$current_page = max( 1, get_query_var('paged') );
	?>
		<nav class="mt-4">
			<?php
			echo paginate_links([
				'total'   => $total_pages,
				'current' => $current_page,
				'type'    => 'list',
			]);
			?>
		</nav>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>