<?php	
	//Template part 
	// portfolio_archive_part.php
?>
	<div class="archivePortfolio">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="row row_patents">
			<div class="title col-xl-12 cell">
				<h4 class="editalTitle"><a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>"><?php the_title(); ?></h4>
				<?php echo get_the_term_list( $post->ID, 'nucleos', '<b>Núcleo:</b> ', ', ', '<br>'); ?>
				<?php echo get_the_term_list( $post->ID, 'tipos', '<b>Tipo:</b> ', ', ', '<br>'); ?>
				<b>Diferencial:</b><br><?php echo get_post_meta($post->ID, 'advantage_portfolios', true)?> <br>

			</div>	
		</div>
		<?php endwhile; else: ?>
			<p><?php _e('OPS!.'); ?></p>
		<?php endif; ?>
		<form>
		  <input type="button" value="voltar" class="backButton" onclick="history.go(-1)">
		</form>
	</div> 
