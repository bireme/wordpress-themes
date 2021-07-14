	<?php $language = pll_current_language(); ?>
	<footer id="footer" class="padding1">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<b>RedETSA</b> <br>
					<a href="http://politicas.bireme.org/terminos/<?php echo $language==''?'es':$language; ?>/" target="_blank">
						<?php pll_e('Terms and conditions of use'); ?>

					</a>
					<a href="http://politicas.bireme.org/privacidad/<?php echo $language==''?'es':$language; ?>/" target="_blank">
						<?php pll_e('Privacy policy'); ?>
					</a>
				</div>
				<div class="col-md-4">
					<img src="http://logos.bireme.org/img/<?php echo $language==''?'es':$language; ?>/h_bir_white.svg" alt="" class="img-fluid">
				</div>
			</div>
		</div>
	</footer>
	<?php wp_footer(); ?>
</body>
</html>