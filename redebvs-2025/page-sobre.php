<?php
/**
 * Template Name: Sobre BVS
 * Description: Modelo de página sobre do Portal da Rede BVS baseado em ACF Flexible "layout".
 */

if (!defined('ABSPATH')) exit;

get_header();
?>

<main id="conteudo-principal" class="bvs-sobre">
    

    <?php
    // Loop ACF Flexible Content: field "layout"
    if ( have_rows('layout') ) :

        while ( have_rows('layout') ) : the_row();

            // Ex: "a_rede", "sobre", "reunioes"
            $layout = get_row_layout();

            $slug = 'sobre-' . $layout;

            rede_bvs_dobra( $slug );

        endwhile;

    else :

        echo '<p>Configure o layout da Home no ACF (campo "Layout").</p>';

    endif;
    ?>

</main>

<?php get_footer();
