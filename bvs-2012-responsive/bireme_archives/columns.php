<?php

	//Set default variables related to current language when multi-language-framework is not installed
	$top_bar = "top_sidebar";
	$footer_bar = "footer_sidebar";

	if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
        	$top_bar .= $current_language;
        	$footer_bar .= $current_language;
	}

	if ($top_sidebar == true){
?>
	<div class="top_sidebar">
			<?php dynamic_sidebar( $top_bar ); ?>
	</div>	
<?php	
	}
?>
<?php 
	$colors = $settings['colors'];
	$layout = $settings['layout'];
	for($i=1; $i <= $total_columns; $i++) {

		$column = "column-" . $i;
		if(is_plugin_active('multi-language-framework/multi-language-framework.php'))
			$column .= $current_language;

		$column_width = $layout[''.$i.''];
		if ($i==1){
			$column_name='first';			
		} elseif($i==2) {
			$column_name='second';					
		} elseif($i==3) {
			$column_name='third';					
		} elseif($i==4) {
			$column_name='fourth';					
		}		
		?>
		<style>
			.column_<?php echo $i;?> .widget {
				background: #<?php echo $colors[''.$column_name.'-background'];?>;
				color: #<?php echo $colors[''.$column_name.'-text'];?>;
			}
			.column_<?php echo $i;?> a {
				color: #<?php echo $colors[''.$column_name.'-link-active'];?>;
			}
			.column_<?php echo $i;?> a:visited {
				color: #<?php echo $colors[''.$column_name.'-link-visited'];?>;
			}
			.column_<?php echo $i;?> h3, .column_<?php echo $i;?> h3 a {
				color: #<?php echo $colors[''.$column_name.'-title-first'];?>;							
			}
			.column_<?php echo $i;?> h3 {
				border-color: #<?php echo $colors[''.$column_name.'-title-first'];?>;	
			}
			.column_<?php echo $i;?> {
				width: <?php echo $column_width; ?>;
			}
			@media (max-width: 480px) {
				.column_<?php echo $i;?> {
					width: 96%;
				}
			}
			@media (min-width: 481px) and (max-width: 729px) {
				.column_<?php echo $i;?> {
					width: 96%;
				}
			}
		</style>
		<div class="column column_<?php echo $i;?>">
				<?php dynamic_sidebar( $column ); ?>
		</div>
	<?php
	}
?>
<div class="spacer"></div>
<?php 
	if ($footer_sidebar == true){
	?>
	<div class="footer_sidebar">
			<?php dynamic_sidebar( $footer_bar ); ?>
	</div>	
	<div class="spacer"></div>	
	<?php	
	}
?>
