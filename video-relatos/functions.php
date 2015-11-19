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

?>
