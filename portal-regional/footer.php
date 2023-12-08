		<footer id="footer">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<ul type="none"><?php dynamic_sidebar('footer1') ?></ul>
					</div>
					<div class="col-lg-6" id="footer-bireme">
						<ul type="none"><?php dynamic_sidebar('footer2') ?></ul>
					</div>
				</div>
				<hr>	
				<p class="text-center"><a href="">Termos e Condições de uso</a> | <a href="">Políticas de Privacidade</a></p>	
			</div>
		</footer>
		<div id="powered">
			<img src="<?php bloginfo('template_directory') ;?>/img/powered.png" alt="">
		</div>
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