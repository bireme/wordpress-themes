	<?php $language = pll_current_language(); ?>
	<footer id="footer">
		<div class="container text-center">
			<img src="<?php bloginfo('template_directory'); ?>/img/logoFooter-<?php echo $language; ?>.png" class="img-fluid" alt="">
		</div>
	</footer>
	<div id="assFooter" class="text-center padding1 d-print-none">
		<div class="container">
			<div class="row" id="footerTermos">
				<div class="col-md-6 text-start">
					<?php bloginfo('site_name'); ?>
				</div>
				<div class="col-md-6 text-end">
					<a href="http://politicas.bireme.org/terminos/<?php echo $language==''?'es':$language; ?>/" target="_blank">
						<?php pll_e('Terms and conditions of use'); ?></a> |
					<a href="http://politicas.bireme.org/privacidad/<?php echo $language==''?'es':$language; ?>/" target="_blank">
						<?php pll_e('Privacy policy'); ?></a>
				</div>
			</div>
		</div>
	</div>
	<?php wp_footer(); ?>
</body>
</html>