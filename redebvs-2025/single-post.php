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

                    // Breadcrumb (Home / Categoria / Post)
                    $home_label = 'Rede BVS';
                    $home_url   = home_url( '/' );

                    $primary_cat = '';
                    if ( get_post_type() === 'post' ) {
                        $cats = get_the_category();
                        if ( ! empty( $cats ) ) {
                            $primary_cat = $cats[0]->name;
                        }
                    }

                    // Banner (usa a thumb; se não tiver, usa imagem padrão)
                    if ( has_post_thumbnail() ) {
                        $hero_bg = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                    } else {
                        // fallback que você definiu
                        $hero_bg = get_template_directory_uri() . '/assets/dafult-posts.png';
                    }
            ?>

                <!-- BREADCRUMB + HERO -->
                <div class="bvs-single-hero">

                    <div class="bvs-breadcrumb">
                        <a href="<?php echo esc_url( $home_url ); ?>" class="bvs-breadcrumb-pill">
                            <?php echo esc_html( $home_label ); ?>
                        </a>

                        <span class="bvs-breadcrumb-sep">&gt;</span>

                        <?php if ( $primary_cat ) : ?>
                            <span class="bvs-breadcrumb-current">
                                <?php echo esc_html( $primary_cat ); ?>
                            </span>
                        <?php else : ?>
                            <span class="bvs-breadcrumb-current">
                                <?php the_title(); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="bvs-single-hero-banner">
                        <div class="bvs-single-hero-bg"
                             style="background-image:url('<?php echo esc_url( $hero_bg ); ?>');">
                            <div class="bvs-single-hero-gradient"></div>
                            <div class="bvs-single-hero-content">
                                <h1 class="bvs-single-title"><?php the_title(); ?></h1>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- META EM BADGES -->
                <div class="bvs-single-meta-badges">
                    <span class="bvs-badge bvs-badge-date">
                        <?php echo get_the_date(); ?>
                    </span>

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
    .bvs-single-wrapper {
        padding: 0;
    }

    .bvs-single-inner {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 16px;
    }

    /* BREADCRUMB */
    .bvs-breadcrumb {
        display: flex;
        align-items: center;
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

    .bvs-breadcrumb-sep {
        color: #999;
    }

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

    .bvs-single-hero-gradient {
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(0,0,0,0.5), rgba(0,0,0,0.15));
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

    /* META BADGES */
    .bvs-single-meta-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 16px;
        margin-bottom: 24px;
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

    /* CONTEÚDO */
    .bvs-single-content {
        font-size: 16px;
        line-height: 1.7;
    }

    .bvs-single-content p {
        margin-bottom: 16px;
    }

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

    .bvs-single-nav a {
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .bvs-single-hero-bg {
            height: 180px;
        }
        .bvs-single-hero-content {
            padding: 16px 20px;
        }
        .bvs-single-title {
            font-size: 22px;
        }

        /* No mobile, remove os floats para não quebrar o layout */
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
