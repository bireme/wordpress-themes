<?php
// Requer as variáveis de configuração definidas em header.php
global $titulo, $texto, $imagem_url, $cor_fundo, $cor_titulo, $cor_texto;
?>
<section class="lilacs-banner">
    <div class="lilacs-banner-content">
        <div class="text-column">
            <h1><?php echo $titulo; ?></h1>
            <p><?php echo $texto; ?></p>
        </div>
        <div class="image-column">
            <img src="<?php echo $imagem_url; ?>" alt="Imagem de Destaque">
        </div>
    </div>
</section>