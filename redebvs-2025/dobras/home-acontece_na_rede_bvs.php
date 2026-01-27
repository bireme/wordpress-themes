<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Campos da layout "Acontece na Rede BVS"
$titulo       = get_sub_field('titulo');
$descricao    = get_sub_field('descricao');
$selecionados = get_sub_field('escolha_quais_eventos_exibir');
$linkGeral = get_sub_field('link_para_ver_todos');

$eventos = [];

// Se o editor escolheu eventos específicos (post_object)
if ( $selecionados ) {
    if ( is_array( $selecionados ) ) {
        $eventos = $selecionados;
    } else {
        $eventos = [ $selecionados ];
    }
// Senão, pega últimos eventos do CPT
} else {
    $q = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 5,
    ]);
    if ( $q->have_posts() ) {
        $eventos = $q->posts;
    }
}
?>



<style>
    /* DOBRA ACONTECE NA REDE BVS */

.home-acontece {
    padding: 40px 0 32px;
    background: #ffffff;
}

.home-acontece-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

.home-acontece-header {
    margin-bottom: 20px;
}

.home-acontece-header h2 {
    font-size: 32px;
    margin: 0 0 8px;
    color: #003c71;
    font-weight: 700;
}

.home-acontece-desc {
    font-size: 16px;
    line-height: 1.6;
    max-width: 100%;
    margin: 0;
}

/* GRID DE CARDS */

.home-acontece-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 18px;
}

.home-acontece-card {
    background: #f6f6fb;
    border-radius: 28px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    min-height: 135px;
}

/* imagem com canto superior bem arredondado */
.home-acontece-card-thumb img {
    display: block;
    width: 100%;
    height: 160px;
    object-fit: contain;
    border-radius: 28px 28px 0 0;
}

.home-acontece-card-body {
    padding: 10px 14px 14px;
}

.home-acontece-card-body h3 {
    font-size: 16px;
    line-height: 1.4;
    margin: 0 0 6px;
    color: #233a8b;
}

.home-acontece-card-body h3 a {
    text-decoration: none;
    color: inherit;
    text-decoration: none;
    font-weight: 500;
}

.home-acontece-card-body h3 a:hover {
    text-decoration: underline;
}

.home-acontece-card-date {
    font-size: 11px;
    color: #777;
    margin-bottom: 4px;
}

.home-acontece-card-tags {
    font-size: 11px;
    color: #a0a0b3;
}

/* Botão "Ver todos" abaixo do loop, à direita */

.home-acontece-footer {
    margin-top: 18px;
    text-align: right;
}

.home-acontece-ver-todos {
    display: inline-block;
    padding: 8px 45px;
    background: #233a8b;
    color: #fff;
    border-radius: 999px;
    text-decoration: none;
    font-size: 13px;
}

.home-acontece-ver-todos:hover {
    background: #233a8b;
    color: #ffffff;
}

/* RESPONSIVO */

@media (max-width: 900px) {
    .home-acontece-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }

    .home-acontece-footer {
        text-align: left;
    }
}

</style>

<section class="home-acontece">
    <div class="home-acontece-inner">

        <header class="home-acontece-header">
            <?php if ( $titulo ) : ?>
                <h2><?php echo esc_html( $titulo ); ?></h2>
            <?php endif; ?>

            <?php if ( $descricao ) : ?>
                <p class="home-acontece-desc">
                    <?php echo esc_html( $descricao ); ?>
                </p>
            <?php endif; ?>
        </header>

        <?php if ( ! empty( $eventos ) ) : ?>
            <div class="home-acontece-grid">
                <?php foreach ( $eventos as $evento ) :

                    if ( is_numeric( $evento ) ) {
                        $evento = get_post( $evento );
                    }
                    if ( ! $evento ) {
                        continue;
                    }

                    $evento_id      = $evento->ID;
                    $thumb_url      = get_the_post_thumbnail_url( $evento_id, 'large' );
                    $titulo_evento  = get_the_title( $evento_id );
                    $data_evento    = get_the_date( 'd/M/Y', $evento_id ); // ex.: 30/set/2025 (pt-BR)
                    $termos_evento  = get_the_terms( $evento_id, 'tag-de-evento' );
                ?>
                    <article class="home-acontece-card">
                        <?php if ( $thumb_url ) : ?>
                            <div class="home-acontece-card-thumb">
                                <a href="<?php echo esc_url( get_permalink( $evento_id ) ); ?>">
                                    <img src="<?php echo esc_url( $thumb_url ); ?>"
                                         alt="<?php echo esc_attr( $titulo_evento ); ?>">
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="home-acontece-card-body">
                            <h3>
                                <a href="<?php echo esc_url( get_permalink( $evento_id ) ); ?>">
                                    <?php echo esc_html( $titulo_evento ); ?>
                                </a>
                            </h3>

                            <?php if ( $data_evento ) : ?>
                                <div class="home-acontece-card-date">
                                    <?php echo esc_html( $data_evento ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $termos_evento ) && ! is_wp_error( $termos_evento ) ) : ?>
                                <div class="home-acontece-card-tags">
                                    <?php
                                    $nomes = wp_list_pluck( $termos_evento, 'name' );
                                    echo esc_html( implode( ', ', $nomes ) );
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>Nenhum evento encontrado.</p>
        <?php endif; ?>

        <div class="home-acontece-footer">
            <a class="home-acontece-ver-todos"
               href="<?php echo esc_url($linkGeral); ?>">
                Ver todos
            </a>
        </div>

    </div>
</section>
