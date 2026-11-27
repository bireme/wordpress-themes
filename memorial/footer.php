
		<footer id="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<ul class="list-unstyled">
							<?php
							$lang = function_exists('pll_current_language') ? pll_current_language() : 'pt';
							if ($lang === 'pt') {
								dynamic_sidebar('footer_pt');
							} elseif ($lang === 'en') {
								dynamic_sidebar('footer_en');
							} elseif ($lang === 'es') {
								dynamic_sidebar('footer_es');
							}
							?>
						</ul>
					</div>
				</div>
				<hr >
				<div class="text-center">
					<img src="<?php bloginfo('template_directory'); ?>/img/powered.svg" id="logo-poweredby" alt=""> <br>	
					<div class="mt-3"><small>© <?php echo esc_html(function_exists('pll__') ? pll__('Todos os direitos são reservados') : __('Todos os direitos são reservados', 'memorial')); ?></small></div>
					<?php $sitemap_url = memorial_sitemap_url(); ?>
					<?php if ($sitemap_url) : ?>
						<div class="mt-2"><small><a href="<?php echo esc_url($sitemap_url); ?>"><?php echo esc_html(memorial_sitemap_text('title')); ?></a></small></div>
					<?php endif; ?>
				</div>
			</div>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>