<section id="barAcessibilidade">
	<?php $idioma = pll_current_language(); ?>
	<div class="container">
		<div class="row">
			<div class="col-md-6" id="acessibilidadeTutorial">
				<a href="#main_container" tabindex="1" role="button"><?php pll_e('Main content'); ?> <span class="hiddenMobile">1</span></a>
				<a href="#nav" tabindex="2"  role="button"><?php pll_e('Menu'); ?> <span class="hiddenMobile">2</span></a>
				<a href="#buscaInput" tabindex="3" role="button"><?php pll_e('Search'); ?> <span class="hiddenMobile">3</span></a>
				<a href="#footer" tabindex="4" role="button"><?php pll_e('Footer'); ?> <span class="hiddenMobile">4</span></a>
			</div>
			<div class="col-md-6" id="acessibilidadeFontes">
				<a href="#!" role="button" id="fontPlus" tabindex="5">+A</a>
				<a href="#!" role="button" id="fontNormal" tabindex="6">A</a>
				<a href="#!" role="button" id="fontLess" tabindex="7">-A</a>
				<a href="#!" role="button" id="contraste" tabindex="8"><i class="fas fa-adjust"></i> <?php pll_e('High contrast'); ?></a>
				<a href="https://politicas.bireme.org/accesibilidad/<?php echo ( in_array($idioma, ['ar', 'fr', 'ru', 'zh']) ? "en" : $idioma ); ?>" role="button" id="accebilidade" tabindex="9" target="_blank"><i class="fas fa-wheelchair"></i></a>
			</div>
		</div>
	</div>
</section>
