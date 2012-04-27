<?php
/**
 * O HomePage do Tema
 * Apresentação do site em 3 colunas administradas via Admin em Aparência / Widgets
 */
get_header(); ?>
			<div class="content">
				<div class="column1">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Coluna_1') ) : ?>
					<?php endif; ?>
				</div><!--/column1 -->
				<div class="column2">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Coluna_2') ) : ?>
					<?php endif; ?>
				</div><!--/column2 -->
				<div class="column3">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Coluna_3') ) : ?>
					<?php endif; ?>
				</div><!--/column3 -->
			<div class="spacer"></div><!--/spacer -->
			</div><!--/content -->
<?php get_footer(); ?>