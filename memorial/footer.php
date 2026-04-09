
		<footer id="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<ul class="list-unstyled"><?php dynamic_sidebar('footer1') ?></ul>
					</div>
				</div>
				<hr >
				<div class="text-center">
					<img src="<?php bloginfo('template_directory'); ?>/img/powered.svg" id="logo-poweredby" alt=""> <br>	
					<div class="mt-3">© Todos os direitos são reservados</div>
				</div>
			</div>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>