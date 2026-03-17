<?php
$languages = array();

if ( function_exists( 'pll_the_languages' ) ) {
    $languages = pll_the_languages(
        array(
            'raw'                    => 1,
            'hide_if_no_translation' => 0,
            'hide_current'           => 0,
        )
    );
}
?>
<div class="lang-switcher">
    <?php if ( ! empty( $languages ) ) : ?>
        <?php foreach ( $languages as $language ) : ?>
            <a
                href="<?php echo esc_url( $language['url'] ); ?>"
                class="<?php echo ! empty( $language['current_lang'] ) ? 'active' : ''; ?>"
                lang="<?php echo esc_attr( $language['locale'] ); ?>"
                hreflang="<?php echo esc_attr( $language['slug'] ); ?>"
            >
                <?php echo esc_html( $language['name'] ); ?>
            </a>
        <?php endforeach; ?>
    <?php else : ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="active">
            <?php echo esc_html( get_bloginfo( 'language' ) ); ?>
        </a>
    <?php endif; ?>
</div>
