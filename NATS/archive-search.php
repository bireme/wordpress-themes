<!DOCTYPE html>
<?php 

get_header();?> 

<div id="primary" class="col-md-12 archive">
	<h3>Resultados de Pesquisa para: <i>"<?php the_search_query(); ?>"</i> em Editais</h3>

</div>

<div class="archiveEdital">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script>
	   $(document).ready(function() {
		 $(".showOpen").click(function () {
				$(".row.open").show("slow");
				$(".row.waiting").hide("slow");
				$(".row.closed").hide("slow");
			});
		 $(".showWaiting").click(function () {
				$(".row.waiting").show("slow");
				$(".row.open").hide("slow");
				$(".row.closed").hide("slow");
			});
		 $(".showClosed").click(function () {
				$(".row.closed").show("slow");
				$(".row.waiting").hide("slow");
				$(".row.open").hide("slow");
			});
		 $(".showAll").click(function () {
				$(".row.closed").show("slow");
				$(".row.waiting").show("slow");
				$(".row.open").show("slow");
			});
			
	   });

	</script>  
	<div class="legenda">
		<a class="showOpen"><span class="open"></span>Inscrições abertas</a> | 
		<a class="showWaiting"><span class="waiting"></span>Aguardando abertura de inscrições</a> |
		<a class="showClosed"><span class="closed"></span>Inscrições encerradas</a> | 
		<a class="showAll">Ver Todos</a> 
	</div>
	<div class="spacer"></div>
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
	<? include 'loop-edital.php'; ?>
	<?php endwhile; else: ?>
		<p><?php _e('Nenhum resultado encontrado!.'); ?></p>
	<?php endif; ?>
	<div class="spacer"></div>
	<form>
	  <input type="button" value="voltar" class="backButton" onclick="history.go(-1)">
	</form>
	<div class="spacer"></div>
	

</div> 
	
<?php
get_footer(); 
?>
