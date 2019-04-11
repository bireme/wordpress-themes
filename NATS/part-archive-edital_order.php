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
		<a href="." alt="."></a>
		<a class="showOpen"><span class="open"></span>Inscrições abertas</a> | 
		<a class="showWaiting"><span class="waiting"></span>Aguardando abertura de inscrições</a> |
		<a class="showClosed"><span class="closed"></span>Inscrições encerradas</a> | 
		<a class="showAll">Ver Todos</a> 
	</div>
	<div class="spacer"></div>
	<?php
		$args = array(
		'numberposts'	=> -1,
		'order'         => 'DESC',
		'meta_key'      => 'endDate_editais',
		'orderby'       => 'endDate_editais',
		'post_status'   => 'publish',
		'post_type'     => 'edital',
	);
	// The Query
	$the_query = new WP_Query( $args );
	// The Loop
	if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$today = date("Ymd");
			$endDate = date('Ymd', strtotime(get_post_meta($post->ID, 'endDate_editais', true)));
			$startDate = date('Ymd', strtotime(get_post_meta($post->ID, 'startDate_editais', true)));
			if(($today >= $startDate) && ($today <= $endDate)) {
				$class = "open";
				?>
				<? include 'loop-edital.php'; ?>
				<?
			} else {
				$class = "none";
			}
		}
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		// no posts found
	}
	?>
	<?php
		$args = array(
		'numberposts'	=> -1,
		'order'         => 'DESC',
		'meta_key'      => 'endDate_editais',
		'orderby'       => 'endDate_editais',
		'post_status'   => 'publish',
		'post_type'     => 'edital',
	);
	// The Query
	$the_query = new WP_Query( $args );
	// The Loop
	if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$today = date("Ymd");
			$endDate = date('Ymd', strtotime(get_post_meta($post->ID, 'endDate_editais', true)));
			$startDate = date('Ymd', strtotime(get_post_meta($post->ID, 'startDate_editais', true)));
			if($today < $startDate) {
				$class = "waiting";
				?>
				<? include 'loop-edital.php'; ?>
				<?
			} else {
				$class = "none";
			}
		}
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		// no posts found
	}
	?>
	<?php
		$args = array(
		'numberposts'	=> -1,
		'order'         => 'DESC',
		'meta_key'      => 'endDate_editais',
		'orderby'       => 'endDate_editais',
		'post_status'   => 'publish',
		'post_type'     => 'edital',
	);
	// The Query
	$the_query = new WP_Query( $args );
	// The Loop
	if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$today = date("Ymd");
			$endDate = date('Ymd', strtotime(get_post_meta($post->ID, 'endDate_editais', true)));
			$startDate = date('Ymd', strtotime(get_post_meta($post->ID, 'startDate_editais', true)));
			if($today > $endDate) {
				$class = "closed";
				?>
				<? include 'loop-edital.php'; ?>
				<?
			} else {
				$class = "none";
			}
		}
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		// no posts found
	}
	?>	
	
	<div class="spacer"></div>
	<form>
	  <input type="button" value="voltar" class="backButton " onclick="history.go(-1)">
	</form>
	<div class="spacer"></div>
</div> 
