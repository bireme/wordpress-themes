<?php if( have_rows('datas') ): ?>
	<?php while( have_rows('datas') ): the_row(); 
		$titulo = get_sub_field('titulo');
		?>
	<?php endwhile; ?>
<?php endif; ?>
<section class="padding1">
	<div class="container">
		<h2 class="title1-opas"><?php echo $titulo;?></h2>
		<ul class="nav nav-tabs" id="myTab" role="tablist" data-aos="fade-down">
			<?php if(have_rows('datas')): ?>
				<?php while( have_rows('datas') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
					<?php while ($count > $loop) : $loop++; ?>
						<?php
						$data = get_sub_field('data_'.$loop);
						$texto = get_sub_field('texto_'.$loop);
						?>
						<?php if ( $texto ) : ?>
							<li class="nav-item" role="presentation">
								<button class="nav-link <?=$loop=='1'?'active':''; ?>" id="day<?= $loop ?>" data-bs-toggle="tab" data-bs-target="#panel-day<?= $loop ?>" type="button" role="tab" aria-controls="day-0" aria-selected="true"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $data;  ?></button>
							</li>
						<?php endif; ?>
					<?php endwhile; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</ul>
		<div class="tab-content" id="myTabContent"data-aos="fade-up" >
			<?php if(have_rows('datas')): ?>
				<?php while( have_rows('datas') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
					<?php while ($count > $loop) : $loop++; ?>
						<?php
						$data = get_sub_field('data_'.$loop);
						$texto = get_sub_field('texto_'.$loop);
						?>
						<?php if ( $texto ) : ?>

							<div class="tab-pane fade <?=$loop=='1'?'show active':''; ?>" id="panel-day<?= $loop ?>" role="tabpanel" aria-labelledby="day<?= $loop ?>" tabindex="0">
								<?php echo $texto;  ?>
							</div>
						<?php endif; ?>
					<?php endwhile; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</section>