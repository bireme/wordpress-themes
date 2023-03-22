<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<img src="<?php bloginfo('template_directory') ?>/img/logo-ins.jpg" id="logo-ins" alt="INS" class="img-fluid">
			</div>
			<div class="col-md-6">
				<ul class="list-unstyled"><?php dynamic_sidebar('footer_widget') ?></ul>
			</div>
			<div class="col-md-4 text-center">
				<b>Parceiros</b> <br>
				<a href="https://www.afro.who.int/pt/countries/mozambique" target="_blank"><img src="<?php bloginfo('template_directory') ?>/img/oms-mocambique.png" alt="OMS Moçambique" id="oms-mocambique" class="img-fluid"></a>
				<a href="https://www.paho.org/pt/bireme" target="_blank"><img src="http://logos.bireme.org/img/pt/v_bir_white.svg" alt="BIREME" id="logo-bireme" class="img-fluid"></a>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>