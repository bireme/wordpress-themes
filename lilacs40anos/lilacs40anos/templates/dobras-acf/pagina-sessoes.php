<?php
/**
 * Dobra: Sessões / Toggles
 * Layout: sessoes
 * Arquivo: pagina-sessoes.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Campos da dobra
$section_title = get_sub_field( 'titulo_da_sessao' );          // Título da SESSÃO
$bg_color      = get_sub_field( 'cor_de_fundo_da_sessao' );    // Cor de fundo da sessão

// Repeater "sessoes"
$sessoes = get_sub_field( 'sessoes' );

// Se não tiver sessões, não renderiza nada
if ( empty( $sessoes ) ) {
    return;
}

$uid = 'lilacs-sessoes-' . get_the_ID() . '-' . get_row_index();

// Estilo inline para o fundo da sessão
$section_style = '';
if ( ! empty( $bg_color ) ) {
    $section_style = ' style="background:' . esc_attr( $bg_color ) . ';"';
}
?>

<style>
/* ----------------------------- */
/* WRAPPER GERAL DA SESSÃO       */
/* ----------------------------- */
#<?php echo esc_attr( $uid ); ?> {
    padding: 40px 16px 60px;
}

/* Wrapper interno com largura máxima */
#<?php echo esc_attr( $uid ); ?> .sessoes-inner {
    max-width: 1180px;
    margin: 0 auto;
}

/* Header da sessão (título da dobra) */
#<?php echo esc_attr( $uid ); ?> .sessoes-section-header {
    margin-bottom: 24px;
}

#<?php echo esc_attr( $uid ); ?> .sessoes-section-title {
    margin: 0;
    font-size: 26px;
    line-height: 1.2;
    font-weight: 700;
    color: #0b2c68;
    font-family: 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* Lista de sessões (toggles) */
#<?php echo esc_attr( $uid ); ?> .sessoes-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Item individual */
#<?php echo esc_attr( $uid ); ?> .sessao-item {
    background: #ffffff;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

/* Cabeçalho (botão do toggle) */
#<?php echo esc_attr( $uid ); ?> .sessao-header {
    width: 100%;
    padding: 14px 18px;
    border: none;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    color: #0b2c68;
    text-align: left;
}

#<?php echo esc_attr( $uid ); ?> .sessao-header:hover {
    background: #e5e7eb;
}

/* Título da sessão (toggle) */
#<?php echo esc_attr( $uid ); ?> .sessao-title {
    margin: 0;
    padding-right: 10px;
}

/* Ícone (setinha) */
#<?php echo esc_attr( $uid ); ?> .sessao-icon {
    flex-shrink: 0;
    font-size: 16px;
    transition: transform 0.2s ease;
}

/* Painel de conteúdo */
#<?php echo esc_attr( $uid ); ?> .sessao-panel {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.25s ease-out;
    background: #ffffff;
}

/* Conteúdo interno do painel */
#<?php echo esc_attr( $uid ); ?> .sessao-panel-inner {
    padding: 16px 18px 18px;
    border-top: 1px solid #e5e7eb;
}

/* Estado aberto */
#<?php echo esc_attr( $uid ); ?> .sessao-item.is-open .sessao-panel {
    max-height: 800px;
    transition: max-height 0.25s ease-in;
}

#<?php echo esc_attr( $uid ); ?> .sessao-item.is-open .sessao-icon {
    transform: rotate(90deg);
}

/* ----------------------------- */
/* ESTILOS DO CONTEÚDO (WYSIWYG) */
/* ----------------------------- */
#<?php echo esc_attr( $uid ); ?> .sessao-content {
    font-size: 15px;
    line-height: 1.7;
    color: #111827;
    font-family: 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

#<?php echo esc_attr( $uid ); ?> .sessao-content p {
    margin-bottom: 12px;
}

#<?php echo esc_attr( $uid ); ?> .sessao-content a {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
}

#<?php echo esc_attr( $uid ); ?> .sessao-content a:hover {
    text-decoration: underline;
}

#<?php echo esc_attr( $uid ); ?> .sessao-content h2,
#<?php echo esc_attr( $uid ); ?> .sessao-content h3,
#<?php echo esc_attr( $uid ); ?> .sessao-content h4 {
    color: #0b2c68;
    margin-top: 18px;
    margin-bottom: 8px;
}

/* Listas */
#<?php echo esc_attr( $uid ); ?> .sessao-content ul,
#<?php echo esc_attr( $uid ); ?> .sessao-content ol {
    padding-left: 20px;
    margin-bottom: 12px;
}

#<?php echo esc_attr( $uid ); ?> .sessao-content li {
    margin-bottom: 4px;
}

