<?php $idioma = pll_current_language(); ?>
<section id="barAccessibility">
	<div class="container">
		<div class="row">
			<div class="col-md-6" id="accessibilityTutorial">
				<a href="#main_container" tabindex="1" role="button"><?php pll_e('Main content'); ?> <span class="hiddenMobile">1</span></a>
				<!-- <a href="#nav" tabindex="2" role="button"><?php pll_e('Menu'); ?> <span class="hiddenMobile">2</span></a> -->
				<!-- <a href="#fieldSearch" tabindex="3" id="accessibilitySearch" role="button"><?php pll_e('Search'); ?> <span class="hiddenMobile">3</span></a> -->
				<a href="#footer" tabindex="4" role="button"><?php pll_e('Footer'); ?> <span class="hiddenMobile">4</span></a>
			</div>
			<div class="col-md-6" id="accessibilityFontes">
				<a href="#!" id="fontPlus"  tabindex="5" aria-hidden="true">+A</a>
				<a href="#!" id="fontNormal"  tabindex="6" aria-hidden="true">A</a>
				<a href="#!" id="fontLess"  tabindex="7" aria-hidden="true">-A</a>
				<a href="#!" id="contraste"  tabindex="8" aria-hidden="true"><i class="fas fa-adjust"></i> <?php pll_e('High contrast'); ?></a>
				<a href="https://politicas.bireme.org/accesibilidad/<?php echo (in_array($idioma, ['fr']) ? "en" : $idioma ); ?>" role="button" id="accebilidade" tabindex="9" target="_blank" title="Acessibilidade"><i class="fas fa-wheelchair"></i></a>
			</div>
		</div>
	</div>
</section>