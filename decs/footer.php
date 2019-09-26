<footer id="footer" class="bgColor2">
	<div class="container">
		<?php $idioma = pll_current_language(); ?>
		<div class="row" id="footerTermos">
			<div class="col-md-3 text-left">
				<?php bloginfo('name');?>
			</div>
			<div class="col-md-4 text-center">
				<!-- <a href="http://feedback.bireme.org/feedback/?application=iahx&version=2.0&lang=<?php echo $idioma; ?>&site=portal" target="_blank"><?php pll_e('enviar um comentário /comunicar um erro'); ?></a> -->
			</div>
			<div class="col-md-4 text-right">
				<a href="http://politicas.bireme.org/terminos/<?php echo $idioma; ?>/" target="_blank"><?php pll_e('Termos e condições de uso'); ?></a> |
				<a href="http://politicas.bireme.org/privacidad/<?php echo $idioma; ?>/" target="_blank"><?php pll_e('Política de privacidade'); ?></a>
			</div>
			<div class="col-md-1 text-right">
				<i class="fas fa-chevron-up" id="to-top"></i>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>