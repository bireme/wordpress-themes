<?php
$posts_home = new WP_Query([
	'post_type'           => 'post',
	'posts_per_page'      => 4,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true, // performance (sem paginação)
]);

if ( $posts_home->have_posts() ) : ?>
	<section class="mt-5 mb-5 container">
		<div class="d-flex align-items-center justify-content-between mb-3">
			<h2 >Notícias</h2>

			<?php
			// Ajuste aqui o destino do "Ver todas"
			$blog_url = get_permalink( get_option('page_for_posts') ); // se você configurou "Página de posts" no WP
			if ( ! $blog_url ) {
				$blog_url = home_url('/blog/'); // fallback: ajuste se necessário
			}
			?>
		</div>

		<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="news">
			<?php while ( $posts_home->have_posts() ) : $posts_home->the_post(); ?>
				<article class="col">
					<div class="card h-100">

						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="d-block">
								<?php the_post_thumbnail('medium', ['class' => 'card-img-top']); ?>
							</a>
						<?php else : ?>
							<a href="<?php the_permalink(); ?>" class="d-block">
								<img
								src="<?php echo esc_url( get_template_directory_uri() . '/img/blog-default.jpg' ); ?>"
								class="card-img-top"
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
								$limit = 3; // quantos badges por post
								$count = 0;
								?>
								<div class="mb-3">
									<?php foreach ( $categories as $category ) :
										if ( $count >= $limit ) break;
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

	</div>
	<div class="mt-3 text-center me-5">
		<a href="<?php echo esc_url( $blog_url ); ?>/noticias" class="btn btn-primary">
			Ver todas
		</a>
	</div>
</section>


<?php wp_reset_postdata(); ?>
<?php endif; ?>
