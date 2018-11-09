<div class="col-md-4 item-generic">
	<div class="content-generic">
		<h3 class="title-generic"><a href="<?php echo the_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h3>
		<hr>
		<div class="excerpt-generic">
			<?php crop_text(get_the_excerpt(get_the_ID()), 130); ?>
		</div>
		<div class="text-right">
			<a href="<?php echo the_permalink(get_the_ID()); ?>"" class="btn btn-primary btn-sm">
				<?php _e('Veja mais', 'bvs_lang'); ?> <span class="fas fa-arrow-right"></span>
			</a>
		</div>
	</div>
</div>