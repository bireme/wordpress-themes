<?php

$fundo = get_sub_field('imagem_de_fundo_');
$cor_de_fundo = get_sub_field('cor_de_fundo');  
$linkc = get_sub_field('link');


?>

<section class="pagina-banner_simples" style="height:450px;    background-position: center; background-image: url('<?php echo esc_url($fundo); ?>'); background-color: <?php echo esc_attr($cor_de_fundo); ?>;">
    <div class="pagina-banner_simples__content">
        <a href="<?php echo esc_url($linkc); ?>" style="height: 450px;display: block;width: 100%;" class="pagina-banner_simples__link">
         
        </a>
    </div>
</section>