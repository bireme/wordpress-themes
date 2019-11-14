<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<section class="container">
	<div class="row" id="main_container">
		<div class="col-md-12">
			<h4 class="title1"><?php the_title(); ?></h4>
			<?php while(have_posts()) : the_post();
				$qrcode = get_field('qr_code');
				?>
				
				<?php the_post_thumbnail('large',['class' => 'img-fluid  imgPost']); ?>
				<?php the_content();
				//echo get_field('qr_code');
			endwhile;
			?>
		</div>
	</div>
</section>
<?php get_footer(); ?>