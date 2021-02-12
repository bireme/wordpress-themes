<?php $idioma = pll_current_language(); ?>
<footer id="footer" class="">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<small><ul class="list-unstyled"><?php dynamic_sidebar('footer1') ?></ul></small>
			</div>
			<div class="col-md-4">
				<img src="http://logos.bireme.org/img/<?php echo $idioma; ?>/h_bir_white.svg" alt="" class="img-fluid">
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>