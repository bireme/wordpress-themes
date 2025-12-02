<?php
/**
 * Dobra: Encontros Anteriores
 * Arquivo: pagina-encontros-anteriores.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Campo post_object múltiplo
$anteriores = get_sub_field( 'encontros_anteriores' );

if ( empty( $anteriores ) || ! is_array( $anteriores ) ) {
    return;
}

// Garante que temos sempre objetos WP_Post
$posts_encontros = array_map( function ( $item ) {
    return $item instanceof WP_Post ? $item : get_post( $item );
}, $anteriores );

// Remove nulos
$posts_encontros = array_filter( $posts_encontros );

// Ordena por data DESC (mais recente primeiro)
usort( $posts_encontros, function ( $a, $b ) {
    return get_the_date( 'U', $b->ID ) <=> get_the_date( 'U', $a->ID );
});

// Coleta anos disponíveis
$anos = [];
foreach ( $posts_encontros as $p ) {
    $ano = get_the_date( 'Y', $p->ID );
    if ( $ano ) {
        $anos[ $ano ] = $ano;
    }
}
krsort( $anos );

$uid = uniqid( 'bvs-encontros-anteriores-' );
?>

<section class="bvs-encontros-anteriores">
    <div class="bvs-encontros-anteriores-inner" id="<?php echo esc_attr( $uid ); ?>">

        <div class="bvs-encontros-anteriores-header">
            <h2 class="bvs-encontros-anteriores-title">
                <?php esc_html_e( 'Encontros anteriores', 'rede-bvs' ); ?>
            </h2>

            <?php if ( ! empty( $anos ) ) : ?>
                <div class="bvs-encontros-anteriores-filter">
                    <label class="screen-reader-text" for="<?php echo esc_attr( $uid . '-filter' ); ?>">
                        <?php esc_html_e( 'Filtre por ano', 'rede-bvs' ); ?>
                    </label>
                    <div class="bvs-encontros-anteriores-filter-select-wrap">
                        <select id="<?php echo esc_attr( $uid . '-filter' ); ?>"
                                class="bvs-encontros-anteriores-filter-select">
                            <option value="todos">
                                <?php esc_html_e( 'Filtre por ano', 'rede-bvs' ); ?>
                            </option>
                            <?php foreach ( $anos as $ano ) : ?>
                                <option value="<?php echo esc_attr( $ano ); ?>"><?php echo esc_html( $ano ); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="bvs-encontros-anteriores-filter-icon">▾</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="bvs-encontros-anteriores-grid">
            <?php foreach ( $posts_encontros as $post_obj ) : ?>
                <?php
                $post_id = $post_obj->ID;

                $ano          = get_the_date( 'Y', $post_id );
                $titulo       = get_the_title( $post_id );
                $subtitulo    = get_the_excerpt( $post_id ); // pode ser ajustado futuramente para um campo próprio
                $tipos        = get_field( 'tipo_de_encontro', $post_id ); // checkbox
                $link_encontro = get_field( 'link_do_encontro', $post_id );

                // Normaliza tipo
                if ( is_array( $tipos ) ) {
                    $tipo_label = implode( ' · ', array_map( 'esc_html', $tipos ) );
                } elseif ( is_string( $tipos ) && $tipos !== '' ) {
                    $tipo_label = esc_html( $tipos );
                } else {
                    $tipo_label = __( 'Online', 'rede-bvs' );
                }

                // URL principal (link ACF, senão permalink)
                $url = '';
                $target = '';
                if ( is_array( $link_encontro ) && ! empty( $link_encontro['url'] ) ) {
                    $url = $link_encontro['url'];
                    if ( ! empty( $link_encontro['target'] ) ) {
                        $target = $link_encontro['target'];
                    }
                } else {
                    $url = get_permalink( $post_id );
                }
                ?>
                <a class="bvs-encontros-anteriores-item"
                   href="<?php echo esc_url( $url ); ?>"
                   data-year="<?php echo esc_attr( $ano ); ?>"
                    <?php if ( $target ) : ?>
                        target="<?php echo esc_attr( $target ); ?>"
                    <?php endif; ?>
                >
                    <div class="bvs-encontros-anteriores-item-text">
                        <span class="bvs-encontros-anteriores-item-title">
                            <?php echo esc_html( $titulo ); ?>
                        </span>
                        <?php if ( $subtitulo ) : ?>
                            <span class="bvs-encontros-anteriores-item-subtitle">
                                <?php echo esc_html( $subtitulo ); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <span class="bvs-encontros-anteriores-item-tag">
                        <?php echo esc_html( $tipo_label ); ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<style>
/* --------------------------------------------- */
/* Encontros Anteriores – lista em 2 colunas     */
/* --------------------------------------------- */

