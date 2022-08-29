<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php 
$args = array(
	'post_type' 		=> 'post',
	's' 				=> $_GET['q'],
	'posts_per_page' 	=> '-1',
	'orderby'			=> 'title',
	'order' 			=> 'ASC',
);
if(!$_GET['q']){
	$args['post__in'] = array(0);
}
$boletim = new WP_Query($args);
?>
<section class="margin4">
	<div class="container">
		<div class="row">
			<nav class="col-md-3 navBoletim" >
				<?php
				wp_nav_menu(array(
					'theme_location'    => 'boletim-nav',
					'depth'             => 2,
					'container'         => 'div',
					'container_class'   => 'navBoletimUl',
				));
				?>
			</nav>
			<div class="col-md-9">
				<h1 class=" title1"><?php the_title(); ?></h1><br>
				<form role="search" method="get" class="search-form form-row" action="">
					<div class="form-group col-md-9">
						<input type="search" class="form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="q" title="<?php _ex( 'Search for:', 'label'); ?>">
					</div>
					<div class="form-group col-md-3">
						<input type="submit" class="btn btn-success btn-block" value="<?php echo esc_attr_x( 'Search', 'submit button'); ?>">
					</div>
				</form>
				<?php 
				while($boletim->have_posts()) : $boletim->the_post(); ?>
					<article class="boxBoletim">
						<a href="<?php permalink_link(); ?>">
							<h5><?php the_title(); ?></h5>
							<i class="far fa-calendar-alt"></i> <?php echo get_the_date(); ?> - <i class="far fa-clock"></i>
							<?php the_time(); ?>
						</a>
					</article>
				<?php  endwhile; ?>
			</div>	
		</div>
	</div>
</section>
<?php get_footer(); ?>