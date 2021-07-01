<?php /* Template Name: Format Details */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<section class="padding2 sectionAlternate" id="introducao">
	<div id="main_container" class="container">
		<h1 class=" title1"><?php the_title(); ?></h1><br> 
		<?php while(have_posts()) : the_post();?>
			<?php the_content(); ?>
		<?php endwhile; ?>

		<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
			<?php if( have_rows('group_1') ): ?>
				<?php while( have_rows('group_1') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
					<?php while ($count > $loop) : $loop++; ?>
						<?php
						$title = get_sub_field('title_'.$loop);
						?>
						<?php if ( $title ) : ?>
							<li class="nav-item" role="presentation">
								<button class="nav-link <?=$loop=='1'?'active':''; ?>" id="<?=$title ?>-tab" data-bs-toggle="tab" data-bs-target="#<?=$title ?>" type="button" role="tab" aria-controls="<?=$title ?>" aria-selected="true"><?=$title ?></button>
							</li>
						<?php endif; ?>
					<?php endwhile; ?>
				<?php endwhile; ?>
			<?php endif; ?>

		</ul>
		<div class="tab-content" id="myTabContent">
			<?php if( have_rows('group_1') ): ?>
				<?php while( have_rows('group_1') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
					<?php while ($count > $loop) : $loop++; ?>
						<?php
						$title = get_sub_field('title_'.$loop);
						$text = get_sub_field('text_'.$loop);
						?>
						<?php if ( $text ) : ?>
							<div class="tab-pane fade <?=$loop=='1'?'show active':''; ?>" id="<?=$title ?>" role="tabpanel" aria-labelledby="<?=$title ?>-tab">
								<?=$text ?>
							</div>
						<?php endif; ?>
					<?php endwhile; ?>
				<?php endwhile; ?>
			<?php endif; ?>

		</div>

		<br><br>
		<?php while(have_posts()) : the_post();
			$title_1 = get_field('title_1'); 
			$text_1 = get_field('text_1'); 
		?>
			
			<h2><?=$title_1  ?></h2>
			<?=$text_1  ?>

		<?php endwhile; ?>
	</div>
</section>


<?php get_footer(); ?>