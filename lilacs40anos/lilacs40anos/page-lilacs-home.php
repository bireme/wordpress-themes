<?php
/*
Template Name: LILACS HomePage2
Description: Home com layout via ACF Flexible Content (campo "layout"), no mesmo padrão do template de Capacitação.
*/

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main>

  <!-- DOBRAS FLEXÍVEIS DA PÁGINA -->
  <section class="lilacs-pagina-layout">
    <div class="lilacs-pagina-layout-inner">
      <?php
      // Loop ACF Flexible Content: campo "layout"
      if ( have_rows( 'layout' ) ) :

        while ( have_rows( 'layout' ) ) : the_row();

          // Ex: "bloco_texto", "imagem_com_texto", "faixa_chamada"
          $layout = get_row_layout();

          // Título opcional acima da dobra
          $titulo_dobra = get_sub_field( 'titulo_da_dobra' );

          // prefixo próprio para este template
          $slug = 'pagina-' . $layout;

          if ( $titulo_dobra ) : ?>
            <div class="lilacs-dobra-titulo-wrapper">
              <h2 class="lilacs-dobra-titulo"><?php echo esc_html( $titulo_dobra ); ?></h2>
            </div>
          <?php endif;

          // chama a função genérica de dobra
          lilacs_bvs_dobra( $slug );

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

<?php get_footer(); ?>