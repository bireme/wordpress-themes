<?php 
/**
 * Single Encontro da Rede
 * Template para exibir post_type = encontro-da-rede
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

// ACF principais
$link_encontro       = get_field( 'link_do_encontro' );   // array: url, title, target
$descricao_completa  = get_field( 'descricao_completa' );
$tipos_encontro      = get_field( 'tipo_de_encontro' );   // checkbox (array)

// Imagem principal
if ( has_post_thumbnail() ) {
    $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
} else {
    $thumb_url = get_template_directory_uri() . '/assets/post-default.png';
}
?>

<style>
/* -------------------------------------------------- */
/* HERO / CABEÇALHO                                   */
/* -------------------------------------------------- */

.single-encontro-hero {
    max-width: 1180px;
    margin: 40px auto 20px;
    padding: 0 16px;
}

.single-encontro-hero-wrapper {
    background: #0b1c52;
    border-radius: 20px 120px 20px 20px;
    padding: 32px 32px 36px;
    color: #fff;
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.2fr);
    gap: 32px;
    position: relative;
    overflow: hidden;
}

.single-encontro-hero-left img{
    width: 100%;
    border-radius: 18px;
    display: block;
}

.single-encontro-hero-right h1{
    font-size: 32px;
    font-weight: 700;
    margin: 0 0 16px;
}

.single-encontro-hero-right .encontro-descricao{
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.encontro-tipos{
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 18px;
}

.encontro-tipo-pill{
    background: #1f2f80;
    border-radius: 999px;
    padding: 4px 12px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .04em;
}

.encontro-cta-box{
    background: #fff;
    color: #0b1c52;
    border-radius: 18px;
    padding: 16px 18px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    max-width: 340px;
}

.encontro-cta-box small{
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .04em;
    opacity: .8;
}

.encontro-cta-box p{
    font-size: 14px;
    margin: 0;
}

.encontro-cta-btn{
margin-top: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    border-radius: 999px;
    background: #28367D;
    color: #fff;
    font-size: 14px;
    text-transform: none;
    text-decoration: none;
    padding-left: 30px;
    padding-right: 30px;
    padding-top: 5px;
    padding-bottom: 5px;
}

.encontro-cta-btn:hover{
    filter: brightness(1.08);
}

/* -------------------------------------------------- */
/* BLOCO PRINCIPAL / INTRO + PRÓXIMA SESSÃO           */
/* -------------------------------------------------- */

.single-encontro-main{
    max-width: 1180px;
    margin: 0 auto 60px;
    padding: 0 16px;
}

.encontro-section{
    margin-top: 40px;
}

.encontro-section h2{
    font-size: 22px;
    margin-bottom: 18px;
    color: #002c71;
}

/* NOVA DOBRA: IMAGEM DESTACADA + TÍTULO + DESCRIÇÃO */
.encontro-intro-wrapper{
    display: grid;
    grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.4fr);
    gap: 32px;
    border-radius: 18px;
    padding: 24px;
    align-items: center;
}

.encontro-intro-thumb img{
    width: 100%;
    border-radius:10px 46px 10px 10px;
    display: block;
}

.encontro-intro-content h1{
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 14px;
    color: #002c71;
}

.encontro-intro-descricao{
    font-size: 15px;
    line-height: 1.7;
    color: #111827;
}

/* PRÓXIMA SESSÃO */

.encontro-proxima-title{
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #111827;
}

.encontro-proxima-wrapper{
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.2fr);
    gap: 32px;
    background: #fff;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 8px 26px rgba(15,23,42,0.08);
}
.encontro-anterior-midia{
        width: 45%;
    padding: 20px;
}
.encontro-proxima-midia,
.encontro-anterior-midia{
    border-radius: 16px;
    overflow: hidden;
}

.encontro-proxima-midia iframe,
.encontro-anterior-midia iframe{
    width: 100%;
    min-height: 260px;
}

.encontro-proxima-descricao,
.encontro-anterior-descricao{
    font-size: 15px;
    line-height: 1.6;
}

/* -------------------------------------------------- */
/* SESSÕES ANTERIORES                                 */
/* -------------------------------------------------- */

.encontro-anteriores-wrapper{
    background: #fff;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 8px 26px rgba(15,23,42,0.08);
}

/* primeiro item aberto */
.encontro-anterior-highlight{
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.2fr);
    gap: 32px;
    margin-bottom: 24px;
}

/* acordeão da lista */
.encontro-accordion-list{
    border-top: 1px solid #e2e8f0;
}

.encontro-accordion-item{
    border-bottom: 1px solid #e2e8f0;
}

.encontro-accordion-header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 4px;
    cursor: pointer;
    font-size: 14px;
    color: #1f2937;
}

.encontro-accordion-header span{
    flex: 1;
}

.encontro-accordion-toggle{
    width: 22px;
    height: 22px;
    border-radius: 999px;
    border: 1px solid #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    line-height: 1;
}

.encontro-accordion-content{
    display: none;
    padding: 10px 0 14px;
    font-size: 14px;
    line-height: 1.6;
}

.encontro-accordion-item.is-open .encontro-accordion-content{
     display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: flex-start;
    align-items: center;
}

.encontro-accordion-item.is-open .encontro-accordion-toggle{
    background: #0056A6;
    color: #fff;
}

/* -------------------------------------------------- */
/* RESPONSIVO                                         */
/* -------------------------------------------------- */

