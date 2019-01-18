<?php	
	//Template part 
	// portfolio_archive_part.php
?>
	<div class="archivePortfolio">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="row row_patents">
			<div class="title col-xl-2 cell">
				<span class="editalTitle"><a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>"><?php the_title(); ?></span><br><br>
				<b>Inventores:</b><br> <?php echo get_post_meta($post->ID, 'inventors_portfolios', true)?>
			</div>
			<div class="info col-xl-2 cell">
				<?php echo get_the_term_list( $post->ID, 'nucleos', '<b>Núcleos:</b> <br>', ', ', '<br>'); ?>
				<?php echo get_the_term_list( $post->ID, 'temas', '<b>Temas:</b> <br>', ', ', '<br>'); ?>
			</div>
			<div class="date col-xl-2 cell">
				<b>Problema a ser resolvido:</b><br> <?php echo get_post_meta($post->ID, 'problem_portfolios', true)?>
			</div>
			<div class="date col-xl-2 cell">
				<b>Inovação da Proposta:</b><br> <?php echo get_post_meta($post->ID, 'innovation_portfolios', true)?>
			</div>
			<div class="date col-xl-2 cell">
				<b>Diferencial:</b><br><?php echo get_post_meta($post->ID, 'advantage_portfolios', true)?> <br><br>
				<b>Status da Propriedade Intelectual:</b> <br><?php echo get_post_meta($post->ID, 'status_portfolios', true)?>
			</div>
			<div class="value col-xl-2 cell">
				<b>O que buscamos: </b><br><?php echo get_post_meta($post->ID, 'seek_portfolios', true)?><br><br>
			</div>	
		</div>
		<?php endwhile; else: ?>
			<p><?php _e('OPS!.'); ?></p>
		<?php endif; ?>
		<form>
		  <input type="button" value="voltar" class="backButton" onclick="history.go(-1)">
		</form>
	</div> 
