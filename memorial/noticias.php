<?php /* Template Name: Notícias */ ?>
<?php get_header('interno'); ?>
<?php $lang = pll_current_language(); ?>
<main id="main_container" class="mb-5">
	<div class="container">
		<div class="breadcrumb mt-3">
			<a href="<?php echo get_option('siteurl'); ?>/<?php echo $lang=='pt'?'':$lang; ?>">Home</a>
				<?php if(function_exists('bcn_display'))
				{
					bcn_display();
				}?>
		</div>
		<h1 class="title"><?php the_title(); ?></h1>
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

					<?php get_template_part('includes/news-card', null, ['fixed_image' => true]); ?>

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