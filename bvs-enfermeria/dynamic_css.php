<?php
// array(6) { [0]=> string(7) "general" [1]=> string(5) "first" [2]=> string(6) "second" [3]=> string(5) "third" [4]=> string(6) "header" [5]=> string(6) "footer" }
// de para do dicionario para o css
$css_terms = array(
	'first' => 'column-1',
	'second' => 'column-2',
	'third' => 'column-3',
	'header' => 'header',
	'footer' => 'footer',
);

?>

<style>

	/* imagem de fundo */
	body {
		background-image: url('<?php vhl_background_image(); ?>');
	}

	/* banner */
	header .topbanner {
	    background-image: url(<?php vhl_banner_image(); ?>);
	}

	<?php if(in_array('general', $settings['colors']['check'])): //var_dump($settings);?>
		
		/* CORES GERAIS */
		body {
			background-color: <?php vhl_color('general-background'); ?>;
			color: <?php vhl_color('general-text'); ?>;
		}
		a, a:active {
			color: <?php vhl_color('general-link-active'); ?>;
		}
		a:visited {
			color: <?php vhl_color('general-link-visited'); ?>;
		}
		h1, h1 a {
			color: <?php vhl_color('general-title-first'); ?>;
		}
		h2, h2 a {
			color: <?php vhl_color('general-title-second'); ?>;
		}
		h3, h3 a {
			color: <?php vhl_color('general-title-third'); ?>;
		}

	<?php endif; ?>

	/* iterando pelo resto das cores, exceto general */
	<?php foreach($settings['colors']['check'] as $block): ?>

		<?php if($block != 'general'): ?>

			/* CORES <?= $block; ?> */
			.<?= $css_terms[$block]; ?> {
				background-color: <?php vhl_color($block . '-background'); ?>;
				color: <?php vhl_color($block . '-text'); ?>;
			}
			.<?= $css_terms[$block]; ?> a:visited {
				color: <?php vhl_color($block . '-link-visited'); ?>;
			}
			.<?= $css_terms[$block]; ?> a, .<?= $css_terms[$block]; ?> a:active {
				color: <?php vhl_color($block . '-link-active'); ?>;
			}
			.<?= $css_terms[$block]; ?> h1 {
				color: <?php vhl_color($block . '-title-first'); ?>;
			}
			.<?= $css_terms[$block]; ?> h2 {
				color: <?php vhl_color($block . '-title-second'); ?>;
			}
			.<?= $css_terms[$block]; ?> h3 {
				color: <?php vhl_color($block . '-title-third'); ?>;
			}

		<?php endif; ?>

	<?php endforeach; ?>
	

</style>