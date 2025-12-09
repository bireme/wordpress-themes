<?php
/**
 * Template Name: Página Modelo BVS
 * Description: Modelo genérico de página institucional do Portal da Rede BVS baseado em ACF Flexible "layout".
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main id="conteudo-principal" class="bvs-pagina-modelo">



    <!-- DOBRAS FLEXÍVEIS DA PÁGINA -->
    <section class="bvs-pagina-layout">
        
            <div class="home-reunioes-inner">
        <?php
        // Loop ACF Flexible Content: campo "layout"
        if ( have_rows( 'layout' ) ) :

            while ( have_rows( 'layout' ) ) : the_row();

                // Ex: "bloco_texto", "imagem_com_texto", "faixa_chamada"
                $layout = get_row_layout();

                // prefixo próprio para este template
                $slug = 'pagina-' . $layout;

                // chama a função genérica de dobra
                rede_bvs_dobra( $slug );

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
