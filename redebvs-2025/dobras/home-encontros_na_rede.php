<?php
/**
 * Dobra: Encontros na Rede
 * Arquivo sugerido: /dobras/dobra-encontros_na_rede.php
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// Campos ACF
$titulo     = get_sub_field( 'titulo' );
$descricao  = get_sub_field( 'descricao' );

// Campo post_object (nome pode estar vazio no ACF, então tentamos as duas formas)
$encontros_selecionados = get_sub_field( 'encontros' );
if ( ! $encontros_selecionados ) {
    $encontros_selecionados = get_sub_field( '' );
}

$encontros = [];

// Se editor escolheu manualmente
if ( $encontros_selecionados ) {
    $encontros = is_array( $encontros_selecionados ) ? $encontros_selecionados : [ $encontros_selecionados ];
} else {
    // Fallback: últimos encontros
    $q = new WP_Query( [
        'post_type'      => 'encontro-da-rede',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ] );

    if ( $q->have_posts() ) {
        $encontros = $q->posts;
    }
}
?>
<style>
/* ENCONTROS NA REDE */

.home-encontros {
    padding: 40px 0 40px;
    background: #ffffff;
}

.home-encontros-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
    display: flex;
    gap: 40px;
    align-items: flex-start;
}

/* Coluna texto */
.home-encontros-texto {
    flex: 0 0 32%;
}

.home-encontros-texto h2 {
    font-size: 32px;
    color: #28367D;
    margin: 0 0 12px;
    font-weight: 700;
}

.home-encontros-texto p {
    font-size: 16px;
    line-height: 1.6;
    color: #28367d;
}

/* Coluna cards */
.home-encontros-cards-wrapper {
    flex: 1;
}

.home-encontros-cards {
    display: flex;
    gap: 18px;
}

/* Card padrão */
.encontro-card {
    flex: 1;
    background: #e3e4e7;
    border-radius: 26px 60px 26px 26px;
    padding: 18px 20px;
    font-size: 13px;
    color: #666;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 150px;
}

.encontro-card-titulo {
    font-weight: 600;
    margin-bottom: 6px;
    font-size:18px;
}

.encontro-card-ano {
    font-size: 12px;
    margin-bottom: 18px;
}

/* Linha de tags */
.encontro-card-tags {
    font-size: 11px;
    text-transform: uppercase;
}

/* Card ativo (primeiro) */
.encontro-card--ativo {
    background: #28367D;
    color: #fff;
}

.encontro-card--ativo .encontro-card-tags {
    opacity: 0.9;
}

/* Rodapé com botão Ver todos */
.home-encontros-footer {
    max-width: 1180px;
    margin: 12px auto 0;
    padding: 0 16px;
    text-align: right;
}



.home-encontros-ver-todos {
    display: inline-block;
    padding: 8px 45px;
    background: #233a8b;
    color: #fff;
    border-radius: 999px;
    text-decoration: none;
    font-size: 13px;
}

/* Responsivo */
@media (max-width: 900px) {
    .home-encontros-inner {
        flex-direction: column;
        gap: 24px;
    }

    .home-encontros-texto {
        flex: 1 0 auto;
    }

    .home-encontros-cards {
        flex-direction: column;
    }
}
</style>

<section class="home-encontros">
    <div class="home-encontros-inner">

        <div class="home-encontros-texto">
            <?php if ( $titulo ) : ?>
                <h2><?php echo esc_html( $titulo ); ?></h2>
            <?php endif; ?>

            <?php if ( $descricao ) : ?>
                <p><?php echo esc_html( $descricao ); ?></p>
            <?php endif; ?>
        </div>

        <div class="home-encontros-cards-wrapper">
            <div class="home-encontros-cards">
                <?php
                if ( ! empty( $encontros ) ) :
                    $index = 0;
                    foreach ( $encontros as $encontro ) :

                        if ( is_numeric( $encontro ) ) {
                            $encontro = get_post( $encontro );
                        }
                        if ( ! $encontro ) {
                            continue;
                        }

                        $id   = $encontro->ID;
                        $link = get_permalink( $id );
                        $ano  = get_the_date( 'Y', $id );

                        // Tags (taxonomia opcional)
                        $tags_line = '';
                        $tags      = get_the_terms( $id, 'tag-de-evento' );
                  
                        if ( ! is_wp_error( $tags ) && ! empty( $tags ) ) {
                            $names    = wp_list_pluck( $tags, 'name' );
                            $tags_line = implode( ', ', $names );
                        }

                        $card_classes = 'encontro-card';
                        if ( 0 === $index ) {
                            $card_classes .= ' encontro-card--ativo';
                        }
                        ?>
                        <article class="<?php echo esc_attr( $card_classes ); ?>">
                            <div>
                                <div class="encontro-card-titulo">
                                    <a href="<?php echo esc_url( $link ); ?>" style="color: inherit; text-decoration: none;">
                                        <?php echo esc_html( get_the_title( $id ) ); ?>
                                    </a>
                                </div>
                                <?php if ( $ano ) : ?>
                                    <div class="encontro-card-ano"><?php echo esc_html( $ano ); ?></div>
                                <?php endif; ?>
                            </div>

                            <?php if ( $tags_line ) : ?>
                                <div class="encontro-card-tags">
                                    <?php echo esc_html( $tags_line ); ?>
                                </div>
                            <?php else : ?>
                                <div class="encontro-card-tags">TAGS</div>
                            <?php endif; ?>
                        </article>
                        <?php
                        $index++;
                    endforeach;
                endif;
                ?>
            </div>
        </div>

    </div>

    <div class="home-encontros-footer">
        <a class="home-encontros-ver-todos" href="<?php echo esc_url( get_post_type_archive_link( 'encontro-da-rede' ) ); ?>">
            Ver todos
        </a>
    </div>
</section>
