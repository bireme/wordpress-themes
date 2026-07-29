<?php get_header('interno'); ?>
<main id="main_container" class="mb-5">
	<div class="container">
		<div class="breadcrumb mt-3">
			<a href="<?php echo get_option('siteurl'); ?>/<?php echo $lang=='pt'?'':$lang; ?>">HOME</a>
			&nbsp > <?php the_title(); ?>
		</div>
		<h1 class="title"><?php  the_title(); ?></h1>
		<div class="float-start me-5 mb-4">
			<?php
			if ( has_post_thumbnail() ) { 
				the_post_thumbnail('full', ['class' => 'img-fluid rounded marginb1']); 
			}
			?>
		</div>
		<?php the_content(); ?>
		<div class="clearfix"></div>
	</div>
</main>

<?php 
$query = new WP_Query([
	'post_type'           => 'aspas',
	'post_status'         => 'publish',
	'posts_per_page'      => -1,
	'orderby'             => 'menu_order',
	'post__not_in'   => [get_the_ID()],
]);
?>
<section id="main_container" class="mb-5">
	<div class="container">
		
		<h1 class="title"><?php pll_e('Vozes da Pandemia'); ?></h1>
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
						<a href="<?php the_permalink(); ?>" class="card-img-top d-block">
							<?php the_post_thumbnail('medium_large', ['class' => 'img-fluid']); ?>
						</a>
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
							<div class="mt-auto text-start">
								<hr>
								<small><i><?php echo esc_html($colecao); ?></i></small>
								<a href="<?php echo esc_url($url); ?>" >
									<img src="<?php bloginfo('template_directory'); ?>/img/icon-right.svg" class="btn-more"  >
								</a>
							</div>
						</div>
					</article>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>