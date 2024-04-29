<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php 
$args = array(
	'post_type' 		=> 'post',
	's' 				=> $_GET['q'],
	'category_name' 	=> 'profissoes-da-saude',
	'posts_per_page' 	=> '-1',
);

$dicas = new WP_Query($args);
?>
<section class="margin4">
	<div class="container">
		<h1 class=" title1">Profissões da Saúde</h1><br> 
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
</section>
<?php get_footer(); ?>