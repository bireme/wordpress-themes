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
   
    align-items: start;
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
.encontro-proxima-midia,
.encontro-anterior-midia{
    border-radius: 16px;
    overflow: hidden;
    min-width: 0;
    box-sizing: border-box;
}

.encontro-proxima-midia iframe{
    width: 100%;
    min-height: 260px;
}

.encontro-proxima-descricao,
.encontro-anterior-descricao{
    font-size: 15px;
    line-height: 1.6;
    min-width: 0;
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
    gap: 16px;
    width: 100%;
    margin: 0;
    padding: 14px 4px;
    background: none;
    border: none;
    cursor: pointer;
    font: inherit;
    font-size: 15px;
    font-weight: 600;
    line-height: 1.4;
    color: #002c71;
    text-align: left;
}

.encontro-accordion-header:hover{
    color: #0056A6;
}

.encontro-accordion-header:focus-visible{
    outline: 2px solid #0056A6;
    outline-offset: 2px;
    border-radius: 8px;
}

.encontro-accordion-header > span:not(.encontro-accordion-toggle){
    flex: 1;
}

.encontro-accordion-toggle{
    flex-shrink: 0;
    width: 28px;
    height: 28px;
    border-radius: 999px;
    border: 1px solid #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    line-height: 1;
    color: #0056A6;
}

.encontro-accordion-content{
    display: none;
}

.encontro-accordion-item.is-open .encontro-accordion-content{
    display: grid;
    grid-template-columns: minmax(0, 1fr);
    gap: 20px;
    align-items: start;
    background: #f5f8fc;
    border-radius: 16px;
    padding: 20px;
    margin: 0 0 16px;
}

.encontro-accordion-item.is-open .encontro-accordion-content.has-media.has-desc{
    grid-template-columns: minmax(240px, 320px) minmax(0, 1fr);
    gap: 28px;
}

.encontro-accordion-item.is-open .encontro-accordion-toggle{
    background: #0056A6;
    border-color: #0056A6;
    color: #fff;
}

/* Gravação: card compacto com proporção 16:9 */
.encontro-accordion-content .encontro-anterior-midia{
    width: 100%;
    max-width: 100%;
    min-width: 0;
    margin: 0;
    padding: 14px;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(15, 23, 42, 0.06);
    overflow: hidden;
}

.encontro-accordion-content .encontro-anterior-midia > *:first-child{
    margin-top: 0;
}

.encontro-accordion-content .encontro-anterior-midia > *:last-child{
    margin-bottom: 0;
}

.encontro-accordion-content .encontro-anterior-midia h1,
.encontro-accordion-content .encontro-anterior-midia h2,
.encontro-accordion-content .encontro-anterior-midia h3,
.encontro-accordion-content .encontro-anterior-midia h4,
.encontro-accordion-content .encontro-anterior-midia h5,
.encontro-accordion-content .encontro-anterior-midia p:first-child strong{
    margin: 0 0 12px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #0056A6;
}

.encontro-accordion-content .encontro-anterior-midia p{
    margin: 0 0 10px;
}

.encontro-accordion-content .encontro-anterior-midia .wp-block-embed,
.encontro-accordion-content .encontro-anterior-midia .wp-block-embed__wrapper,
.encontro-accordion-content .encontro-anterior-midia .fluid-width-video-wrapper{
    margin: 0;
    width: 100%;
    max-width: 100%;
}

.encontro-accordion-content .encontro-anterior-midia iframe,
.encontro-accordion-content .encontro-anterior-midia video,
.encontro-accordion-content .encontro-anterior-midia embed{
    display: block;
    width: 100% !important;
    max-width: 100%;
    border: 0;
    border-radius: 10px;
    background: #0b1c52;
}

.encontro-accordion-content .encontro-anterior-midia > iframe,
.encontro-accordion-content .encontro-anterior-midia p > iframe,
.encontro-accordion-content .encontro-anterior-midia > video,
.encontro-accordion-content .encontro-anterior-midia p > video{
    height: auto !important;
    min-height: 0;
    aspect-ratio: 16 / 9;
}

.encontro-accordion-content .encontro-anterior-midia img{
    width: 100%;
    max-width: 100% !important;
    height: auto !important;
    aspect-ratio: 16 / 9;
    object-fit: cover;
    border-radius: 10px;
}

.encontro-accordion-content .encontro-anterior-midia a:has(img){
    position: relative;
    display: block;
    border-radius: 10px;
    overflow: hidden;
}

.encontro-accordion-content .encontro-anterior-midia a:has(img)::after{
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(11, 28, 82, 0.22);
    pointer-events: none;
}

.encontro-accordion-content .encontro-anterior-midia a:has(img)::before{
    content: "";
    position: absolute;
    left: 50%;
    top: 50%;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 12px 0 12px 20px;
    border-color: transparent transparent transparent #fff;
    transform: translate(-35%, -50%);
    filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.35));
    z-index: 1;
    pointer-events: none;
}

/* Texto: coluna de leitura, imagens em bloco */
.encontro-accordion-content .encontro-anterior-descricao{
    width: 100%;
    max-width: 94%;
    min-width: 0;
    margin: 0;
    padding: 20px 22px;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(15, 23, 42, 0.06);
    color: #1f2937;
    font-size: 15px;
    line-height: 1.7;
}

