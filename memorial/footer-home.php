<footer id="footer-home">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<ul class="list-unstyled"><?php dynamic_sidebar('nova-home') ?></ul>
					</div>
					<div class="col-md-3 offset-md-1" id="footer-home-social">
						<p>Redes Sociais</p>
					<hr>
					<a href=""><img src="<?php bloginfo('template_directory'); ?>/img/instagram-footer.png" alt="" id="logo" class="img-fluid"></a>
					<a href=""><img src="<?php bloginfo('template_directory'); ?>/img/facebook-footer.png" alt="" id="logo" class="img-fluid"></a>
					<a href=""><img src="<?php bloginfo('template_directory'); ?>/img/x-footer.png" alt="" id="logo" class="img-fluid"></a>
					<a href=""><img src="<?php bloginfo('template_directory'); ?>/img/email-footer.png" alt="" id="logo" class="img-fluid"></a>
					</div>
				</div>
				<hr >
				<div class="text-center">
					<img src="<?php bloginfo('template_directory'); ?>/img/powered.png" alt=""> <br>	
					<small>© Todos os direitos são reservados</small>
				</div>
			</div>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>
