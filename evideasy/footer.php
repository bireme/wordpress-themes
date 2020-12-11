	<?php $idioma = pll_current_language(); ?>
	<footer id="footer" class="padding1">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<b>EVID@Easy</b> <br>
					<a href="http://politicas.bireme.org/terminos/<?php echo $idioma?>/" target="_blank"><?php pll_e('Terms and conditions of use'); ?></a> | 
					<a href="http://politicas.bireme.org/privacidad/<?php echo $idioma?>/" target="_blank"><?php pll_e('Privacy Policy'); ?></a>
				</div>
				<div class="col-md-7 text-right">
					<img src="http://logos.bireme.org/img/<?php echo $idioma; ?>/h_bir_color.svg" alt="" class="img-fluid">
				</div>
			</div>
		</div>
	</footer>
</body>
</html>
<?php wp_footer(); ?>