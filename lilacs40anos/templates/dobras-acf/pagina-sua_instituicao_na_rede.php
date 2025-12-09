<?php
/**
 * Dobra: Sua instituição na rede
 * Slug esperado: pagina-sua_instituicao_na_rede
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$campos = get_sub_field( 'campos' );

if ( empty( $campos ) || ! is_array( $campos ) ) {
    return;
}

$section_id = 'lilacs-sua-instituicao-' . get_the_ID() . '-' . get_row_index();
$cor_de_fundo = get_sub_field('cor_do_fundo_da_sessao');
$tituloPrincipal = get_sub_field('titulo');
$cor_titulo = get_sub_field('cor_do_titulo');

if(!$cor_titulo){
    $cor_titulo = "#0b2c68";
}
?>

<style>
/* --------------------------------------------------------- */
/* Acesso rápido – Sua instituição na rede                   */
/* --------------------------------------------------------- */

#<?php echo esc_attr( $section_id ); ?> {
    background-color: <?=$cor_de_fundo;?>;
        padding-top: 30px;
    padding-bottom: 30px;
    margin-top: 10px;
    margin-bottom: 10px;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Título da sessão */
#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-heading {
    margin-bottom: 24px;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-heading h2 {
    font-size: 30px;
    line-height: 1.3;
    font-weight: 700;
    color: <?=$cor_titulo?>;
}

/* Grid – duas colunas de cartões horizontais */
#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-grid {
    display: grid;
    grid-template-columns: repeat(1, minmax(0, 1fr));
    gap: 14px 18px;
}

@media (min-width: 900px) {
    #<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

/* Card */
#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-card-link {
    text-decoration: none;
    color: inherit;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-card {
    background-color: #00205C; /* cor pedida */
    border-radius: 14px;
    padding: 18px 22px;
    display: flex;
    align-items: center;
    gap: 18px;
    color: #ffffff;
    box-shadow: 0 14px 32px rgba(15,23,42,0.28);
    border: 1px solid #01153a;
    transition: transform 0.16s ease, box-shadow 0.16s ease, border-color 0.16s ease, background-color 0.16s ease;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 40px rgba(15,23,42,0.4);
    border-color: #133c9d;
    background-color: #001744;
}

/* Ícone à esquerda */
#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    border-radius: 999px;
    background-color: rgba(15, 23, 42, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-icon img {
    max-width: 24px;
    max-height: 24px;
    display: block;
}

/* Conteúdo (título + descrição) */
#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-content {
    flex: 1 1 auto;
    min-width: 0;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 4px;
    color: #ffffff;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-desc {
    font-size: 16px;
    line-height: 1.5;
    color: #e5e7eb;
}

/* Ícone seta à direita */
#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-arrow {
    flex-shrink: 0;
    width: 32px;
    height: 32px;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-arrow span {
    display: block;
    transform: translateX(1px);
}

/* Acessibilidade foco */
#<?php echo esc_attr( $section_id ); ?> .lilacs-acesso-card-link:focus-visible .lilacs-acesso-card {
    outline: 2px solid #fbbf24;
    outline-offset: 2px;
}
</style>

<section id="<?php echo esc_attr( $section_id ); ?>" class="lilacs-sua-instituicao">
    <div class="lilacs-acesso-inner">

        <div class="lilacs-acesso-heading">
            <h2><?= $tituloPrincipal; ?></h2>
        </div>

        <div class="lilacs-acesso-grid">
            <?php foreach ( $campos as $campo ) :

                $titulo         = isset( $campo['titulo'] ) ? $campo['titulo'] : '';
                $link           = isset( $campo['link'] ) ? $campo['link'] : '';
                $icone          = isset( $campo['iconeimagem'] ) ? $campo['iconeimagem'] : '';
                $descricao_curta= isset( $campo['descricao_curta'] ) ? $campo['descricao_curta'] : '';

                if ( is_array( $icone ) && isset( $icone['url'] ) ) {
                    $icone = $icone['url'];
                }

                $tag_out = $link ? 'a' : 'div';
                $attrs   = $link
                    ? 'href="' . esc_url( $link ) . '" class="lilacs-acesso-card-link" target="_blank" rel="noopener noreferrer"'
                    : 'class="lilacs-acesso-card-link"';
            ?>
                <<?php echo $tag_out; ?> <?php echo $attrs; ?>>
                    <article class="lilacs-acesso-card">
                        
                        <?php if($icone){ ?>
                        <div class="lilacs-acesso-icon">
                            <?php if ( $icone ) : ?>
                                <img src="<?php echo esc_url( $icone ); ?>" alt="" loading="lazy">
                            <?php endif; ?>
                        </div>
                        <?php } ?>
                        
                        <div class="lilacs-acesso-content">
                            <?php if ( $titulo ) : ?>
                                <div class="lilacs-acesso-title">
                                    <?php echo esc_html( $titulo ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( $descricao_curta ) : ?>
                                <div class="lilacs-acesso-desc">
                                    <?php echo esc_html( $descricao_curta ); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="lilacs-acesso-arrow" aria-hidden="true">
                            <span>›</span>
                        </div>
                    </article>
                </<?php echo $tag_out; ?>>
            <?php endforeach; ?>
        </div>
    </div>
</section>
