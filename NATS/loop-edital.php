<div class="row <?php echo $class; ?>">
	<div class="title col-xl-5 cell">
		<span class="editalTitle"><?php the_title(); ?></span><br><br>
		<span class="link"><a href="<?php echo get_post_meta($post->ID, 'linkUrl_01_editais', true)?>">Veja mais... </a></span>
		<p></p>
		<div class="shareButtons">
			<b>Compartilhar:</b> 
			<a target="_blank" class="twitterButton" href="https://twitter.com/home?status=<?php the_permalink(); ?>"><span>Twitter</span></a>
			<a target="_blank" class="faceButton" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><span>Facebook</span></a>
			<a target="_blank" class="whatsAppButton" href="https://wa.me/?text=<?php the_permalink(); ?>"><span>WhatsApp</span></a>
		</div>
		
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
	<div class="date col-xl-1 cell">
		Início:<br>  
			<strong><?php echo date('d/m/Y', strtotime(get_post_meta($post->ID, 'startDate_editais', true))); ?> </strong><br>
		<p>Fim: <br>
			<strong><?php echo date('d/m/Y', strtotime(get_post_meta($post->ID, 'endDate_editais', true))); ?> </strong>
		</p>
	</div>	
</div>