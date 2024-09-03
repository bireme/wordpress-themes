<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<ul class="list-unstyled"><?php dynamic_sidebar('footer_1') ?></ul>
			</div>
			<div class="col-md-8" id="border-left-1">
				<ul class="list-unstyled"><?php dynamic_sidebar('footer_2') ?></ul>
			</div>
		</div>
		<div id="powered-by">
			<img src="<?php bloginfo('template_directory'); ?>/img/powered-by-bireme.png" id="" alt=""> <br>
			© WHO (CC BY-NC-SA 4.0)
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
