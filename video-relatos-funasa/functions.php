<?php

add_image_size( 'news-thumb', 75 ); // 75 pixels wide (and unlimited height)
add_image_size( '75-square-thumb', 75, 75, true ); // (cropped)

function append_post_type($termlink) {
	if (is_single()) {
		$pt = get_post_type();
		return $termlink . "&post_type=" . $pt;
	}
}
add_filter('tag_link','append_post_type');

function read_more_link( $id, $section ) {
    $postmeta = get_post_meta($id, $section, true);
    $doc = new DOMDocument();
    $doc->loadHTML($postmeta);
    $size = $doc->getElementsByTagName('a')->length;
    foreach($doc->getElementsByTagName('a') as $index => $href) { $index++;
        echo utf8_decode($doc->saveHTML($href));
        if ( $size > 5 && $index == 5 ) echo '<div style="display: none;">';
        if ( $size > 5 && $index == $size ) echo '</div><a class="more_like_that" style="display: block; text-align: right; text-decoration: underline; cursor: pointer;">>> Mostrar mais</a>';
    }
}

function custom_content_after_body_open_tag() {

    ?>

    <div id="barra-brasil" style="background: #7F7F7F; height: 20px; padding: 0 0 0 10px; display: block;">
        <ul id="menu-barra-temp" style="list-style: none;">
            <li style="display: inline; float: left; padding-right: 10px; margin-right: 10px; border-right: 1px solid #EDEDED;">
                <a href="http://brasil.gov.br" style="font-family: sans, sans-serif; text-decoration: none; color: white;">Portal do Governo Brasileiro</a>
            </li>
            <li>
                <a style="font-family: sans, sans-serif; text-decoration: none; color: white;" href="http://epwg.governoeletronico.gov.br/barra/atualize.html">Atualize sua Barra de Governo</a>
            </li>
        </ul>
    </div>
    <script defer="defer" src="//barra.brasil.gov.br/barra.js" type="text/javascript"></script>

    <?php

}
add_action('wp_head', 'custom_content_after_body_open_tag');

?>
