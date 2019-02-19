<div class="col-md-3 item-sof-home">
	<div class="content-sof">
		<label class="date-sof"><?php echo get_the_date('d M Y', get_the_ID()); ?></label>
		<label class="nucleo-sof"><?php echo get_the_term_list(get_the_ID(), 'teleconsultor', '', ', '); ?></label>
		<h3 class="title-sof"><a href="<?php echo the_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h3>
		<div class="excerpt-sof">
			<?php crop_text(get_the_excerpt(get_the_ID()), 130); ?>
		</div>
	</div>
</div>