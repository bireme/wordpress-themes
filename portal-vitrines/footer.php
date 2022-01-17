<?php
/**
 * The template for displaying the footer.
 *
 */
    $settings = get_option( "wp_bvs_theme_settings" );
    $current_language = strtolower(get_bloginfo('language'));

    if ($current_language != ''){
        $current_language = '_' . $current_language;
    }

    $bottom = "footer";

    if(is_plugin_active('multi-language-framework/multi-language-framework.php'))
        $bottom .= $current_language;

?>

    <div class="footer">
        <?php dynamic_sidebar( $bottom ); ?>
        <div class="spacer"></div>
    </div>
    <div class="siteInfo">
        <ul>
            <li><?php echo '<a href="http://wordpress.org" title="WordPress.org">WordPress</a> version ' . get_bloginfo ( 'version' ); ?></li>
            <li><?php echo '<a href="https://github.com/bireme/bvs-site-wp-plugin" title="plugin repository">BVS-Site Plugin</a> version ' . BVS_VERSION;  ?></li>
        </ul>
    </div>
</div><!-- .container -->

<?php wp_footer(); ?>

<script type="text/javascript">
//<![CDATA[
    $(document).ready(function() {
       $('.read_more').on('click', function(e) {
           $(this).parent().hide();
           $(this).closest('div').next().fadeToggle('slow');
       });
       $('.show_excerpt').on('click', function(e) {
           $(this).parent().hide();
           $(this).closest('div').prev().children().fadeToggle('slow');
       });
    });

    $(document).ready(function() {
        inputval = $( ".vhl-search-submit" ).val();
        $( "#vhl-search-input", this).focus(function() {
            if (inputval == $(this).val())
            {
                $(this).attr('value', '');
            }
        });
        $( "#vhl-search-input", this ).blur(function() {
            if (!$(this).val())
            {
                $(this).attr('value', inputval);
            }
        });
        $( "#searchForm", this ).submit(function() {
            if ($(this).children('#vhl-search-input').val() == inputval)
            {
                $(this).children('#vhl-search-input').attr('value', '');
            }
        });
    });

    $(document).on("ready", listenWidth);
    $(document).on("ready", network);
    $(document).ready($(window).on("resize", listenWidth));
    $(document).ready($(window).on("resize", network));

    function listenWidth( e ) {
        if($(window).width()<729)
        {
            if ($('body').find('.2_columns').length)
            {
                $(".column_1").remove().insertAfter($(".column_2"));
            }
        } else {
           $(".column_1").remove().insertBefore($(".column_2"));
        }
    }
//]]>
</script>
<noscript>Your browser does not support JavaScript!</noscript>
</body>
</html>