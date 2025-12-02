<?php
/* Template Name: LILACS Capacitação */

get_header(); // Mantém compatibilidade com o tema (se quiser sempre usar header do plugin, substitua)

$theme_dir = trailingslashit( get_stylesheet_directory() ); // garante barra no final
$tpl = $theme_dir . 'templates/capacitacao.php';
if ( file_exists( $tpl ) ) {
    include $tpl;
} else {
    // debug rápido: caminho que está sendo verificado
    echo '<p>Template não encontrado: ' . esc_html( $tpl ) . '</p>';
}


get_footer();
?>