<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php 
$args = array(
	'post_type' 		=> 'post',
	'category_name' 	=> 'profissoes-da-saude',
	'posts_per_page' 	=> '-1',
	'orderby'			=> 'title',
	'order'				=> 'ASC',
);

$dicas = new WP_Query($args);
?>
<section class="margin4">
	<div class="container">
		<h1 class=" title1">Profissões da Saúde</h1><br> 
		<?php 
		while($dicas->have_posts()) : $dicas->the_post(); ?>
			<article class="boxBoletim">
				<div class="col">
					<a href="<?php permalink_link(); ?>">
						<h5><?php the_title(); ?></h5>
						<p><?php  echo substr(get_the_excerpt(),0,300); ?>[...]</p>
					</a>
				</div>		
			</article>
		<?php endwhile;	?>
	</div>
</section>
<?php get_footer(); ?>