<!-- Rodapé -->
<footer id="footer" class="padding1">
	<div class="container">
		<div class="row">
			<address id="" class="col-md-6">
				<h5><?php pll_e('Outros Índices'); ?></h5>
				Avenue Appia 20 <br>
				CH-1211 Geneva 27 <br>
				Tel: (41) 22 791 20 62 <br>
				Tel: (41) 22 791 41 50 <br>
				<a href="http://www.who.int/library/en" target="_blank">http://www.who.int/library/en</a>
			</address>
			<address id="footerAddress" class="col-md-6">
				<h5>Bireme</h5>
				Rua Vergueiro, 1759 - 12º -	Vila Mariana <br>
				São Paulo/SP - CEP: 04101-100 <br>
				+55 11 5576-9800 <br>
				<!-- <a href="http://www.who.int/library/en" target="_blank"></a> -->
			</address>
		</div>
	</div>
</footer>
<div id="assFooter" class="text-center">
	<?php $idioma = pll_current_language(); ?>
	<img src="<?php bloginfo('template_directory') ?>/img/<?php echo $idioma; ?>/logoBireme.svg" alt="Bireme" class="img-fluid">
</div>
<?php wp_footer(); ?>