/* Imagens responsivas */
#<?php echo esc_attr( $uid ); ?> .sessao-content img {
    max-width: 100%;
    height: auto;
}

/* Classes padrão de alinhamento do editor */
#<?php echo esc_attr( $uid ); ?> .sessao-content .alignleft {
    float: left;
    margin: 0 1.5em 1em 0;
}

#<?php echo esc_attr( $uid ); ?> .sessao-content .alignright {
    float: right;
    margin: 0 0 1em 1.5em;
}

#<?php echo esc_attr( $uid ); ?> .sessao-content .aligncenter {
    display: block;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
}

/* Respeitar text-align inline do WYSIWYG */
#<?php echo esc_attr( $uid ); ?> .sessao-content [style*="text-align:center"] {
    text-align: center;
}

#<?php echo esc_attr( $uid ); ?> .sessao-content [style*="text-align:right"] {
    text-align: right;
}

#<?php echo esc_attr( $uid ); ?> .sessao-content [style*="text-align:left"] {
    text-align: left;
}

/* Responsivo */
@media (max-width: 900px) {
    #<?php echo esc_attr( $uid ); ?> {
        padding: 24px 12px 40px;
    }

    #<?php echo esc_attr( $uid ); ?> .sessoes-section-title {
        font-size: 22px;
    }

    #<?php echo esc_attr( $uid ); ?> .sessao-header {
        padding: 12px 14px;
        font-size: 14px;
    }

    #<?php echo esc_attr( $uid ); ?> .sessao-panel-inner {
        padding: 12px 14px 16px;
    }
}
</style>

<section
    id="<?php echo esc_attr( $uid ); ?>"
    class="lilacs-sessoes-toogle"
    aria-label="<?php esc_attr_e( 'Sessões', 'textdomain' ); ?>"
    <?php echo $section_style; ?>
>
    <div class="sessoes-inner">

        <?php if ( ! empty( $section_title ) ) : ?>
            <header class="sessoes-section-header">
                <h2 class="sessoes-section-title">
                    <?php echo esc_html( $section_title ); ?>
                </h2>
            </header>
        <?php endif; ?>

        <div class="sessoes-list" data-sessoes-accordion>
            <?php
            $index = 0;
            foreach ( $sessoes as $sessao ) :
                $index++;
                $titulo   = isset( $sessao['titulo_da_sessao'] ) ? $sessao['titulo_da_sessao'] : '';
                $conteudo = isset( $sessao['conteudo_da_sessao'] ) ? $sessao['conteudo_da_sessao'] : '';

                // ID único para o painel (acessibilidade)
                $panel_id = $uid . '-panel-' . $index;

                // Se não tiver título e conteúdo, pula
                if ( empty( $titulo ) && empty( $conteudo ) ) {
                    continue;
                }
            ?>
                <article class="sessao-item">
                    <button
                        class="sessao-header"
                        type="button"
                        aria-expanded="false"
                        aria-controls="<?php echo esc_attr( $panel_id ); ?>"
                    >
                        <span class="sessao-title">
                            <?php echo esc_html( $titulo ); ?>
                        </span>
                        <span class="sessao-icon" aria-hidden="true">›</span>
                    </button>

                    <div
                        id="<?php echo esc_attr( $panel_id ); ?>"
                        class="sessao-panel"
                        role="region"
                        aria-hidden="true"
                    >
                        <div class="sessao-panel-inner">
                            <div class="sessao-content">
                                <?php
                                if ( $conteudo ) {
                                    echo apply_filters( 'the_content', $conteudo );
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.querySelector('#<?php echo esc_js( $uid ); ?> [data-sessoes-accordion]');
    if (!wrapper) return;

    const items = wrapper.querySelectorAll('.sessao-item');

    items.forEach(function (item) {
        const header = item.querySelector('.sessao-header');
        const panel  = item.querySelector('.sessao-panel');

        if (!header || !panel) return;

        header.addEventListener('click', function () {
            const isOpen = item.classList.contains('is-open');

            // Fecha todos
            items.forEach(function (other) {
                other.classList.remove('is-open');
                const btn  = other.querySelector('.sessao-header');
                const pnl  = other.querySelector('.sessao-panel');
                if (btn && pnl) {
                    btn.setAttribute('aria-expanded', 'false');
                    pnl.setAttribute('aria-hidden', 'true');
                }
            });

            // Abre o clicado se estava fechado
            if (!isOpen) {
                item.classList.add('is-open');
                header.setAttribute('aria-expanded', 'true');
                panel.setAttribute('aria-hidden', 'false');
            }
        });
    });
});
</script>
