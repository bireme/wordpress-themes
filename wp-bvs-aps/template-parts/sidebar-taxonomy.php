<aside id="secondary" class="widget-area col-sm-12 col-lg-3" role="complementary">

	<div class="sidebar-taxonomy">
		<div class="block">
			<?php $taxonomy_filter = get_queried_object(); ?>
			
			<?php if($taxonomy_filter->taxonomy == 'categoria-da-evidencia'){ ?>
			<img class="icon-block" src="<?php echo get_stylesheet_directory_uri().'/assets/img/icons/areas-tematicas.png'; ?>" alt="<?php _e('Quais as Áreas Temáticas', 'bvs_lang'); ?>?">
			<h2 class="title-block"><?php _e('Quais as Áreas Temáticas', 'bvs_lang'); ?>?</h2>
			<?php } else if($taxonomy_filter->taxonomy == 'tipo-de-profissional'){ ?>
			<img class="icon-block" src="<?php echo get_stylesheet_directory_uri().'/assets/img/icons/quem-perguntou.png'; ?>" alt="<?php _e('Quem Perguntou', 'bvs_lang'); ?>?">
			<h2 class="title-block"><?php _e('Quem Perguntou', 'bvs_lang'); ?>?</h2>
			<?php } else if($taxonomy_filter->taxonomy == 'teleconsultor'){ ?>
			<img class="icon-block" src="<?php echo get_stylesheet_directory_uri().'/assets/img/icons/quem-respondeu.png'; ?>" alt="<?php _e('Quem Respondeu', 'bvs_lang'); ?>?">
			<h2 class="title-block"><?php _e('Quem Respondeu', 'bvs_lang'); ?>?</h2>
			<?php } ?>

			<?php
			$terms = get_terms($taxonomy_filter->taxonomy, array(
			    'orderby'    => 'count',
			    'order' => 'DESC',
			    'hide_empty' => true
			));

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
			    echo '<ul class="list-terms">';

			    foreach ( $terms as $term ) {
			        echo "<li><a href='".get_term_link($term->term_id)."'>$term->name <span>($term->count)</span></a></li>";
			    }

			    echo '</ul>';
			}
			?>
		</div>
	</div>

</aside><!-- #secondary -->