<?php
/**
 * Dobra: Destaques
 * Arquivo: dobras/home-destaques.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Repeater "banners" do layout "destaques"
$banners = get_sub_field( 'banners' );
if ( ! $banners ) {
    return;
}
?>
<style>
/* --- DOBRA DESTAQUES (HOME) --- */

.home-destaques {
    padding: 30px 0;
}

.home-destaques-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

/* Slider */
.home-destaques-slider {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.destaques-track {
    display: flex;
    transition: transform 0.5s ease;
}

/* 1 banner por vez, 100% da largura do container */
.destaque-slide {
min-width: 100%;
    box-sizing: border-box;
    max-height: 524px;
    
}

.destaque-slide img {
    width: 100%;
    height: auto;
    border-radius: 24px;
    display: block;
}

/* Navegação */
.destaques-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: #dfe1e7;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 5;
}

.destaques-prev { left: 8px; }
.destaques-next { right: 8px; }

.destaques-nav:hover {
    background: #c7c9d1;
}
</style>

<section class="home-destaques">
    <div class="home-destaques-inner">

        <div class="home-destaques-slider">

            <button class="destaques-nav destaques-prev" type="button"><img style=" max-width: 8px;transform: rotate(180deg);" src="https://floralwhite-lion-322305.hostingersite.com/wp-content/uploads/2025/11/arrow_right.png"></button>

            <div class="destaques-track">
                <?php foreach ( $banners as $banner ) :

                    $img = $banner['imagem_do_banner'] ?? null;
                    $url = $banner['link_banner'] ?? '';
                    if ( ! $img ) {
                        continue;
                    }

                    $src = $img['url'] ?? '';
                    $alt = $img['alt'] ?? '';
                ?>
                    <div class="destaque-slide">
                        <?php if ( $url ) : ?>
                            <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener">
                                <img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
                            </a>
                        <?php else : ?>
                            <img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="destaques-nav destaques-next" type="button"><img style="    max-width: 8px;" src="https://floralwhite-lion-322305.hostingersite.com/wp-content/uploads/2025/11/arrow_right.png"></button>

        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.querySelector('.home-destaques');
    if (!wrapper) return;

    const track  = wrapper.querySelector('.destaques-track');
    const slides = wrapper.querySelectorAll('.destaque-slide');
    const prev   = wrapper.querySelector('.destaques-prev');
    const next   = wrapper.querySelector('.destaques-next');

    if (!track || slides.length === 0 || !prev || !next) return;

    let current = 0;

    function updateSlide() {
        track.style.transform = 'translateX(-' + (current * 100) + '%)';
    }

    prev.addEventListener('click', function () {
        current = (current <= 0) ? slides.length - 1 : current - 1;
        updateSlide();
    });

    next.addEventListener('click', function () {
        current = (current >= slides.length - 1) ? 0 : current + 1;
        updateSlide();
    });
});
</script>
