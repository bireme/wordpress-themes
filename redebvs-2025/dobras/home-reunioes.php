<?php
if (!defined('ABSPATH')) exit;

// Campos da layout "reunioes"
$titulo     = get_sub_field('titulo');
$descricao  = get_sub_field('descricao');
$rss_url    = get_sub_field('url_do_rss');
$modo       = get_sub_field('modo_'); // checkbox (array ou string)
$modo_array = is_array($modo) ? $modo : ( $modo ? array($modo) : array() );
$is_manual  = in_array('Manual', $modo_array, true);
?>
<style>
/* REUNIÕES */

.home-reunioes {
    padding: 40px 0;
    background: #F1F1F1;
}

.home-reunioes-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px 30px;
}

/* Header */
.home-reunioes-header {
    margin-bottom: 24px;
}

.home-reunioes-header h2 {
    font-size: 32px;
    color: #003c71;
    margin: 0 0 6px;
    font-weight: 700;
}

.home-reunioes-header p {
    margin: 0;
    max-width: 100%;
    font-size: 16px;
    color: #28367D;
}

/* Cards */
.home-reunioes-cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.reuniao-card {
    flex: 1 1 calc(33.333% - 20px);
    min-width: 260px;
}

.reuniao-card-inner {
background: #ffffff;
    border-radius: 10px 30px 10px 10px;
    padding: 18px 22px;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.02);
    min-height: 133px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.reuniao-card-title {
    font-size: 16px;
    font-weight: 600;
    color: #28367D;
    line-height: 1.5;
    margin: 0 0 8px;
}

.reuniao-card-meta {
    font-size: 11px;
    color: #777;
    margin: 0;
}

/* Footer com botão Ver todos */
.home-reunioes-footer {
    margin-top: 20px;
    text-align: right;
}

.home-reunioes-ver-todos {
    display: inline-block;
    padding: 8px 45px;
    background: #233a8b;
    color: #fff;
    border-radius: 999px;
    text-decoration: none;
    font-size: 13px;
}

/* Responsivo */
@media (max-width: 768px) {
    .reuniao-card {
        flex: 1 1 100%;
    }
}
</style>

<section class="home-reunioes">
    <div class="home-reunioes-inner">

        <header class="home-reunioes-header">
            <?php if ($titulo): ?>
                <h2><?php echo esc_html($titulo); ?></h2>
            <?php endif; ?>

            <?php if ($descricao): ?>
                <p><?php echo esc_html($descricao); ?></p>
            <?php endif; ?>
        </header>

        <?php if ( $is_manual && have_rows('url_do_rss_copiar') ) : ?>

            <div class="home-reunioes-cards">
                <?php while ( have_rows('url_do_rss_copiar') ) : the_row();
                    $titulo_card = get_sub_field('titulo');
                    $linha_inf   = get_sub_field('linha_inferior');
                    $linha_link   = get_sub_field('link_do_rss');
                ?>
                    <article class="reuniao-card">
                        <a style="text-decoration:none;" href="<?=$linha_link?>">
                        <div class="reuniao-card-inner">
                            <?php if ( $titulo_card ) : ?>
                                <h3 class="reuniao-card-title">
                                    <?php echo esc_html( $titulo_card ); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ( $linha_inf ) : ?>
                                <p class="reuniao-card-meta">
                                    <?php echo esc_html( $linha_inf ); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="home-reunioes-footer">
               
                    <a href="<?php echo esc_url($rss_url); ?>" class="home-reunioes-ver-todos">
                        Ver todos
                    </a>
               
            </div>

        <?php else : ?>

            <!-- Modo RSS ou sem itens manuais: placeholder antigo -->
            <?php if ( $rss_url ): ?>
                <a href="<?php echo esc_url($rss_url); ?>" target="_blank" class="home-reunioes-ver-todos">
                    Ver RSS
                </a>
            <?php else: ?>
                <p>Em breve: listagem das últimas reuniões via RSS.</p>
            <?php endif; ?>

        <?php endif; ?>

    </div>
</section>
