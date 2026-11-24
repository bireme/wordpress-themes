<?php
/**
 * Template Name: Página Modelo de País
 * Description: Modelo genérico de página país
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main id="conteudo-principal" class="bvs-pagina-modelo">



    <!-- DOBRAS FLEXÍVEIS DA PÁGINA -->
    <section class="bvs-pagina-layout">
        
            <div class="home-reunioes-inner">
        <?php
        // Listagem completa das notícias do país, no mesmo idioma da página.
        if ( function_exists( 'rede_bvs_is_rede_acao_todas' ) && rede_bvs_is_rede_acao_todas() ) :
            rede_bvs_dobra( 'pagina-rede_em_acao', array( 'lista_completa' => true ) );

        // Loop ACF Flexible Content: campo "layout"
        elseif ( have_rows( 'layout' ) ) :

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
