<?php
/* Template Name: Lilacs Periodicos/Revistas */

get_header(); // Mantém compatibilidade com o tema (se quiser sempre usar header do plugin, substitua)

// INCLUDE CORRETO dos campos (use caminho do TEMA, não do plugin)
$theme_dir = trailingslashit( get_stylesheet_directory() ); // para child theme use get_stylesheet_directory(); para sempre usar o pai, use get_template_directory()


?>
<main>
    <?php
    // Inclui template de conteúdo do tema
    $tpl = $theme_dir . 'templates/periodicos.php';
    if ( file_exists( $tpl ) ) {
        include $tpl;
    } else {
        // fallback caso não exista
        echo '<p>Template home-page não encontrado.</p>';
    }
    ?>
</main>

<?php
get_footer();
?>
