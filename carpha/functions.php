<?php

if (!function_exists('input_search_default_value')) {
    function input_search_default_value () {
        echo "\n<script type=\"text/javascript\">/* <![CDATA[ */";
        echo "\n    jQuery(document).ready(function($) {";
        echo "\n        inputval = 'Enter search terms';";
        echo "\n        $('.vhl-search-input').val(inputval);";
        echo "\n    });";
        echo "\n/* ]]> */</script>";
        echo "\n<noscript>Your browser does not support JavaScript!</noscript>";
        echo "\n";
    }
    add_action('wp_footer', 'input_search_default_value', 100);
}

?>
