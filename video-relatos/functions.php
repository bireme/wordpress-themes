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




?>
