<?php get_header();?>

		<div id="content">
			<div class="c-ajusta">
				<section id="main">
					<?php if (have_posts()): while (have_posts()) : the_post();?>
						<h1 class="h2-home"><?php the_title();?></h1>
						<span class="s-recents-data"><?php the_time('d/m/Y');?> - <?php the_time('g:i');?></span>

						<div id="page" class="row-fluid margin-top10">
							<?php the_content();?>
						</div>

					<?php endwhile; else:?>
					<?php endif;?> 
				</section>
				
				<?php get_sidebar();?>
			</div>
		</div>

<?php get_footer();?>
