<?php
/**
 * Dobra: Caixa dupla com botões
 * Slug esperado: pagina-caixa_com_botoes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Flexible: campos da dobra
$caixas = get_sub_field( 'caixas' );

if ( empty( $caixas ) || ! is_array( $caixas ) ) {
    return;
}

// ID único para não conflitar com outras instâncias
$uid = 'lilacs-caixas-botoes-' . get_the_ID() . '-' . get_row_index();

// Quantidade de caixas (para tratar 1 x 100% de largura)
$caixas_count = count( $caixas );
?>

<style>
#<?php echo esc_attr( $uid ); ?> {
    max-width: 1180px;
    margin: 40px auto 60px;
    padding: 0 16px;
}

/* Grid das caixas: 2 colunas em desktop */
#<?php echo esc_attr( $uid ); ?> .caixas-botoes-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;
}

/* Quando houver apenas 1 caixa, 1 coluna (100% largura) */
#<?php echo esc_attr( $uid ); ?> .caixas-botoes-grid.is-single {
    grid-template-columns: minmax(0, 1fr);
}

/* Caixa */
#<?php echo esc_attr( $uid ); ?> .caixa-botoes-item {
    border-radius: 18px;
    padding: 24px 28px;
    color: #ffffff;
    background: linear-gradient(90deg, #7b2cbf 0%, #005fa3 100%);
    box-shadow: 0 18px 35px rgba(15, 23, 42, 0.18);
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* Título da caixa */
#<?php echo esc_attr( $uid ); ?> .caixa-botoes-titulo {
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 18px;
}

/* Área dos botões */
#<?php echo esc_attr( $uid ); ?> .caixa-botoes-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

/* Botão */
#<?php echo esc_attr( $uid ); ?> .caixa-botoes-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 20px;
    border-radius: 999px;
    background: #ffffff;
    color: #0b2144;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 6px 14px rgba(15, 23, 42, 0.15);
    transition: background 0.15s ease, color 0.15s ease, transform 0.15s ease,
        box-shadow 0.15s ease;
}

#<?php echo esc_attr( $uid ); ?> .caixa-botoes-btn:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: translateY(-1px);
    box-shadow: 0 10px 20px rgba(15, 23, 42, 0.20);
}

/* Responsivo */
@media (max-width: 900px) {
    #<?php echo esc_attr( $uid ); ?> .caixas-botoes-grid {
        grid-template-columns: minmax(0, 1fr);
    }
}
</style>

<section id="<?php echo esc_attr( $uid ); ?>" class="lilacs-caixa-com-botoes">

    <div class="caixas-botoes-grid <?php echo $caixas_count === 1 ? 'is-single' : ''; ?>">
        <?php foreach ( $caixas as $caixa ) :
            $titulo_caixa = isset( $caixa['titulo_da_caixa'] ) ? trim( (string) $caixa['titulo_da_caixa'] ) : '';
            $botoes       = isset( $caixa['botoes'] ) && is_array( $caixa['botoes'] ) ? $caixa['botoes'] : [];
        ?>
            <article class="caixa-botoes-item">
                <?php if ( $titulo_caixa ) : ?>
                    <h3 class="caixa-botoes-titulo">
                        <?php echo esc_html( $titulo_caixa ); ?>
                    </h3>
                <?php endif; ?>

                <?php if ( $botoes ) : ?>
                    <div class="caixa-botoes-actions">
                        <?php foreach ( $botoes as $btn ) :
                            $titulo_btn = isset( $btn['titulo_botao'] ) ? trim( (string) $btn['titulo_botao'] ) : '';
                            $link_btn   = isset( $btn['link_botao'] ) ? esc_url( $btn['link_botao'] ) : '';
                            if ( ! $titulo_btn ) {
                                continue;
                            }
                        ?>
                            <?php if ( $link_btn ) : ?>
                                <a class="caixa-botoes-btn" href="<?php echo $link_btn; ?>" target="_blank" rel="noopener">
                                    <?php echo esc_html( $titulo_btn ); ?>
                                </a>
                            <?php else : ?>
                                <span class="caixa-botoes-btn">
                                    <?php echo esc_html( $titulo_btn ); ?>
                                </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>
