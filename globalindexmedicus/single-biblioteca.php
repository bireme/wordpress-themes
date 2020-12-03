<?php get_header(); ?>
<main class="padding1" id="main_container" role="main">
	<div class="container">
		<?php while(have_posts()) : the_post(); ?>
			<h2 class="titulo1" tabindex="10"><?php the_title(); ?></h2>
			<div class="row">
				<div class="col-12" data-aos="fade-up" tabindex="11">
					<?php the_content(); ?>
				<hr><div class="clearfix"><?php echo do_shortcode('[DISPLAY_ULTIMATE_SOCIAL_ICONS]'); ?></div><br>
				</div>
			</div>
			<br>
		<?php endwhile; ?>

		<!-- Outros -->
		<h2 class="titulo1"><p><?php pll_e('World Health Organization'); ?></p></h2>
		<div class="row text-center" id="outros">
			<?php 
			$x = get_the_title();
			$biblioteca = new WP_Query(array(
				'post_type' => 'biblioteca',
				'orderby' => 'title',
    			'order'   => 'ASC'
			));
			$i = 1;
			while($biblioteca->have_posts()) : $biblioteca->the_post();
				if(get_the_title()==$x){$biblioteca->the_post();}
				?>
				<div class="col-4 col-md-2" data-aos="zoom-in" data-aos-delay="<?php echo $i ?>00">
					<a href="<?php the_permalink(); ?>" role="link">
						<?php the_post_thumbnail('Bibliotecas', array('class'=>'img-fluid')); ?>
						<h6><?php the_title(); ?></h6>
					</a>
				</div>
			<?php
				$i++;
				endwhile;
			?>
		</div>
	</div>
</main>
<?php get_footer(); ?>