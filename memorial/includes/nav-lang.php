<div id="lang">
	<?php 
	if (is_page_template(MEMORIAL_SITEMAP_TEMPLATE) && function_exists('pll_the_languages')) {
		echo '<ul class="list-unstyled">';
		echo wp_kses_post(pll_the_languages(array(
			'echo' => 0,
			'hide_if_no_translation' => 1,
			'show_names' => 1,
			'show_flags' => 0,
		)));
		echo '</ul>';
	} else {
		wp_nav_menu( array(
			'theme_location'    => 'Language',
			'container_class'   => 'list-unstyled',
		) );
	}
	?>
</div>
