<?php
get_header(); ?>

<div class="content">
	<div class="left">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Coluna_1') ) : ?>
		<?php endif; ?>
	</div><!--/left-->
	<div class="middle">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Coluna_2') ) : ?>
		<?php endif; ?>
		</div><!--/middle-->
	<div class="right">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Coluna_3') ) : ?>
		<?php endif; ?>
	</div><!--/right-->
	<div class="spacer"> </div>
</div><!--/content-->
	<?php get_footer(); ?>
