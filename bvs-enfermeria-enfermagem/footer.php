<?php
/**
 * The template for displaying the footer.
 *
 */

$current_language = strtolower(get_bloginfo('language'));
$site_lang = substr($current_language, 0,2);
if ($current_language != ''){
    $current_language = '_' . $current_language;
} 

$bottom = "footer";
if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
    $bottom .= $current_language;
}

?>

        </div>

        <footer class='footer'>
            <div class='container'>
                <div class='row'><?php dynamic_sidebar( $bottom ); ?></div>
            </div>

            <div class="siteInfo">
                <ul>
                    <li><?php echo '<a href="http://wordpress.org" title="WordPress.org">WordPress</a> version ' . get_bloginfo ( 'version' ); ?></li>
                    <li><?php echo '<a href="https://github.com/bireme/bvs-site-wp-plugin" title="plugin repository">BVS-Site Plugin</a> version ' . BVS_VERSION;  ?></li>
                </ul>
            </div>
        </footer>

        <?php wp_footer(); ?>
        
        <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>  
        <script src="http://owlgraphic.com/owlcarousel/owl-carousel/owl.carousel.js"></script>  
        <script src="<?= get_template_directory_uri(); ?>/static/js/script.js"></script>  

    </body>
</html>