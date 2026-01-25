<?php
$args = [
	'post_type'      => 'colecoes',
	'post_status'    => 'publish',
	'posts_per_page' => 6,
	'orderby'        => 'date',
	'order'          => 'DESC',
];

$q = new WP_Query($args);

if ($q->have_posts()) : ?>
	<div class="colecoes-slider">
		<?php while ($q->have_posts()) : $q->the_post(); ?>
			<article class="colecao-card">

				<div class="colecao-thumb">
					<a href="<?php the_permalink(); ?>" aria-label="Abrir <?php the_title_attribute(); ?>">
						<?php if (has_post_thumbnail()) : ?>
							<?php the_post_thumbnail('medium_large'); ?>
						<?php else : ?>
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/placeholder.png'); ?>" alt="">
						<?php endif; ?>
					</a>
				</div>
				<h3 class="colecao-title"><?php the_title(); ?></h3>
				<div class="colecao-excerpt">
					<?php echo wp_kses_post(get_the_excerpt()); ?>
				</div>

				<a class="btn btn-primary" href="<?php the_permalink(); ?>">
					Ver detalhes
				</a>
			</article>
		<?php endwhile; ?>
	</div>
	<?php
endif;
wp_reset_postdata();
?>
<style>
	.colecao-card {
		padding: 16px;
		border: 1px solid #e6e6e6;
		border-radius: 12px;
		background: #fff;
		height: 100%;
		margin: 0 10px;
	}

	.colecao-title {
		margin: 10px 0;
		font-size: 24px;
	}

	.colecao-thumb img {
		display: block;
		width: 100%;
		height: auto;
		border-radius: 10px;
	}

	.colecao-excerpt {
		margin: 10px 0;
		font-size: 18px;
		line-height: 1.4;
	}

	.colecao-link {
		display: inline-block;
		margin-top: 12px;
		text-decoration: none;
		font-weight: 600;
	}

</style>