		<footer id="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<ul class="list-unstyled"><?php dynamic_sidebar('footer1') ?></ul>
					</div>
					<div class="col-md-2 offset-md-2">
						<ul class="list-unstyled"><?php dynamic_sidebar('footer2') ?></ul>
						
					</div>
					<div class="col-md-2">
						<ul class="list-unstyled"><?php dynamic_sidebar('footer3') ?></ul>
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
