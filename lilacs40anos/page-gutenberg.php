<?php
/**
 * Template Name: LILACS Página (Gutenberg)
 * Description: Template genérico para páginas com Gutenberg, mantendo header/footer e wrappers do tema.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main>

  <section class="lilacs-pagina-layout">
    <div class="lilacs-pagina-layout-inner">

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php
        /**
         * Gutenberg / conteúdo padrão da página
         * - the_content() renderiza os blocos.
         * - wp_link_pages() dá suporte a paginação de conteúdo (<!--nextpage-->).
         */
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('lilacs-gutenberg-content'); ?>>

 
          <div class="lilacs-content-entry">
            <?php the_content(); ?>
          </div>

          <?php
          wp_link_pages(array(
            'before' => '<nav class="lilacs-page-links">' . esc_html__('Páginas:', 'lilacs'),
            'after'  => '</nav>',
          ));
          ?>

        </article>

      <?php endwhile; endif; ?>

    </div>
  </section>

</main>

<?php get_footer(); ?>
