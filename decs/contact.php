<?php
/* Template Name: Contact */
?>
<?php get_header(); ?>
<?php get_template_part('includes/navInter') ?>
<?php $idioma = pll_current_language(); ?>
<div class="titleMain text-center">
	<h2><?php the_title(); ?></h2>	
</div>

<main id="main_container" class="padding2">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo get_option('siteurl'); ?>/<?php echo $idioma=='pt'?'':$idioma; ?>">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
			</ol>
		</nav>
		<div id="main_container">
			<div class="row">
				<?php 
				while(have_posts()) : the_post();
					$map = get_field('map');
					$form = get_field('form');
					$address = get_field('address');
					?>
					<div class="col-md-4">
						<p><?php echo $address; ?></p>
						<?php echo $map; ?>
						
					</div>
					<div class="col-md-8 marginM1">
						<?php echo $form; ?>
					</div>
				<?php endwhile;?>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>