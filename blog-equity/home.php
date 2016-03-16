<?php get_header(); ?>


<?php

	//Set default variables related to current language when multi-language-framework is not installed
	$top_bar = "top_sidebar";
	$footer_bar = "footer_sidebar";
	$slider = "slider";


	if ($top_sidebar == true){
?>
	<div class="top_sidebar">
		<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
		<?php dynamic_sidebar( $top_bar ); ?>
	</div>	
<?php	
	}
?>
<?php if ($slider == true) { ?>
	<div class="slider">
		<?php dynamic_sidebar( $slider ); ?>
	</div>	
<?php	
	}
?>
<?php 
	for($i=1; $i <= $total_columns; $i++) {

		$column = "column-" . $i;
                ?>
		<div class="column column_<?php echo $i;?>">
			<?php
				if ( has_nav_menu( $column ) ) {
 				wp_nav_menu(array('theme_location' => $column));
			} ?> 		
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
		<?php wp_nav_menu(array('theme_location' => 'bottom')); ?>
	</div>	
	<div class="spacer"></div>	
	<?php	
	}
?>


<?php get_sidebar(); ?>
<?php get_footer(); ?>