.encontro-accordion-content .encontro-anterior-descricao::after{
    content: "";
    display: table;
    clear: both;
}

.encontro-accordion-content .encontro-anterior-descricao > *:first-child{
    margin-top: 0;
}

.encontro-accordion-content .encontro-anterior-descricao > *:last-child{
    margin-bottom: 0;
}

.encontro-accordion-content .encontro-anterior-descricao h1,
.encontro-accordion-content .encontro-anterior-descricao h2,
.encontro-accordion-content .encontro-anterior-descricao h3,
.encontro-accordion-content .encontro-anterior-descricao h4,
.encontro-accordion-content .encontro-anterior-descricao h5{
    color: #002c71;
    font-weight: 700;
    line-height: 1.3;
    margin: 1.25em 0 0.5em;
}

.encontro-accordion-content .encontro-anterior-descricao h1,
.encontro-accordion-content .encontro-anterior-descricao h2{
    font-size: 22px;
}

.encontro-accordion-content .encontro-anterior-descricao h3{
    font-size: 18px;
}

.encontro-accordion-content .encontro-anterior-descricao h4,
.encontro-accordion-content .encontro-anterior-descricao h5{
    font-size: 15px;
}

.encontro-accordion-content .encontro-anterior-descricao p{
    margin: 0 0 12px;
}

.encontro-accordion-content .encontro-anterior-descricao a{
    color: #0056A6;
}

.encontro-accordion-content .encontro-anterior-descricao ul,
.encontro-accordion-content .encontro-anterior-descricao ol{
    margin: 0 0 12px 1.2em;
}

.encontro-accordion-content img,
.encontro-accordion-content video,
.encontro-accordion-content figure,
.encontro-accordion-content .wp-caption{
    max-width: 100% !important;
    height: auto !important;
    display: block;
}

.encontro-accordion-content .encontro-anterior-descricao img,
.encontro-accordion-content .encontro-anterior-descricao figure,
.encontro-accordion-content .encontro-anterior-descricao .wp-caption{
    margin: 0 0 16px;
    border-radius: 12px;
}

.encontro-accordion-content iframe,
.encontro-accordion-content embed,
.encontro-accordion-content object{
    max-width: 100%;
}

.encontro-accordion-content .wp-caption{
    width: auto !important;
}

.encontro-accordion-content .alignleft,
.encontro-accordion-content .alignright,
.encontro-accordion-content .aligncenter,
.encontro-accordion-content .wp-block-image{
    float: none;
    margin: 0 0 16px;
    max-width: 100%;
}

.encontro-accordion-content table{
    max-width: 100%;
}

/* -------------------------------------------------- */
/* RESPONSIVO                                         */
/* -------------------------------------------------- */

@media (max-width: 992px){
    .single-encontro-hero-wrapper,
    .encontro-proxima-wrapper,
    .encontro-anterior-highlight,
    .encontro-intro-wrapper,
    .encontro-accordion-item.is-open .encontro-accordion-content,
    .encontro-accordion-item.is-open .encontro-accordion-content.has-media.has-desc{
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
                    <?php foreach ( $items as $i => $item ) :
                        $content_class = 'encontro-accordion-content';
                        if ( ! empty( $item['midia'] ) ) {
                            $content_class .= ' has-media';
                        }
                        if ( ! empty( $item['desc'] ) ) {
                            $content_class .= ' has-desc';
                        }
                        $panel_id = 'encontro-sessao-' . ( $i + 1 );
                    ?>
                        <div class="encontro-accordion-item">
                            <button type="button"
                                    class="encontro-accordion-header"
                                    aria-expanded="false"
                                    aria-controls="<?php echo esc_attr( $panel_id ); ?>">
                                <span><?php echo esc_html( $item['titulo'] ); ?></span>
                                <span class="encontro-accordion-toggle" aria-hidden="true">+</span>
                            </button>
                            <div class="<?php echo esc_attr( $content_class ); ?>"
                                 id="<?php echo esc_attr( $panel_id ); ?>">
                                <?php
                                if ( ! empty( $item['midia'] ) ) {
                                    echo '<div class="encontro-anterior-midia">' . apply_filters( 'the_content', $item['midia'] ) . '</div>';
                                }
                                if ( ! empty( $item['desc'] ) ) {
                                    echo '<div class="encontro-anterior-descricao">' . wp_kses_post( $item['desc'] ) . '</div>';
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

    function closeItem(it) {
        it.classList.remove('is-open');
        const header = it.querySelector('.encontro-accordion-header');
        const toggle = it.querySelector('.encontro-accordion-toggle');
        if (header) header.setAttribute('aria-expanded', 'false');
        if (toggle) toggle.textContent = '+';
    }

    function openItem(it) {
        it.classList.add('is-open');
        const header = it.querySelector('.encontro-accordion-header');
        const toggle = it.querySelector('.encontro-accordion-toggle');
        if (header) header.setAttribute('aria-expanded', 'true');
        if (toggle) toggle.textContent = '–';
    }

    items.forEach(function (item) {
        const header = item.querySelector('.encontro-accordion-header');
        if (!header) return;

        header.addEventListener('click', function () {
            const isOpen = item.classList.contains('is-open');
            items.forEach(closeItem);
            if (!isOpen) openItem(item);
        });
    });
});
</script>

<?php
get_footer();
