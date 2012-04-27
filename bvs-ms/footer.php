<?php
/**
 * O Footer do Tema
 * Deve ser incluido nas demais páginas do template com a chamada 
 * get_footer();
 */
?>
			<div class="footer">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
				<?php endif; ?>
			</div><!--/footer -->
		</div><!-- /container -->
	</body>	
</html>