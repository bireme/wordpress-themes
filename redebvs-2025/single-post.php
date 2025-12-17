<?php
/**
 * Template padrão de single post
 * Arquivo: single.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main id="conteudo-principal" class="bvs-single-post">

    <section class="bvs-single-wrapper">
        <div class="bvs-single-inner">

            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();

                    // Breadcrumb fixo: Rede BVS > noticias da rede > titulo atual
                    $home_label   = 'Rede BVS';
                    $home_url     = home_url( '/' );
                    $news_label   = 'noticias da rede';
                    $news_url     = home_url( '/noticias-da-rede/' );

                    // Featured image (para exibir acima do conteúdo)
                    $featured_img_url = '';
                    $featured_img_alt = '';
                    if ( has_post_thumbnail() ) {
                        $thumb_id = get_post_thumbnail_id( get_the_ID() );
                        $featured_img_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                        $featured_img_alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
                        if ( $featured_img_alt === '' ) {
                            $featured_img_alt = get_the_title();
                        }
                    }
            ?>

                <!-- BREADCRUMB + HERO -->
                <div class="bvs-single-hero">

                    <div class="bvs-breadcrumb">
                        <a href="<?php echo esc_url( $home_url ); ?>" class="bvs-breadcrumb-pill">
                            <?php echo esc_html( $home_label ); ?>
                        </a>

                        <span class="bvs-breadcrumb-sep">&gt;</span>

                        <a href="<?php echo esc_url( $news_url ); ?>" class="bvs-breadcrumb-link">
                            <?php echo esc_html( $news_label ); ?>
                        </a>

                        <span class="bvs-breadcrumb-sep">&gt;</span>

                        <span class="bvs-breadcrumb-current">
                            <?php the_title(); ?>
                        </span>
                    </div>

                    <div class="bvs-single-hero-banner">
                        <div class="bvs-single-hero-bg bvs-single-hero-bg--solid">
                            <div class="bvs-single-hero-gradient"></div>
                            <div class="bvs-single-hero-content">
                                <h1 class="bvs-single-title"><?php the_title(); ?></h1>
                            </div>
                        </div>
                    </div>

                </div>

                <?php
                // Categorias do post (para badges)
                $cats = [];
                if ( get_post_type() === 'post' ) {
                    $cats = get_the_category();
                }
                ?>

                <!-- META: TAGS À ESQUERDA + DATA À DIREITA -->
                <div class="bvs-single-meta-row">

                    <div class="bvs-single-meta-left">
                        <?php
                        if ( ! empty( $cats ) ) :
                            foreach ( $cats as $cat ) :
                                ?>
                                <span class="bvs-badge bvs-badge-cat">
                                    <?php echo esc_html( $cat->name ); ?>
                                </span>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>

                    <div class="bvs-single-meta-right">
                        <span class="bvs-badge bvs-badge-date">
                            <?php echo esc_html( get_the_date() ); ?>
                        </span>
                    </div>

                </div>

                <!-- IMAGEM DESTACADA (ACIMA DO TEXTO) -->
                <?php if ( $featured_img_url ) : ?>
                    <figure class="bvs-single-featured">
                        <img src="<?php echo esc_url( $featured_img_url ); ?>"
                             alt="<?php echo esc_attr( $featured_img_alt ); ?>"
                             loading="lazy" />
                    </figure>
                <?php endif; ?>

                <!-- CONTEÚDO -->
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'bvs-single-article' ); ?>>

                    <div class="bvs-single-content entry-content">
                        <?php
                        // Mantém TODA a formatação do editor usando o filtro the_content.
                        $content = get_the_content();
                        echo apply_filters( 'the_content', $content );

                        // Paginação interna de post (<!--nextpage-->)
                        wp_link_pages( array(
                            'before' => '<div class="bvs-single-pages">' . esc_html__( 'Páginas:', 'seu-text-domain' ),
                            'after'  => '</div>',
                        ) );
                        ?>
                    </div>

                    <footer class="bvs-single-footer">
                        <?php
                        $tags = get_the_tags();
                        if ( $tags ) :
                            ?>
                            <div class="bvs-single-tags">
                                <?php foreach ( $tags as $tag ) : ?>
                                    <span class="bvs-badge bvs-badge-tag">
                                        #<?php echo esc_html( $tag->name ); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </footer>

                </article>

                <!-- NAVEGAÇÃO ENTRE POSTS -->
                <nav class="bvs-single-nav">
                    <div class="bvs-single-prev">
                        <?php previous_post_link( '%link', '&laquo; %title' ); ?>
                    </div>
                    <div class="bvs-single-next">
                        <?php next_post_link( '%link', '%title &raquo;' ); ?>
                    </div>
                </nav>

                <?php
                // Comentários desativados
                endwhile;
            else :
                ?>
                <div class="bvs-single-empty">
                    <p><?php esc_html_e( 'Nenhum conteúdo encontrado.', 'seu-text-domain' ); ?></p>
                </div>
            <?php endif; ?>

        </div>
    </section>

</main>

<style>
    .bvs-single-wrapper { padding: 0; }

    .bvs-single-inner {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 16px;
    }

    /* BREADCRUMB */
    .bvs-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 16px;
        font-size: 14px;
    }

    .bvs-breadcrumb-pill {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        border-radius: 999px;
        background: #eef2ff;
        text-decoration: none;
        font-weight: 500;
    }

    .bvs-breadcrumb-link {
        color: #555;
        font-weight: 500;
        text-decoration: none;
    }
    .bvs-breadcrumb-link:hover { text-decoration: underline; }

    .bvs-breadcrumb-sep { color: #999; }

    .bvs-breadcrumb-current {
        color: #555;
        font-weight: 500;
    }

    /* HERO */
    .bvs-single-hero-banner {
        border-radius: 10px 60px 10px 10px;
        overflow: hidden;
    }

    .bvs-single-hero-bg {
        position: relative;
        width: 100%;
        height: 220px;
        background-size: cover;
        background-position: center;
    }

    /* Fundo fixo */
    .bvs-single-hero-bg--solid { background: #2A377E; }

    .bvs-single-hero-gradient {
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(0,0,0,0.18), rgba(0,0,0,0.06));
        pointer-events: none;
    }

    .bvs-single-hero-content {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        padding: 24px 32px;
        color: #fff;
    }

    .bvs-single-title {
        font-size: 28px;
        line-height: 1.3;
        margin: 0;
    }

    /* META ROW: TAGS ESQUERDA + DATA DIREITA */
    .bvs-single-meta-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 16px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .bvs-single-meta-left {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        min-width: 0;
    }

    .bvs-single-meta-right {
        display: flex;
        justify-content: flex-end;
        margin-left: auto;
    }

    .bvs-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 500;
        border: 1px solid transparent;
        background: #f3f4f6;
        white-space: nowrap;
    }

    .bvs-badge-date {
        background: #e0f2fe;
        border-color: #bae6fd;
    }

    .bvs-badge-cat {
        background: #eef2ff;
        border-color: #e0e7ff;
    }

    .bvs-badge-tag {
        background: #fef3c7;
        border-color: #fde68a;
        margin-right: 4px;
        margin-bottom: 4px;
    }

    /* IMAGEM DESTACADA */
    .bvs-single-featured {
        margin: 0 0 22px 0;
        border-radius: 12px 60px 12px 12px;
        overflow: hidden;
        background: #f3f4f6;
        box-shadow: 0 8px 22px rgba(0,0,0,0.08);
    }

    .bvs-single-featured img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    /* CONTEÚDO */
    .bvs-single-content {
        font-size: 16px;
        line-height: 1.7;
    }

    .bvs-single-content p { margin-bottom: 16px; }

    .bvs-single-content h2,
    .bvs-single-content h3,
    .bvs-single-content h4 {
        margin-top: 24px;
        margin-bottom: 12px;
    }

    .bvs-single-content ul,
    .bvs-single-content ol {
        margin: 0 0 16px 24px;
    }

    /* Imagens dentro do conteúdo */
    .bvs-single-content img {
        max-width: 100%;
        height: auto;
    }

    /* Classes padrão do WP: respeitam alinhamento do editor */
    .bvs-single-content .alignleft {
        float: left;
        margin: 0 1.5em 1em 0;
    }

    .bvs-single-content .alignright {
        float: right;
        margin: 0 0 1em 1.5em;
    }

    .bvs-single-content .aligncenter {
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 1em;
    }

    .bvs-single-footer {
        margin-top: 32px;
        border-top: 1px solid #eee;
        padding-top: 16px;
    }

    .bvs-single-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
    }

    .bvs-single-nav {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
        gap: 16px;
        font-size: 14px;
    }

    .bvs-single-nav a { text-decoration: none; }

    @media (max-width: 768px) {
        .bvs-single-hero-bg { height: 180px; }
        .bvs-single-hero-content { padding: 16px 20px; }
        .bvs-single-title { font-size: 22px; }

        .bvs-single-featured {
            border-radius: 12px 36px 12px 12px;
        }

        /* No mobile, remove floats */
        .bvs-single-content .alignleft,
        .bvs-single-content .alignright {
            float: none;
            margin: 0 0 1em 0;
            display: block;
        }
    }
</style>

<?php
get_footer();
