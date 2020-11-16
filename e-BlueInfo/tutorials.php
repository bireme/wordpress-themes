<?php /* Template Name: Tutorials */ ?>
<?php get_header('app'); ?>
<main class="padding2 " role="main">
	<div class="container" id="main_container">
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
		<hr>
		<div class="row">
			<?php if( have_rows('group') ): ?>
				<?php while( have_rows('group') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
					<?php while ($count > $loop) : $loop++; ?>
						<?php $url_video = get_sub_field('url_video_'.$loop); ?>
						<?php $title_video = get_sub_field('title_video_'.$loop); ?>
						<?php if ( $url_video ) : ?>
							<div class="col-12 col-md-6 margin1">
								<div class="embed-responsive embed-responsive-16by9 margin1">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo get_video_code($url_video);  ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</div>
								<h4 class="text-center"><?php echo $title_video; ?></h4>
							</div>
						<?php endif; ?>
					<?php endwhile; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</main>
<?php get_footer('app'); ?>