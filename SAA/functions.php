<?php
/*
 * functions.php - Arquivo que carrega as funções específicas do tema como
 * declarar as colunas, definir tamanho dos thumbs etc.
 */

  /* SIDEBARS */
  if ( function_exists('register_sidebar') )

    register_sidebar(array(
    'name' => 'Sidebar',
      'before_widget' => '<section class="s-list row-fluid margin-bottom25"  id="%1$s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="h2-home">',
      'after_title' => '</h2>',
    )); 
  
    register_sidebar(array(
    'name' => 'Featured Home',
      'before_widget' => '<div class="block">',
      'after_widget' => '</div>',
      'before_title' => '<h2 class="h2-home">',
      'after_title' => '</h2>',
    )); 

    register_sidebar(array(
    'name' => 'Tv-Sidebar',
      'before_widget' => '<section class="s-list row-fluid margin-bottom25">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="tv-sidebar-tit">',
      'after_title' => '</h2>',
    )); 
    
  function wp_limit_post($max_char, $more_link_text = '[...]',$notagp = false, $stripteaser = 0, $more_file = '') {
      $content = get_the_content($more_link_text, $stripteaser, $more_file);
      $content = apply_filters('the_content', $content);
      $content = str_replace(']]>', ']]&gt;', $content);
      $content = strip_tags($content);
   
     if (strlen($_GET['p']) > 0) {
        if($notagp) {
        echo substr($content,0,$max_char);
        }
        else {
        echo '<p>';
        echo substr($content,0,$max_char);
        echo "</p>";
        }
     }
     else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
          $content = substr($content, 0, $espacio);
          $content = $content;
          if($notagp) {
          echo substr($content,0,$max_char);
          echo $more_link_text;
          }
          else {
          echo '<p>';
          echo substr($content,0,$max_char);
          echo $more_link_text;
          echo "</p>";
          }
     }
     else {
        if($notagp) {
        echo substr($content,0,$max_char);
        }
        else {
        echo '<p>';
        echo substr($content,0,$max_char);
        echo "</p>";
        }
     }
  }
?>