@media (max-width: 992px){
    .single-encontro-hero-wrapper,
    .encontro-proxima-wrapper,
    .encontro-anterior-highlight,
    .encontro-intro-wrapper{
        grid-template-columns: minmax(0,1fr);
    }

    .single-encontro-hero-wrapper{
        border-radius: 20px;
    }
}

@media (max-width: 640px){
    .single-encontro-hero-wrapper{
        padding: 20px 18px 24px;
    }
    .single-encontro-hero-right h1{
        font-size: 24px;
    }
    .encontro-accordion-item.is-open .encontro-accordion-content{
        display: flex;
    flex-direction: column;
    }
    .encontro-anterior-midia{
        width:100%;
    }
}
</style>

<!-- HERO -->
<?php
 include('dobras/encontros-banner.php');
?>

<main class="single-encontro-main">

    <!-- NOVA DOBRA: IMAGEM DESTACADA + TÍTULO + DESCRIÇÃO COMPLETA -->
    <?php if ( $thumb_url || $descricao_completa ) : ?>
        <section class="encontro-section encontro-intro">
            <div class="encontro-intro-wrapper">
                <div class="encontro-intro-thumb">
                    <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                </div>
                <div class="encontro-intro-content">
                    <h1><?php the_title(); ?></h1>
                    <?php if ( $descricao_completa ) : ?>
                        <div class="encontro-intro-descricao">
                            <?php echo wp_kses_post( $descricao_completa ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- PRÓXIMA SESSÃO -->
    <?php if ( have_rows( 'proximas_sessoes' ) ) : ?>
        <section class="encontro-section encontro-proxima">
            <h2><?php esc_html_e( 'Próxima sessão', 'bvs' ); ?></h2>

            <?php
            // pega somente a primeira linha como "próxima sessão"
            the_row();
            $proxima_titulo     = get_sub_field( 'titulo_da_sessao' );
            $proxima_midia      = get_sub_field( 'midia_ou_texto' );
            $proxima_descricao  = get_sub_field( 'descricao_personalizada' );
            ?>

            <?php if ( $proxima_titulo ) : ?>
                <p class="encontro-proxima-title"><?php echo esc_html( $proxima_titulo ); ?></p>
            <?php endif; ?>

            <div class="encontro-proxima-wrapper">
                <?php if ( $proxima_midia ) : ?>
                    <div class="encontro-proxima-midia">
<?php echo apply_filters( 'the_content', $proxima_midia ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( $proxima_descricao ) : ?>
                    <div class="encontro-proxima-descricao">
                        <?php echo wp_kses_post( $proxima_descricao ); ?>

                        <?php if ( ! empty( $link_encontro['url'] ) ) : ?>
                            <p style="margin-top:18px;">
                                <a class="encontro-cta-btn"
                                   href="<?php echo esc_url( $link_encontro['url'] ); ?>"
                                   target="<?php echo esc_attr( $link_encontro['target'] ?: '_self' ); ?>">
                                    <?php echo esc_html( $link_encontro['title'] ?: __( 'Inscreva-se', 'bvs' ) ); ?>
                                </a>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

        </section>
    <?php endif; ?>

    <!-- SESSÕES ANTERIORES -->
    <?php if ( have_rows( 'sessoes' ) ) : ?>
        <section class="encontro-section encontro-anteriores">
            <h2><?php esc_html_e( 'Sessões anteriores', 'bvs' ); ?></h2>

            <div class="encontro-anteriores-wrapper">

                <?php
                $items = array();

                while ( have_rows( 'sessoes' ) ) : the_row();
                    $titulo   = get_sub_field( 'titulo_da_sessao' );
                    $midia    = get_sub_field( 'midia_ou_texto' );
                    $desc     = get_sub_field( 'descricao_personalizada' );

                    // se não tiver título preenchido, gera um fallback a partir do conteúdo
                    if ( $titulo ) {
                        $titulo_accordion = $titulo;
                    } else {
                        $titulo_accordion = wp_strip_all_tags( wp_trim_words( $desc ?: $midia, 16, '…' ) );
                    }

                    $items[] = array(
                        'titulo' => $titulo_accordion,
                        'midia'  => $midia,
                        'desc'   => $desc,
                    );
                endwhile;


?>
                <div class="encontro-accordion-list">
                    <?php foreach ( $items as $i => $item ) : ?>
                        <div class="encontro-accordion-item">
                            <div class="encontro-accordion-header">
                                <span><?php echo esc_html( $item['titulo'] ); ?></span>
                                <div class="encontro-accordion-toggle">+</div>
                            </div>
                            <div class="encontro-accordion-content">
                                <?php
                                if ( ! empty( $item['midia'] ) ) {
    echo '<div class="encontro-anterior-midia">' . apply_filters( 'the_content', $item['midia'] ) . '</div>';
                                }
                                if ( ! empty( $item['desc'] ) ) {
                                    echo '<div class="encontro-anterior-descricao" style="margin-top:10px;">' . wp_kses_post( $item['desc'] ) . '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>
    <?php endif; ?>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.encontro-accordion-item');

    items.forEach(function (item) {
        const header = item.querySelector('.encontro-accordion-header');
        const toggle = item.querySelector('.encontro-accordion-toggle');

        header.addEventListener('click', function () {
            const isOpen = item.classList.contains('is-open');

            // fecha todos
            items.forEach(function (it) {
                it.classList.remove('is-open');
                const t = it.querySelector('.encontro-accordion-toggle');
                if (t) t.textContent = '+';
            });

            // se não estava aberto, abre
            if (!isOpen) {
                item.classList.add('is-open');
                if (toggle) toggle.textContent = '–';
            }
        });
    });
});
</script>

<?php
get_footer();
