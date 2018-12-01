<div class="col-12 col-sm-6 col-md-4 item-colaborador">
	<div class="content-colaborador">
		<div class="row align-items-center">
			<div class="col-5 col-sm-5 col-md-5">
				<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="img-fluid img-colaborador">
			</div>
			<div class="col-7 col-sm-7 col-md-7">
				<h3 class="title-colaborador">
					<a href="<?php echo get_post_meta( get_the_ID(), 'wpcf-url', true ); ?>" target="_blank">
						<?php the_title(); ?>
					</a>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<label class="nucleo-colaborador"><?php echo get_post_meta( get_the_ID(), 'wpcf-nucleo', true ); ?></label>
				<a href="<?php echo get_post_meta( get_the_ID(), 'wpcf-url', true ); ?>" target="_blank" class="url-colaborador">
					<?php echo get_post_meta( get_the_ID(), 'wpcf-url', true ); ?>					
				</a>
			</div>
		</div>
	</div>
</div>