<?php
/*
 * functions.php - Arquivo que carrega as funções específicas do tema como
 * declarar as colunas, definir tamanho dos thumbs etc.
 */
	if ( function_exists('register_sidebar') )
		register_sidebar(
	    	array('name'=>'Coluna_1',
	            'id' => 'Coluna_1',
	            'description' => __('Coluna 01', 'example'),
	            'before_widget' => '<div id="%1$s" class="widget %2$s">',
	            'after_widget' => '<div class="spacer"></div></div>',
	            'before_title' => '<h3 class="widgettitle"><span>',
	            'after_title' => '</span></h3>',
	        ));      
		
		register_sidebar(
	    	array('name'=>'Coluna_2',
	            'id' => 'Coluna_2',
	            'description' => __('Coluna 02', 'example'),
	            'before_widget' => '<div id="%1$s" class="widget %2$s">',
	            'after_widget' => '<div class="spacer"></div></div>',
	            'before_title' => '<h3 class="widgettitle"><span>',
	            'after_title' => '</span></h3>',
	        ));      
		
		register_sidebar(
	    	array('name'=>'Coluna_3',
	            'id' => 'Coluna_3',
	            'description' => __('Coluna 03', 'example'),
	            'before_widget' => '<div id="%1$s" class="widget %2$s">',
	            'after_widget' => '<div class="spacer"></div></div>',
	            'before_title' => '<h3 class="widgettitle"><span>',
	            'after_title' => '</span></h3>',
	        ));      
		
		register_sidebar(
	    	array('name'=>'Footer',
	            'id' => 'Footer',
	            'description' => __('Footer', 'example'),
	            'before_widget' => '<div id="%1$s" class="widget %2$s">',
	            'after_widget' => '<div class="spacer"></div></div>',
	            'before_title' => '<h3 class="widgettitle"><span>',
	            'after_title' => '</span></h3>',
	        ));      
		
     if (function_exists('add_theme_support')) {
        add_theme_support('post-thumbnails');
		set_post_thumbnail_size(50, 50, true);
        add_image_size('mini_thumb', 90, 90, true);
		add_image_size('cases', 180, 120, true);
	}
	
?>