<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Campos ACF da dobra
$titulo = get_sub_field('titulo');

// Tenta pegar posts selecionados em um campo (caso você dê nome depois)
$posts_selecionados = get_sub_field('vozes_selecionadas');
if ( ! $posts_selecionados ) {
    // fallback para o campo sem nome (como está no seu grupo hoje)
    $posts_selecionados = get_sub_field('');
}

$vozes = [];

// Se o editor selecionou manualmente
if ( $posts_selecionados ) {
    $vozes = is_array($posts_selecionados) ? $posts_selecionados : [ $posts_selecionados ];
} else {
    // Buscar últimos depoimentos
    $q = new WP_Query([
        'post_type'      => 'voz-da-rede',
        'posts_per_page' => 10,
        'post_status'    => 'publish',
    ]);

    if ( $q->have_posts() ) {
        $vozes = $q->posts;
    }
}

// Se não tiver nenhum post, não renderiza nada
if ( empty( $vozes ) ) {
    return;
}
?>
<style>
/* VOZES DA REDE */

.home-vozes {
    padding: 0px;
    background: #ffffff;
}

.home-vozes-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

.home-vozes-title {
    text-align: center;
    font-size: 32px;
    color: #003c71;
    margin-bottom: 30px;
    font-weight: 700;
}

/* Slider container */
.home-vozes-slider {
    position: relative;
    display: flex;
    align-items: center;
}

/* Setas */
.vozes-nav {
    background: #dfe1e7;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.vozes-prev { margin-right: 8px; }
.vozes-next { margin-left: 8px; }

/* Faixa deslizando (2 cards por vez) */
.vozes-track {
    display: flex;
    overflow-x: hidden; /* importante para o slide */
    gap: 20px;
    padding-bottom: 10px;
    width: 100%;
    scroll-behavior: smooth; /* animação nativa */
}

/* Card de cada voz: 2 por vez no desktop */
.voz-card {
    flex: 0 0 50%;
    max-width: 50%;
    box-sizing: border-box;
}

.voz-card-inner {
    background: #F5F5F5;
    border-radius: 10px 60px 10px 10px;
    padding: 24px;
}

/* Header do card */
.voz-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 14px;
}

.voz-avatar img {
    width: 58px;
    height: 58px;
    object-fit: cover;
    border-radius: 50%;
}

.voz-avatar-placeholder {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: #ffffff;
}

.voz-author strong {
    display: block;
    color: #233a8b;
    font-size: 14px;
}

.voz-author span {
    font-size: 12px;
    color: #777;
}

/* Texto */
.voz-texto {
    font-size: 13px;
    color: #444;
    line-height: 1.6;
}

/* Barra inferior */
.home-vozes-bottom-bar {
    background: #A2A2A2;
    padding: 8px 20px;
    border-radius: 12px;
    text-align: center;
    margin: 20px 0 10px;
    font-size: 16px;
    color: #fff;
    
}

/* Botão Ver todos */
.home-vozes-footer {
    text-align: right;
}

.home-vozes-ver-todos {
    display: inline-block;
    padding: 8px 45px;
    background: #233a8b;
    color: #fff;
    border-radius: 999px;
    text-decoration: none;
    font-size: 13px;
}

/* Responsivo: 1 card por vez no mobile */
@media (max-width: 768px) {
    .voz-card {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>

<section class="home-vozes">
    <div class="home-vozes-inner">

        <?php if ( $titulo ) : ?>
            <h2 class="home-vozes-title"><?php echo esc_html( $titulo ); ?></h2>
        <?php endif; ?>

        <div class="home-vozes-slider">

            <button class="vozes-nav vozes-prev" type="button"><img style=" max-width: 8px;transform: rotate(180deg);" src="https://floralwhite-lion-322305.hostingersite.com/wp-content/uploads/2025/11/arrow_right.png"></button>

            <div class="vozes-track">
                <?php foreach ( $vozes as $voz ) :

                    if ( is_numeric( $voz ) ) {
                        $voz = get_post( $voz );
                    }
                    if ( ! $voz ) {
                        continue;
                    }

                    $id = $voz->ID;

                    // Campos ACF do CPT "voz-da-rede"
                    $nome  = get_field( 'nome_do_depoimento', $id );
                    $extra = get_field( 'texto_complementar_cargopais', $id );
                    $texto = get_field( 'depoimento_completo', $id );
                    $foto  = get_field( 'foto_do_autor_depoimento', $id );

                    // Fallbacks caso ACF esteja vazio
                    if ( empty( $nome ) ) {
                        $nome = get_the_title( $id );
                    }
                    if ( empty( $texto ) ) {
                        $texto = wp_trim_words( strip_tags( get_post_field( 'post_content', $id ) ), 40 );
                    }

                    $foto_url = is_array( $foto ) && ! empty( $foto['url'] ) ? $foto['url'] : '';
                ?>
                    <article class="voz-card">
                        <div class="voz-card-inner">

                            <div class="voz-header">
                                <div class="voz-avatar">
                                    <?php if ( $foto_url ) : ?>
                                        <img src="<?php echo esc_url( $foto_url ); ?>" alt="<?php echo esc_attr( $nome ); ?>">
                                    <?php else : ?>
                                        <div class="voz-avatar-placeholder"></div>
                                    <?php endif; ?>
                                </div>

                                <div class="voz-author">
                                    <strong><?php echo esc_html( $nome ); ?></strong>
                                    <?php if ( $extra ) : ?>
                                        <span><?php echo esc_html( $extra ); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="voz-texto">
                                <?php echo wp_kses_post( nl2br( $texto ) ); ?>
                            </div>

                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <button class="vozes-nav vozes-next" type="button"><img style="    max-width: 8px;" src="https://floralwhite-lion-322305.hostingersite.com/wp-content/uploads/2025/11/arrow_right.png"></button>

        </div>

        <div class="home-vozes-bottom-bar">
            <span>Envie seu relato e venha fazer parte dessa história!</span>
        </div>

        <div class="home-vozes-footer">
            <a class="home-vozes-ver-todos" href="<?php echo esc_url( get_post_type_archive_link( 'voz-da-rede' ) ); ?>">
                Ver todos
            </a>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('.home-vozes-slider');
    if (!slider) return;

    const track = slider.querySelector('.vozes-track');
    const cards = track ? track.querySelectorAll('.voz-card') : [];
    const prev  = slider.querySelector('.vozes-prev');
    const next  = slider.querySelector('.vozes-next');

    if (!track || cards.length === 0 || !prev || !next) return;

    let perView;
    let currentPage = 0;
    let pageWidth = 0;

    function updatePerView() {
        perView = window.innerWidth <= 768 ? 1 : 2;
        pageWidth = track.clientWidth; // largura visível
        currentPage = 0;
        track.scrollTo({ left: 0, behavior: 'instant' });
    }

    function totalPages() {
        return Math.max(1, Math.ceil(cards.length / perView));
    }

    function goToPage(page) {
        const maxPage = totalPages() - 1;
        currentPage = Math.min(Math.max(page, 0), maxPage);
        const offset = pageWidth * currentPage;
        track.scrollTo({ left: offset, behavior: 'smooth' });
    }

    prev.addEventListener('click', function () {
        goToPage(currentPage - 1);
    });

    next.addEventListener('click', function () {
        goToPage(currentPage + 1);
    });

    window.addEventListener('resize', function () {
        updatePerView();
    });

    updatePerView();
});
</script>
