<footer id="footer" class="bgColor2">
	<div class="container">
		<?php $idioma = pll_current_language(); ?>
		<div class="row" id="footerTermos">
			<div class="col-md-6 text-left">
				<?php bloginfo('name');?>
			</div>
			<div class="col-md-5 text-right">
				<a href="http://politicas.bireme.org/terminos/<?php echo $idioma; ?>/" target="_blank"><?php pll_e('Terms and conditions of use'); ?></a> |
				<a href="http://politicas.bireme.org/privacidad/<?php echo $idioma; ?>/" target="_blank"><?php pll_e('Privacy policy'); ?></a>
			</div>
			<div class="col-md-1 text-right">
				<i class="fas fa-chevron-up" id="to-top"></i>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>