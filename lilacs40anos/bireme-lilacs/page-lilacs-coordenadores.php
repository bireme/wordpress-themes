<?php
/* Template Name: Lilacs Coordenadores */

get_header(); // Mantém compatibilidade com o tema (se quiser sempre usar header do plugin, substitua)
$theme_dir = trailingslashit( get_stylesheet_directory() ); // para child theme use get_stylesheet_directory(); para sempre usar o pai, use get_template_directory()


?>
<main>
    <?php
    // Inclui template de conteúdo do tema
    $tpl = $theme_dir . 'templates/coordenadores.php';
    if ( file_exists( $tpl ) ) {
        include $tpl;
    } else {
        // fallback caso não exista
        echo '<p>Template não encontrado.</p>';
    }
    ?>
</main>

<?php
get_footer();
?>
