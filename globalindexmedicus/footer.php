<!-- Rodapé -->
<footer id="footer" class="padding1">
	<div class="container">
		<div class="row">
			<address id="footerWHO" class="col-md-6">
				<h5><?php pll_e('Outros Índices'); ?></h5>
				<ul class="list-unstyled">
					<?php dynamic_sidebar('footer_left'); ?>
				</ul>
			</address>
			<address id="footerAddress" class="col-md-6">
				<h5><?php pll_e('Bireme'); ?></h5>
				<ul class="list-unstyled">
					<?php dynamic_sidebar('footer_right'); ?>
				</ul>
			</address>
		</div>
	</div>
</footer>
<div id="assFooter" class="text-center">
	<?php $idioma = pll_current_language(); ?>
	<img src="<?php bloginfo('template_directory') ?>/img/<?php echo $idioma; ?>/logoBireme.svg" alt="Bireme" class="img-fluid">
</div>
<?php wp_footer(); ?>