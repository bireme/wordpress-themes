<?php
/**
 * Dobra: Título + editor Wysiwyg
 * Slug esperado: pagina-titulo_+_editor_wysing
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Repeater principal
$conteudos_raw = get_sub_field( 'conteudos' ) ?: array();
$total_boxes   = is_array( $conteudos_raw ) ? count( $conteudos_raw ) : 0;

if ( $total_boxes === 0 ) {
    return;
}

$uid = 'lilacs-tpw-' . get_the_ID() . '-' . get_row_index();
?>

<style>
/* ----------------------------- */
/* WRAPPER GERAL                 */
/* ----------------------------- */
/* 1256 = coluna de 1200px da seção seguinte (LILACS Plus) + 28px de
   respiro de cada lado do cartão. O texto fica na mesma margem. */
#<?php echo esc_attr( $uid ); ?> {
    max-width: 1256px;
    width: calc(100% - 32px);
    margin: 36px auto 48px;
    padding: 0;
    box-sizing: border-box;
}

/* Grid de cartões:
   - 2 colunas quando houver 2 ou mais boxes
   - 1 coluna quando houver apenas 1 box
*/
#<?php echo esc_attr( $uid ); ?> .tpw-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;
}

#<?php echo esc_attr( $uid ); ?> .tpw-grid.is-single {
    grid-template-columns: minmax(0, 1fr);
}

/* Cartão individual */
#<?php echo esc_attr( $uid ); ?> .tpw-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px 28px;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
    border: 1px solid rgba(148, 163, 184, 0.35);
}

/* Título da sessão */
#<?php echo esc_attr( $uid ); ?> .tpw-card-title {
    font-size: 20px;
    font-weight: 700;
    color: #0b2c68;
    margin: 0 0 12px;
}

/* Conteúdo vindo do WYSIWYG */
#<?php echo esc_attr( $uid ); ?> .tpw-card-content {
    font-size: 18px;
    line-height: 1.7;
    color: #111827;
}

#<?php echo esc_attr( $uid ); ?> .tpw-card-content h2,
#<?php echo esc_attr( $uid ); ?> .tpw-card-content h3 {
    color: #0b2c68;
    margin-top: 18px;
    margin-bottom: 8px;
}

#<?php echo esc_attr( $uid ); ?> .tpw-card-content a {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
}

#<?php echo esc_attr( $uid ); ?> .tpw-card-content a:hover {
    text-decoration: underline;
}

#<?php echo esc_attr( $uid ); ?> .tpw-card-content p {
    margin: 0 0 12px;
    text-align: left;
}

#<?php echo esc_attr( $uid ); ?> .tpw-card-content p:last-child {
    margin-bottom: 0;
}

/* Ícone alinhado no editor (direita ou esquerda) fica ao lado do bloco
   inteiro, sem encolher só as primeiras linhas do parágrafo. */
#<?php echo esc_attr( $uid ); ?> .tpw-with-media {
    display: flex;
    align-items: center;
    gap: 32px;
}

#<?php echo esc_attr( $uid ); ?> .tpw-with-media.is-left {
    flex-direction: row-reverse;
}

#<?php echo esc_attr( $uid ); ?> .tpw-text {
    flex: 1 1 auto;
    min-width: 0;
}

#<?php echo esc_attr( $uid ); ?> .tpw-media {
    flex: 0 0 auto;
}

#<?php echo esc_attr( $uid ); ?> .tpw-media img {
    display: block;
    float: none !important;
    width: auto;
    max-width: 150px;
    height: auto;
    margin: 0;
}

@media (max-width: 700px) {
    #<?php echo esc_attr( $uid ); ?> .tpw-with-media,
    #<?php echo esc_attr( $uid ); ?> .tpw-with-media.is-left {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
}

/* Responsivo: em telas menores força 1 coluna.
   Abaixo de 1256px o cartão ocupa a largura útil; sem padding horizontal
   o texto continua na mesma margem da seção LILACS Plus. */
@media (max-width: 1288px) {
    #<?php echo esc_attr( $uid ); ?> .tpw-card {
        padding-left: 0;
        padding-right: 0;
    }
}

@media (max-width: 900px) {
    #<?php echo esc_attr( $uid ); ?> .tpw-grid {
        grid-template-columns: minmax(0, 1fr);
    }
}
</style>

<section id="<?php echo esc_attr( $uid ); ?>" class="lilacs-titulo-editor-wysing">
    <div class="tpw-grid <?php echo $total_boxes === 1 ? 'is-single' : ''; ?>">
        <?php if ( have_rows( 'conteudos' ) ) : ?>
            <?php while ( have_rows( 'conteudos' ) ) : the_row(); 
                $titulo   = get_sub_field( 'titulo_da_sessao' );
                $conteudo = get_sub_field( 'conteudo' );
            ?>
                <article class="tpw-card">
                    <?php if ( $titulo ) : ?>
                        <h3 class="tpw-card-title">
                            <?php echo esc_html( $titulo ); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if ( $conteudo ) : ?>
                        <div class="tpw-card-content">
                            <?php
                            // Permite HTML e shortcodes do WYSIWYG
                            echo apply_filters( 'the_content', $conteudo );
                            ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>

<script>
(function () {
    var root = document.getElementById(<?php echo wp_json_encode( $uid ); ?>);
    if (!root) return;

    root.querySelectorAll('.tpw-card-content').forEach(function (content) {
        if (content.querySelector('.tpw-with-media')) return;

        var img = content.querySelector('img.alignright, img.alignleft, img.cad-img');
        if (!img) return;

        var onLeft = img.classList.contains('alignleft') && !img.classList.contains('alignright');

        img.classList.remove('alignleft', 'alignright');
        img.removeAttribute('width');
        img.removeAttribute('height');
        img.style.float = 'none';

        var text = document.createElement('div');
        text.className = 'tpw-text';
        while (content.firstChild) {
            text.appendChild(content.firstChild);
        }

        text.querySelectorAll('p').forEach(function (p) {
            if (p.querySelector('img')) return;
            var plain = (p.textContent || '').replace(/\u00a0/g, '').trim();
            if (!plain) p.remove();
        });

        var media = document.createElement('div');
        media.className = 'tpw-media';
        media.appendChild(img);

        var wrap = document.createElement('div');
        wrap.className = 'tpw-with-media' + (onLeft ? ' is-left' : '');
        wrap.appendChild(text);
        wrap.appendChild(media);
        content.appendChild(wrap);
    });
})();
</script>
