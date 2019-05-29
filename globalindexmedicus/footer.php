<!-- Rodapé -->
<footer id="footer" class="padding1">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h5>Menu</h5>
				<?php
				wp_nav_menu( array(
					'theme_location'    => 'rodape',
					'depth'             => 1,
					'container'         => 'ol',
					'container_class'   => '',
					'container_id'      => 'bs-example-navbar-collapse-1',
					'menu_class'        => '',
				) );
				?>
			</div>
			<address id="footerAddress" class="col-md-6">
				<h5><?php pll_e('Outros Índices'); ?></h5>
				Avenue Appia 20 <br>
				CH-1211 Geneva 27 <br>
				Tel: (41) 22 791 20 62 <br>
				Tel: (41) 22 791 41 50 <br>
				<a href="http://www.who.int/library/en" target="_blank">http://www.who.int/library/en</a>
			</address>
		</div>
	</div>
</footer>
<div id="assFooter" class="text-center">BIREME | OPS | OMS</div>
<?php wp_footer(); ?>