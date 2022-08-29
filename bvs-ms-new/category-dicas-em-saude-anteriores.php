<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php 
$args = array(
	'post_type' 		=> 'post',
	's' 				=> $_GET['q'],
	'category_name' 	=> 'dicas-em-saude-anteriores',
	'posts_per_page' 	=> '-1',
);

$dicas = new WP_Query($args);
?>
<section class="margin4">
	<div class="container">
		<h1 class=" title1">Dicas em Saúde</h1><br> 
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
			while($dicas->have_posts()) : $dicas->the_post(); ?>
				<div class="col-md-12">
					<article class="boxBoletim">
						<div class="row">
							<div class="col-4 col-md-3">
								<?php
								if (has_post_thumbnail()) { 
									the_post_thumbnail('medium',['class' => 'img-fluid']);
								}else{ ?>
									<img src="<?php bloginfo('template_directory')?>/img/temaIndisponivel2.jpg" class="img-fluid rounded" alt="sem fotos">
								<?php }
								?>
							</div>
							<div class="col-8  col-md-9">
								<a href="<?php permalink_link(); ?>">
									<h5><?php the_title(); ?></h5>
									<p><?php  echo substr(get_the_excerpt(),0,300); ?>[...]</p>
									<i class="far fa-calendar-alt"></i> <?php echo get_the_date(); ?> - <i class="far fa-clock"></i>
									<?php the_time(); ?>
								</a>
							</div>
						</div>
						
					</article>
				</div>	
			<?php endwhile;	?>
		</div>	
		<?php // the_posts_pagination( array('mid_size' => 2) ); ?>
	</div>
</div>
</section>
<?php get_footer(); ?>