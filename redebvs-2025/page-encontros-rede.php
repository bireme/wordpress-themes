<?php
/**
 * Template Name: Encontros da Rede BVS
 * Description: Página de Encontros da Rede BVS baseada no ACF Flexible "layout".
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main id="conteudo-principal" class="bvs-encontros-rede">

    <!-- DOBRAS FLEXÍVEIS DA PÁGINA ENCONTROS -->
    <section class="bvs-encontros-layout">
        <div class="encontros-rede-inner">
            <?php
            // Loop ACF Flexible Content: campo "layout"
            if ( have_rows( 'layout' ) ) :

                while ( have_rows( 'layout' ) ) : the_row();

                    // Ex: "lista_encontros", "banner_encontros", etc.
                    $layout = get_row_layout();

                    $slug = 'pagina-' . $layout;

                    // chama a função genérica de dobra
                    if ( function_exists( 'rede_bvs_dobra' ) ) {
                        rede_bvs_dobra( $slug );
                    }

                endwhile;

            else :

                echo '<div class="bvs-pagina-empty">';
                echo '<p>Configure o layout desta página no ACF (campo "layout").</p>';
                echo '</div>';

            endif;
            ?>
        </div>
    </section>

</main>

<?php get_footer();
