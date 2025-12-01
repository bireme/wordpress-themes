<?php
/**
 * Dobra: Banner encontros
 * Arquivo: /dobras/produto-banner.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

?>
<style>
/* BANNER SOBRE */

.sobre-banner {
    padding: 0;
    background: #ffffff;
}

.sobre-banner-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

.sobre-banner-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 10px 90px 10px 10px;
    background-color: #e4e7f0;
}
.bvs-search-form{
    margin-top:20px;
}
.bvs-search-widget{
    margin-left: 0;
}
/* Imagem */
.sobre-banner-image {
    width: 100%;
    height: 285px;
    background-repeat: no-repeat;

    background-size: cover;
        background-position: center !important;
    
}

/* Texto opcional (caso use título/descrição no futuro) */
.sobre-banner-text {
position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    color: #ffffff;
    max-width: 100%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    background: #2a377e99;
    height: 100%;
    width: 100%;
    padding: 60px;
    display: flex;
    justify-content: center;

}

.sobre-banner-text h1 {
    font-size: 45px;
    margin: 0 0 6px;
    font-weight: 700;
}

.sobre-banner-text p {
    margin: 0;
    color:#fff !important;
    font-size: 16px;
}

/* Responsivo */
@media (max-width: 768px) {
    .sobre-banner {
        padding: 20px 0 10px;
    }

    .sobre-banner-wrapper {
        border-radius: 18px 40px 40px 18px;
    }

    .sobre-banner-image {
        height: 280px;
    }

    .sobre-banner-text {
        left: 20px;
        right: 20px;
        max-width: none;
    }

    .sobre-banner-text h1 {
        font-size: 18px;
    }

    .sobre-banner-text p {
        font-size: 13px;
    }
    .bvs-search-form{
        width:100%;
    }
    .bvs-search-target{
            font-size: 11px;
    }
}
</style>

<section class="sobre-banner" aria-label="<?php echo esc_attr( $titulo ? $titulo : 'Banner Sobre BVS' ); ?>">
    <div class="sobre-banner-inner">
        
  <?php
// Slugs originais das páginas em português
$slug_rede_bvs       = 'a-rede-bvs';
$slug_encontros_rede = 'encontros-com-a-rede-bvs';

// Recupera os IDs via slug
$pagina_rede_bvs       = get_page_by_path( $slug_rede_bvs );
$pagina_encontros_rede = get_page_by_path( $slug_encontros_rede );

// Garante tradução via Polylang
if ( function_exists('pll_get_post') ) {
    if ( $pagina_rede_bvs ) {
        $pagina_rede_bvs = pll_get_post( $pagina_rede_bvs->ID );
    }
    if ( $pagina_encontros_rede ) {
        $pagina_encontros_rede = pll_get_post( $pagina_encontros_rede->ID );
    }
}

rede_bvs_breadcrumb( array(
    array(
        'label' => pll__('Rede BVS'),
        'url'   => $pagina_rede_bvs ? get_permalink( $pagina_rede_bvs ) : '#',
    ),
    array(
        'label' => pll__('Encontros com a rede'),
        'url'   => $pagina_encontros_rede ? get_permalink( $pagina_encontros_rede ) : '#',
    ),
    array(
        'label' => pll__('Encontros'),
    ),
) );
?>


        <div class="sobre-banner-wrapper">
      
<div class="sobre-banner-image" style="background:url('<?= get_template_directory_uri() . '/assets/dafult-encontros.png'; ?>');">
              
            </div>

     
                <div class="sobre-banner-text">
              
                        <h1><?=get_the_title();?></h1>
           

                    
                         <?= do_shortcode('[bvs_busca_repositorio]') ?>
                </div>
            
           
            
        </div>
    </div>
</section>
