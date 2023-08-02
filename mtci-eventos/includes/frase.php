<?php while(have_posts()) : the_post();
	$frase 			= get_field('frase');
endwhile;
?>
<section class="padding2 color1">
	<div class="container">
		<div class="row" data-aos="zoom-in">
			<div class="col-md-10  offset-md-1">
				<h3 class=" text-center h3-m"><?php echo $frase; ?></h3>
			</div>
		</div>
	</div>
</section>