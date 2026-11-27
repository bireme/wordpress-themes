<?php
/**
 * Template Name: Mapa do site / Sitemap
 * Template Post Type: page
 */

defined('ABSPATH') || exit;

get_header('interno');
?>
<main id="main_container" class="container mb-5">
    <?php while (have_posts()) : the_post(); ?>
        <?php if (post_password_required()) : ?>
            <h1 class="title mt-4"><?php echo esc_html(get_the_title()); ?></h1>
            <?php echo get_the_password_form(); ?>
            <?php continue; ?>
        <?php endif; ?>
        <nav class="breadcrumb mt-3" aria-label="<?php echo esc_attr(memorial_sitemap_text('breadcrumb')); ?>">
            <a href="<?php echo esc_url(memorial_sitemap_home_url()); ?>"><?php echo esc_html(memorial_sitemap_text('home')); ?></a>
            <span aria-hidden="true">&nbsp;&gt;&nbsp;</span>
            <span aria-current="page"><?php echo esc_html(get_the_title()); ?></span>
        </nav>
        <h1 class="title mt-4 mb-3" id="memorial-sitemap-title"><?php echo esc_html(get_the_title()); ?></h1>
        <p class="mb-4"><?php echo esc_html(memorial_sitemap_text('intro')); ?></p>
        <nav aria-labelledby="memorial-sitemap-title">
            <?php memorial_sitemap_render(memorial_sitemap_tree(), true); ?>
        </nav>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
