<?php
if (!defined('ABSPATH')) exit;

// Campos do ACF
$titulo = get_sub_field('titulo');
$itens  = get_sub_field('acesso_rapido'); // repeater anônimo no ACF
?>

<section class="home-acesso-rapido">
    <div class="home-acesso-rapido-inner">

        <div class="acesso-rapido-box">
            
            <?php if ($titulo): ?>
                <div class="acesso-rapido-label">
                    <?php echo esc_html($titulo); ?>
                </div>
            <?php endif; ?>

            <div class="acesso-rapido-itens">
                <?php if ($itens): foreach ($itens as $item): 
                    $img = $item['logoimagem'];
                    $link = $item['link'];
                ?>
                    <a href="<?php echo esc_url($link); ?>" class="acesso-rapido-item" target="_blank" rel="noopener">
                        <?php if ($img): ?>
                            <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
                        <?php endif; ?>
                    </a>
                <?php endforeach; endif; ?>
            </div>

        </div>

    </div>
</section>

<style>
.home-acesso-rapido {
    padding: 40px 0;
}

.home-acesso-rapido-inner {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 16px;
}

.acesso-rapido-box {
    background: #085695; /* azul do tema */
    padding: 24px 40px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 40px;
}

.acesso-rapido-label {
    font-weight: 600;
    font-size: 16px;
    color: #ffffff;
    white-space: nowrap;
}

.acesso-rapido-itens {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 50px;
    width: 100%;
}

.acesso-rapido-item img {
    max-height: 54px;
    width: auto;
    display: block;
    transition: opacity .2s ease;
}

.acesso-rapido-item:hover img {
    opacity: .8;
}

@media (max-width: 768px) {
    .acesso-rapido-box {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    .acesso-rapido-itens {
        flex-wrap: wrap;
        gap: 30px;
    }
}
</style>
