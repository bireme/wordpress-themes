<?php
/** Template Name: Página com header visual */
get_header(); ?>
<main id="main-content" class="site-main visual-header-page">
<?php while ( have_posts() ) : the_post();
 get_template_part('template-parts/components/page-hero'); ?>
<section class="container section-space"><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><div class="entry-content"><?php the_content(); ?></div></article></section>
<?php endwhile; ?>
</main>
<?php get_footer();
