<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<section class="margin4">
	<div class="container">
		<h4 class="title1">Resultado de Busca: <?php echo esc_html(get_query_var('s')); ?></h4>
		<?php $posts = new WP_Query([
				'post_type' => 'post',
				's' => $_GET['s'],
				'posts_per_page' => '-1'
			]);
			if($posts->have_posts()): while ($posts->have_posts()) : $posts->the_post(); ?>
				<article class="boxResultSearch">
					<a href="<?php permalink_link(); ?>">
						<b><?php the_title(); ?></b> <br>
						<small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></small>
					</a>
				</article>
			<?php endwhile; else:?>
		<?php endif;?>
		<div class="text-center">
			<?php the_posts_pagination(array('mid_size' => 2) ); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>