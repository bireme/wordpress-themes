<?php $lang = pll_current_language(); ?>
<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-6 margin-m1 text-cm" id="footer-logo-bireme">
				<img src="http://logos.bireme.org/img/<?php echo $lang; ?>/h_bir_white.svg" class="img-fluid" alt="">
			</div>
			<div class="col-md-6 text-end" id="footer-terms">
				<a href="https://politicas.bireme.org/terminos/<?php echo $lang=='fr'?'en':$lang; ?>/" target="_blank"><?php _e('Terms and Conditions of Use', 'Eventos-BVS'); ?></a> | 
				<a href="https://politicas.bireme.org/privacidad/<?php echo $lang=='fr'?'en':$lang; ?>/" target="_blank"><?php _e('Privacy policy', 'Eventos-BVS'); ?></a>
			</div>
		</div>
	</div>
</footer>
<div id="poweredby" class="text-center"><?php _e('Poweredby: BIREME/OPAS/OMS', 'Eventos-BVS'); ?></div>

<?php wp_footer(); ?>
</body>
</html>