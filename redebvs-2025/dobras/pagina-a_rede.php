<?php
/**
 * Dobra "A Rede" - usada no flexible layout a_rede
 * Campos:
 *  - titulo (texto)          => título da aba ("A Rede")
 *  - mapa (wysiwyg)          => embed do mapa
 *  - sobre_a_rede (wysiwyg)  => texto da aba
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$aba_titulo   = get_sub_field( 'titulo' );
$mapa_embed   = get_sub_field( 'mapa' );
$sobre_a_rede = get_sub_field( 'sobre_a_rede' );
$bandeira = get_sub_field('bandeira_do_pais');
?>

<style>
/* --------------------- A REDE - PÁGINA PAÍSES --------------------- */

.pais-a-rede-section{
    margin: 40px auto;
    max-width: 1180px;
    padding: 0 16px;
}

.pais-a-rede-inner{
    display: grid;
    grid-template-columns: minmax(0, 1.05fr) minmax(0, 1.2fr);
    gap: 32px;
    align-items: flex-start;
}

.pais-a-rede-mapa{
    background: #ffffff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(15,23,42,0.12);
}

.pais-a-rede-mapa iframe{
    width: 100%;
    min-height: 360px;
    border: 0;
}

/* Coluna de texto à direita */

.pais-a-rede-content{
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.pais-a-rede-titulo-pais{
    font-size: 32px;
    line-height: 1.2;
    font-weight: 700;
    color: #002c71;
    margin: 0;
    margin-top:-7px;
}

.pais-a-rede-aba-titulo{
    display: inline-block;
    margin-top: 4px;
    padding: 8px 14px;
    border-radius: 8px;
    background: #e5e7eb;
    font-size: 16px;
    font-weight: 600;
    color: #374151;
}

.pais-a-rede-descricao{
    margin-top: 4px;
    font-size: 15px;
    line-height: 1.7;
    color: #111827;
}

.pais-a-rede-descricao p{
    margin-bottom: 10px;
}

/* responsivo */

@media (max-width: 992px){
    .pais-a-rede-inner{
        grid-template-columns: minmax(0,1fr);
    }

    .pais-a-rede-mapa iframe{
        min-height: 280px;
    }

    .pais-a-rede-titulo-pais{
        font-size: 26px;
    }
}

@media (max-width: 640px){
    .pais-a-rede-section{
        margin: 24px auto;
    }
    .pais-a-rede-mapa{
        border-radius: 18px;
    }
}

.logo-pais img{
    max-width: 35px !important;
    min-width: 35px !important;
    height: 35px;
    width: 35px;
}
.header-a-rede-sobre{
        display: flex;
    align-content: center;
    align-items: center;
    justify-content: flex-start;
    gap: 12px;
}
</style>

<section class="pais-a-rede-section">
    <div class="pais-a-rede-inner">

        <!-- Mapa à esquerda -->
        <div class="pais-a-rede-mapa">
            <?php
            if ( $mapa_embed ) {
                // usa the_content para garantir o embed do mapa
                echo apply_filters( 'the_content', $mapa_embed );
            }
            ?>
        </div>

        <!-- Conteúdo à direita -->
        <div class="pais-a-rede-content">
            <div class="header-a-rede-sobre">
            <?php
            if($bandeira) : ?>
                <div class="logo-pais">
                    <img src="<?=$bandeira?>">
                </div>
            <?php    
            endif; 
            ?>
            <h1 class="pais-a-rede-titulo-pais"><?php the_title(); ?></h1>
            </div>
            <?php if ( $aba_titulo ) : ?>
                <div class="pais-a-rede-aba-titulo">
                    <?php echo esc_html( $aba_titulo ); ?>
                </div>
            <?php endif; ?>

            <?php if ( $sobre_a_rede ) : ?>
                <div class="pais-a-rede-descricao">
                    <?php
                    // aqui você pode usar the_content ou wp_kses_post, conforme preferir
                    echo apply_filters( 'the_content', $sobre_a_rede );
                    ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>
