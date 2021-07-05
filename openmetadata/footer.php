	<?php $idioma = pll_current_language(); ?>
	<?php get_template_part('includes/termo') ?>
	<footer id="footer" class="padding1 d-print-none">
		<div class="container">
			<hr><br>
			<div class="row">
				<div class="col-md-4">
					<?php pll_e('Metadados Abertos das Fontes de Informação da BVS - BETA'); ?>
				</div>
				<div class="col-md-4 text-center">
					<a href="https://bvsalud.org/contate-nos/" target="_blank"><?php pll_e('Ask for help / Leave a comment / Report an error'); ?></a>
				</div>
				<div class="col-md-4 text-end">
					<a href="http://politicas.bireme.org/terminos/<?php echo $idioma=='fr'?'en':$idioma; ?>/" target="_blank"><?php pll_e('Terms and conditions'); ?></a> |
					<a href="http://politicas.bireme.org/privacidad/<?php echo $idioma=='fr'?'en':$idioma; ?>/" target="_blank"><?php pll_e('Privacy policy'); ?></a>
				</div>
			</div>
		</div>
	</footer>
	<!-- seta up -->
	<div id="to-top" class="to-top">
		<span class="float-left">
			<i class="fas fa-arrow-up"></i>
		</span>
	</div>
	<?php wp_footer(); ?>
</body>
</html>
