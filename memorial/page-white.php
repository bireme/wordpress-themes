<?php
/**
 * Template: Padrão White
 * CPT: colecoes
 */
<?php get_header('home'); ?>
<?php 
$thumb = get_the_post_thumbnail_url(get_the_ID(), 'full'); 
$bg = $thumb ? $thumb : get_template_directory_uri() . '/img/header-memorial.jpg';
?>
<section id="header-title" class="pt-5 pb-5" style="background: linear-gradient(45deg, rgba(0,0,0,0.6), rgba(0,0,0,0.2)), url('<?php echo $bg; ?>') center bottom no-repeat fixed; background-size: cover;">
	<div class="container">
		<h1 class="title"><?php  the_title(); ?></h1>
		<div class="row">
			<div class="col-8">
			<?php the_excerpt(); ?>	
		</div>
	</div>
</section>
	<main id="main_container" class="mb-5">
		<div class="container">
			<div class="breadcrumb">
				<?php if (function_exists('bcn_display')) { bcn_display(); } ?>
			</div>
			<?php the_content(); ?>
		</div>
	</main>
<?php get_footer('home'); ?>