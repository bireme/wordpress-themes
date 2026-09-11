<?php
/**
 * Template Name: LILACS 40 Anos
 * Description: Página comemorativa 40 anos da LILACS – gerenciada via ACF Flexible Content
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main>
    <section class="lilacs-pagina-layout">
        <div class="lilacs-pagina-layout-inner">
        <?php
        if ( have_rows( 'layout' ) ) :
            while ( have_rows( 'layout' ) ) : the_row();
                $layout = get_row_layout();
                lilacs_bvs_dobra( 'pagina-' . $layout );
            endwhile;
        else :
            echo '<div class="bvs-pagina-empty"><p>Configure o layout desta página no ACF (campo "layout").</p></div>';
        endif;
        ?>
        </div>
    </section>
</main>

<?php get_footer();
