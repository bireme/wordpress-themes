<?php wp_footer(); ?>
<?php $idioma = pll_current_language(); ?>
<footer>
	<div id="footer" class="container">
		<div class="row">
			<div class="col-md-5">
				<b>e-BlueInfo</b> <br>
				<a href="https://politicas.bireme.org/terminos/" target="_blank"><?php pll_e('Terms and conditions of use'); ?></a> | 
				<a href="https://politicas.bireme.org/privacidad/" target="_blank"><?php pll_e('Privacy policy'); ?></a>
			</div>
			<div class="col-md-7 text-right" id="logoOPAS">
				<img src="https://logos.bireme.org/img/<?php echo $idioma; ?>/h_bir_color.svg" alt="">
			</div>
		</div>
	</div>
</footer>