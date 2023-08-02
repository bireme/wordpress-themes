<section class="padding1 color4">
	<div class="container">
		<div class="row row-cols-1 row-cols-md-3 margin-mobile1">
			<?php if(have_rows('videos')) : ?>
				<?php while( have_rows('videos') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
					<?php while ($count > $loop) : $loop++; ?>
						<?php
						$video = get_sub_field('video_'.$loop);
						$capa_video = get_sub_field('capa_video_'.$loop);
						?>
						<?php if ( $video ) : ?>
							<div class="col margin-mobile1">
								<video src="<?php echo $video; ?>" controls class="video100" poster="<?php echo $capa_video['url']; ?>"></video>
							</div>
						<?php endif; ?>
					<?php endwhile; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</section>