		<footer class="f">
			<div class="bg-risc margin-bottom15"></div>
			
			<div class="pull-left f-340px">
				<div class="f-logo"></div>
				<p class="f-info">
					<strong>Equipe de Comunicação</strong><br>
					Subsecretaria de Assuntos Administrativos (SAA/SE/MS)<br>
					Ministério da Saúde<br>
					(61) 3315-2479
				</p>
			</div>

			<div class="pull-right">
				<ul class="f-patrocinios">
					
					<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('adv01') ) : else : ?>
					<?php endif; ?>
				
					<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('adv02') ) : else : ?>
					<?php endif; ?>
				
					<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('adv03') ) : else : ?>
					<?php endif; ?>
					
				</ul>
			</div>

			<div class="bg-risc margin-top15 margin-bottom15"></div>

			<div class="pull-left margin-bottom15">
				<div class="logo-acessibility"></div>
				<div class="logo-css"></div>
			</div>

			<div class="pull-right margin-bottom15">
				<div class="logo-sus"></div>
				<div class="logo-ministerio"></div>
				<div class="logo-governo"></div>
			</div>
		</footer>

		<!-- SCRIPTS -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/Js/jquery.js"></script>
	</div>
	</div>

	<?php wp_footer(); ?>
</body>
</html>