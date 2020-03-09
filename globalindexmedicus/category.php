<?php get_header(); ?>

<main class="padding1" id="main_container" role="main">
	<div class="container">
		<?php while(have_posts()) : the_post(); ?>
			<h2 class="titulo1"><?php the_title(); ?></h2>
			<div class="row">
				<div class="col-12 col-md-12">
					<?php the_post_thumbnail() ?>
					<?php the_content(); ?>
				</div>
				
			</div>
		<?php endwhile; ?>

		<!-- Outros -->
		<h2 class="titulo1">Bibliotecas da OMS</h2>
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