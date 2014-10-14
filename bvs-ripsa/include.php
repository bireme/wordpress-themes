<?php

// widgets
$widgets_file = TEMPLATEPATH . '/bireme_archives/custom/widgets';
if(file_exists($widgets_file)) {
	foreach(glob($widgets_file . "/*.php") as $file) {
		require $file;
	}
}

?>
