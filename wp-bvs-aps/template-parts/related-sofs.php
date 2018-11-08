<?php
$term_list = wp_get_post_terms( get_the_ID(), 'categoria-da-evidencia', array( 'fields' => 'all' ) );
$terms_id = array();

if( !empty($term_list) ):
	foreach($term_list as $term) $terms_id[] = $term->term_id;

	$args_sof = array(
			'tax_query' => array(
			array(
				'taxonomy' => 'categoria-da-evidencia',
				'field'    => 'term_id',
				'terms'    => $terms_id,
				'operator' => 'IN',
			),
		),
			'post__not_in' => array(get_the_ID()),
			'showposts' => 5,
			'caller_get_posts'=> 1
		);

	$sofs = new WP_Query( $args_sof );

	if ( $sofs->have_posts() ) : ?>

		<section id="related-sofs" class="col-md-12">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h2 class="title-section"><?php _e('SOF Relacionadas', 'bvs_lang'); ?></h2>
						<h3 class="subtitle-section"><?php _e('Perguntas e respostas da SOF relacionadas a', 'bvs_lang'); ?> <strong><?php echo get_the_term_list(get_the_ID(), 'categoria-da-evidencia', '', ', '); ?></strong></h3>
					</div>
				</div>

				<div class="row">
					<?php while ( $sofs->have_posts() ) : $sofs->the_post(); 

							get_template_part('template-parts/item-sof', 'home');

						endwhile; ?>
						<?php wp_reset_postdata(); ?>			
				</div>

				<div class="row">
					<div class="col-md-8">
						<p class="feed-rss"><?php _e('Quero receber as <b>últimas SOF</b> por', 'bvs_lang'); ?> <a target="_blank" href="<?php bloginfo('rss2_url'); ?>?post_type=aps"><u>RSS</u> <span class="fas fa-rss-square"></span></a></p>
					</div>
					<div class="col-md-4 text-right">
						<a href="<?php echo get_term_link($terms_id[0]); ?>" class="btn btn-primary btn-sm">
							<?php _e('Mais SOFs Relacionadas', 'bvs_lang'); ?> <span class="fas fa-arrow-right"></span>
						</a>
					</div>
				</div>
			</div>
		</section>

	<?php endif; ?>
<?php endif; ?>