<?php
/**
 * Template Name: LILACS – Como Pesquisar
 * Description: Página com banner principal configurável (título, descrição e imagem de fundo).
 */
if (!defined('ABSPATH')) exit;

get_header();
$theme_dir = trailingslashit( get_stylesheet_directory() ); // para child theme use get_stylesheet_directory(); para sempre usar o pai, use get_template_directory()

?>

<main>
    <?php
    // Inclui template de conteúdo do tema
    $tpl = $theme_dir . 'templates/como-pesquisar.php';
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