.bvs-encontros-anteriores {
    margin: 32px 0 40px;
}

.bvs-encontros-anteriores-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

/* Header */
.bvs-encontros-anteriores-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
    gap: 16px;
}

.bvs-encontros-anteriores-title {
    margin: 0;
    font-size: 26px;
    color: #28367D;
    font-weight: 700;
}

/* Filtro por ano */
.bvs-encontros-anteriores-filter {
    font-size: 13px;
}

.bvs-encontros-anteriores-filter-select-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
    background: #F2F2F2;
    border-radius: 999px;
    padding: 4px 30px 4px 12px;
    border: 1px solid #d1d5db;
}

.bvs-encontros-anteriores-filter-select {
    border: none;
    background: transparent;
    font-size: 13px;
    color: #374151;
    padding: 0;
    outline: none;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

.bvs-encontros-anteriores-filter-icon {
    position: absolute;
    right: 10px;
    font-size: 10px;
    color: #6b7280;
    pointer-events: none;
}

/* Grid de itens (2 colunas no desktop) */
.bvs-encontros-anteriores-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 8px 24px;
}

/* Item */
.bvs-encontros-anteriores-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 16px;
    border-radius: 8px;
    background: #f5f6f9;
    text-decoration: none;
    transition: background 0.15s ease, transform 0.15s ease, box-shadow 0.15s ease;
}

.bvs-encontros-anteriores-item:hover,
.bvs-encontros-anteriores-item:focus-visible {
    background: #e6ecff;
    box-shadow: 0 4px 10px rgba(15, 23, 42, 0.15);
    transform: translateY(-1px);
    outline: none;
}

/* Texto */
.bvs-encontros-anteriores-item-text {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-width: 0;
}

.bvs-encontros-anteriores-item-title {
    font-size: 16px;
    font-weight: 600;
    color: #28367D;
    line-height: 1.3;
    display: block;
}

.bvs-encontros-anteriores-item-subtitle {
    font-size: 11px;
    color: #6b7280;
    margin-top: 2px;
}

/* Tag "Online" / "Presencial" */
.bvs-encontros-anteriores-item-tag {
    flex-shrink: 0;
    font-size: 12px;
    font-weight: 600;
    color: #28367D;
    padding: 4px 12px;
    border-radius: 999px;
    background: #e0e7ff;
}

/* Responsivo */
@media (max-width: 900px) {
    .bvs-encontros-anteriores-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 600px) {
    .bvs-encontros-anteriores-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .bvs-encontros-anteriores-filter-select-wrap {
        width: 100%;
        justify-content: space-between;
    }

    .bvs-encontros-anteriores-filter-select {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var wrapper = document.getElementById('<?php echo esc_js( $uid ); ?>');
    if (!wrapper) return;

    var select = wrapper.querySelector('.bvs-encontros-anteriores-filter-select');
    var items  = wrapper.querySelectorAll('.bvs-encontros-anteriores-item');

    if (!select || !items.length) return;

    select.addEventListener('change', function () {
        var year = this.value;

        items.forEach(function (item) {
            var itemYear = item.getAttribute('data-year');
            if (!year || year === 'todos' || itemYear === year) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>
