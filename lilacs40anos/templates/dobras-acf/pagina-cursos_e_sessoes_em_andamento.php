<?php
/**
 * Dobra: Cursos e Sessões em Andamento
 * Slug esperado: pagina-cursos_e_sessoes_em_andamento
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$titulo = get_sub_field('titulo_da_sessao');
$itens  = get_sub_field('cursos_sessoes');

if ( empty($itens) ) return;

$uid = 'lilacs-cursos-' . get_the_ID() . '-' . get_row_index();
?>

<style>
/* ----------------------------- */
/* FUNDO DA SESSÃO (FULL WIDTH)  */
/* ----------------------------- */
#<?php echo $uid; ?> {
    background: #f3f4f6; /* cinza claro LILACS-like */
    padding: 40px 0 60px;
}

/* CONTAINER INTERNO 1180px */
#<?php echo $uid; ?> .cursos-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

/* TÍTULO DA SESSÃO */
#<?php echo $uid; ?> .cursos-title {
    font-size: 28px;
    font-weight: 700;
    color: #0b2c68;
    margin-bottom: 28px;
}

/* GRID 2 COLUNAS */
#<?php echo $uid; ?> .cursos-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 26px;
}

/* CARD */
#<?php echo $uid; ?> .curso-card {
    border-radius: 16px;
    padding: 20px 24px;
}

/* TÍTULO DO CARD */
#<?php echo $uid; ?> .curso-card-title {
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 16px;
    color: #0b2c68;
}

/* LINK NO TÍTULO */
#<?php echo $uid; ?> .curso-card-title a {
    color: inherit;
    text-decoration: none;
    border-bottom: 1px solid transparent;
    transition: border-color 0.2s ease, color 0.2s ease;
}

#<?php echo $uid; ?> .curso-card-title a:hover {
    color: #1d4ed8;
    border-bottom-color: #1d4ed8;
}

/* CONTEÚDO WYSIWYG */
#<?php echo $uid; ?> .curso-content {
    font-size: 15px;
    line-height: 1.7;
    color: #111827;
}

#<?php echo $uid; ?> .curso-content img {
    max-width: 100%;
    border-radius: 12px;
    margin: 10px 0;
}

#<?php echo $uid; ?> .curso-content table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 12px;
}

#<?php echo $uid; ?> .curso-content table td,
#<?php echo $uid; ?> .curso-content table th {
    border: 1px solid #d1d5db;
    padding: 8px;
}

/* RESPONSIVO */
@media (max-width: 900px) {
    #<?php echo $uid; ?> .cursos-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<section id="<?php echo esc_attr($uid); ?>" class="lilacs-cursos-sessoes">
    <div class="cursos-inner">

        <?php if ( $titulo ) : ?>
            <h2 class="cursos-title"><?php echo esc_html( $titulo ); ?></h2>
        <?php endif; ?>

        <div class="cursos-grid">
            <?php foreach ( $itens as $item ) :

                $titulo_item   = isset($item['titulo']) ? $item['titulo'] : '';
                $conteudo_item = isset($item['video_imagem_conteudo']) ? $item['video_imagem_conteudo'] : '';
                $link_titulo   = isset($item['link_do_titulo']) ? $item['link_do_titulo'] : '';

            ?>
                <article class="curso-card">

                    <?php if ( $titulo_item ) : ?>
                        <h3 class="curso-card-title">
                            <?php if ( ! empty( $link_titulo ) ) : ?>
                                <a href="<?php echo esc_url( $link_titulo ); ?>" target="_blank" rel="noopener">
                                    <?php echo esc_html( $titulo_item ); ?>
                                </a>
                            <?php else : ?>
                                <?php echo esc_html( $titulo_item ); ?>
                            <?php endif; ?>
                        </h3>
                    <?php endif; ?>

                    <?php if ( $conteudo_item ) : ?>
                        <div class="curso-content">
                            <?php echo apply_filters( 'the_content', $conteudo_item ); ?>
                        </div>
                    <?php endif; ?>

                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
