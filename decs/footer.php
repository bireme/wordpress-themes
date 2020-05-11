<?php $idioma = pll_current_language(); ?>
<footer id="footer" class="bgColor2">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6" id="footerBrand">
				<img src="http://logos.bireme.org/img/<?php echo $idioma; ?>/decs_white.svg"  alt="Brand DeCS">
			</div>
			<div class="col-12 col-md-3 navFooter">
				<?php
					wp_nav_menu( array(
						'theme_location'    => 'rodape1',
						'depth'             => 1,
						'container'         => 'ul',
						'container_class'   => 'list-unstyle',
						'container_id'      => '',
						'menu_class'        => '',
					) );
					?>
			</div>
			<div class="col-12 col-md-3 navFooter">
				<?php
					wp_nav_menu( array(
						'theme_location'    => 'rodape2',
						'depth'             => 1,
						'container'         => 'ul',
						'container_class'   => 'list-unstyle',
						'container_id'      => '',
						'menu_class'        => '',
					) );
					?>
			</div>
		</div>
		<hr class="lineWhite">
		<div class="row" id="footerTermos">
			<div class="col-md-11">
				<a href="http://politicas.bireme.org/terminos/<?php echo $idioma=='fr'?'en':$idioma; ?>/" target="_blank"><?php pll_e('Terms and conditions of use'); ?></a>
				<a href="http://politicas.bireme.org/privacidad/<?php echo $idioma=='fr'?'en':$idioma; ?>/" target="_blank"><?php pll_e('Privacy policy'); ?></a>
			</div>
			<div class="col-md-1 text-right">
				<i class="fas fa-chevron-up" id="to-top"></i>
			</div>
		</div>
	</div>
</footer>
<?php get_template_part('includes/feedback') ?>
<?php wp_footer(); ?>