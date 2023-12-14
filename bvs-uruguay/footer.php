		<footer id="footer">
			<div class="container">
				<ul type="none"><?php dynamic_sidebar('footer') ?></ul>
				<hr>	
				<p class="text-center"><a href="">Términos y condiciones de uso</a> | <a href="">Política de privacidad</a></p>
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