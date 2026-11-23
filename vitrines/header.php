<?php
$language = vitrines_locale();
$copy = vitrines_copy();
$is_showcase = is_singular( array( 'vitrine', 'post_vitrines' ) );
$brand_url = 'https://bvsalud.org/vitrinas/';
if ( in_array( $language, array( 'en', 'es' ), true ) ) {
    $brand_url .= $language . '/';
}
$logo_id = (int) get_theme_mod( "vitrines_logo_{$language}", 0 );
$logo = $logo_id ? wp_get_attachment_image( $logo_id, 'full', false, array( 'alt' => $copy['title'] ) ) : '';
$title = get_theme_mod( "vitrines_title_{$language}" );
$bvs_url = 'pt' === $language ? 'https://bvsalud.org/' : "https://bvsalud.org/{$language}/";
$bvs_names = array( 'pt' => 'Biblioteca Virtual em Saúde', 'es' => 'Biblioteca Virtual en Salud', 'en' => 'Virtual Health Library' );
$bvs_logo_url = "https://logos.bireme.org/img/{$language}/bvs_color.svg";
$languages = array();
$language_options = function_exists( 'pll_the_languages' )
    ? pll_the_languages( array( 'raw' => 1, 'hide_if_no_translation' => 0 ) )
    : array();
foreach ( $language_options ?: array() as $item ) {
    $code = strtolower( substr( $item['locale'] ?? $item['slug'], 0, 2 ) );
    $url = $item['url'];
    if ( $is_showcase && ! $item['current_lang'] && ! empty( $item['no_translation'] ) ) {
        $url = get_theme_mod( "vitrines_landing_{$code}" );
    }
    if ( $url ) {
        $languages[ $code ] = array( 'url' => $url, 'current' => $item['current_lang'] );
    }
}
$language_labels = array( 'pt' => 'Português', 'en' => 'English', 'es' => 'Español' );
$languages = array_intersect_key( $languages, $language_labels );
$content_id = is_singular( 'vitrine' ) ? 'vitrine-single' : 'primary';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="vitrines-skip" href="#<?php echo esc_attr( $content_id ); ?>"><?php echo esc_html( $copy['skip'] ); ?></a>
<header class="vitrines-site-header">
    <div class="vitrines-masthead">
        <?php if ( ! empty( $languages ) ) : ?>
            <nav class="vitrines-languages" aria-label="<?php echo esc_attr( $copy['language'] ); ?>">
                <ul>
                <?php foreach ( $language_labels as $code => $label ) : ?>
                    <?php if ( ! isset( $languages[ $code ] ) ) { continue; } ?>
                    <?php $item = $languages[ $code ]; ?>
                    <li>
                        <a href="<?php echo esc_url( $item['url'] ); ?>" lang="<?php echo esc_attr( $code ); ?>" hreflang="<?php echo esc_attr( $code ); ?>"<?php echo $item['current'] ? ' aria-current="page"' : ''; ?>>
                            <?php echo esc_html( $label ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                </ul>
            </nav>
        <?php endif; ?>
        <a class="vitrines-bvs" href="<?php echo esc_url( $bvs_url ); ?>">
            <img src="<?php echo esc_url( $bvs_logo_url ); ?>" alt="<?php echo esc_attr( $bvs_names[ $language ] ); ?>">
        </a>
        <a class="vitrines-brand" href="<?php echo esc_url( $brand_url ); ?>">
            <?php if ( $logo ) : ?>
                <?php echo $logo; ?>
            <?php else : ?>
                <?php echo esc_html( $title ?: $copy['title'] ); ?>
            <?php endif; ?>
        </a>
    </div>
    <?php if ( has_nav_menu( 'institutional' ) || has_nav_menu( 'primary' ) || is_active_sidebar( 'header' ) ) : ?>
        <div class="vitrines-frame vitrines-header-resources">
            <?php if ( has_nav_menu( 'institutional' ) ) : ?>
                <nav aria-label="<?php echo esc_attr( $copy['institution'] ); ?>">
                    <?php wp_nav_menu( array( 'theme_location' => 'institutional', 'container' => false, 'fallback_cb' => false ) ); ?>
                </nav>
            <?php endif; ?>
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <nav aria-label="<?php echo esc_attr( $copy['menu'] ); ?>">
                    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'fallback_cb' => false ) ); ?>
                </nav>
            <?php endif; ?>
            <?php dynamic_sidebar( 'header' ); ?>
        </div>
    <?php endif; ?>
</header>
