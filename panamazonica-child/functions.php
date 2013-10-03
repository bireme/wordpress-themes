<?php
if ( function_exists('register_sidebar') )

   	register_sidebar( array (
  		'name' => __( 'First Column','panamazonica' ),
  		'description' => __( 'first column for panamazonica library widgets','panamazonica' ),
  		'id' => 'col1',
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
  		'after_widget' => '</div>',
  		'before_title' => '<h3 class="widget-title">',
  		'after_title' => '</h3>',
  	) );
   	register_sidebar( array (
  		'name' => __( 'Second Column','panamazonica' ),
  		'description' => __( 'second column for panamazonica library widgets','panamazonica' ),
  		'id' => 'col2',
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
  		'after_widget' => '</div>',
  		'before_title' => '<h3 class="widget-title">',
  		'after_title' => '</h3>',
  	) );
   	register_sidebar( array (
  		'name' => __( 'Third Column','panamazonica' ),
  		'description' => __( 'third column for panamazonica library widgets','panamazonica' ),
  		'id' => 'col3',
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
  		'after_widget' => '</div>',
  		'before_title' => '<h3 class="widget-title">',
  		'after_title' => '</h3>',
  	) );
  

?>

