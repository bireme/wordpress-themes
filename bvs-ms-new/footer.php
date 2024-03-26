
<footer id="footer" class="padding1">
	<div class="container">
		<div class="row">

			<nav class="col-md-6 col-lg-3 navFooter">
				<ul class="list-unstyled"><?php dynamic_sidebar('footer1') ?></ul>
			</nav>
			<nav class="col-md-6 col-lg-3 navFooter">
				<ul class="list-unstyled"><?php dynamic_sidebar('footer2') ?></ul>
			</nav>
			<nav class="col-md-6 col-lg-3 navFooter">
				<ul class="list-unstyled"><?php dynamic_sidebar('footer3') ?></ul>
			</nav>
			<div class="col-md-6 col-lg-3" id="footerSocial">
				<ul class="list-unstyled"><?php dynamic_sidebar('footer4') ?></ul>
			</div>
		</div>
	</div>
</footer>
<!-- seta up -->
<div id="to-top" class="to-top d-print-none">
	<span class="float-left">
		<i class="fas fa-arrow-up"></i>
	</span>
</div>
<?php wp_footer(); ?>
</body>
</html>