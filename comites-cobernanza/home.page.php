<?php /* Template Name: Home Page */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php $language = pll_current_language(); ?>
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
				<a class="btn btn-sm btn-warning" href="ca/<?php echo $language==''?'es':$language; ?>"><?php pll_e('View more'); ?></a>
			</div>
			<div class="col-md-6 marginM1">
				<h2 class="title1"><?php pll_e('Scientific Comittee'); ?></h2>
				<?php 
				$cientifico = get_the_title();
				$posts = new WP_Query([
					'post_type' => 'cientifico',
					'posts_per_page' => '3'
				]);
				while($posts->have_posts()) : $posts->the_post();?>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br><?php the_excerpt(); ?>
				<?php endwhile;	?>
				<a class="btn btn-sm btn-warning" href="cc-ca/<?php echo $language==''?'es':$language; ?>"><?php pll_e('View more'); ?></a>
			</div>
			<div class="col-md-12 list-news">
				<hr>
				<h2 class="title1">Noticias</h2>
				<ul class="list-unstyled"><?php dynamic_sidebar('home_widget') ?></ul>
				<a class="btn btn-sm btn-warning" href="https://boletin.bireme.org/pt/?s=Comit%C3%AA+Cient%C3%ADfico" target="_blank"><?php pll_e('View more'); ?></a>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>