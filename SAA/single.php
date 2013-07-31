<?php get_header();?>

		<div id="content">
			<div class="c-ajusta">
				<section id="main">
					<?php if (have_posts()): while (have_posts()) : the_post();?>
						<span class="s-recents-h3"><?php the_category(', ');?></span>
						<h1 class="h2-home"><?php the_title();?></h1>
						<span class="s-recents-data"><?php the_time('d/m/Y');?> - <?php the_time('G\hi'); ?></span>

						<div id="single" class="row-fluid margin-top10">
							<?php if ( has_post_thumbnail() ) {
								the_post_thumbnail('medium', array('class' => 'pull-left-img img-single'));
							}else{
								echo "<img src='http://www.kross.pl/sites/default/files/styles/bike_zoom/public/default_images/proj_no_photo.png' class='pull-left-img img-single' alt='No Photo'>";
							} ?>

							<?php the_content();?>

							<div class="comentarios row-fluid">
								<?php comments_template(); ?>
							</div>
						</div>

					<?php endwhile; else:?>
					<?php endif;?> 
				</section>
				
				<?php get_sidebar();?>
			</div>
		</div>

<?php get_footer();?>
