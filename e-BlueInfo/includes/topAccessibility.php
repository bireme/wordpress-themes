<section id="barAcessibilidade">
	<div class="container">
		<div class="row">
			<div class="col-md-6" id="acessibilidadeTutorial">
				<a href="#main_container" tabindex="1" role="button"><?php pll_e('Main content'); ?> <span class="hiddenMobile">1</span></a>
				<a href="#nav" tabindex="2" role="button"><?php pll_e('Menu'); ?> <span class="hiddenMobile">2</span></a>
				<a href="#footer" tabindex="4" role="button"><?php pll_e('Footer'); ?> <span class="hiddenMobile">4</span></a>
			</div>
			<div class="col-md-6" id="acessibilidadeFontes">
				<a id="fontPlus" role="button" tabindex="5">+A</a>
				<a id="fontNormal" role="button" tabindex="6">A</a>
				<a id="fontLess" role="button" tabindex="7">-A</a>
				<a id="contraste" role="button" tabindex="8"><i class="fas fa-adjust"></i> <?php pll_e('High contrast'); ?></a>
			</div>
		</div>
	</div>
</section>