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
    'name' => 'Category Left Block',
      'before_widget' => '<div class="block">',
      'after_widget' => '</div>',
      'before_title' => '<h2 class="h2-home">',
      'after_title' => '</h2>',
    )); 
    register_sidebar(array(
    'name' => 'Category Right Block',
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
    register_sidebar(array(
    'name' => 'Tv-QrCode',
      'before_widget' => '<div style="float:left;">',
      'after_widget' => '</div>',
    ));
    register_sidebar(array(
    'name' => 'Tv-forecast',
      'before_widget' => '<div style="float:right;">',
      'after_widget' => '</div>',
    ));
    register_sidebar(array(
    'name' => 'adv01',
      'before_widget' => '<li class="f-patrocinios-li" id="%1$s">',
      'after_widget' => '</li>',
    )); 
    register_sidebar(array(
    'name' => 'adv02',
      'before_widget' => '<li class="f-patrocinios-li" id="%1$s">',
      'after_widget' => '</li>',
    )); 
    register_sidebar(array(
    'name' => 'adv03',
      'before_widget' => '<li class="f-patrocinios-li" id="%1$s">',
      'after_widget' => '</li>',
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
  add_theme_support( 'post-thumbnails' ); 
  // This theme uses wp_nav_menu() in one location.
  register_nav_menu( 'primary', __( 'Primary Menu', 'SAA' ) );

  function twentytwelve_scripts_styles() {
    global $wp_styles;

    /*
     * Adds JavaScript to pages with the comment form to support
     * sites with threaded comments (when in use).
     */
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
      wp_enqueue_script( 'comment-reply' );

    /*
     * Adds JavaScript for handling the navigation menu hide-and-show behavior.
     */
    wp_enqueue_script( 'twentytwelve-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );
  }
  function twentytwelve_page_menu_args( $args ) {
    if ( ! isset( $args['show_home'] ) )
      $args['show_home'] = true;
    return $args;
  }
  add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );

?>