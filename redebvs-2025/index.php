<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="conteudo-principal">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p><?php _e( 'Nenhum conteúdo encontrado.', 'rede-bvs' ); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
