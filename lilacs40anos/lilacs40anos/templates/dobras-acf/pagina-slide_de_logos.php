<?php
/**
 * Dobra: Slide de Logos
 * Slug esperado: pagina-slide_de_logos
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Campos ACF da dobra
$titulo      = get_sub_field( 'titulo_da_sessao' );
$descricao   = get_sub_field( 'descricao_da_sessao' );
$logos       = get_sub_field( 'logos' );

if ( ! $logos || ! is_array( $logos ) ) {
    return;
}

$uid   = 'slide-logos-' . get_the_ID() . '-' . get_row_index();
$total = count( $logos );

// Defaults
if ( ! $titulo ) {
    $titulo = __( 'Coordenadores da rede LILACS', 'rede-bvs' );
}
?>

<style>
#<?php echo esc_attr( $uid ); ?> {
    background: #ffffff;
    padding: 40px 0 60px;
}

/* container interno */
#<?php echo esc_attr( $uid ); ?> .logos-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

/* título + descrição */
#<?php echo esc_attr( $uid ); ?> .logos-header {
    text-align: left;
    margin-bottom: 28px;
}

#<?php echo esc_attr( $uid ); ?> .logos-title {
    font-size: 30px;
    font-weight: 700;
    color: #0b2144;
    margin: 0 0 8px;
}

#<?php echo esc_attr( $uid ); ?> .logos-desc {
    font-size: 15px;
    line-height: 1.6;
    color: #4b5563;
    max-width: 640px;
}

/* slider */
#<?php echo esc_attr( $uid ); ?> .logos-slider {
    position: relative;
    --per-view: 6; /* valor padrão, recalculado via JS */
}

#<?php echo esc_attr( $uid ); ?> .logos-viewport {
    overflow: hidden;
    padding: 16px 0 6px;
}

#<?php echo esc_attr( $uid ); ?> .logos-track {
    display: flex;
    align-items: center;
    transition: transform 0.45s ease;
}

/* item logo */
#<?php echo esc_attr( $uid ); ?> .logo-item {
    flex: 0 0 calc(100% / var(--per-view));
    display: flex;
    justify-content: center;
    align-items: center;
    box-sizing: border-box;
}

#<?php echo esc_attr( $uid ); ?> .logo-item a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

#<?php echo esc_attr( $uid ); ?> .logo-img {
max-width: 140px;
    max-height: 125px;
    width: auto;
    height: auto;
    object-fit: contain;
    transition: transform 0.15s 
ease, box-shadow 0.15s 
ease;
    background: #ffffff;
    padding: 6px 10px;
}

#<?php echo esc_attr( $uid ); ?> .logo-item a:hover .logo-img,
#<?php echo esc_attr( $uid ); ?> .logo-item:hover .logo-img {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 22px rgba(15,23,42,0.2);
}

/* navegação (setas) */
#<?php echo esc_attr( $uid ); ?> .logos-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    border-radius: 999px;
    border: none;
    padding: 0;
    background: #ffffff;
    box-shadow: 0 6px 18px rgba(15,23,42,0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #0b2144;
    transition: background 0.15s ease, transform 0.15s ease, box-shadow 0.15s ease;
    z-index: 2;
}

#<?php echo esc_attr( $uid ); ?> .logos-nav:hover:not(:disabled) {
    background: #edf2ff;
    transform: translateY(-50%) scale(1.05);
    box-shadow: 0 10px 24px rgba(15,23,42,0.45);
}

#<?php echo esc_attr( $uid ); ?> .logos-nav:disabled {
    opacity: 0.35;
    cursor: default;
    box-shadow: none;
}

#<?php echo esc_attr( $uid ); ?> .logos-nav.prev {
    left: -6px;
}

#<?php echo esc_attr( $uid ); ?> .logos-nav.next {
    right: -6px;
}

#<?php echo esc_attr( $uid ); ?> .logos-nav svg {
    width: 18px;
    height: 18px;
}

/* dots */
#<?php echo esc_attr( $uid ); ?> .logos-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 10px;
}

#<?php echo esc_attr( $uid ); ?> .logos-dot {
    width: 8px;
    height: 8px;
    border-radius: 999px;
    border: none;
    padding: 0;
    background: #d1d5db;
    cursor: pointer;
    transition: background 0.15s ease, transform 0.15s ease, width 0.15s ease;
}

#<?php echo esc_attr( $uid ); ?> .logos-dot.is-active {
    background: #0b2144;
    transform: scale(1.2);
    width: 18px;
}

/* responsivo */
@media (max-width: 1024px) {
    #<?php echo esc_attr( $uid ); ?> .logos-nav.prev {
        left: 0;
    }
    #<?php echo esc_attr( $uid ); ?> .logos-nav.next {
        right: 0;
    }
}

