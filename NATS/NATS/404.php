<!DOCTYPE html>
<?php 

get_header();?> 
	<div id="primary" class="container">
		<div class="row 404page">
			<div class="col-md-12 text-center">
				<p class="text-center"><h1 style="text-align: center;">Erro 404</h1></p>
				<p class="text-center"><img src="<?php echo get_bloginfo( 'stylesheet_directory' );?>/images/404.jpg" alt="404"/></p>
			</div>
			<div class="col-md-12">
				<p class="text-center">OOOOOOOOOOOOOOOOOOps! Lamentamos, mas a página procurada não existe ou foi apagada.</p>
				<p class="text-center">Você pode navegar através do menu abaixo:</p>
				<p class="text-center">
					<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
				</p>
			</div>
		</div>
	</div>


<?php
get_footer(); 
?>
