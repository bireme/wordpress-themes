<div class="archiveEdital">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<? 
	$today = date("Ymd");
	$endDate = date('Ymd', strtotime(get_post_meta($post->ID, 'endDate_editais', true)));
	$startDate = date('Ymd', strtotime(get_post_meta($post->ID, 'startDate_editais', true)));
	if(($today >= $startDate) && ($today <= $endDate)) {
		$class = "open";
	} else if ($today < $startDate) {
		$class = "waiting";
	} else if ($today > $endDate) {
		$class = "closed";
	} else {
		$class = "none";
	}
	?>
	<div class="row <?php echo $class; ?>">
		<div class="title col-xl-3 cell">
			<span class="editalTitle"><a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>"><?php the_title(); ?></span><br>
			<span class="link"><a href="<?php echo get_post_meta($post->ID, 'linkUrl_01_editais', true)?>"><?php echo get_post_meta($post->ID, 'linkText_01_editais', true)?> </a></span>
		</div>
		<div class="info col-xl-4 cell">
			Objetivo: <?php echo get_post_meta($post->ID, 'objectives_editais', true)?></br>
			<?php echo get_the_term_list( $post->ID, 'agencias', 'Agência: ', ', ', '</br>'); ?>
			<?php echo get_the_term_list( $post->ID, 'publicos', 'Público-Alvo: ', ', ', '</br>'); ?>
			<?php echo get_the_term_list( $post->ID, 'institutions', 'Instituição Responsável: ', ', ', '</br>'); ?>
			<?php echo get_the_term_list( $post->ID, 'researchLines', 'Linhas de Pesquisa: ', ', ', '</br>'); ?>
			<?php echo get_the_term_list( $post->ID, 'topics', 'Temas de Interesse: ', ', ', ''); ?>
		</div>
		<div class="value col-xl-2 cell">
			Valor do Fomento: <br><strong><?php echo get_post_meta($post->ID, 'value_editais', true)?></strong>
		</div>
		<div class="date col-xl-3 cell">
			Início:  
				<strong><?php echo date('d/m/Y', strtotime(get_post_meta($post->ID, 'startDate_editais', true))); ?> </strong>
			- Fim: 
				<strong><?php echo date('d/m/Y', strtotime(get_post_meta($post->ID, 'endDate_editais', true))); ?> </strong>
		</div>	
	</div>
	<?php endwhile; else: ?>
		<p><?php _e('OPS!.'); ?></p>
	<?php endif; ?>
	<div class="spacer"></div>
	<div class="legenda">
		Legenda: <span class="open"></span>Inscrições abertas | 
		<span class="waiting"></span>Aguardando abertura de inscrições |
		<span class="closed"></span>Inscrições encerradas 
	</div>
	<div class="spacer"></div>
	<form>
	  <input type="button" value="voltar" class="backButton" onclick="history.go(-1)">
	</form>
	<div class="spacer"></div>
	

</div> 