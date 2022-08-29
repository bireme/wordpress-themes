<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>

<section class="margin4">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1 class="title1"><?php the_title(); ?></h1> <br>
				<?php while(have_posts()) : the_post();	?>
					<?php the_post_thumbnail('medium',['class' => 'img-fluid imgPost']); ?>
					<?php the_content();
				endwhile;
				?>
			</div>
		</div>
	</div>
</section>
<div class="color1">
<?php get_template_part('includes/noticias') ?>
</div>
<?php get_footer(); ?>