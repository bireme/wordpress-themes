<footer id="footer" class="bgColor2">
	<div class="container">
		<?php $idioma = pll_current_language(); ?>
		<div class="row" id="footerTermos">
			<div class="col-md-6 text-left">
				<?php bloginfo('name');?>
			</div>
			<div class="col-md-5 text-right">
				<a href="http://politicas.bireme.org/terminos/<?php echo $idioma=='fr'?'en':$idioma; ?>/" target="_blank"><?php pll_e('Termos e condições de uso'); ?></a> |
				<a href="http://politicas.bireme.org/privacidad/<?php echo $idioma=='fr'?'en':$idioma; ?>/" target="_blank"><?php pll_e('Política de privacidade'); ?></a>
			</div>
			<div class="col-md-1 text-right">
				<i class="fas fa-chevron-up" id="to-top"></i>
			</div>
		</div>
	</div>
</footer>
<?php get_template_part('includes/feedback') ?>
<?php wp_footer(); ?>