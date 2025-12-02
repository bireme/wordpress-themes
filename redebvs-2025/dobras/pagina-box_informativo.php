<?php
/**
 * Dobra: Produtos – Box Informativo
 * Arquivo: produtos-box_informativo.php
 * Local: /dobras/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Repeater ACF
$boxes = get_sub_field('box_informativo');

if ( empty($boxes) ) return;

// Quantidade para definir colunas
$count = count($boxes);

// Define a classe de grid conforme quantidade
$grid_class = 'grid-4'; // padrão 4 colunas

if ($count === 1) {
    $grid_class = 'grid-1';
} elseif ($count === 2) {
    $grid_class = 'grid-2';
} elseif ($count === 3) {
    $grid_class = 'grid-3';
}
?>

<section class="produtos-box-informativo">
    <div class="container">

        <div class="produtos-box-wrapper <?php echo esc_attr($grid_class); ?>">

            <?php foreach ( $boxes as $box ) :

                $imagem  = $box['imagem_de_fundo'];
                $titulo  = $box['titulo'];
                $link    = $box['link_do_box'];

                $bg_url  = $imagem && isset($imagem['url']) ? $imagem['url'] : '';
            ?>

                <a class="produto-box-item" 
                   href="<?php echo esc_url($link); ?>"
                   style="background-image:url('<?php echo esc_url($bg_url); ?>');">

                    <div class="produto-box-overlay">
                        <h3><?php echo esc_html($titulo); ?></h3>
                    </div>

                </a>

            <?php endforeach; ?>

        </div>

    </div>
</section>

<style>
/* --- GRID DINÂMICO --- */
.produtos-box-wrapper {
    display: grid;
    gap: 24px;
}

/* 1 box */
.produtos-box-wrapper.grid-1 {
    grid-template-columns: 1fr;
}

/* 2 boxes */
.produtos-box-wrapper.grid-2 {
    grid-template-columns: repeat(2, 1fr);
}

/* 3 boxes */
.produtos-box-wrapper.grid-3 {
    grid-template-columns: repeat(3, 1fr);
}

/* 4 ou mais */
.produtos-box-wrapper.grid-4 {
    grid-template-columns: repeat(4, 1fr);
}

/* --- ITEM --- */
.produto-box-item {
    display: block;
    position: relative;
    height: 180px;
    border-radius: 20px 80px 20px 20px; /* curva como no layout */
    background-size: cover;
    background-position: center;
    overflow: hidden;
    text-decoration: none;
}
.produtos-box-informativo{
    padding-left: 15px;
    padding-right: 15px;
    margin-top: 20px;
    margin-bottom: 20px;
}

.produto-box-overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 20px;
    color: #fff;
    background: linear-gradient(0deg, rgba(5,34,89,0.8), rgba(5,34,89,0.2));
}

.produto-box-overlay h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
}

/* --- RESPONSIVO --- */
@media (max-width: 900px) {
    .produtos-box-wrapper.grid-4,
    .produtos-box-wrapper.grid-3 {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .produtos-box-wrapper {
        grid-template-columns: 1fr;
    }
}
</style>
