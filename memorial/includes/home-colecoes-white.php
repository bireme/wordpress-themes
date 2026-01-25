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
				<a  href="<?php the_permalink(); ?>">
					<h3 class="colecao-title"><?php the_title(); ?></h3>
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
		background: #fff;
		height: 100%;
		margin: 0 10px;
	}
	.colecao-title {
		margin-top: 10px;
		font-size: 24px;
	}
	.colecao-card a{
		color: #000;
	}
	.colecao-card a:hover{
		color: #999;
	}
	.colecao-thumb img {
		display: block;
		width: 100%;
		height: auto;
	}

</style>