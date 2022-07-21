<?php /* Template Name: Home Page */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php $language = pll_current_language(); ?>
<?php
$posts = new WP_Query([
	'post_type' => 'acessor',
	'posts_per_page' => '3'
]);
?>
<?php 
$linkCA = get_field('link_comite_assessor'); 
$linkCC = get_field('link_comite_cientifico'); 
$documentos_de_referencia = get_field('documentos_de_referencia'); 
?>
<main id="main_container" class="margin1 padding2">
	<div class="container">
		<?php the_content(); ?>
		<hr class="text-prymary border-2 opacity-25">
		<div class="row">
			<div class="col-md-6 marginM1">
				<h2 class="title1"><?php pll_e('Advisory Committee'); ?></h2>
				<?php 
				$acessor = get_the_title();
				$posts = new WP_Query([
					'post_type' => 'acessor',
					'posts_per_page' => '3'
				]);
				while($posts->have_posts()) : $posts->the_post();?>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br><?php the_excerpt(); ?>
				<?php endwhile;	?>
				<a class="btn btn-sm btn-warning" href="<?php echo $linkCA; ?>"><?php pll_e('View more'); ?></a>
			</div>
			<div class="col-md-6 marginM1">
				<h2 class="title1"><?php pll_e('Scientific Comittee'); ?></h2>
				<?php 
				$cientifico = get_the_title();
				$posts = new WP_Query([
					'post_type' => 'cientifico',
					'posts_per_page' => '3',
				]);
				while($posts->have_posts()) : $posts->the_post();?>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br><?php the_excerpt(); ?>
				<?php endwhile;	?>
				<a class="btn btn-sm btn-warning" href="<?php echo $linkCC; ?>"><?php pll_e('View more'); ?></a>
			</div>
			<div class="col-md-6 list-news">
				<hr>
				<h2 class="title1"><?php pll_e('Reference Documents'); ?></h2>
				<?php echo $documentos_de_referencia; ?>
			</div>
			<div class="col-md-6 list-news">
				<hr>
				<h2 class="title1"><?php pll_e('News'); ?></h2>
				<ul class="list-unstyled"><?php dynamic_sidebar('home_widget') ?></ul>
				<a class="btn btn-sm btn-warning" href="https://boletin.bireme.org<?php echo $language=='es'?'':'/'.$language.'/'; ?>" target="_blank"><?php pll_e('View more'); ?></a>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>
