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
	<div class="container">
		<?php $idioma = pll_current_language(); ?>
		<img src="<?php bloginfo('template_directory') ?>/img/<?php echo $idioma; ?>/logoBireme.svg" alt="Bireme" class="img-fluid">
		<hr>
		<div class="row" id="footerTermos">
			<div class="col-md-4 text-left">
				Powered by iAHx - <?php bloginfo('name');?>
			</div>
			<div class="col-md-4 text-center">
				<a href="http://feedback.bireme.org/feedback/?application=iahx&version=2.0&lang=<?php echo $idioma; ?>&site=portal" target="_blank"><?php pll_e('enviar um comentário /comunicar um erro'); ?></a>
			</div>
			<div class="col-md-4 text-right">
				<a href="http://politicas.bireme.org/terminos/<?php echo $idioma; ?>/" target="_blank"><?php pll_e('Termos e condições de uso'); ?></a> |
				<a href="http://politicas.bireme.org/privacidad/<?php echo $idioma; ?>/" target="_blank"><?php pll_e('Políticas de privacidade'); ?></a>
			</div>
		</div>
	</div>
</div>
<?php wp_footer(); ?>