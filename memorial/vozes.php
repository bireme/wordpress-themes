<?php /* Template Name: Vozes da Pandemia */ ?>
<?php get_header('interno'); ?>

<?php 
$query = new WP_Query([
	'post_type'           => 'aspas',
	'post_status'         => 'publish',
	'posts_per_page'      => -1,
	'orderby'             => 'menu_order',
]);
?>
<main id="main_container" class="mb-5">
	<div class="container">
		<div class="breadcrumb mt-3">
			<?php if ( function_exists('bcn_display') ) { bcn_display(); } ?>
		</div>
		<h1 class="title"><?php the_title(); ?></h1>
		<div class="mt-5 mb-5">
				<?php the_content(); ?>
		</div>
		<div class="row g-4" id="colecoes">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<?php
				$autor = get_field('autor');
				$colecao = get_field('colecao');
				$url   = get_field('link_da_colecao');
				?>
				<div class="col-12 col-md-6 col-lg-4">
					<article class="card h-100 shadow-sm">

						<div class="card-body d-flex flex-column text-center">
							<h2 class="h5 card-title">
								<a href="<?php echo esc_url($url); ?>" class="text-decoration-none">
									<?php the_title(); ?>
									<hr>
								</a>
							</h2>

							<p class="card-text text-muted">
								<?php the_content(); ?>
								<?php echo esc_html($autor); ?>
							</p>
							<div class="mt-auto">
								<a href="<?php echo esc_url($url); ?>" class="btn btn-primary mb-3">
									Coleção:  <i><?php echo esc_html($colecao); ?></i>
								</a>
							</div>
						</div>
					</article>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>