<?php get_header(); ?>
</header>
<?php get_template_part('includes/nav') ?>
<section class="container">
	<div class="row" id="recent">
		<div class="col-md-8" id="main_container">
			<h2 class="title1">Destaques SAA Informa</h2>
			<?php get_template_part('includes/banners') ?>
		</div>
		<div class="col-md-4 d-none d-md-block" id="category">
			<ul class="list-unstyled"><?php dynamic_sidebar('categorias') ?></ul>
		</div>
	</div>
</section>
<section class="container">
	<div class="row">
		<div class="col-md-8">
			<h4 class="title1">Mais Recentes</h4>
			<div class="row">
				<div class="col-md-6 categoryHome">
					<ul>
						<?php 
						$posts = new WP_Query([
							'post_type' => 'post',
							'posts_per_page' => '5'
						]);
						while($posts->have_posts()) : $posts->the_post(); ?>
							<li><a href="<?php permalink_link(); ?>"><?php the_title(); ?></a></li>
							<?php
						endwhile;
						?>
					</ul>
				</div>
				<div class="col-md-6 categoryHome d-none d-md-block">
					<ul>
						<?php 
						$posts = new WP_Query([
							'post_type' => 'post',
							'offset'         => 5,
							'posts_per_page' => '5'
						]);
						while($posts->have_posts()) : $posts->the_post(); ?>
							<li><a href="<?php permalink_link(); ?>"><?php the_title(); ?></a></li>
							<?php
						endwhile;
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col d-block d-md-none">
			<h4 class="title1">Enquete</h4>
		</div>
		<div class="col-md-4" id="enquete">
			<div class="row">
				<div class="col-md-12" >
					<ul class="list-unstyled"><?php dynamic_sidebar('enquete') ?></ul>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>