<?php
/**
 * Dobra: Produto – Conteúdo Toogle
 * Slug: produto-conteudo_toogle
 * ACF: layout_69263be563e51
 */

if (!defined('ABSPATH')) exit;

// repeater
$conteudos = get_sub_field('conteudos');

if (empty($conteudos)) return;
?>

<section class="produto-toogle-wrapper">
    <div class="container">

        <div class="produto-toogle-list">

            <?php foreach ($conteudos as $index => $item) :

                $titulo   = $item['titulo'] ?? '';
                $conteudo = $item['conteudo'] ?? '';
                $id       = 'toggle-item-' . $index;
            ?>

                <div class="toggle-item" data-toggle="<?php echo esc_attr($id); ?>">

                    <button class="toggle-header" aria-expanded="false">
                        <span class="toggle-title"><?php echo esc_html($titulo); ?></span>
                        <span class="toggle-icon">+</span>
                    </button>

                    <div class="toggle-content" id="<?php echo esc_attr($id); ?>">
                        <div class="toggle-content-inner">
                            <?php echo wp_kses_post($conteudo); ?>
                        </div>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>
</section>


<style>
/* ---- WRAPPER ---- */
.produto-toogle-wrapper {
    padding: 40px 0;
}

.produto-toogle-list {
    max-width: 100%
    margin: 0 auto;
}

/* ---- ITEM ---- */
.toggle-item {
    border-bottom: 1px solid #e5e5e5;;
    background: #F2F2F2;
    margin-bottom: 10px;
    padding: 13px;
    border-radius: 10px;
}

/* ---- HEADER ---- */
.toggle-header {
    width: 100%;
    background: none;
    border: none;
    padding: 0;
    font-size: 18px;
    font-weight: 600;
    color: #003A70;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

.toggle-header:focus {
    outline: none;
}

/* icon */
.toggle-icon {
    font-size: 22px;
    line-height: 1;
    color: #003A70;
    font-weight: bold;
    transition: transform .3s ease;
}

/* ---- CONTENT ---- */
.toggle-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height .35s ease;
}

.toggle-content-inner {
    padding: 15px 0 5px;
    color: #444;
    line-height: 1.6;
}

/* OPEN STATE */
.toggle-item.active .toggle-content {
    max-height: 800px;
}

.toggle-item.active .toggle-icon {
    transform: rotate(180deg);
}

.toggle-item.active .toggle-icon::after {
    content: "-";
}
</style>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const items = document.querySelectorAll(".toggle-item");

    items.forEach(item => {

        let header = item.querySelector(".toggle-header");
        let content = item.querySelector(".toggle-content");
        let icon = item.querySelector(".toggle-icon");

        header.addEventListener("click", function () {

            // fechar todos os outros
            items.forEach(i => {
                if (i !== item) {
                    i.classList.remove("active");
                    i.querySelector(".toggle-header").setAttribute("aria-expanded", "false");
                }
            });

            // alternar atual
            item.classList.toggle("active");

            const expanded = item.classList.contains("active");
            header.setAttribute("aria-expanded", expanded ? "true" : "false");

            // ícone
            icon.textContent = expanded ? "–" : "+";
        });
    });

});
</script>
