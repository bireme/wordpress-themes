<?php
/**
 * Dobra: Vozes da Rede
 * Slug esperado: pagina-vozes_da_rede
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Campos ACF dentro do Flexible
$depoimentos = get_sub_field( 'depoimentos' );
$bg_image    = get_sub_field( 'imagem_de_fundo' ); // nova imagem de fundo da sessão

if ( ! $depoimentos || ! is_array( $depoimentos ) ) {
    return;
}

$uid   = 'vozes-rede-' . get_the_ID() . '-' . get_row_index();
$total = count( $depoimentos );
?>

<style>
/* SECTION - fundo 100% */
#<?php echo esc_attr( $uid ); ?> {
    width: 100%;
    padding: 60px 16px;
    max-width: 97%;
    <?php if ( $bg_image ) : ?>
    background-image: url('<?php echo esc_url( $bg_image ); ?>');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    <?php else : ?>
    background: #f3f4f6;
    <?php endif; ?>
}

/* container centralizado 1180px */
#<?php echo esc_attr( $uid ); ?> .vozes-rede-inner {
    max-width: 1180px;
    margin: 0 auto;
}

/* Cabeçalho */
#<?php echo esc_attr( $uid ); ?> .vozes-rede-header {
    margin-bottom: 24px;
}

#<?php echo esc_attr( $uid ); ?> .vozes-rede-title {
    font-size: 30px;
    font-weight: 700;
    color: #0b2144;
}

/* Slider */
#<?php echo esc_attr( $uid ); ?> .vozes-rede-slider {
    position: relative;
}

#<?php echo esc_attr( $uid ); ?> .vozes-rede-viewport {
    overflow: hidden;
}

#<?php echo esc_attr( $uid ); ?> .vozes-rede-track {
    display: flex;
    transition: transform 0.4s ease;
}

/* Card */
#<?php echo esc_attr( $uid ); ?> .voz-card {
    flex: 0 0 calc(100% / var(--per-view));
    padding: 10px;
    box-sizing: border-box;
}

#<?php echo esc_attr( $uid ); ?> .voz-card-inner {
    background: linear-gradient(90deg, #7540e6 0%, #0059b2 100%);
    border-radius: 18px;
    padding: 28px 32px;
    color: #ffffff;
    min-height: 200px;
}

#<?php echo esc_attr( $uid ); ?> .voz-head {
    display: flex;
    align-items: center;
    margin-bottom: 16px;
}

/* avatar */
#<?php echo esc_attr( $uid ); ?> .voz-avatar {
    width: 56px;
    height: 56px;
    border-radius: 999px;
    background: rgba(255,255,255,0.2);
    overflow: hidden;
    margin-right: 16px;
    flex-shrink: 0;
}

#<?php echo esc_attr( $uid ); ?> .voz-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

#<?php echo esc_attr( $uid ); ?> .voz-name {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 4px;
}

#<?php echo esc_attr( $uid ); ?> .voz-role {
    font-size: 14px;
    opacity: 0.9;
}

/* texto do depoimento */
#<?php echo esc_attr( $uid ); ?> .voz-text {
    font-size: 15px;
    line-height: 1.7;
}

/* Controles */
#<?php echo esc_attr( $uid ); ?> .vozes-rede-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    border-radius: 999px;
    border: none;
    background: #ffffff;
    box-shadow: 0 6px 16px rgba(15,23,42,0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #0b2144;
    transition: background 0.15s ease, transform 0.15s ease;
    padding: 0;
}

#<?php echo esc_attr( $uid ); ?> .vozes-rede-nav:hover:not(:disabled) {
    background: #edf2ff;
    transform: translateY(-50%) scale(1.05);
}

#<?php echo esc_attr( $uid ); ?> .vozes-rede-nav:disabled {
    opacity: 0.35;
    cursor: default;
}

#<?php echo esc_attr( $uid ); ?> .vozes-rede-nav.prev {
    left: -10px;
    z-index: 999;
}

#<?php echo esc_attr( $uid ); ?> .vozes-rede-nav.next {
    right: -10px;
    
    z-index: 999;
}

