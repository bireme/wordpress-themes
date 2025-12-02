<?php
$portais = get_sub_field('grupos_de_portais');

if ($portais && is_array($portais)) :

    $total = count($portais);
    $ultimo_duplo = ($total % 3 == 1); // ativa o modo de card maior
?>

    <section class="sobre-portais">
        <div class="sobre-portais-inner">

            <div class="grid-portais">
        
                <?php foreach ($portais as $index => $portal): 
        
     
                    // Se for o último item e a regra for verdadeira, aplica classe especial
                    $classe = '';
                    if ($ultimo_duplo && $index == $total - 1) {
                        $classe = ' card-portal-triplo';
                    }
                ?>
        
                    <div class="card-portal<?= $classe; ?>">
                       <?php  if($portal['link_do_portal']){ ?>
                        <a href="<?= $portal['link_do_portal']?>">
                        <?php    }?>
                        <?php 
                        if($portal['icone_do_portal'] != ""){ ?>
                        <div class="card-portal-img">
                            <img src="<?=$portal['icone_do_portal'];?>">
                        </div>
                        <?php } ?>
                        <h3 class="portal-titulo">
                            <?= esc_html($portal['titulo']); ?>
                        </h3>
        
                        <p class="portal-descricao">
                            <?= nl2br(esc_html($portal['descricao'])); ?>
                        </p>
                        <?php  if($portal['link_do_portal']){?>  </a> <?php    }?>
                    </div>
        
                <?php endforeach; ?>
        
            </div>
        </div>
    </section>

<?php endif; ?>

<style>

.sobre-portais {
    padding: 30px 0;
}
.card-portal-img img{
    max-width: 150px;
    object-fit: contain;
    min-height: 85px;
}

.sobre-portais-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}
    
.grid-portais {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin: 40px 0;
}

.card-portal a{
    text-decoration: none;
}

.card-portal {
    background: #f5f7fa;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.card-portal-triplo {
    grid-column: span 3; /* último card ocupa duas colunas */
}

.portal-titulo {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 12px;
    color: #233b75;
}

.portal-descricao {
    font-size: 15px;
    line-height: 1.6;
    color: #333;
}
    
</style>