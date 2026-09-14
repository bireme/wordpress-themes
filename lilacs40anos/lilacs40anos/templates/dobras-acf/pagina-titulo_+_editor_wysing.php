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
#<?php echo esc_attr( $uid ); ?> {
    max-width: 1180px;
    margin: 40px auto 60px;
    padding: 0 16px;
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
    font-size: 15px;
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

/* Responsivo: em telas menores força 1 coluna */
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
