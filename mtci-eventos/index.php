<?php get_header('home'); ?>
<main id="main_container"class="padding1">
	<div class="container">
		<div class="row d-none">
			<div class="col-md-6 offset-md-3">
				<img src="http://logos.bireme.org/img/pt/v_bir_color.svg" class="img-fluid" id="logo-bireme" alt="Logo BIREME">
			</div>
		</div>
		<h1>Eventos</h1>
		<hr>
		<div class=" padding1 row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xl-5">
			<?php 
			$event = new WP_Query(array(
				'post_type' => 'event',
				'orderby' => 'title',
				'order'   => 'ASC',
				'posts_per_page' => -1,
			));
			while($event->have_posts()) : $event->the_post(); 
				$logo= get_field('logo');
				?>
				<div class="col margin1 img-logo-event ">
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" class="img-fluid border">
					</a>
				</div>

			<?php endwhile; ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>