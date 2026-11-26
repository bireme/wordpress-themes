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
			<h2 class="title"><?php pll_e('Novidades'); ?></h2>

			<?php
			$idioma = function_exists('pll_current_language')
			    ? pll_current_language('slug')
			    : 'pt';
			
			$idioma = $idioma ?: 'pt';

$home_idioma = function_exists('pll_home_url')
    ? pll_home_url($idioma)
    : home_url('/');

$links_novidades = [
    'pt' => 'novidades/',
    'en' => 'whats-new/',
    'es' => 'novedades/',
];

$blog_url = trailingslashit($home_idioma)
    . ($links_novidades[$idioma] ?? $links_novidades['pt']);
			?>
		</div>

		<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="news">
			<?php while ( $posts_home->have_posts() ) : $posts_home->the_post(); ?>
				<?php get_template_part('includes/news-card', null, ['fixed_image' => false]); ?>
		<?php endwhile; ?>

	</div>
	<div class="mt-3 text-center me-5 mt-5">
		<a href="<?php echo esc_url($blog_url); ?>" class="btn btn-primary">
		    <?php pll_e('Ver todas'); ?>
		</a>
	</div>
</section>


<?php wp_reset_postdata(); ?>
<?php endif; ?>
