	<?php $idioma = pll_current_language(); ?>
	<footer id="footer" class="padding1">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<b>EVID@Easy</b> <br>
					<a href="http://politicas.bireme.org/terminos/<?php echo $idioma?>/" target="_blank"><?php pll_e('Terms and conditions of use'); ?></a> | 
					<a href="http://politicas.bireme.org/privacidad/<?php echo $idioma?>/" target="_blank"><?php pll_e('Privacy Policy'); ?></a>
				</div>
				<div class="col-md-6 text-right" id="logoBir">
					<a href="https://www.paho.org/<?php echo $idioma?>/bireme" target="_blank">
						<img src="http://logos.bireme.org/img/<?php echo $idioma; ?>/v_bir_color.svg" alt="" class="imgBlack">
					</a>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>
<?php wp_footer(); ?>