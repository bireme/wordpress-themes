<?php
$has_top = is_active_sidebar( 'top_sidebar' );
$has_main = is_active_sidebar( 'column-1' );
$has_side = is_active_sidebar( 'column-2' );

if ( ! is_front_page() || ! ( $has_top || $has_main || $has_side ) ) {
    require get_theme_file_path( 'index.php' );
    return;
}

get_header();
?>
<main id="primary" class="vitrines-frame vitrines-layout vitrines-home-widgets" tabindex="-1">
    <?php if ( $has_top ) : ?>
        <div><?php dynamic_sidebar( 'top_sidebar' ); ?></div>
    <?php endif; ?>
    <?php if ( $has_main || $has_side ) : ?>
        <div class="vitrines-home-columns">
            <?php if ( $has_main ) : ?>
                <div><?php dynamic_sidebar( 'column-1' ); ?></div>
            <?php endif; ?>
            <?php if ( $has_side ) : ?>
                <aside aria-label="<?php esc_attr_e( 'Busca e coleções', 'vitrines' ); ?>">
                    <?php dynamic_sidebar( 'column-2' ); ?>
                </aside>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
