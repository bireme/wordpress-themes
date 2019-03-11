<div class="col-12 col-sm-6 col-md-3 item-colaborador">
	<a href="<?php echo get_post_meta( get_the_ID(), 'wpcf-url', true ); ?>" target="_blank">
		<div class="content-colaborador">
			<div class="row align-items-center">
				<div class="col-12 col-sm-12 col-md-12 img-container">
					<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="img-fluid img-colaborador">
				</div>
				<div class="col-12 col-sm-12 col-md-12">
					<h3 class="title-colaborador">
						<?php the_title(); ?>
					</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 url-nucleo">
					<label class="nucleo-colaborador"><?php echo get_post_meta( get_the_ID(), 'wpcf-nucleo', true ); ?></label>
				</div>
			</div>
		</div>
	</a>
</div>
