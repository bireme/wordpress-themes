<section id="ultimas-sofs" class="col-md-12">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="title-section"><?php _e('Fique por dentro', 'bvs_lang'); ?></h2>
				<h3 class="subtitle-section"><?php _e('Acesse as últimas SOF publicadas na BVS APS', 'bvs_lang'); ?></h3>
			</div>
		</div>

		<div class="row">
			<?php
			$args_sof = array(
				'posts_per_page' => 4,
				'post_type'  => 'aps',
				'orderby' => 'date',
				'order'   => 'DESC',
			);
			$sofs = new WP_Query( $args_sof );
			?>

			<?php if ( $sofs->have_posts() ) : 
				while ( $sofs->have_posts() ) : $sofs->the_post(); 

					get_template_part('template-parts/item-sof', 'home');

				endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>

		<div class="row">
			<div class="col-md-8">
				<p class="feed-rss"><?php _e('Quero receber as <b>últimas SOF</b> por', 'bvs_lang'); ?> <a target="_blank" href="<?php bloginfo('rss2_url'); ?>?post_type=aps"><u>RSS</u> <span class="fas fa-rss-square"></span></a></p>
			</div>
			<div class="col-md-4 grid-btn">
				<a href="<?php echo get_post_type_archive_link('aps'); ?>" class="btn btn-primary btn-sm">
					<?php _e('Veja mais', 'bvs_lang'); ?> <span class="fas fa-arrow-right"></span>
				</a>
			</div>
		</div>
	</div>
</section>