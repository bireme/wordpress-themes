<?php $lang = pll_current_language(); ?>
<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-6 offset-3 margin1">
				<img src="http://logos.bireme.org/img/<?php echo $lang; ?>/h_bir_white.svg" id="footer-bireme" class="img-fluid" alt="">		
			</div>
		</div>
		<div class="text-center">
			<ul class="list-unstyled"><?php dynamic_sidebar('footer1') ?></ul>
		</div>
	</div>
</footer>
<div id="footer-term" class="text-center">
	<?php pll_e('La responsabilidad de los contenidos de la BVS MTCI es de la Red MTCI Américas'); ?> | <a href="https://politicas.bireme.org/terminos/<?php echo $lang=='fr'?'en':$lang; ?>/" target="_blank"><?php _e('Terms and Conditions of Use', 'mtci'); ?></a> | 
	<a href="https://politicas.bireme.org/privacidad/<?php echo $lang=='fr'?'en':$lang; ?>/" target="_blank"><?php _e('Privacy policy', 'mtci'); ?><?php pll_e('Privacy policy'); ?></a>
</div>
</body>
</html>
<?php wp_footer(); ?>