<?php
/***
Template Name: Home
***/
?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php
$home = new WP_Query([ 'post_type' => 'Home']);
while($home->have_posts()):$home->the_post();
	while(have_rows('group_1')):the_row(); 
		$title = get_sub_field('title'); 
		$text = get_sub_field('text'); 
		?>
		<section class="padding2" id="main_container">
			<div class="container">
				<h1 class="title1"><?php echo $title ?></h1>
				<div class="row">
					<div class="col-md-8">
						<?php echo $text ?>
					</div>
					<div class="col-md-4">
						<img src="<?php bloginfo('template_directory') ?>/img/search.png" class="img-fluid" alt="">
					</div>
				</div>
			</div>
		</section>
		<?php
	endwhile;
endwhile;
?>

<?php
while($home->have_posts()):$home->the_post();
	while(have_rows('group_2')):the_row(); 
		$title = get_sub_field('title'); 
		$text = get_sub_field('text'); 
		?>
		<section class="padding2 color1" id="howtoUse">
			<div class="container">
				<h1 class="title1"><?php echo $title ?></h1>
				<?php echo $text ?>
			</div>
		</section>
		<?php
	endwhile;
endwhile;
?>


<?php 
while($home->have_posts()):$home->the_post();
	if( $home->have_rows('group_faq') ): while ( $home->have_rows('group_faq') ) : the_row(); $title = get_sub_field('text_1'); endwhile; endif; ?>
	<section class="padding2 <?php echo $title==''?'d-none':''; ?>">
		<div class="container">
			<h1 class="title1">FAQ</h1>
			<div class="accordion" id="accordionExample">
				<?php if( have_rows('group_faq') ): ?>
					<?php while( have_rows('group_faq') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
						<?php while ($count > $loop) : $loop++; ?>
							<?php
							$title = get_sub_field('title_'.$loop);
							$text = get_sub_field('text_'.$loop);
							?>
							<?php if ( $text ) : ?>

								<div class="accordion-item">
									<h2 class="accordion-header" id="heading_<?= $loop ?>">
										<button class="accordion-button <?=$loop=='1'?'':'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?= $loop ?>" aria-expanded="<?=$loop=='1'?'true':'false'; ?>" aria-controls="collapse_<?= $loop ?>">
											<?php echo $title;  ?>
										</button>
									</h2>
									<div id="collapse_<?= $loop ?>" class="accordion-collapse collapse <?=$loop=='1'?'show':''; ?>" aria-labelledby="heading_<?= $loop ?>" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<?php echo $text;  ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endwhile; ?>
					<?php endwhile; ?>
				<?php endif; ?>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>