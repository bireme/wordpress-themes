<?php
/* Template Name: Lilacs HomePage */

get_header(); // Mantém compatibilidade com o tema (se quiser sempre usar header do plugin, substitua)

// INCLUDE CORRETO dos campos (use caminho do plugin, não do tema)
$plugin_dir = plugin_dir_path( __FILE__ ); // se esse arquivo estiver na raiz do plugin
$meta_fields = $plugin_dir . 'inc/admin/meta-templates/page-lilacs-home-fields.php';
if ( file_exists( $meta_fields ) ) {
    include $meta_fields;
}

// Corpo do site (exemplo que você já tem)
?>
<main>
    <?php
    // Inclui template de conteúdo do plugin (use caminho do plugin também)
      $tpl = $plugin_dir . 'templates/home-page.php';
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
