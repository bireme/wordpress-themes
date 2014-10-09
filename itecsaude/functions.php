<?php
	add_image_size( 'highlight-right', 100 , 100 , true );
	add_image_size( 'list-thumb', 200 , 200 , true );
	register_sidebar( array(
		'name'          => 'level2_top',
		'id'            => 'level2_top',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
?>
