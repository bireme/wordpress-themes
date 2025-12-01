<?php
/**
 * Dobra: Próximas Sessões (slider)
 * Slug esperado: pagina-proximas_sessao
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Título da sessão
$section_title = get_sub_field( 'titulo' );
if ( ! $section_title ) {
    $section_title = __( 'Próxima Sessão', 'rede-bvs' );
}

// Posts selecionados (post_object múltiplo) – ENCONTROS
$proximas = get_sub_field( 'proximas_sessoes' );
if ( empty( $proximas ) || ! is_array( $proximas ) ) {
    return;
}

$uid = uniqid( 'bvs-encontros-proximos-' );
?>

<section class="bvs-encontros-proxima">
    <div class="bvs-encontros-proxima-inner">

        <div class="bvs-encontros-proxima-header">
            <h2 class="bvs-encontros-proxima-title">
                <?php echo esc_html( $section_title ); ?>
            </h2>

            <?php if ( count( $proximas ) > 1 ) : ?>
                <div class="bvs-encontros-proxima-nav">
                    <button type="button"
                            class="bvs-encontros-proxima-nav-btn bvs-encontros-proxima-prev"
                            aria-label="<?php esc_attr_e( 'Sessão anterior', 'rede-bvs' ); ?>">
                        ‹
                    </button>
                    <button type="button"
                            class="bvs-encontros-proxima-nav-btn bvs-encontros-proxima-next"
                            aria-label="<?php esc_attr_e( 'Próxima sessão', 'rede-bvs' ); ?>">
                        ›
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <div class="bvs-encontros-proxima-slider" id="<?php echo esc_attr( $uid ); ?>">

            <?php
            $index = 0;

            foreach ( $proximas as $post_obj ) :
                if ( ! $post_obj instanceof WP_Post ) {
                    continue;
                }

                $index++;

                $post_id = $post_obj->ID;

                // Imagem destacada do ENCONTRO
                $thumb_id  = get_post_thumbnail_id( $post_id );
                $thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'large' ) : '';

                // Campos ACF do ENCONTRO
                $link_encontro      = get_field( 'link_do_encontro', $post_id ); // link (array)
                $descricao_encontro = get_field( 'descricao_completa', $post_id );
                $tipos              = get_field( 'tipo_de_encontro', $post_id ); // checkbox: array ou string

                // ------- PEGAR A PRÓXIMA SESSÃO DENTRO DO ENCONTRO -------
                $proxima_sessao      = null;
                $proximas_repeater   = get_field( 'proximas_sessoes', $post_id ); // repeater no post encontro-da-rede
                $sessao_titulo       = '';
                $sessao_midia        = '';
                $sessao_descricao    = '';

                if ( is_array( $proximas_repeater ) && ! empty( $proximas_repeater ) ) {
                    // Considera a PRIMEIRA linha do repeater como "próxima sessão"
                    $proxima_sessao = $proximas_repeater[0];

                    $sessao_titulo    = isset( $proxima_sessao['titulo_da_sessao'] ) ? trim( (string) $proxima_sessao['titulo_da_sessao'] ) : '';
                    $sessao_midia     = isset( $proxima_sessao['midia_ou_texto'] ) ? $proxima_sessao['midia_ou_texto'] : '';
                    $sessao_descricao = isset( $proxima_sessao['descricao_personalizada'] ) ? $proxima_sessao['descricao_personalizada'] : '';
                }

                // URL e rótulo do botão
                $btn_url    = '';
                $btn_label  = __( 'Inscreva-se', 'rede-bvs' );
                $btn_target = '';

                if ( is_array( $link_encontro ) && ! empty( $link_encontro['url'] ) ) {
                    $btn_url = $link_encontro['url'];
                    if ( ! empty( $link_encontro['title'] ) ) {
                        $btn_label = $link_encontro['title'];
                    }
                    if ( ! empty( $link_encontro['target'] ) ) {
                        $btn_target = $link_encontro['target'];
                    }
                } else {
                    $btn_url = get_permalink( $post_id );
                }

                // Normaliza tipos (Online, Presencial)
                if ( is_array( $tipos ) ) {
                    $tipos_label = implode( ' · ', array_map( 'esc_html', $tipos ) );
                } elseif ( is_string( $tipos ) && $tipos !== '' ) {
                    $tipos_label = esc_html( $tipos );
                } else {
                    $tipos_label = '';
                }

                // Descrição base vinda do ENCONTRO
                $descricao_base_html = $descricao_encontro ? wp_kses_post( $descricao_encontro ) : '';

                // Descrição que será usada: prioridade para a descrição da sessão
                if ( $sessao_descricao ) {
                    $descricao_html = wp_kses_post( $sessao_descricao );
                } else {
                    $descricao_html = $descricao_base_html;
                }

                // Título exibido: prioridade para o título da sessão
                $titulo_exibido = $sessao_titulo !== '' ? $sessao_titulo : get_the_title( $post_id );

                $is_active = ( $index === 1 );
                ?>
                <article class="bvs-encontros-proxima-slide<?php echo $is_active ? ' is-active' : ''; ?>"
                         aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>">

                    <div class="bvs-encontros-proxima-card">

                        <div class="bvs-encontros-proxima-media">
                            <?php if ( $sessao_midia ) : ?>
                                <div class="bvs-encontros-proxima-media-embed">
                                    <?php echo apply_filters( 'the_content', $sessao_midia ); ?>
                                </div>
                            <?php elseif ( $thumb_url ) : ?>
                                <img src="<?php echo esc_url( $thumb_url ); ?>"
                                     alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>">
                            <?php else : ?>
                                <div class="bvs-encontros-proxima-media-placeholder"></div>
                            <?php endif; ?>
                        </div>

                        <div class="bvs-encontros-proxima-info">

                            <h3 class="bvs-encontros-proxima-session-title">
                                <?php echo esc_html( $titulo_exibido ); ?>
                            </h3>

                            <?php if ( $tipos_label ) : ?>
                                <div class="bvs-encontros-proxima-meta">
                                    <?php echo $tipos_label; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( $descricao_html ) : ?>
                                <div class="bvs-encontros-proxima-desc">
                                    <?php echo $descricao_html; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( $btn_url ) : ?>
                                <a class="bvs-encontros-proxima-cta"
                                   href="<?php echo esc_url( $btn_url ); ?>"
                                   <?php if ( $btn_target ) : ?>
                                       target="<?php echo esc_attr( $btn_target ); ?>"
                                   <?php endif; ?>>
                                    <?php echo esc_html( $btn_label ); ?>
                                </a>
                            <?php endif; ?>

                        </div>

                    </div>
                </article>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<style>
/* -------------------------------------------------- */
/* Encontros – Próxima Sessão (slider)                */
/* -------------------------------------------------- */

