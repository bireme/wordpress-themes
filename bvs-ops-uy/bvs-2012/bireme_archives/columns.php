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
	for($i=1; $i <= $total_columns; $i++) {

		$column = "column-" . $i;
		if(is_plugin_active('multi-language-framework/multi-language-framework.php'))
			$column .= $current_language;
                ?>
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
