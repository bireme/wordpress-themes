<?php
/**
 * Template para single do CPT: Produtos
 */

if ( ! defined('ABSPATH') ) exit;

get_header();

?>

<main id="conteudo-principal" class="single-produto">
<section class="home-reunioes" style="padding-top:0;">
    <div class="home-reunioes-inner">
        <?php
        
      
   
                // Loop ACF Flexible Content: field "layout"
                if ( have_rows('layout') ) :
            
                    while ( have_rows('layout') ) : the_row();
            
                        // Ex: "a_rede", "sobre", "reunioes"
                        $layout = get_row_layout();
            
                        // Mapeia para um arquivo de dobra:
                        // "a_rede"   -> dobras/home-a_rede.php
                        // "sobre"    -> dobras/home-sobre.php
                        // "reunioes" -> dobras/home-reunioes.php
                        $slug = 'produto-' . $layout;
            
                        rede_bvs_dobra( $slug );
            
                    endwhile;
            
                else :
            
                    echo '<p>Configure o layout da Home no ACF (campo "Layout").</p>';
            
                endif;
                   ?> 
        
    </div>
</section>

</main>

<?php get_footer(); ?>
