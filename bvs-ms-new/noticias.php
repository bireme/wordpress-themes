<?php /* Template Name: Notícias */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php 
$args = array(
	'post_type' 		=> 'post',
	's' 				=> $_GET['q'],
	'category_name'  	=> 'ultimas-noticias',
	'posts_per_page' 	=> '-1',
);
$noticias = new WP_Query($args);
?>
<section class="padding1">
	<div class="container">
		<h2 class="title1">Notícias</h2> <br>
		<form role="search" method="get" class="search-form form-row" action="">
			<div class="form-group col-md-9">
				<input type="search" class="form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="q" title="<?php _ex( 'Search for:', 'label'); ?>">
			</div>
			<div class="form-group col-md-3">
				<input type="submit" class="btn btn-success btn-block" value="<?php echo esc_attr_x( 'Search', 'submit button'); ?>">
			</div>
		</form>
		<div class="row">
			<?php 
			while($noticias->have_posts()) : $noticias->the_post();?>
				<article class="col-12 col-md-6 col-lg-4 clippingNews boxClipping">
					<a href="<?php permalink_link(); ?>">
						<!-- <img src="img/news1.jpg" alt="" class="img-fluid"> -->
						<h4><?php the_title(); ?></h4>
						<div class="slideNewsDate"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></div>
					</a>
				</article>
				<?php
			endwhile;
			?>
		</div>
	</div>
</section>
<?php get_footer(); ?>