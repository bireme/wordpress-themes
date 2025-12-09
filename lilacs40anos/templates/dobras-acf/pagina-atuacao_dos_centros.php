<?php
/**
 * Dobra: Atuação dos Centros
 * Slug esperado: pagina-atuacao_dos_centros
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// repeater
$atuacoes = get_sub_field( 'atuacao' );

if ( empty( $atuacoes ) || ! is_array( $atuacoes ) ) {
    return;
}

$section_id = 'lilacs-atuacao-centros-' . get_the_ID() . '-' . get_row_index();


$titulo_da_dobra = get_sub_field('titulo');

?>

<style>
/* --------------------------------------------------------- */
/* Sessão: Cada Centro pode atuar como                       */
/* --------------------------------------------------------- */

#<?php echo esc_attr( $section_id ); ?> {
    background-color: #ffffff;
    padding: 40px 0 60px;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Título da sessão */
#<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-heading {
    margin-bottom: 24px;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-heading h2 {
    font-size: 30px;
    line-height: 1.3;
    font-weight: 700;
    color: #0b2c68; /* azul institucional */
}

/* Grid 3x3 */
#<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-grid {
    display: grid;
    grid-template-columns: repeat(1, minmax(0,1fr));
    gap: 16px 18px;
}

@media (min-width: 768px) {
    #<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-grid {
        grid-template-columns: repeat(2, minmax(0,1fr));
    }
}

@media (min-width: 1024px) {
    #<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-grid {
        grid-template-columns: repeat(3, minmax(0,1fr));
    }
}

/* Card */
#<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-card {
    background-color: #f5f7fb;                 /* fundo suave como no layout */
    border-radius: 12px;
    border: 1px solid #e0e4f0;
    padding: 22px 22px 20px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-card:hover {
    border-color: #c3cbe4;
    box-shadow: 0 12px 26px rgba(15,23,42,0.08);
    transform: translateY(-2px);
}

/* cabeçalho: ícone + título */
#<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-card-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 10px;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-icon img {
    max-width: 36px;
    max-height: 36px;
    display: block;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-title {
    font-size: 18px;
    font-weight: 700;
    color: #0b2c68;
    line-height: 1.4;
}
.lilacs-atuacao-desc p{
    font-size:16px;
}
/* descrição */
#<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-desc {
    font-size: 14px;
    line-height: 1.6;
    color: #374151;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-atuacao-desc p {
    margin: 0;
}
</style>

<section id="<?php echo esc_attr( $section_id ); ?>" class="lilacs-atuacao-centros">
    <div class="lilacs-atuacao-inner">

        <div class="lilacs-atuacao-heading">
            <h2><?= $titulo_da_dobra; ?></h2>
        </div>

        <div class="lilacs-atuacao-grid">
            <?php foreach ( $atuacoes as $item ) :

                $titulo    = isset( $item['titulo'] ) ? $item['titulo'] : '';
                $icone     = isset( $item['iconeimagem'] ) ? $item['iconeimagem'] : '';
                $descricao = isset( $item['descricao'] ) ? $item['descricao'] : '';
                $link      = isset( $item['link'] ) ? $item['link'] : '';

                if ( is_array( $icone ) && isset( $icone['url'] ) ) {
                    $icone = $icone['url'];
                }
            ?>
                <article class="lilacs-atuacao-card">
                    <div class="lilacs-atuacao-card-header">
                            <?php if ( $icone ) : ?>
                        <div class="lilacs-atuacao-icon">
                 
                                <img src="<?php echo esc_url( $icone ); ?>" alt="" loading="lazy">
                      
                        </div>
                         <?php endif; ?>

                        <?php if ( $titulo ) : ?>
                            <h3 class="lilacs-atuacao-title">
                                <?php echo esc_html( $titulo ); ?>
                            </h3>
                        <?php endif; ?>
                    </div>

                    <?php if ( $descricao ) : ?>
                        <div class="lilacs-atuacao-desc">
                            <?php echo wp_kses_post( $descricao ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $link ) : ?>
                        <!-- link opcional apenas no texto, layout original não mostra botão -->
                        <div style="margin-top:8px;font-size:13px;">
                            <a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer" style="color:#0b2c68;font-weight:600;text-decoration:underline;">
                                <?php esc_html_e( 'Saiba mais', 'rede-bvs' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
