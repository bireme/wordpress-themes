		<?php $lang = pll_current_language(); ?>
		<footer id="footer">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<img src="<?php bloginfo('template_directory') ;?>/img/bvs-footer-<?php echo $lang; ?>.svg" alt="BVS" id="footer-bvs" class="float-start">
						<ul type="none"><?php dynamic_sidebar('footer1') ?></ul>
					</div>
					<div class="col-lg-4" id="footer-bireme">
						<ul type="none"><?php dynamic_sidebar('footer2') ?></ul>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-6" id="copyright">
						© BIREME / OPAS / OMS. Todo os direitos são reservados.
					</div>
					<div class="col-md-6" id="powered">
						<img src="<?php bloginfo('template_directory') ;?>/img/powered.png" alt="">
					</div>
				</div>	
			</div>
		</footer>
		<div id="to-top" class="to-top">
			<span class="float-left">
				<i class="bi bi-arrow-up-circle-fill"></i>
			</span>
		</div>
		<div id="social" class="d-print-none">
			<ul>
				<ul type="none"><?php dynamic_sidebar('social') ?></ul>
			</ul>
		</div>
		<?php wp_footer(); ?>
	</body>
	</html>