@media (max-width: 768px) {
    #<?php echo esc_attr( $uid ); ?> .logos-header {
        text-align: center;
    }
    #<?php echo esc_attr( $uid ); ?> .logos-desc {
        margin: 0 auto;
    }
}

@media (max-width: 640px) {
    #<?php echo esc_attr( $uid ); ?> .logos-nav {
        width: 32px;
        height: 32px;
    }
}
</style>

<section id="<?php echo esc_attr( $uid ); ?>" class="lilacs-slide-logos">
    <div class="logos-inner">
        <div class="logos-header">
            <h2 class="logos-title"><?php echo esc_html( $titulo ); ?></h2>
            <?php if ( $descricao ) : ?>
                <p class="logos-desc"><?php echo esc_html( $descricao ); ?></p>
            <?php endif; ?>
        </div>

        <div class="logos-slider" data-total="<?php echo esc_attr( $total ); ?>">
            <button type="button"
                    class="logos-nav prev"
                    aria-label="<?php esc_attr_e( 'Logos anteriores', 'rede-bvs' ); ?>">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 5l-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div class="logos-viewport">
                <div class="logos-track">
                    <?php foreach ( $logos as $linha ) :
                        $logo_url = ! empty( $linha['logo'] ) ? esc_url( $linha['logo'] ) : '';
                        $logo_link = ! empty( $linha['link_do_logo'] ) ? esc_url( $linha['link_do_logo'] ) : '';
                        if ( ! $logo_url ) {
                            continue;
                        }
                    ?>
                        <div class="logo-item">
                            <?php if ( $logo_link ) : ?>
                                <a href="<?php echo $logo_link; ?>" target="_blank" rel="noopener">
                                    <img src="<?php echo $logo_url; ?>" alt="" class="logo-img">
                                </a>
                            <?php else : ?>
                                <img src="<?php echo $logo_url; ?>" alt="" class="logo-img">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="button"
                    class="logos-nav next"
                    aria-label="<?php esc_attr_e( 'Próximos logos', 'rede-bvs' ); ?>">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <div class="logos-dots" aria-hidden="true"></div>
    </div>
</section>

<script>
(function() {
    const root  = document.getElementById('<?php echo esc_js( $uid ); ?>');
    if (!root) return;

    const slider   = root.querySelector('.logos-slider');
    const track    = root.querySelector('.logos-track');
    const items    = track ? track.children : [];
    const prevBtn  = root.querySelector('.logos-nav.prev');
    const nextBtn  = root.querySelector('.logos-nav.next');
    const dotsWrap = root.querySelector('.logos-dots');

    const total = items.length;
    if (!slider || !track || !total) return;

    let perView = 6;
    let pages   = 1;
    let page    = 0;

    function computePerView() {
        if (total <= 2) return total;
        const w = window.innerWidth || document.documentElement.clientWidth;

        if (w >= 1200) return Math.min(6, total);
        if (w >= 992)  return Math.min(5, total);
        if (w >= 768)  return Math.min(4, total);
        if (w >= 576)  return Math.min(3, total);
        return Math.min(2, total);
    }

    function rebuildDots() {
        if (!dotsWrap) return;

        dotsWrap.innerHTML = '';
        if (pages <= 1) {
            dotsWrap.style.display = 'none';
            return;
        }

        dotsWrap.style.display = 'flex';

        for (let i = 0; i < pages; i++) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'logos-dot' + (i === page ? ' is-active' : '');
            btn.setAttribute('aria-label', 'Ir para slide ' + (i + 1));
            btn.addEventListener('click', function() {
                page = i;
                updateSlider();
            });
            dotsWrap.appendChild(btn);
        }
    }

    function updateDotsActive() {
        if (!dotsWrap || pages <= 1) return;
        const dots = dotsWrap.querySelectorAll('.logos-dot');
        dots.forEach(function(d, i) {
            d.classList.toggle('is-active', i === page);
        });
    }

    function updateSlider() {
        perView = computePerView();
        root.style.setProperty('--per-view', perView);

        pages = Math.max(1, Math.ceil(total / perView));
        if (page > pages - 1) {
            page = pages - 1;
        }

        const offset = page * 100; // cada página = 100% da viewport
        track.style.transform = 'translateX(-' + offset + '%)';

        const needNav = pages > 1;

        if (prevBtn && nextBtn) {
            prevBtn.style.display = needNav ? '' : 'none';
            nextBtn.style.display = needNav ? '' : 'none';

            prevBtn.disabled = page === 0;
            nextBtn.disabled = page >= pages - 1;
        }

        if (dotsWrap) {
            if (dotsWrap.children.length !== pages) {
                rebuildDots();
            } else {
                updateDotsActive();
            }
        }
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            if (page > 0) {
                page--;
                updateSlider();
            }
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            if (page < pages - 1) {
                page++;
                updateSlider();
            }
        });
    }

    window.addEventListener('resize', updateSlider);
    updateSlider();
})();
</script>
