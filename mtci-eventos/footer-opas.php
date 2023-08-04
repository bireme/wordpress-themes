		<?php $lang = pll_current_language(); ?>
		<footer id="footer-opas" class="padding1">
			<div class="container">
				<div class="row">
					<div class="col-md-3">
						<img src="<?php bloginfo('template_directory'); ?>/img/footer-paho-<?php echo $lang; ?>.png" class="img-fluid" alt="">
					</div>
					<div class="col-md-9 text-end">
						<a href="https://politicas.bireme.org/terminos/<?php echo $lang=='fr'?'en':$lang; ?>/" target="_blank"><?php _e('Terms and Conditions of Use', 'Eventos-BVS'); ?></a> | 
						<a href="https://politicas.bireme.org/privacidad/<?php echo $lang=='fr'?'en':$lang; ?>/" target="_blank"><?php _e('Privacy policy', 'Eventos-BVS'); ?></a>
					</div>
				</div>
			</div>
		</footer>
		<section id="powered">
			<div class="container text-center">
				Powered by BIREME | OPS | OMS
			</div>
		</section>
		<?php wp_footer(); ?>
	</body>
</html>