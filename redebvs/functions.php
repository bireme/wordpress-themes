<?php
	register_nav_menus( array(
		'top-menu' => 'Top menu',
	) );
	register_sidebar( array(
		'name' => __( 'Auxiliar top - level 2' ),
		'id' => 'aux-top-level2',
		'description' => __( 'Área de widget topo do segundo nível' ),
		'before_widget' => '<div id="%1$s" class="widget top-level2">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Auxiliar footer - level 2' ),
		'id' => 'single-sidebar',
		'description' => __( 'Área de widget topo do segundo nível' ),
		'before_widget' => '<div id="%1$s" class="widget single-sidebar">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
?>