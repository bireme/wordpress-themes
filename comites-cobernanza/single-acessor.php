<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="margin1 padding2">
		<div class="container">
			<div class="text-center">
				<h1 class="text-center"><?php the_title(); ?></h1>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-8">
					<?php the_content(); ?>
				</div>
				<div class="col-md-4 box-news">
					<?php the_field('detalhes'); ?>
				</div>
			</div>
			<hr>
			
		</div>
	</main>
<?php get_footer(); ?>