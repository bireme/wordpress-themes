	<?php $language = pll_current_language(); ?>
	<footer id="footer" class="padding2">
		<div class="container">
			<div class="row">
				<div class="col-md-6" id="logoFooter">
					<img src="<?php bloginfo('template_directory'); ?>/img/logo-footer-<?=$language; ?>.svg" alt="">
				</div>
				<nav class="col-md-3">
					<ul class="list-unstyled"><?php dynamic_sidebar('footer_1') ?></ul>
				</nav>
				<nav class="col-md-3">
					<ul class="list-unstyled"><?php dynamic_sidebar('footer_2') ?></ul>
				</nav>
			</div>
		</div>
	</footer>
	<div id="assFooter" class="text-center padding3">
		<div class="container">
			<img src="http://logos.bireme.org/img/<?=$language; ?>/h_bir_color.svg" alt="Bireme" class="img-fluid imgBlack">
			<hr>
			<div class="row" id="footerTermos">
				<div class="col-md-6 text-left">
					<?php pll_e('Best Pratices'); ?>
				</div>
				<div class="col-md-6 text-right">
					<a href="http://politicas.bireme.org/terminos/<?php echo $language?>/" target="_blank"><?php pll_e('Terms and conditions of use'); ?></a> |
					<a href="http://politicas.bireme.org/privacidad/<?php echo $language?>/" target="_blank"><?php pll_e('Privacy Policy'); ?></a>
				</div>
			</div>
		</div>
	</div>
	<?php wp_footer(); ?>
</body>
</html>