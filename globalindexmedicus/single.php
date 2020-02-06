<?php get_header(); ?>

<main class="padding1"  id="main_container" role="main">
	<div class="container">
		<?php while(have_posts()) : the_post(); ?>
			<h2 class="titulo1"><?php the_title(); ?></h2>
			<div class="row">
				<div class="col-12 col-md-4">
					<?php the_post_thumbnail('Bibliotecas', array('class'=>'img-fluid')); ?>
				</div>
				<div class="col-12 col-md-8">
					<?php //the_excerpt(); ?>
					<?php the_content(); ?>
				</div>
				
			</div>

			<br>
			<!-- Opções -->
			<div class="row">
				<div class="col-md-4 paddingM1">
					<div class="area">
						<a href="">
							<img src="<?php bloginfo( 'template_directory' ); ?>/img/aboutus.svg" alt="" class="img-fluid">
							<p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio sapiente, dolore magni voluptas atque accusantium debitis quam, ab voluptatibus commodi, hic laborum explicabo! Cumque animi expedita dolor, quisquam tenetur veritatis.</p>
						</a>
					</div>
				</div>
				<div class="col-md-4 paddingM1">
					<div class="area">
						<a href="">
							<img src="<?php bloginfo( 'template_directory' ); ?>/img/search2.svg" alt="" class="img-fluid">
							<p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio sapiente, dolore magni voluptas atque accusantium debitis quam, ab voluptatibus commodi, hic laborum explicabo! Cumque animi expedita dolor, quisquam tenetur veritatis.</p>
						</a>
					</div>
				</div>
				<div class="col-md-4 paddingM1">
					<div class="area">
						<a href="">
							<img src="<?php bloginfo( 'template_directory' ); ?>/img/data.svg" alt="" class="img-fluid">
							<p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio sapiente, dolore magni voluptas atque accusantium debitis quam, ab voluptatibus commodi, hic laborum explicabo! Cumque animi expedita dolor, quisquam tenetur veritatis.</p>
						</a>
					</div>
				</div>
			</div>
			<br>
		<?php endwhile; ?>

		<!-- Outros -->
		<h2 class="titulo1">Outros</h2>
		<div class="row text-center">
			<?php 
			$x = get_the_title();
			$biblioteca = new WP_Query([
				'post_type' => 'biblioteca'
			]);
			while($biblioteca->have_posts()) : $biblioteca->the_post();
				 if(get_the_title()==$x){$biblioteca->the_post();}
				?>
				<div class="col-4 col-md-2">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('Bibliotecas', array('class'=>'img-fluid')); ?>
						<h6><?php the_title(); ?></h6>
					</a>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>