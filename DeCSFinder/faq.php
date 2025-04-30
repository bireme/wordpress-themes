<?php /* Template Name: FAQ */ ?>
<?php get_header(); ?>


<div id="highlights" class="header-inter m">
	<div class="container">
		<h1><?php the_title() ?></h1>
	</div>
</div>
<main id="main" class="ptb-50">
	<div class="container">
		<?php the_content(); ?>

		<?php if( have_rows('accordion_items') ): ?>
			<div class="accordion" id="accordionExample">
				<?php $i = 0; while( have_rows('accordion_items') ): the_row(); 
				$title = get_sub_field('title');
				$content = get_sub_field('content');
				$id = 'item-' . $i;
				?>
				<div class="accordion-item">
					<h2 class="accordion-header" id="heading-<?php echo $id; ?>">
						<button class="accordion-button <?php echo $i > 0 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $id; ?>" aria-expanded="<?php echo $i == 0 ? 'true' : 'false'; ?>" aria-controls="collapse-<?php echo $id; ?>">
							<?php echo esc_html($title); ?>
						</button>
					</h2>
					<div id="collapse-<?php echo $id; ?>" class="accordion-collapse collapse <?php echo $i == 0 ? 'show' : ''; ?>" aria-labelledby="heading-<?php echo $id; ?>" data-bs-parent="#accordionExample">
						<div class="accordion-body">
							<?php echo wp_kses_post($content); ?>
						</div>
					</div>
				</div>
				<?php $i++; endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