/* Ícones setas */
#<?php echo esc_attr( $uid ); ?> .vozes-rede-nav svg {
    width: 18px;
    height: 18px;
}

/* responsivo: em telas menores sempre 1 por vez */
@media (max-width: 900px) {
    #<?php echo esc_attr( $uid ); ?> {
        padding: 40px 12px;
    }

    #<?php echo esc_attr( $uid ); ?> .vozes-rede-nav.prev {
        left: 4px;
    }
    #<?php echo esc_attr( $uid ); ?> .vozes-rede-nav.next {
        right: 4px;
    }
}
</style>

<section id="<?php echo esc_attr( $uid ); ?>" class="vozes-da-rede">
    <div class="vozes-rede-inner">
        <div class="vozes-rede-header">
            <h2 class="vozes-rede-title">
                <?php esc_html_e( 'Depoimentos', 'rede-bvs' ); ?>
            </h2>
        </div>

        <div class="vozes-rede-slider" data-total="<?php echo esc_attr( $total ); ?>">
            <button type="button"
                    class="vozes-rede-nav prev"
                    aria-label="<?php esc_attr_e( 'Depoimento anterior', 'rede-bvs' ); ?>">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 5l-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

            <div class="vozes-rede-viewport">
                <div class="vozes-rede-track">
                    <?php foreach ( $depoimentos as $dep ) :
                        $foto      = ! empty( $dep['foto'] )      ? esc_url( $dep['foto'] )      : '';
                        $titulo    = ! empty( $dep['titulo'] )    ? $dep['titulo']              : '';
                        $profissao = ! empty( $dep['profissao'] ) ? $dep['profissao']           : '';
                        $texto     = ! empty( $dep['depoimento'] ) ? $dep['depoimento']         : '';
                    ?>
                        <article class="voz-card">
                            <div class="voz-card-inner">
                                <div class="voz-head">
                                    <div class="voz-avatar">
                                        <?php if ( $foto ) : ?>
                                            <img src="<?php echo $foto; ?>" alt="<?php echo esc_attr( $titulo ); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <?php if ( $titulo ) : ?>
                                            <div class="voz-name"><?php echo esc_html( $titulo ); ?></div>
                                        <?php endif; ?>

                                        <?php if ( $profissao ) : ?>
                                            <div class="voz-role"><?php echo esc_html( $profissao ); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if ( $texto ) : ?>
                                    <div class="voz-text">
                                        <?php echo wp_kses_post( nl2br( $texto ) ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="button"
                    class="vozes-rede-nav next"
                    aria-label="<?php esc_attr_e( 'Próximo depoimento', 'rede-bvs' ); ?>">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>
</section>

<script>
(function() {
    const root  = document.getElementById('<?php echo esc_js( $uid ); ?>');
    if (!root) return;

    const track = root.querySelector('.vozes-rede-track');
    const cards = track ? track.children : [];
    const prev  = root.querySelector('.vozes-rede-nav.prev');
    const next  = root.querySelector('.vozes-rede-nav.next');
    const total = cards.length;

    if (!track || !total) return;

    let perView = 1;
    let index   = 0;

    function computePerView() {
        if (total === 1) return 1;
        return window.innerWidth >= 900 ? 2 : 1;
    }

    function updateSlider() {
        perView = computePerView();
        root.style.setProperty('--per-view', perView);

        const maxIndex = Math.max(0, total - perView);
        if (index > maxIndex) index = maxIndex;

        const offset = (100 / perView) * index;
        track.style.transform = 'translateX(-' + offset + '%)';

        const needNav = total > perView;
        if (prev && next) {
            prev.style.display = needNav ? '' : 'none';
            next.style.display = needNav ? '' : 'none';
            prev.disabled = index === 0;
            next.disabled = index >= maxIndex;
        }
    }

    if (prev) {
        prev.addEventListener('click', function() {
            if (index > 0) {
                index--;
                updateSlider();
            }
        });
    }

    if (next) {
        next.addEventListener('click', function() {
            const maxIndex = Math.max(0, total - perView);
            if (index < maxIndex) {
                index++;
                updateSlider();
            }
        });
    }

    window.addEventListener('resize', updateSlider);
    updateSlider();
})();
</script>
