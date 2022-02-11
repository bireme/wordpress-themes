<?php
	$site_language = strtolower(get_bloginfo('language'));
	$lang = substr($site_language,0,2);
?>
<section id="barAccessibility" class="d-print-none">
	<div class="container">
		<div class="row">
			<div class="col-md-6" id="accessibilityTutorial">
				<a href="#main_container" tabindex="1" role="button"><?php _e('Main Content', 'best-practices'); ?> <span class="hiddenMobile">1</span></a>
				<a href="#nav" tabindex="2" role="button"><?php _e('Menu', 'best-practices'); ?> <span class="hiddenMobile">2</span></a>
				<a href="#fieldSearch" tabindex="3" id="accessibilitySearch" role="button"><?php _e('Search', 'best-practices'); ?> <span class="hiddenMobile">3</span></a>
				<a href="#footer" tabindex="4" role="button"><?php _e('Footer', 'best-practices'); ?> <span class="hiddenMobile">4</span></a>
			</div>
			<div class="col-md-6" id="accessibilityFontes">
				<a href="#!" id="fontPlus"  tabindex="5" aria-hidden="true">+A</a>
				<!-- <a href="#!" id="fontNormal"  tabindex="6" aria-hidden="true">A</a> -->
				<a href="#!" id="fontLess"  tabindex="7" aria-hidden="true">-A</a>
				<a href="#!" id="contraste"  tabindex="8" aria-hidden="true"><i class="fas fa-adjust"></i> <?php _e('High Contrast', 'best-practices'); ?></a>
				<a href="https://politicas.bireme.org/accesibilidad/<?php echo (in_array($lang, ['fr']) ? "en" : $lang ); ?>" role="button" id="accebilidade" tabindex="9" target="_blank" title="Accessibility"><i class="fas fa-wheelchair"></i></a>
			</div>
		</div>
	</div>
</section>