.bvs-encontros-proxima {
    margin: 32px 0 40px;
}

.bvs-encontros-proxima-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

/* Header: título + setas */
.bvs-encontros-proxima-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.bvs-encontros-proxima-title {
    margin: 0;
    font-size: 26px;
    color: #28367D;
    font-weight: 700;
}

/* Navegação (setas) */
.bvs-encontros-proxima-nav {
    display: inline-flex;
    gap: 6px;
}

.bvs-encontros-proxima-nav-btn {
    width: 30px;
    height: 30px;
    border-radius: 999px;
    border: 1px solid #d1d5db;
    background: #ffffff;
    color: #111827;
    cursor: pointer;
    font-size: 18px;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
}

.bvs-encontros-proxima-nav-btn:hover,
.bvs-encontros-proxima-nav-btn:focus-visible {
    background: #28367D;
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(15, 23, 42, 0.25);
    outline: none;
}

/* Slider */
.bvs-encontros-proxima-slider {
    position: relative;
}

/* Cada slide */
.bvs-encontros-proxima-slide {
    display: none;
}

.bvs-encontros-proxima-slide.is-active {
    display: block;
}

/* Card geral (imagem + texto) */
.bvs-encontros-proxima-card {
    border-radius: 24px 120px 24px 24px;
    padding: 0;
    display: grid;
    grid-template-columns: minmax(0, 1.3fr) minmax(0, 1.8fr);
    gap: 18px;
    align-items: stretch;
}

