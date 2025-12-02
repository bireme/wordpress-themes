<?php
/**
 * Dobra: Página – Banner Final (slider)
 * Slug esperado: pagina-banner_final
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Repeater "banners"
$banners = get_sub_field( 'banners' );
if ( ! $banners || ! is_array( $banners ) ) {
    return;
}

// ID único para JS (caso use mais de uma dobra na mesma página)
$uid = uniqid( 'bvs-banner-final-' );
?>

<section class="bvs-banner-final">
    <div class="bvs-banner-final-inner">

        <div class="bvs-banner-final-slider" id="<?php echo esc_attr( $uid ); ?>">
            <?php
            $i = 0;
            foreach ( $banners as $banner ) :
                $i++;

                $img      = isset( $banner['imagem_de_fundo'] ) ? $banner['imagem_de_fundo'] : null;
                $bg_url   = ( is_array( $img ) && ! empty( $img['url'] ) ) ? $img['url'] : '';
                $titulo   = isset( $banner['titulo_banner'] ) ? $banner['titulo_banner'] : '';
                $desc     = isset( $banner['descricao_banner'] ) ? $banner['descricao_banner'] : '';
                $link     = isset( $banner['link_do_banner'] ) ? $banner['link_do_banner'] : '';
                $btn_text = isset( $banner['texto_botao_do_banner'] ) && $banner['texto_botao_do_banner']
                                ? $banner['texto_botao_do_banner']
                                : __( 'Ver mais', 'rede-bvs' );

                $active_class = ( $i === 1 ) ? ' is-active' : '';
                ?>
                <article class="bvs-banner-final-slide<?php echo esc_attr( $active_class ); ?>"
                         <?php if ( $bg_url ) : ?>
                             style="background-image: url('<?php echo esc_url( $bg_url ); ?>');"
                         <?php endif; ?>
                         aria-hidden="<?php echo $i === 1 ? 'false' : 'true'; ?>">

                    <div class="bvs-banner-final-overlay"></div>

                    <div class="bvs-banner-final-content">
                        <?php if ( $titulo ) : ?>
                            <h2 class="bvs-banner-final-title">
                                <?php echo esc_html( $titulo ); ?>
                            </h2>
                        <?php endif; ?>

                        <?php if ( $desc ) : ?>
                            <p class="bvs-banner-final-desc">
                                <?php echo esc_html( $desc ); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ( $link ) : ?>
                            <a class="bvs-banner-final-button"
                               href="<?php echo esc_url( $link ); ?>">
                                <?php echo esc_html( $btn_text ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php if ( count( $banners ) > 1 ) : ?>
            <div class="bvs-banner-final-nav">
                <button type="button"
                        class="bvs-banner-final-nav-btn bvs-banner-final-nav-prev"
                        aria-label="<?php esc_attr_e( 'Anterior', 'rede-bvs' ); ?>">
                    ‹
                </button>
                <button type="button"
                        class="bvs-banner-final-nav-btn bvs-banner-final-nav-next"
                        aria-label="<?php esc_attr_e( 'Próximo', 'rede-bvs' ); ?>">
                    ›
                </button>
            </div>
        <?php endif; ?>

    </div>
</section>

<style>
/* --------------------------------------------- */
/* BVS – Banner Final (slider)                   */
/* --------------------------------------------- */

.bvs-banner-final {
    margin: 40px 0 32px;
}

.bvs-banner-final-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

.bvs-banner-final-slider {
    position: relative;
}

/* Slide base */
.bvs-banner-final-slide {
    position: relative;
    width: 100%;
    min-height: 380px;
    background-color: #111827;
    background-size: cover;
    background-position: center center;
    border-radius: 24px 120px 24px 24px;
    overflow: hidden;
    display: none; /* controlado pelo JS */
    color: #ffffff;
}

/* Slide visível */
.bvs-banner-final-slide.is-active {
    display: block;
}

/* Gradiente escuro na metade esquerda */
.bvs-banner-final-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        90deg,
        rgba(0,0,0,0.65) 0%,
        rgba(0,0,0,0.6) 40%,
        rgba(0,0,0,0.2) 70%,
        rgba(0,0,0,0.0) 100%
    );
}

/* Conteúdo alinhado à esquerda */
.bvs-banner-final-content {
    position: relative;
    z-index: 1;
    max-width: 420px;
    padding: 78px 40px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.bvs-banner-final-title {
    margin: 0;
    font-size: 38px;
    line-height: 1.3;
    font-weight: 700;
}

.bvs-banner-final-desc {
    margin: 0;
    font-size: 18px;
    line-height: 1.5;
    opacity: 0.9;
    color:#fff;
}

/* Botão */
.bvs-banner-final-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-top: 8px;
    padding: 8px 22px;
    border-radius: 999px;
    background: #28367D;
    color: #ffffff;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    max-width: 110px;
    box-shadow: 0 6px 14px rgba(15, 23, 42, 0.35);
    transition: background 0.15s ease, box-shadow 0.15s ease, transform 0.15s ease;
}

.bvs-banner-final-button:hover,
.bvs-banner-final-button:focus-visible {
    background: #1f2a60;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.5);
    transform: translateY(-1px);
    outline: none;
}

/* Navegação */
.bvs-banner-final-nav {
    margin-top: 10px;
    display: flex;
    justify-content: flex-end;
    gap: 6px;
}

.bvs-banner-final-nav-btn {
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

.bvs-banner-final-nav-btn:hover,
.bvs-banner-final-nav-btn:focus-visible {
    background: #28367D;
    color: #ffffff;
    box-shadow: 0 3px 8px rgba(15, 23, 42, 0.25);
    outline: none;
}

/* Responsivo */
@media (max-width: 768px) {
    .bvs-banner-final-slide {
        border-radius: 20px;
        min-height: 210px;
    }

    .bvs-banner-final-content {
        padding: 24px 22px;
        max-width: 100%;
    }

    .bvs-banner-final-title {
        font-size: 18px;
    }

    .bvs-banner-final-desc {
        font-size: 13px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var slider = document.getElementById('<?php echo esc_js( $uid ); ?>');
    if (!slider) return;

    var slides = slider.querySelectorAll('.bvs-banner-final-slide');
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

    var navPrev = slider.parentNode.querySelector('.bvs-banner-final-nav-prev');
    var navNext = slider.parentNode.querySelector('.bvs-banner-final-nav-next');

    if (navPrev) navPrev.addEventListener('click', prevSlide);
    if (navNext) navNext.addEventListener('click', nextSlide);
// opcional: autoplay leve (pode remover se não quiser)
    var autoplay = setInterval(nextSlide, 10000);

    slider.addEventListener('mouseenter', function () {
        clearInterval(autoplay);
    });
});
</script>