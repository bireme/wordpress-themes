
		<footer id="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<ul class="list-unstyled">
							<?php
							$lang = function_exists('pll_current_language') ? pll_current_language() : 'pt';
							if ($lang === 'pt') {
								dynamic_sidebar('footer1_pt');
							} elseif ($lang === 'en') {
								dynamic_sidebar('footer1_en');
							} elseif ($lang === 'es') {
								dynamic_sidebar('footer1_es');
							}
							?>
						</ul>
					</div>
				</div>
				<hr >
				<div class="text-center">
					<img src="<?php bloginfo('template_directory'); ?>/img/powered.svg" id="logo-poweredby" alt=""> <br>	
					<div class="mt-3"><small>© <?php pll_e('Todos os direitos são reservados'); ?></small></div>
				</div>
			</div>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>