/* Coluna esquerda – mídia */
.bvs-encontros-proxima-media {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    min-height: 180px;
}

.bvs-encontros-proxima-media img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    background:#fff;
    display: block;
}

.bvs-encontros-proxima-media-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #1f2937, #111827);
}

/* Coluna direita – textos */
.bvs-encontros-proxima-info {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-right: 12px;
}

.bvs-encontros-proxima-session-title {
    margin: 0 0 6px;
    font-size: 18px;
    color: #28367D;
    font-weight: 700;
}

.bvs-encontros-proxima-meta {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 8px;
}

/* Descrição */
.bvs-encontros-proxima-desc {
    font-size: 13px;
    color: #111827;
    line-height: 1.5;
    margin-bottom: 10px;
}

.bvs-encontros-proxima-desc p {
    margin: 0 0 4px;
}

.bvs-encontros-proxima-desc p:last-child {
    margin-bottom: 0;
}

/* Botão Inscreva-se */
.bvs-encontros-proxima-cta {
    align-self: flex-start;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 22px;
    border-radius: 999px;
    background: #28367D;
    color: #ffffff;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    box-shadow: 0 6px 14px rgba(15, 23, 42, 0.35);
    transition: background 0.15s ease, box-shadow 0.15s ease, transform 0.15s ease;
}

.bvs-encontros-proxima-cta:hover,
.bvs-encontros-proxima-cta:focus-visible {
    background: #1f2a60;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.5);
    transform: translateY(-1px);
    outline: none;
}

/* Responsivo */
@media (max-width: 960px) {
    .bvs-encontros-proxima-card {
        grid-template-columns: minmax(0, 1.2fr) minmax(0, 1.8fr);
    }
}

@media (max-width: 768px) {
    .bvs-encontros-proxima-card {
        grid-template-columns: 1fr;
        border-radius: 20px;
    }

    .bvs-encontros-proxima-info {
        padding-right: 0;
    }

    .bvs-encontros-proxima-media {
        min-height: 180px;
    }
}

@media (max-width: 480px) {
    .bvs-encontros-proxima-header {
        flex-direction: row;
        align-items: center;
        gap: 10px;
    }

    .bvs-encontros-proxima-title {
        font-size: 15px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var slider = document.getElementById('<?php echo esc_js( $uid ); ?>');
    if (!slider) return;

    var slides = slider.querySelectorAll('.bvs-encontros-proxima-slide');
    if (!slides.length) return;

    var current = 0;

    function showSlide(index) {
        slides.forEach(function (slide, i) {
            if (i === index) {
                slide.classList.add('is-active');
                slide.setAttribute('aria-hidden', 'false');
            } else {
                slide.classList.remove('is-active');
                slide.setAttribute('aria-hidden', 'true');
            }
        });
        current = index;
    }

    function nextSlide() {
        var next = current + 1;
        if (next >= slides.length) next = 0;
        showSlide(next);
    }

    function prevSlide() {
        var prev = current - 1;
        if (prev < 0) prev = slides.length - 1;
        showSlide(prev);
    }

    var container = slider.closest('.bvs-encontros-proxima-inner');
    if (!container) container = document;

    var btnPrev = container.querySelector('.bvs-encontros-proxima-prev');
    var btnNext = container.querySelector('.bvs-encontros-proxima-next');

    if (btnPrev) btnPrev.addEventListener('click', prevSlide);
    if (btnNext) btnNext.addEventListener('click', nextSlide);

    // autoplay suave (remova se não quiser)
    var autoplay = null;
    if (slides.length > 1) {
        autoplay = setInterval(nextSlide, 12000);

        slider.addEventListener('mouseenter', function () {
            clearInterval(autoplay);
        });
        slider.addEventListener('mouseleave', function () {
            autoplay = setInterval(nextSlide, 12000);
        });
    }
});
</script>
