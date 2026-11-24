<?php
$copy = vitrines_copy();
$language = vitrines_locale();
?>
<footer class="vitrines-site-footer">
    <?php if ( is_active_sidebar( 'footer_sidebar' ) ) : ?>
        <div class="vitrines-frame vitrines-footer-aux"><?php dynamic_sidebar( 'footer_sidebar' ); ?></div>
    <?php endif; ?>
    <div class="vitrines-frame vitrines-footer-content institutionalFooter">
        <?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
            <?php dynamic_sidebar( 'sidebar-footer' ); ?>
        <?php elseif ( is_active_sidebar( 'footer' ) ) : ?>
            <?php dynamic_sidebar( 'footer' ); ?>
        <?php else : ?>
            <div class="Institution-info">
                <p><strong><?php echo esc_html( $copy['institution'] ); ?></strong></p>
                <p><?php echo esc_html( $copy['center'] ); ?></p>
                <p><?php echo esc_html( $copy['department'] ); ?></p>
                <p>Rua Vergueiro, 1759 | CEP 04101-000 | São Paulo - SP | <a href="tel:+551155769800">+55 11 5576-9800</a></p>
                <p><a href="https://www.paho.org/bireme/">www.paho.org/bireme</a></p>
                <p>
                    <a href="<?php echo esc_url( "https://politicas.bireme.org/terminos/{$language}/index.html" ); ?>"><?php echo esc_html( $copy['terms'] ); ?></a> |
                    <a href="<?php echo esc_url( "https://politicas.bireme.org/privacidad/{$language}/index.html" ); ?>"><?php echo esc_html( $copy['privacy'] ); ?></a>
                </p>
            </div>
        <?php endif; ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
