<div class="col-md-4 item-sof">
	<div class="content-sof">
		<label class="date-sof"><?php echo get_the_date('d M Y', get_the_ID()); ?></label>
		<label class="nucleo-sof"><?php echo get_the_term_list(get_the_ID(), 'teleconsultor', '', ', '); ?></label>
		<h3 class="title-sof"><a href="<?php echo the_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h3>
		<hr>
		<label class="area-tematica-sof"><?php echo get_the_term_list(get_the_ID(), 'categoria-da-evidencia', '', ', '); ?></label>
		<label class="ciap2-sof">
			<strong>CIAP2:</strong> <?php echo get_the_term_list(get_the_ID(), 'ciap2', '', ', '); ?>
		</label>
		<label class="decs-mesh-sof">
			<strong>DeCS/MeSH:</strong> <?php echo get_the_term_list(get_the_ID(), 'decs', '', ', '); ?>
		</label>
		<div class="text-right d-block d-sm-block d-md-none">
			<a href="<?php echo the_permalink(get_the_ID()); ?>"" class="btn btn-primary btn-sm">
				<?php _e('Veja mais', 'bvs_lang'); ?> <span class="fas fa-arrow-right"></span>
			</a>
		</div>
	</div>
</div>