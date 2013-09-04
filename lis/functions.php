<?php
/*
 * functions.php - Arquivo que carrega as funções específicas do tema como
 * declarar as colunas, definir tamanho dos thumbs etc.
 */

  /* SIDEBARS */
  if ( function_exists('register_sidebar') )

    register_sidebar(array(
    'name' => 'Sidebar',
      'before_widget' => '<section class="row-fluid marginbottom25 %2$s" id="%1$s">',
      'after_widget' => '</section>',
      'before_title' => '<header class="row-fluid border-bottom marginbottom15"><h1 class="h1-header">',
      'after_title' => '</h1></header>',
    )); 
    
  add_theme_support( 'post-thumbnails' ); 

  function new_excerpt_more( $more ) {
    return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '"> Ver mais...</a>';
  }
  add_filter( 'excerpt_more', 'new_excerpt_more' );
?>