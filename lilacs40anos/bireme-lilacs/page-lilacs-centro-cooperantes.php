<?php
/**
 * Template Name: LILACS Centro Cooperantes
 *
 */
if (!defined('ABSPATH')) exit;

get_header();
$theme_dir = trailingslashit( get_stylesheet_directory() ); // para child theme use get_stylesheet_directory(); para sempre usar o pai, use get_template_directory()

?>

<main>
    <?php
    // Inclui template de conteúdo do tema
    $tpl = $theme_dir . 'templates/centro-cooperantes.php';
    if ( file_exists( $tpl ) ) {
        include $tpl;
    } else {
        // fallback caso não exista
        echo '<p>Template não encontrado.</p>';
    }
    ?>
</main>

<?php

 get_footer(); ?>
