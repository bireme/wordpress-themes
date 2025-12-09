<?php



$titulo = get_sub_field('titulo');
$texto = get_sub_field('conteudo_textual');

?>

<style>
.sobre-destaques {
    padding: 30px 0;
}

.sobre-destaques-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}
.sobre-destaques h2{
    color:#28367D;
    font-size:32px;
}
</style>


<section class="sobre-destaques">
    <div class="sobre-destaques-inner">
        <h2><?= $titulo; ?></h2>
        <?= $texto; ?>
    </div>
</section>