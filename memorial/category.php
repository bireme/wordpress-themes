
<?php get_header('interno'); ?>
<main id="main_container" class="mb-5">
	<div class="container">
		<div class="breadcrumb mt-3">
			<?php if (function_exists('bcn_display')) { bcn_display(); } ?>
		</div>
		<h1 class="title mb-5">Categoria: <?php single_cat_title(); ?></h1>

		<?php
		$cat_atual = get_queried_object();
		$posts = new WP_Query([
			'post_type'      => 'post',
			'cat'            => $cat_atual->term_id
		]);
		?>
		<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
			<?php if ( $posts->have_posts() ) : ?>
				<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
					<article class="col">
						<div class="card h-100">
							<a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail('medium', ['class' => 'card-img-top card-img-fixed']); ?>
								<?php else : ?>
									<img src="<?php echo get_template_directory_uri(); ?>/img/blog-default.jpg" class="card-img-top" alt="">
								<?php endif; ?>

								<div class="card-body">
									<h5 class="card-title"><?php the_title(); ?></h5>
									<p class="card-text"><?php the_excerpt(); ?></p>
								</div>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<p>Nenhum post encontrado nesta categoria.</p>
			<?php endif; ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>